<?php

namespace Baytek\Commerce\Sage50\Traits;

use Exception;

trait StringifyColumns 
{
    /**
     * Make fields that should be stringified
     *
     * @param array $columns
     * @param array $stringable
     * @return array
     */
    public function stringifyColumns(array $columns, array $stringable): array
    {
        // This method is not complete, not using stringable yet
        return array_map(
            function ($field) {
                if (stripos($field, ' ') !== false) {
                    return "\"$field\"";
                }

                if (stripos($field, ',') !== false) {
                    return "\"$field\"";
                }
                return $field;
            }, 
            $columns
        );
    }
} 