<?php


namespace Lune\Osmosis\DataSource;

use Lune\Osmosis\DataSourceInterface;
use Lune\Osmosis\Operator;
use Lune\Osmosis\FiltersInterface;

class SQLDataSource implements DataSourceInterface
{

    private $filters = [];
    private $variables = [];
    private $prefix = '';

    public function __construct(array $filters = [], array $variables = [], string $prefix = null)
    {
        $this->filters = $filters;
        $this->variables = $variables;
        $this->prefix = ':' . $prefix ?? uniqid();
    }

    public function __toString()
    {
        return $this->getQueryString();
    }

    public function applyFilters(array $filters):DataSourceInterface
    {
        array_map(function ($fieldname) use ($filters) {
            array_map(function ($operator) use ($fieldname) {
                $this->addFilter($fieldname, $operator);
            }, $filters[$fieldname]);
        }, array_keys($filters));

        return $this;
    }

    /**
     * Add a variable and return the key for binding
     *
     * @param $var
     *
     * @return string
     */
    private function addVariable($var):string
    {
        $key = "{$this->prefix}_" . count($this->variables);
        $this->variables[$key] = $var;

        return $key;
    }


    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    public function getQueryString():string
    {
        return implode(' AND ', $this->filters);
    }

    protected function addFilter(string $fieldname, Operator $operator)
    {
        switch ($operator->getType()) {
            case FiltersInterface::FILTER_EQUALS:
                $key = $this->addVariable($operator->getValue());
                $this->filters[] = "`{$operator->getFieldname()}` = {$key}";
                break;
            case FiltersInterface::FILTER_IN_ARRAY:
                $keys = array_map(function ($value) {
                    return $this->addVariable($value);
                }, $operator->getValue());

                $this->filters[] = "`{$operator->getFieldname()}` IN (" . implode(',', $keys) . ")";
                break;

            case FiltersInterface::FILTER_GREATER_THAN:
                $key = $this->addVariable($operator->getValue());
                $this->filters[] = "`{$operator->getFieldname()}` > {$key}";
                break;

            case FiltersInterface::FILTER_GREATER_THAN_OR_EQUAL:
                $key = $this->addVariable($operator->getValue());
                $this->filters[] = "`{$operator->getFieldname()}` >= {$key}";
                break;

            case FiltersInterface::FILTER_LESS_THAN:
                $key = $this->addVariable($operator->getValue());
                $this->filters[] = "`{$operator->getFieldname()}` < {$key}";
                break;

            case FiltersInterface::FILTER_LESS_THAN_OR_EQUAL:
                $key = $this->addVariable($operator->getValue());
                $this->filters[] = "`{$operator->getFieldname()}` <= {$key}";
                break;

            case FiltersInterface::FILTER_NOT:
                $key = $this->addVariable($operator->getValue());
                $this->filters[] = "`{$operator->getFieldname()}` <> {$key}";
                break;

            case FiltersInterface::FILTER_NOT_IN_ARRAY:
                $keys = array_map(function ($value) {
                    return $this->addVariable($value);
                }, $operator->getValue());

                $this->filters[] = "`{$operator->getFieldname()}` NOT IN (" . implode(',', $keys) . ")";
                break;

            default:
                throw new \LogicException(sprintf('Unknown operator: %s', $operator->getType()));
        }

    }

}