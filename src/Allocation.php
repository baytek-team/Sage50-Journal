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

    protected $stringable = ['description'];
    protected $optional = ['description'];

    
}