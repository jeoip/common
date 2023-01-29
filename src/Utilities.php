<?php

namespace Jeoip\Common;

class Utilities
{
    public static function isIp(string $ip): bool
    {
        return (filter_var($ip, FILTER_VALIDATE_IP)) ? true : false;
    }

    public static function isIpv4(string $ip): bool
    {
        return (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) ? true : false;
    }

    public static function isIpv6(string $ip): bool
    {
        return (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? true : false;
    }

    public static function ipToDec(string $ip): string
    {
        if (!extension_loaded('gmp')) {
            throw new \Exception("'gmp' extension is not available");
        }
        $bytes = inet_pton($ip);
        if (false === $bytes) {
            throw new \Exception();
        }
        $number = gmp_import($bytes);

        return gmp_strval($number, 10);
    }

    public static function decToIp(string $number, int $ver = 0): string
    {
        if (!extension_loaded('gmp')) {
            throw new \Exception("'gmp' extension is not available");
        }
        $number = gmp_init($number, 10);
        switch ($ver) {
            case 0:
                $bits = strlen(gmp_strval($number, 2));
                $bits = $bits <= 32 ? 32 : 128;
                break;
            case 4:
                $bits = 32;
                break;
            case 6:
                $bits = 128;
                break;
            default:
                throw new \InvalidArgumentException('ver must be 4 or 6');
        }

        $bytes = gmp_export($number);
        $packed = str_pad($bytes, $bits / 8, "\x00", STR_PAD_LEFT);

        $ip = inet_ntop($packed);
        if (false === $ip) {
            throw new \Exception();
        }

        return $ip;
    }
}
