<?php


namespace Lune\Osmosis;


interface FilterInterface
{
    public function equals(string $fieldname, $value, bool $strict = true):FilterInterface;

    public function inArray(string $fieldname, $value, bool $strict = true):FilterInterface;

    public function greaterThan(string $fieldname, $value):FilterInterface;

    public function greaterThanOrEqual(string $fieldname, $value):FilterInterface;

    public function lessThan(string $fieldname, $value):FilterInterface;

    public function lessThanOrEqual(string $fieldname, $value):FilterInterface;
}