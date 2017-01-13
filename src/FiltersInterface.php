<?php


namespace Lune\Osmosis;


interface FiltersInterface
{

    const FILTER_EQUALS = 'equals';
    const FILTER_IN_ARRAY = 'inArray';
    const FILTER_GREATER_THAN = 'greaterThan';
    const FILTER_GREATER_THAN_OR_EQUAL = 'greaterThanOrEqual';
    const FILTER_LESS_THAN = 'lessThan';
    const FILTER_LESS_THAN_OR_EQUAL = 'lessThanOrEqual';

    public function equals(string $fieldname, $value, bool $strict = true):FiltersInterface;

    public function inArray(string $fieldname, $value, bool $strict = true):FiltersInterface;

    public function greaterThan(string $fieldname, $value):FiltersInterface;

    public function greaterThanOrEqual(string $fieldname, $value):FiltersInterface;

    public function lessThan(string $fieldname, $value):FiltersInterface;

    public function lessThanOrEqual(string $fieldname, $value):FiltersInterface;
}