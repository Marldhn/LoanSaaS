<?php

class Auth {

    public static function check() {
        session_start();
        return isset($_SESSION['user']);
    }

    public static function user() {
        session_start();
        return $_SESSION['user'] ?? null;
    }

    public static function role($role) {
        session_start();
        return isset($_SESSION['user']) && $_SESSION['user']['role'] == $role;
    }
}