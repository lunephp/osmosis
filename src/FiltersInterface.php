<?php


namespace Lune\Osmosis;


interface FiltersInterface
{
    public function equals(string $fieldname, $value, bool $strict = true):FiltersInterface;

    public function inArray(string $fieldname, $value, bool $strict = true):FiltersInterface;

    public function greaterThan(string $fieldname, $value):FiltersInterface;

    public function greaterThanOrEqual(string $fieldname, $value):FiltersInterface;

    public function lessThan(string $fieldname, $value):FiltersInterface;

    public function lessThanOrEqual(string $fieldname, $value):FiltersInterface;
}