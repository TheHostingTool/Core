<?php


namespace TheHostingTool\Component\Security\Event;

/**
 * This class contains all of the available security events.
 */
final class SecurityEvents
{
    // permission events
    const PERMISSION_UPDATE = 'tht_security.permission_update';

    // user
    const PASSWORD_UPDATE = 'tht_security.password_update';
    const EMAIL_UPDATE = 'tht_security.email_update';
    const PASSWORD_RESET = 'tht_security.password_reset';
    const USER_LOGIN = 'tht_security.user_login';
    const USER_LOGOUT = 'tht_security.user_logout';
    const LOGIN_FAILED = 'tht_security.login_failed';

}