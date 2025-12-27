<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// phan quyen
$config['cms_language_role']['groups'] = 'Group';
$config['cms_language_role']['media'] = 'Media';
$config['cms_language_role']['newsletter'] = 'Newsletter';
$config['cms_language_role']['post'] = 'Bài viết';
$config['cms_language_role']['property'] = 'Thuộc tính';
$config['cms_language_role']['setting'] = 'Cài đặt';
$config['cms_language_role']['page'] = 'Page';
$config['cms_language_role']['users'] = 'Thành viên';
$config['cms_language_role']['banner'] = 'Banner';
$config['cms_language_role']['company'] = 'Đơn vị thành viên';
$config['cms_language_role']['business'] = 'Lĩnh vực hoạt động';
$config['cms_language_role']['library'] = 'Thư viện';
$config['cms_language_role']['project'] = 'Dự án';
$config['cms_language_role']['video'] = 'Video';
$config['cms_language_role']['store'] = 'Cửa hàng';
$config['cms_language_role']['category'] = 'Danh mục';
$config['cms_language_role']['contact'] = 'Liên hệ';
$config['cms_language_role']['page'] = 'Quản lý trang';
$config['cms_language_role']['question'] = 'Câu hỏi';
$config['cms_language_role']['menus'] = 'Quản lý menu';
$config['cms_language_role']['gallery'] = 'Thư viện ảnh';
$config['cms_language_role']['historydv'] = 'Lịch sử phát triển';
$config['cms_language_role']['working_field'] = 'Lĩnh vực hoạt động';
$config['cms_language_role']['product'] = 'Sản phẩm';
$config['cms_language_role']['location'] = 'Quản lý địa điểm';
$config['cms_language_role']['category_post'] = 'Danh mục bài viết';
$config['cms_language_role']['category_career'] = 'Danh mục tuyển dụng';
$config['cms_language_role']['category_pro_service'] = 'Danh mục sản phẩm';
$config['cms_language_role']['pro_service'] = 'Sản phẩm / dịch vụ';
$config['cms_language_role']['category_project'] = 'Danh mục dự án';
$config['cms_language_role']['category_document'] = 'Danh mục tài liệu';
$config['cms_language_role']['category_video'] = 'Danh mục video';
$config['cms_language_role']['category_question'] = 'Danh mục câu hỏi';
$config['cms_language_role']['property_location'] = 'Địa điểm tuyển dụng';
$config['cms_language_role']['career'] = 'Quản lý tuyển dụng';
$config['cms_language_role']['candidate'] = 'Quản lý ứng viên';
$config['cms_language_role']['location_city'] = 'Quản lý tỉnh/thành phố';
$config['cms_language_role']['location_district'] = 'Quản lý quận/huyện';
$config['cms_language_role']['location_ward'] = 'Quản lý phường xã';
$config['cms_language_role']['task'] = 'Quản lý nhiệm vụ';
$config['cms_language_role']['account'] = 'Quản lý tài khoản';
$config['cms_language_role']['schools'] = 'Quản lý trường học';
$config['cms_language_role']['packages'] = 'Quản lý khoá học';
$config['cms_language_role']['payments'] = 'Quản lý thanh toán';
$config['cms_language_role']['report'] = 'Báo cáo';
$config['cms_language_role']['setting'] = 'Cấu hình chung';
$config['cms_language_role']['schools_register'] = 'Danh sách trường học đăng ký';

$config['cms_check_not_add'] = array('contact');

$config['cms_check_not_edit'] = array('contact');
// Những controller ai cũng có quyền xem
$config['cms_not_per'] = array('dashboard');
$config['cms_not_per_method'] = array();
$config['cms_check_export'] = array();
$config['cms_check_import'] = array();

$config['cms_check_not_delete'] = array('report_product','report_account','report_sales_out');
//Những controller custom phân quyền
$config['cms_custom_per'] = ['category', 'property','location'];
$category = ['post', 'pro_service','career','project','document','video','question'];
$property = ['location'];
$location = ['city', 'district', 'ward'];
// những method cần phân quyền theo cms_custom_per
$config['cms_per_list_method'] = array_merge($category, $property, $location);
// list controller cần phân quyền
$config['cms_controller_permission'] = array('groups', 'users', 'task', 'account', 'schools', 'schools_register', 'packages', 'payments', 'setting', 'report');