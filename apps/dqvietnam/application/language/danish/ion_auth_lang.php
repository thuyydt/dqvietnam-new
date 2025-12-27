<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
*
* Author: Ben Edmunds
*         ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful']            = 'Kontoen er oprettet';
$lang['account_creation_unsuccessful']          = 'Kan ikke oprette konto';
$lang['account_creation_duplicate_email']       = 'E-mail allerede brugt eller ugyldig';
$lang['account_creation_duplicate_identity']    = 'Identitet allerede brugt eller ugyldig';
$lang['account_creation_missing_default_group'] = 'Standardgruppe er ikke indstillet';
$lang['account_creation_invalid_default_group'] = 'Ugyldigt standardgruppenavnsæt';


// Password
$lang['password_change_successful']          = 'Adgangskoden er blevet ændret';
$lang['password_change_unsuccessful']        = 'Kan ikke ændre adgangskode';
$lang['forgot_password_successful']          = 'Password Reset Email sent';
$lang['forgot_password_unsuccessful']        = 'Kan ikke sende e-mail til linket Nulstil adgangskode';

// Activation
$lang['activate_successful']                 = 'Konto aktiveret';
$lang['activate_unsuccessful']               = 'Kan ikke aktivere konto';
$lang['deactivate_successful']               = 'Konto deaktiveret';
$lang['deactivate_unsuccessful']             = 'Kan ikke deaktivere konto';
$lang['activation_email_successful']         = 'Aktiverings-e-mail sendt. Kontroller din indbakke eller spam ';
$lang['activation_email_unsuccessful']       = 'Kan ikke sende aktiverings-e-mail';
$lang['deactivate_current_user_unsuccessful']= 'Du kan ikke deaktivere dig selv.';
$lang['activate_successful_note']            = 'Din konto er bekræftet';

// Login / Logout
$lang['login_successful']                    = 'Logget med succes';
$lang['login_unsuccessful']                  = 'Forkert login';
$lang['login_unsuccessful_not_active']       = 'Konto er inaktiv';
$lang['login_timeout']                       = 'Midlertidigt låst ud. Prøv igen senere.';
$lang['logout_successful']                   = 'Logget ud med succes';

// Account Changes
$lang['update_successful']                   = 'Kontooplysninger er opdateret';
$lang['update_unsuccessful']                 = 'Kan ikke opdatere kontooplysninger';
$lang['delete_successful']                   = 'Bruger er slettet';
$lang['delete_unsuccessful']                 = 'Kan ikke slette bruger';

// Groups
$lang['group_creation_successful']           ='Gruppen blev oprettet med succes';
$lang['group_already_exists']                ='Gruppenavn allerede taget';
$lang['group_update_successful']             ='Opdaterede gruppeoplysninger';
$lang['group_delete_successful']             ='Gruppen er slettet';
$lang['group_delete_unsuccessful']           ='Kan ikke slette gruppe';
$lang['group_delete_notallowed']             ='Kan ikke slette administratorerne \' gruppen ';
$lang['group_name_required']                 ='Gruppenavn er et påkrævet felt';
$lang['group_name_admin_not_alter']          ='Administrationsgruppenavn kan ikke ændres';

// Activation Email
$lang['email_activation_subject']            ='Kontoaktivering';
$lang['email_activate_heading']              ='Du har oprettet en konto %s';
$lang['email_activate_subheading']           ='Klik på dette link til %s.';
$lang['email_activate_link']                 ='Aktivér din konto';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Glemt password-bekræftelse';
$lang['email_forgot_password_heading']       = 'Nulstil adgangskode til %s';
$lang['email_forgot_password_subheading']    = 'Klik på dette link til %s.';
$lang['email_forgot_password_link']          = 'Nulstil din adgangskode';

// New Password Email
$lang['email_new_password_subject']          = 'Nyt kodeord';
$lang['email_new_password_heading']          = 'Ny adgangskode til %s';
$lang['email_new_password_subheading']       = 'Dit kodeord er nulstillet til: %s';
