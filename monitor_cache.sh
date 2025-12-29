#!/bin/bash

# Cache Performance Monitor
# Usage: ./monitor_cache.sh

echo "========================================="
echo "Cache Performance Monitor"
echo "========================================="
echo ""

# Check Redis status
echo "1. Redis Status:"
docker compose -f docker-compose.dev.yaml exec redis redis-cli ping
echo ""

# Get cache keys count
echo "2. Cache Keys Count:"
docker compose -f docker-compose.dev.yaml exec redis redis-cli DBSIZE
echo ""

# Show cache keys for users
echo "3. User Cache Keys (sample):"
docker compose -f docker-compose.dev.yaml exec redis redis-cli KEYS "dqedu_user_points_*" | head -10
echo ""

# Show account cache keys
echo "4. Account Cache Keys (sample):"
docker compose -f docker-compose.dev.yaml exec redis redis-cli KEYS "dqedu_account_info_*" | head -10
echo ""

# Redis memory usage
echo "5. Redis Memory Usage:"
docker compose -f docker-compose.dev.yaml exec redis redis-cli INFO memory | grep "used_memory_human"
echo ""

# Check database indexes
echo "6. Database Indexes Status:"
echo "   - logs_point indexes:"
docker compose -f docker-compose.dev.yaml exec mysql mysql -u root -pn0kuqThog5ar8jF3kh cauvong -e "SELECT TABLE_NAME, INDEX_NAME, COLUMN_NAME FROM information_schema.STATISTICS WHERE TABLE_SCHEMA='cauvong' AND TABLE_NAME='c19_logs_point' AND INDEX_NAME LIKE 'idx_%';" 2>/dev/null
echo ""
echo "   - logs_play indexes:"
docker compose -f docker-compose.dev.yaml exec mysql mysql -u root -pn0kuqThog5ar8jF3kh cauvong -e "SELECT TABLE_NAME, INDEX_NAME, COLUMN_NAME FROM information_schema.STATISTICS WHERE TABLE_SCHEMA='cauvong' AND TABLE_NAME='c19_logs_play' AND INDEX_NAME LIKE 'idx_%';" 2>/dev/null
echo ""
echo "   - account indexes:"
docker compose -f docker-compose.dev.yaml exec mysql mysql -u root -pn0kuqThog5ar8jF3kh cauvong -e "SELECT TABLE_NAME, INDEX_NAME, COLUMN_NAME FROM information_schema.STATISTICS WHERE TABLE_SCHEMA='cauvong' AND TABLE_NAME='c19_account' AND INDEX_NAME LIKE 'idx_%';" 2>/dev/null

echo ""
echo "========================================="
echo "Monitor Complete"
echo "========================================="
