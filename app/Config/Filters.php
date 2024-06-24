<?php

namespace Config;

use App\Filters\JWTMiddleware;
use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'     => \CodeIgniter\Filters\CSRF::class,
        'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'jwt'      => JWTMiddleware::class,
    ];

    public $globals = [
        'before' => [
            // 'csrf',
        ],
        'after' => [
            'toolbar',
        ],
    ];

    public $methods = [];

    public $filters = [];
}
