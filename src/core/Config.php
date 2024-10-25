<?php

namespace app\core;

class Config
{
    public static function load($file)
    {
        if (!file_exists($file)) {
            throw new \Exception("Configuration file not found: {$file}");
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), "#") === 0) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
            }
        }
    }

    public static function get($key, $default = null)
    {
        return $_ENV[$key] ?? getenv($key) ?? $default;
    }
}
