<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\DebugToolbar;

class Filters extends BaseFilters
{
    public array $aliases = [
        'toolbar' => DebugToolbar::class,
    ];

    public array $globals = [
        'before' => [],
        'after'  => ['toolbar'],
    ];

    public array $methods = [];
    public array $filters = [];
}