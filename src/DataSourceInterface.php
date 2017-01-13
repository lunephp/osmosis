<?php


namespace Lune\Osmosis;


interface DataSourceInterface
{
    public function apply(array $filters):DataSourceInterface;
}