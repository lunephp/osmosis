<?php


namespace Lune\Osmosis;


class Filters implements FiltersInterface
{

    private $filters = [];

    public function __construct(callable $constructor = null)
    {
        if ( ! is_null($constructor)) {
            call_user_func($constructor, $this);
        }
    }

    private function addOperator(string $type, string $fieldname, $value, bool $strict = false)
    {
        $this->filters[$fieldname][] = new Operator($type, $fieldname, $value, $strict);
    }

    public function equals(string $fieldname, $value, bool $strict = true):FiltersInterface
    {
        $this->addOperator(FiltersInterface::FILTER_EQUALS, $fieldname, $value, $strict);

        return $this;
    }

    public function inArray(string $fieldname, array $value, bool $strict = true):FiltersInterface
    {
        $this->addOperator(FiltersInterface::FILTER_IN_ARRAY, $fieldname, $value, $strict);

        return $this;
    }

    public function greaterThan(string $fieldname, $value):FiltersInterface
    {
        $this->addOperator(FiltersInterface::FILTER_GREATER_THAN, $fieldname, $value);

        return $this;
    }

    public function greaterThanOrEqual(string $fieldname, $value):FiltersInterface
    {
        $this->addOperator(FiltersInterface::FILTER_GREATER_THAN_OR_EQUAL, $fieldname, $value);

        return $this;
    }

    public function lessThan(string $fieldname, $value):FiltersInterface
    {
        $this->addOperator(FiltersInterface::FILTER_LESS_THAN, $fieldname, $value);

        return $this;
    }

    public function lessThanOrEqual(string $fieldname, $value):FiltersInterface
    {
        $this->addOperator(FiltersInterface::FILTER_LESS_THAN_OR_EQUAL, $fieldname, $value);

        return $this;
    }

    public function not(string $fieldname, $value, bool $strict = true):FiltersInterface
    {
        $this->addOperator(FiltersInterface::FILTER_NOT, $fieldname, $value, $strict);
        return $this;
    }

    public function notInArray(string $fieldname, array $value, bool $strict = true):FiltersInterface
    {
        $this->addOperator(FiltersInterface::FILTER_NOT_IN_ARRAY, $fieldname, $value, $strict);
        return $this;
    }

    public function apply(DataSourceInterface $target):DataSourceInterface
    {
        return $target->applyFilters($this->filters);
    }


}