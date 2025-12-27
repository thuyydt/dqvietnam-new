<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Name:  Auth Lang - Vietnamese
 *
 * Author: Trung Dinh Quang
 * 		  trungdq88@gmail.com
 *         @trungdq88
 *
 * Location: http://github.com/benedmunds/ion_auth/
 *
 * Created:  01.17.2015
 *
 * Description:  Vietnamese language file for Ion Auth example views
 *
 */

// Errors
$lang['error_csrf'] = 'Có lỗi xảy ra trong quá trình đăng nhập.';

// Login
$lang['login_heading']         = 'Login';
$lang['login_subheading']      = 'Login with email.';
$lang['login_identity_label']  = 'Email';
$lang['login_password_label']  = 'Password';
$lang['login_remember_label']  = 'Remember password';
$lang['login_submit_btn']      = 'Login';
$lang['login_forgot_password'] = 'Forgot password?';

// Index
$lang['index_heading']           = 'Account';
$lang['index_subheading']        = 'Accounts list.';
$lang['index_fname_th']          = 'First name';
$lang['index_lname_th']          = 'Last name';
$lang['index_email_th']          = 'Email';
$lang['index_groups_th']         = 'Group';
$lang['index_status_th']         = 'Status';
$lang['index_action_th']         = 'Tác vụ';
$lang['index_active_link']       = 'Activate';
$lang['index_inactive_link']     = 'Deactivate';
$lang['index_create_user_link']  = 'Create new account';
$lang['index_create_group_link'] = 'Create new group';

// Deactivate User
$lang['deactivate_heading']                  = 'Deactivate account';
$lang['deactivate_subheading']               = 'Are you sure you want to deactivate account "%s';
$lang['deactivate_confirm_y_label']          = 'Yes:';
$lang['deactivate_confirm_n_label']          = 'No:';
$lang['deactivate_submit_btn']               = 'Submit';
$lang['deactivate_validation_confirm_label'] = 'Confirm';
$lang['deactivate_validation_user_id_label'] = 'ID account';

// Create User
$lang['create_user_heading']                           = 'Create account';
$lang['create_user_subheading']                        = 'Please fill the following required information.';
$lang['create_user_fname_label']                       = 'First name:';
$lang['create_user_lname_label']                       = 'Last name:';
$lang['create_user_identity_label']                    = 'Identity:';
$lang['create_user_company_label']                     = 'Company:';
$lang['create_user_email_label']                       = 'Email:';
$lang['create_user_phone_label']                       = 'Phone:';
$lang['create_user_password_label']                    = 'Password:';
$lang['create_user_password_confirm_label']            = 'retype password:';
$lang['create_user_submit_btn']                        = 'Create account';
$lang['create_user_validation_fname_label']            = 'First name';
$lang['create_user_validation_lname_label']            = 'Last name';
$lang['create_user_validation_identity_label']         = 'Identity';
$lang['create_user_validation_email_label']            = 'Email';
$lang['create_user_validation_phone1_label']           = 'Phone (area code)';
$lang['create_user_validation_phone2_label']           = 'Phone (The first 3 numbers)';
$lang['create_user_validation_phone3_label']           = 'Phone (the remaining numbers)';
$lang['create_user_validation_company_label']          = 'Company';
$lang['create_user_validation_password_label']         = 'Password';
$lang['create_user_validation_password_confirm_label'] = 'Retype password';

// Edit User
$lang['edit_user_heading']                           = 'Edit account information';
$lang['edit_user_subheading']                        = 'Please fill the following information.';
$lang['edit_user_fname_label']                       = 'First name:';
$lang['edit_user_lname_label']                       = 'Last name:';
$lang['edit_user_company_label']                     = 'Company:';
$lang['edit_user_email_label']                       = 'Email:';
$lang['edit_user_phone_label']                       = 'Phone:';
$lang['edit_user_password_label']                    = 'Password: (if any changes)';
$lang['edit_user_password_confirm_label']            = 'Retype password: (if any changes)';
$lang['edit_user_groups_heading']                    = 'Groups';
$lang['edit_user_submit_btn']                        = 'Submit';
$lang['edit_user_validation_fname_label']            = 'First name';
$lang['edit_user_validation_lname_label']            = 'Last name';
$lang['edit_user_validation_email_label']            = 'Email';
$lang['edit_user_validation_phone1_label']           = 'Phone (area code)';
$lang['edit_user_validation_phone2_label']           = 'Phone (The first 3 numbers)';
$lang['edit_user_validation_phone3_label']           = 'Phone (the remaining numbers)';
$lang['edit_user_validation_company_label']          = 'Company';
$lang['edit_user_validation_groups_label']           = 'Group';
$lang['edit_user_validation_password_label']         = 'Password';
$lang['edit_user_validation_password_confirm_label'] = 'Retype password';

// Create Group
$lang['create_group_title']                  = 'Create new group';
$lang['create_group_heading']                = 'Create new group';
$lang['create_group_subheading']             = 'Please fill the following information.';
$lang['create_group_name_label']             = 'Group name:';
$lang['create_group_desc_label']             = 'Description:';
$lang['create_group_submit_btn']             = 'Submit';
$lang['create_group_validation_name_label']  = 'Group name';
$lang['create_group_validation_desc_label']  = 'Description';

// Edit Group
$lang['edit_group_title']                  = 'Edit group';
$lang['edit_group_saved']                  = 'Saved';
$lang['edit_group_heading']                = 'Edit group';
$lang['edit_group_subheading']             = 'Please fill the following information.';
$lang['edit_group_name_label']             = 'Group name:';
$lang['edit_group_desc_label']             = 'Description:';
$lang['edit_group_submit_btn']             = 'Submit';
$lang['edit_group_validation_name_label']  = 'Group name';
$lang['edit_group_validation_desc_label']  = 'Description';

// Change Password
$lang['change_password_heading']                               = 'Change password';
$lang['change_password_old_password_label']                    = 'Old password:';
$lang['change_password_new_password_label']                    = 'New password (at least %s characters):';
$lang['change_password_new_password_confirm_label']            = 'Retype new password:';
$lang['change_password_submit_btn']                            = 'Submit';
$lang['change_password_validation_old_password_label']         = 'Old password';
$lang['change_password_validation_new_password_label']         = 'New password';
$lang['change_password_validation_new_password_confirm_label'] = 'Retype new password:';

// Forgot Password
$lang['forgot_password_heading']                 = 'Forgot password';
$lang['forgot_password_subheading']              = 'Please enter %s to receive a password reset email.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Submit';
$lang['forgot_password_validation_email_label']  = 'Email';
$lang['forgot_password_username_identity_label'] = 'Username';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_email_not_found']         = 'Email address does not exist.';
$lang['forgot_password_identity_not_found']         = 'No record of that username address.';

// Reset Password
$lang['reset_password_heading']                               = 'Change password';
$lang['reset_password_new_password_label']                    = 'New password (at least %s characters):';
$lang['reset_password_new_password_confirm_label']            = 'Retype new password:';
$lang['reset_password_submit_btn']                            = 'Submit';
$lang['reset_password_validation_new_password_label']         = 'New password';
$lang['reset_password_validation_new_password_confirm_label'] = 'Retype new password';
