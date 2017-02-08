<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Http;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionAuthenticator
{
    /**
     * @param SessionInterface $session
     * @param int $userId
     */
    public function logIn(SessionInterface $session, $userId)
    {
        $session->migrate();
        $session->set('user_id', $userId);
    }

    /**
     * @param SessionInterface $session
     */
    public function logOut(SessionInterface $session)
    {
        $session->invalidate();
    }
}