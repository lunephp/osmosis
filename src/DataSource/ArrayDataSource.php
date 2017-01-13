<?php


namespace Lune\Osmosis\DataSource;


use Lune\Osmosis\DataSourceInterface;
use ArrayObject;
use Lune\Osmosis\FiltersInterface;
use Lune\Osmosis\Operator;

class ArrayDataSource extends ArrayObject implements DataSourceInterface
{

    public function applyFilters(array $filters):DataSourceInterface
    {

        $items = array_filter((array)$this, function ($item) use ($filters) {

            return array_reduce(array_keys($filters), function ($carry, $key) use ($item, $filters) {
                if ($carry) {
                    $value = $item[$key];
                    $operators = $filters[$key];
                    $carry = array_reduce($operators, function ($result, $operator) use ($value) {
                        if ($result) {
                            $result = $this->applyOperator($operator, $value);
                        }

                        return $result;
                    }, true);
                }

                return $carry;
            }, true);
        });

        return new ArrayDataSource($items);
    }

    protected function applyOperator(Operator $operator, $value):bool
    {

        switch ($operator->getType()) {
            case FiltersInterface::FILTER_EQUALS:
                return $operator->isStrict() ? $value === $operator->getValue() : $value == $operator->getValue();

            case FiltersInterface::FILTER_IN_ARRAY:
                return in_array($value, $operator->getValue(), $operator->isStrict());

            case FiltersInterface::FILTER_GREATER_THAN:
                return $value > $operator->getValue();

            case FiltersInterface::FILTER_GREATER_THAN_OR_EQUAL:
                return $value >= $operator->getValue();

            case FiltersInterface::FILTER_LESS_THAN:
                return $value < $operator->getValue();

            case FiltersInterface::FILTER_LESS_THAN_OR_EQUAL:
                return $value <= $operator->getValue();

            default:
                throw new \LogicException(sprintf('Unknown operator: %s', $operator->getType()));
        }

    }


}