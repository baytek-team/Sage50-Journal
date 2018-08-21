<?php

namespace Baytek\Commerce\Sage50;

use Exception;

abstract class Row 
{
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
        if (!array_key_exists($property, $this->properties)) {
            throw new Exception('Unknown property '.$property);
        }

        return $this->properties[$property];
    }

    /**
     * Magic setter that validates the property
     *
     * @param string $property
     * @return void
     */
    public function __set(string $property, $value)
    {
        if (!array_key_exists($property, $this->properties)) {
            throw new Exception('Unknown property '.$property);
        }

        $this->properties[$property] = $value;
    }

    /**
     * Stringify the header used in file generation
     *
     * @return string
     */
    public function __toString() 
    {
        // Filter the optional properties so they don't show up as blank.
        $properties = array_filter(
            $this->properties, 
            function ($field, $key) {
                if (in_array($key, $this->optional) && empty($field)) {
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
                if (in_array($key, $this->stringable) 
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