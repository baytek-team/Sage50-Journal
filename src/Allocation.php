<?php

namespace Baytek\Commerce\Sage50;

use Exception;

class Allocation 
{
    /**
     * List of properties for allocations
     *
     * @var array
     */
    private $_properties = [
        'account' => null,
        'amount' => null,
        'description' => null
    ];

    private $_stringable = ['description'];
    private $_optional = ['description'];

    /**
     * Constructor that can take an array of properties
     *
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Magic getter that validates the property
     *
     * @param string $property
     * @return void
     */
    public function __get(string $property)
    {
        if (!array_key_exists($property, $this->_properties)) {
            throw new Exception('Unknown property '.$property);
        }

        return $this->_properties[$property];
    }

    /**
     * Magic setter that validates the property
     *
     * @param string $property
     * @return void
     */
    public function __set(string $property, $value)
    {
        if (!array_key_exists($property, $this->_properties)) {
            throw new Exception('Unknown property '.$property);
        }

        $this->_properties[$property] = $value;
    }

    /**
     * Stringify the allocation used in file generation
     *
     * @return string
     */
    public function __toString() 
    {
        // Filter the optional properties so they don't show up as blank.
        $properties = array_filter(
            $this->_properties, 
            function ($field, $key) {
                if (in_array($key, $this->_optional) && empty($field)) {
                    return false;
                }
                return true;
            },
            ARRAY_FILTER_USE_BOTH
        );

        // Walk through the fields to ensure what should be in quotes is.
        array_walk(
            $properties,
            function (&$field, $key) {
                if ($key == 'description' 
                    || stripos($field, ' ') !== false 
                    || stripos($field, ',') !== false
                ) {
                    $field = "\"$field\"";
                }
                
                return $field;
            }
        );

        return implode(',', array_values($properties))."\r\n";
    }
}