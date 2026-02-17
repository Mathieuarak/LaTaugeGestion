<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;
use CodeIgniter\Shield\Filters\AuthRates;
use CodeIgniter\Shield\Filters\ChainAuth;
use CodeIgniter\Shield\Filters\GroupFilter;
use CodeIgniter\Shield\Filters\PermissionFilter;
use CodeIgniter\Shield\Filters\SessionAuth;
use CodeIgniter\Shield\Filters\TokenAuth;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'session'       => SessionAuth::class,
        'tokens'        => TokenAuth::class,
        'chain'         => ChainAuth::class,
        'auth-rates'    => AuthRates::class,
        'group'         => GroupFilter::class,
        'permission'    => PermissionFilter::class,
    ];

    public array $globals = [
        'before' => [
            // 'forcehttps', // Décommentez si vous voulez forcer HTTPS
        ],
        'after'  => [
            'toolbar',
        ],
    ];

    public array $methods = [];
    public array $filters = [];
}