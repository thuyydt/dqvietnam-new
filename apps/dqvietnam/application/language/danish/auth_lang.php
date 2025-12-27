<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';

// Login
$lang['login_heading']         = 'Log på';
$lang['register_heading']      = 'Tilmeld';
$lang['login_subheading']      = 'Log venligst ind med din email / brugernavn og adgangskode nedenfor.';
$lang['login_identity_label']  = 'Email / Brugernavn:';
$lang['login_password_label']  = 'Adgangskode:';
$lang['login_remember_label']  = 'Husk mig:';
$lang['login_submit_btn']      = 'Log på';
$lang['login_forgot_password'] = 'Glemt din adgangskode?';

// Index
$lang['index_heading']           =
$lang['index_subheading']        = 'Brugere';
$lang['index_fname_th']          = 'Nedenfor er en liste over brugerne.';
$lang['index_lname_th']          = 'Fornavn';
$lang['index_email_th']          = 'Efternavn';
$lang['index_groups_th']         = 'E-mail';
$lang['index_status_th']         = 'Grupper';
$lang['index_action_th']         = 'Status';
$lang['index_active_link']       = 'Handling';
$lang['index_inactive_link']     = 'Aktiv';
$lang['index_create_user_link']  = 'Inaktiv';
$lang['index_create_group_link'] = 'Opret en ny bruger';

// Deactivate User
$lang['deactivate_heading']                  = 'Deaktiver bruger';
$lang['deactivate_subheading']               = 'Are you sure you want to deactivate the user \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Ja:';
$lang['deactivate_confirm_n_label']          = 'Ingen:';
$lang['deactivate_submit_btn']               = 'Indsend';
$lang['deactivate_validation_confirm_label'] = 'bekræftelse';
$lang['deactivate_validation_user_id_label'] = 'bruger ID';

// Create User
$lang['create_user_heading']                           = 'Opret bruger';
$lang['create_user_subheading']                        = 'Indtast venligst brugerens oplysninger nedenfor.';
$lang['create_user_fname_label']                       = 'Fornavn:';
$lang['create_user_lname_label']                       = 'Efternavn:';
$lang['create_user_company_label']                     = 'Firmanavn:';
$lang['create_user_identity_label']                    = 'Identitet:';
$lang['create_user_email_label']                       = 'E-mail:';
$lang['create_user_phone_label']                       = 'Telefon:';
$lang['create_user_password_label']                    = 'Adgangskode:';
$lang['create_user_password_confirm_label']            = 'Bekræft kodeord:';
$lang['create_user_submit_btn']                        = 'Opret bruger';
$lang['create_user_validation_fname_label']            = 'Fornavn';
$lang['create_user_validation_lname_label']            = 'Efternavn';
$lang['create_user_validation_identity_label']         = 'Identitet';
$lang['create_user_validation_email_label']            = 'Email adresse';
$lang['create_user_validation_phone_label']            = 'Telefon';
$lang['create_user_validation_company_label']          = 'Firmanavn';
$lang['create_user_validation_password_label']         = 'Adgangskode';
$lang['create_user_validation_password_confirm_label'] = 'Kodeords bekræftelse';

// Edit User
$lang['edit_user_heading']                           = 'Rediger bruger';
$lang['edit_user_subheading']                        = 'Indtast venligst brugerens oplysninger nedenfor.';
$lang['edit_user_fname_label']                       = 'Fornavn:';
$lang['edit_user_lname_label']                       = 'Efternavn:';
$lang['edit_user_company_label']                     = 'Firmanavn:';
$lang['edit_user_email_label']                       = 'E-mail:';
$lang['edit_user_phone_label']                       = 'Telefon:';
$lang['edit_user_password_label']                    = 'Adgangskode: (hvis du ændrer adgangskode)';
$lang['edit_user_password_confirm_label']            = 'Bekræft adgangskode: (hvis du ændrer adgangskode)';
$lang['edit_user_groups_heading']                    = 'Medlem af grupper';
$lang['edit_user_submit_btn']                        = 'Gem bruger';
$lang['edit_user_validation_fname_label']            = 'Fornavn';
$lang['edit_user_validation_lname_label']            = 'Efternavn';
$lang['edit_user_validation_email_label']            = 'Email adresse';
$lang['edit_user_validation_phone_label']            = 'Telefon';
$lang['edit_user_validation_company_label']          = 'Firmanavn';
$lang['edit_user_validation_groups_label']           = 'Grupper';
$lang['edit_user_validation_password_label']         = 'Adgangskode';
$lang['edit_user_validation_password_confirm_label'] = 'Kodeords bekræftelse';

// Create Group
$lang['create_group_title']                  = 'Opret gruppe';
$lang['create_group_heading']                = 'Opret gruppe';
$lang['create_group_subheading']             = 'Indtast venligst gruppens oplysninger nedenfor.';
$lang['create_group_name_label']             = 'Gruppe navn:';
$lang['create_group_desc_label']             = 'Beskrivelse:';
$lang['create_group_submit_btn']             = 'Opret gruppe';
$lang['create_group_validation_name_label']  = 'Gruppe navn';
$lang['create_group_validation_desc_label']  = 'Beskrivelse';

// Edit Group
$lang['edit_group_title']                  = 'Rediger gruppe';
$lang['edit_group_saved']                  = 'Gemt Gemt';
$lang['edit_group_heading']                = 'Rediger gruppe';
$lang['edit_group_subheading']             = 'Indtast venligst gruppens oplysninger nedenfor.';
$lang['edit_group_name_label']             = 'Gruppe navn:';
$lang['edit_group_desc_label']             = 'Beskrivelse:';
$lang['edit_group_submit_btn']             = 'Gem gruppe';
$lang['edit_group_validation_name_label']  = 'Gruppe navn';
$lang['edit_group_validation_desc_label']  = 'Beskrivelse';

// Change Password
$lang['change_password_heading']                               = 'Skift kodeord';
$lang['change_password_old_password_label']                    = 'Gammelt kodeord:';
$lang['change_password_new_password_label']                    = 'Nyt kodeord (mindst %s tegn lang):';
$lang['change_password_new_password_confirm_label']            = 'Bekræft ny adgangskode:';
$lang['change_password_submit_btn']                            = 'Lave om';
$lang['change_password_validation_old_password_label']         = 'Gammelt kodeord';
$lang['change_password_validation_new_password_label']         = 'Nyt kodeord';
$lang['change_password_validation_new_password_confirm_label'] = 'Bekræft ny adgangskode';

// Forgot Password
$lang['forgot_password_heading']                = 'Glemt kodeord';
$lang['forgot_password_subheading']             = 'Indtast venligst din %s, så vi kan sende dig en e-mail for at nulstille dit kodeord.';
$lang['forgot_password_email_label']            = '%S:';
$lang['forgot_password_submit_btn']             = 'Indsend';
$lang['forgot_password_validation_email_label'] = 'Email adresse';
$lang['forgot_password_identity_label']         = 'Identitet';
$lang['forgot_password_email_identity_label']   = 'E-mail';
$lang['forgot_password_email_not_found']        = 'Ingen registrering af den email adresse.';
$lang['forgot_password_identity_not_found']     = 'Ingen registrering af det brugernavn.';

// Reset Password
$lang['reset_password_heading']                               = 'Skift kodeord';
$lang['reset_password_new_password_label']                    = 'Nyt kodeord (mindst %s tegn lang):';
$lang['reset_password_new_password_confirm_label']            = 'Bekræft ny adgangskode:';
$lang['reset_password_submit_btn']                            = 'Lave om';
$lang['reset_password_validation_new_password_label']         = 'Nyt kodeord';
$lang['reset_password_validation_new_password_confirm_label'] = 'Bekræft ny adgangskode';
