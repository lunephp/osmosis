<?php


namespace Lune\Osmosis\Test;


use Lune\Osmosis\DataSource\ArrayDataSource;
use Lune\Osmosis\DataSourceInterface;
use Lune\Osmosis\Filters;
use Lune\Osmosis\FiltersInterface;
use PHPUnit\Framework\TestCase;

class ArrayFilterTest extends TestCase
{

    private function getArraySource():ArrayDataSource
    {
        return new ArrayDataSource([
            ['a' => 1, 'b' => 10],
            ['a' => 2, 'b' => 20],
            ['a' => 3, 'b' => 30],
            ['a' => 4, 'b' => 40]
        ]);
    }


    private function getResultsArray(Filters $filters, DataSourceInterface $dataSource)
    {
        return array_values((array)$filters->apply($dataSource));
    }

    public function testEqualsFilter()
    {
        $filters = new Filters();
        $filters->equals('a', 1);

        $source = $this->getArraySource();

        $expected = [
            ['a' => 1, 'b' => 10]
        ];
        $this->assertEquals($expected, $this->getResultsArray($filters, $source));
    }

    public function testInArrayFilter()
    {
        $filters = new Filters();
        $filters->inArray('b', [10, 20]);

        $source = $this->getArraySource();

        $expected = [
            ['a' => 1, 'b' => 10],
            ['a' => 2, 'b' => 20],
        ];
        $this->assertEquals($expected, $this->getResultsArray($filters, $source));
    }

    public function testGreaterThanFilter()
    {
        $filters = new Filters();
        $filters->greaterThan('a', 3);

        $source = $this->getArraySource();

        $expected = [
            ['a' => 4, 'b' => 40],
        ];
        $this->assertEquals($expected, $this->getResultsArray($filters, $source));
    }

    public function testGreaterThanOrEqualFilter()
    {
        $filters = new Filters();
        $filters->greaterThanOrEqual('a', 3);

        $source = $this->getArraySource();

        $expected = [
            ['a' => 3, 'b' => 30],
            ['a' => 4, 'b' => 40],
        ];
        $this->assertEquals($expected, $this->getResultsArray($filters, $source));
    }

    public function testLessThanFilter()
    {
        $filters = new Filters();
        $filters->lessThan('a', 2);

        $source = $this->getArraySource();

        $expected = [
            ['a' => 1, 'b' => 10]
        ];
        $this->assertEquals($expected, $this->getResultsArray($filters, $source));
    }

    public function testLessThanOrEqualFilter()
    {
        $filters = new Filters();
        $filters->lessThanOrEqual('a', 2);

        $source = $this->getArraySource();

        $expected = [
            ['a' => 1, 'b' => 10],
            ['a' => 2, 'b' => 20],
        ];
        $this->assertEquals($expected, $this->getResultsArray($filters, $source));
    }

    public function testNot()
    {
        $filters = new Filters();
        $filters->not('a', 1);
        $source = $this->getArraySource();

        $expected = [
            ['a' => 2, 'b' => 20],
            ['a' => 3, 'b' => 30],
            ['a' => 4, 'b' => 40],
        ];
        $this->assertEquals($expected, $this->getResultsArray($filters, $source));
    }


    public function testNotInArray()
    {
        $filters = new Filters();
        $filters->notInArray('a', [1, 2]);
        $source = $this->getArraySource();

        $expected = [
            ['a' => 3, 'b' => 30],
            ['a' => 4, 'b' => 40],
        ];
        $this->assertEquals($expected, $this->getResultsArray($filters, $source));
    }
}