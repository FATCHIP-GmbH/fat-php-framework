<?php

namespace FatFramework;

class Auth
{

    public function login($sUsername)
    {
        $_SESSION['sUsername'] = $sUsername;
    }

    public function logout()
    {
        session_unset();
    }
}
