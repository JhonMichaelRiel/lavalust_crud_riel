<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    public function handle(Closure $next)
    {
        if (!$this->_is_authenticated()) {
            redirect('login');
            return;
        }

        return $next();
    }

    private function _is_authenticated()
    {
        return !empty($_SESSION['logged_in']);
    }
}
