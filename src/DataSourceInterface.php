<?php


namespace Lune\Osmosis;


interface DataSourceInterface
{
    public function applyFilters(array $filters):DataSourceInterface;
}