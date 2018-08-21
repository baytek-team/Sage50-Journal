<?php

namespace Baytek\Commerce\Sage50;

use Exception;

class Header extends Row
{
    /**
     * List of properties for Header
     *
     * @var array
     */
    protected $properties = [
        'date' => null,
        'id' => null,
        'description' => null,
        'currency' => null,
        'exchange' => null,
    ];

    protected $stringable = ['id', 'description'];
    protected $optional = ['description', 'currency', 'exchange'];
}