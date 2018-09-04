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

    /**
     * Fields that should be treated as strings
     *
     * @var array
     */
    protected $stringable = ['id', 'description'];

    /**
     * Optional fields that do not need columns
     *
     * @var array
     */
    protected $optional = ['description', 'currency', 'exchange'];
}