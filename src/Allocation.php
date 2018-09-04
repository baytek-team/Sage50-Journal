<?php

namespace Baytek\Commerce\Sage50;

use Exception;

class Allocation extends Row
{
    /**
     * List of properties for allocations
     *
     * @var array
     */
    protected $properties = [
        'account' => null,
        'amount' => null,
        'description' => null
    ];

    /**
     * Fields that should be treated as strings
     *
     * @var array
     */
    protected $stringable = ['description'];

    /**
     * Optional fields that do not need columns
     *
     * @var array
     */
    protected $optional = ['description'];
}