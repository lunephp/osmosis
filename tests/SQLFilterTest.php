<?php


namespace Lune\Osmosis\Test;


use Lune\Osmosis\DataSource\SQLDataSource;
use Lune\Osmosis\Filters;
use PHPUnit\Framework\TestCase;

class SQLFilterTest extends TestCase
{


    public function testEqualsFilter()
    {
        $filters = new Filters();
        $filters->equals('a', 1);

        $query = $filters->apply(new SQLDataSource([], [], 'test'));

        $this->assertEquals('`a` = :test_0', $query->getQueryString());
        $expected = [
            ':test_0' => 1
        ];
        $this->assertEquals($expected, $query->getVariables());
    }

    public function testInArrayFilter()
    {
        $filters = new Filters();
        $filters->inArray('a', [1, 2]);

        $query = $filters->apply(new SQLDataSource([], [], 'test'));

        $this->assertEquals('`a` IN (:test_0,:test_1)', $query->getQueryString());

        $expected = [
            ':test_0' => 1,
            ':test_1' => 2
        ];

        $this->assertEquals($expected, $query->getVariables());
    }


    public function testGreaterThanFilter()
    {
        $filters = new Filters();
        $filters->greaterThan('a', 1);

        $query = $filters->apply(new SQLDataSource([], [], 'test'));
        $this->assertEquals('`a` > :test_0', $query->getQueryString());

        $expected = [
            ':test_0' => 1
        ];

        $this->assertEquals($expected, $query->getVariables());
    }


    public function testGreaterThanOrEqualFilter()
    {
        $filters = new Filters();
        $filters->greaterThanOrEqual('a', 1);

        $query = $filters->apply(new SQLDataSource([], [], 'test'));
        $this->assertEquals('`a` >= :test_0', $query->getQueryString());

        $expected = [
            ':test_0' => 1
        ];

        $this->assertEquals($expected, $query->getVariables());
    }

    public function testLessThanFilter()
    {
        $filters = new Filters();
        $filters->lessThan('a', 1);

        $query = $filters->apply(new SQLDataSource([], [], 'test'));
        $this->assertEquals('`a` < :test_0', $query->getQueryString());

        $expected = [
            ':test_0' => 1
        ];

        $this->assertEquals($expected, $query->getVariables());
    }


    public function testLessThanOrEqualFilter()
    {
        $filters = new Filters();
        $filters->lessThanOrEqual('a', 1);

        $query = $filters->apply(new SQLDataSource([], [], 'test'));
        $this->assertEquals('`a` <= :test_0', $query->getQueryString());

        $expected = [
            ':test_0' => 1
        ];

        $this->assertEquals($expected, $query->getVariables());
    }

    public function testNot()
    {
        $filters = new Filters();
        $filters->not('a', 1);

        $query = $filters->apply(new SQLDataSource([], [], 'test'));

        $this->assertEquals('`a` <> :test_0', $query->getQueryString());
        $expected = [
            ':test_0' => 1
        ];
        $this->assertEquals($expected, $query->getVariables());
    }

    public function testInNotArrayFilter()
    {
        $filters = new Filters();
        $filters->notInArray('a', [1, 2]);

        $query = $filters->apply(new SQLDataSource([], [], 'test'));

        $this->assertEquals('`a` NOT IN (:test_0,:test_1)', $query->getQueryString());

        $expected = [
            ':test_0' => 1,
            ':test_1' => 2
        ];

        $this->assertEquals($expected, $query->getVariables());
    }
}