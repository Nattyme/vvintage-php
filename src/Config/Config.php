<?php

namespace Vvintage\Config;

class Config
{
    public const DB_HOST = 'localhost';
    public const DB_NAME = 'vvintage';
    public const DB_USER = 'root';
    public const DB_PASS = '';

    public const SITE_NAME = 'vvintage';
    public const SITE_EMAIL = 'info@vvintage.com';

    public static function getHost(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
        return $protocol . $_SERVER['HTTP_HOST'] . '/';
    }

    public static function getRoot(): string
    {
      return rtrim(dirname(__DIR__, 2), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }
}
