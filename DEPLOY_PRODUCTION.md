# Hướng Dẫn Deploy Production - DQVietnam (High Performance)

Tài liệu này hướng dẫn triển khai hệ thống DQVietnam với kiến trúc chịu tải cao, sử dụng 4 Server riêng biệt.

## Kiến Trúc Hệ Thống

*   **Server 1 (Load Balancer):** Chạy Nginx trực tiếp (Native). Điều hướng traffic vào 2 Web Server.
*   **Server 2 (Database & Cache):** Chạy MariaDB, MongoDB, Redis.
*   **Server 3 (Web 1):** Chạy Web App (Docker).
*   **Server 4 (Web 2):** Chạy Web App (Docker).

---

## Phần 1: Server 1 - Nginx Load Balancer (Native)

**Yêu cầu:** Cài đặt trực tiếp trên OS (Ubuntu/CentOS), không dùng Docker để tối ưu hiệu năng mạng.

### 1. Cài đặt Nginx
```bash
# Ubuntu
sudo apt update
sudo apt install nginx -y
```

### 2. Cấu hình Load Balancing
Tạo file cấu hình `/etc/nginx/conf.d/loadbalancer.conf`:

```nginx
upstream backend_servers {
    # Thuật toán least_conn giúp phân phối vào server đang rảnh hơn
    least_conn; 
    server <IP_WEB_SERVER_1>:8080 max_fails=3 fail_timeout=30s;
    server <IP_WEB_SERVER_2>:8080 max_fails=3 fail_timeout=30s;
    keepalive 32;
}

server {
    listen 80;
    server_name dqvietnam.com www.dqvietnam.com;
    
    # Redirect HTTP to HTTPS (Khuyên dùng)
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name dqvietnam.com www.dqvietnam.com;

    # SSL Config (Sử dụng Let's Encrypt hoặc chứng chỉ mua)
    ssl_certificate /etc/nginx/ssl/live/dqvietnam.com/fullchain.pem;
    ssl_certificate_key /etc/nginx/ssl/live/dqvietnam.com/privkey.pem;

    # Tối ưu SSL
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;
    ssl_protocols TLSv1.2 TLSv1.3;

    location / {
        proxy_pass http://backend_servers;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        # Tối ưu Proxy
        proxy_http_version 1.1;
        proxy_set_header Connection "";
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
    }
}
```

### 3. Tối ưu OS cho Nginx (High Traffic)
Sửa file `/etc/sysctl.conf`:
```conf
net.core.somaxconn = 65535
net.ipv4.tcp_max_tw_buckets = 1440000
net.ipv4.ip_local_port_range = 1024 65000
net.ipv4.tcp_fin_timeout = 15
net.ipv4.tcp_window_scaling = 1
net.ipv4.tcp_max_syn_backlog = 3240000
```
Chạy `sysctl -p` để áp dụng.

---

## Phần 2: Server 2 - Database & Cache (MariaDB, MongoDB, Redis)

Có thể với quy mô 1 triệu user, **KHÔNG NÊN** chạy Database qua Docker nếu team không có chuyên gia tối ưu Docker Storage/Network. Việc chạy trực tiếp (Native) trên Server vật lý/VM sẽ cho hiệu năng I/O đĩa cứng tốt nhất và dễ dàng tuning bộ nhớ.

Tuy nhiên, để dễ quản lý version và backup, có thể dùng Docker nhưng cần dùng chế độ mạng `host` và mount volume trực tiếp vào đĩa cứng tốc độ cao (NVMe). Dưới đây là cấu hình Docker tối ưu (nếu chọn Docker).

### Phương án: Docker Compose (Database Server)
Tạo file `docker-compose-db.yml` trên Server 2:

```yaml
services:
  mariadb:
    image: mariadb:10.6
    container_name: mariadb_prod
    restart: always
    network_mode: "host" # Tối ưu network, bỏ qua lớp NAT của Docker
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASS}
      MYSQL_DATABASE: dqvietnam
      MYSQL_USER: dqvietnam_user
      MYSQL_PASSWORD: ${DB_PASS}
    volumes:
      - /mnt/nvme/mariadb_data:/var/lib/mysql # Mount vào ổ cứng nhanh nhất
      - ./conf/mariadb/my.cnf:/etc/mysql/conf.d/my.cnf
    command: --max_connections=1000 --innodb-buffer-pool-size=4G # Tùy chỉnh theo RAM server

  mongodb:
    image: mongo:6.0
    container_name: mongodb_prod
    restart: always
    network_mode: "host"
    environment:
      MONGO_INITDB_ROOT_USERNAME: root
      MONGO_INITDB_ROOT_PASSWORD: ${MONGO_PASS}
    volumes:
      - /mnt/nvme/mongo_data:/data/db

  redis:
    image: redis:7.0-alpine
    container_name: redis_prod
    restart: always
    network_mode: "host"
    command: redis-server --requirepass ${REDIS_PASS} --maxmemory 2gb --maxmemory-policy allkeys-lru
    volumes:
      - /mnt/nvme/redis_data:/data
```

**Lưu ý quan trọng:**
1.  Cần mở firewall (UFW/IPTables) trên Server 2 chỉ cho phép IP của Server 3 và Server 4 kết nối vào port 3306 (MariaDB), 27017 (Mongo), 6379 (Redis).
2.  **Backup:** Thiết lập cronjob backup database hàng ngày.

---

## Phần 3: Server 3 & 4 - Web Application (CodeIgniter 3)

Nên chạy Docker vì Web App là stateless (không lưu dữ liệu cứng), việc dùng Docker giúp đồng bộ code giữa 2 server cực nhanh, dễ scale lên Server 5, 6 nếu cần.

### Vấn đề File Upload (Media/Images)
Vì có 2 Web Server, nếu User A upload ảnh vào Server 3, User B truy cập vào Server 4 sẽ không thấy ảnh đó.
**Giải pháp:**
1.  **Tốt nhất:** Sử dụng AWS S3 hoặc MinIO hoặc Cloud nào đó để lưu trữ file upload.
2.  **Giải pháp Server riêng:** Dùng NFS (Network File System). Server 2 (hoặc 1 server storage riêng) share thư mục `public/media` qua mạng, Server 3 và 4 mount thư mục đó vào.

### Cấu hình Docker Compose (Cho cả Server 3 và 4)
Tạo file `docker-compose-web.yml`:

```yaml
services:
  web:
    image: your-docker-registry/dqvietnam-web:latest
    container_name: dqvietnam_web
    restart: always
    ports:
      - "8080:80" # Expose port 8080 để Nginx LB kết nối
    environment:
      - CI_ENV=production
      - DB_HOST=<IP_SERVER_2>
      - DB_USER=dqvietnam_user
      - DB_PASS=${DB_PASS}
      - MONGO_HOST=<IP_SERVER_2>
      - REDIS_HOST=<IP_SERVER_2>
      - REDIS_PASS=${REDIS_PASS}
    volumes:
      # Mount code nếu cần hot-fix (không khuyến khích trên prod)
      # - ./apps/dqvietnam:/app/dqvietnam
      
      # QUAN TRỌNG: Mount thư mục upload từ NFS Share
      - /mnt/nfs_share/media:/app/dqvietnam/public/media
      - /mnt/nfs_share/images:/app/dqvietnam/public/images
      - /mnt/nfs_share/videos:/app/dqvietnam/public/videos
    logging:
      driver: "json-file"
      options:
        max-size: "10m"
        max-file: "3"
```

### Dockerfile tối ưu cho Production
Cần đảm bảo `Dockerfile` hiện tại cài đặt đủ extension và bật Opcache.

```dockerfile
FROM php:8.1-fpm

# Cài đặt dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev

# Cài đặt PHP Extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd curl

# Cài đặt Redis
RUN pecl install redis && docker-php-ext-enable redis

# Cài đặt MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Cấu hình Opcache (Bắt buộc cho High Traffic)
RUN docker-php-ext-install opcache
COPY ./conf/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /app
COPY . /app

# Phân quyền
RUN chown -R www-data:www-data /app
```

---

## Phần 4: Chiến lược Serving Static Files (Ảnh, Video, Audio) - Quan Trọng

Việc phục vụ file tĩnh (đặc biệt là Video/Audio) là gánh nặng lớn nhất. Nếu để Web Server (PHP) xử lý hoặc Proxy ngược qua Nginx mà không tối ưu, hệ thống sẽ bị nghẽn băng thông ngay lập tức.

### Phương án A: Sử dụng CDN (Khuyên dùng)
Đây là phương án tối ưu nhất.
1.  Code upload sẽ đẩy file lên **AWS S3 / MinIO / DigitalOcean Spaces**.
2.  Dùng **Cloudflare** hoặc **AWS CloudFront** để cache và phân phối file.
3.  Web Server chỉ trả về URL (ví dụ: `https://cdn.dqvietnam.com/images/abc.jpg`).
4.  **Ưu điểm:** Giảm 90% tải băng thông cho server gốc.

### Phương án B: Tự host (Sử dụng Server 1 làm Static Server)
Nếu bạn muốn tiết kiệm chi phí CDN và tự host, bạn **TUYỆT ĐỐI KHÔNG** để request ảnh/video đi qua Web Server (Server 3, 4). Hãy để Server 1 (Nginx LB) phục vụ trực tiếp.

**Mô hình luồng dữ liệu:**
*   **Upload:** User -> Server 1 -> Server 3/4 (Xử lý logic) -> Ghi vào NFS Share.
*   **Xem/Tải:** User -> Server 1 (Đọc trực tiếp từ NFS Share) -> Trả về User. (Bỏ qua Server 3/4).

**Cấu hình chi tiết:**

1.  **Mount NFS trên Server 1:**
    Server 1 cũng cần mount thư mục share từ Server 2 (giống như Server 3 & 4).
    ```bash
    mount -t nfs <IP_SERVER_2>:/mnt/nvme/media /mnt/nfs_share/media
    ```

2.  **Cấu hình Nginx tại Server 1 (`/etc/nginx/conf.d/loadbalancer.conf`):**
    Thêm block `location` để chặn các request static và phục vụ ngay tại chỗ.

    ```nginx
    server {
        listen 443 ssl http2;
        server_name dqvietnam.com;
        
        # ... (SSL config) ...

        # CẤU HÌNH QUAN TRỌNG: Phục vụ Static Files trực tiếp từ NFS Mount
        # Nginx sẽ đọc file từ đĩa cứng (qua NFS) và trả về ngay, cực nhanh.
        location ~ ^/(media|images|videos|audio|download)/ {
            root /mnt/nfs_share; # Trỏ về thư mục mount NFS
            
            # Cache trình duyệt 30 ngày
            expires 30d;
            add_header Cache-Control "public, no-transform";
            
            # Tắt log để giảm I/O nếu quá đông
            access_log off;
            
            # Tối ưu cho video streaming (cần module http_mp4_module)
            mp4; 
            mp4_buffer_size 1m;
            mp4_max_buffer_size 5m;
            
            # Cho phép tải file to
            client_max_body_size 100M;
        }

        # Các request còn lại mới đẩy vào Web Server (PHP)
        location / {
            proxy_pass http://backend_servers;
            proxy_set_header Host $host;
            # ...
        }
    }
    ```

---

## Tóm tắt Checklist Triển Khai

1.  **Server 1 (LB):** Cài Nginx, config upstream trỏ về IP Server 3 & 4.
2.  **Server 2 (DB):** Cài MariaDB, Mongo, Redis (Native hoặc Docker Host Mode). Mở port cho Server 3 & 4.
3.  **Storage:** Thiết lập NFS Server trên Server 2 (hoặc server riêng), share thư mục `public`.
4.  **Server 3 & 4 (Web):**
    *   Cài Docker & Docker Compose.
    *   Mount NFS share vào `/mnt/nfs_share`.
    *   Chạy container Web App, trỏ config DB/Redis về IP Server 2.
5.  **CodeIgniter Config:**
    *   Đảm bảo `config.php` có `base_url` là domain chính (https://dqvietnam.com), không phải localhost.
    *   Cấu hình Session driver sang Redis trong `config.php` để user login không bị out khi load balancer chuyển server.

```php
// application/config/config.php
$config['sess_driver'] = 'redis';
$config['sess_save_path'] = 'tcp://<IP_SERVER_2>:6379?auth=${REDIS_PASS}';
```
