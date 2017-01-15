# Osmosis
A fluent interface for filtering data.

## Installation
The (highly) recommended way to install Osmosis is by using [Composer](https://getcomposer.org/)

```bash
composer require lune/osmosis
```

## Operators
The following operators are available:
 
equals 

inArray

greaterThan

greaterThanOrEqual

lessThan

lessThanOrEqual

not

notInArray


## DataSources
The following DataSources are bundled:

### ArrayDataSource
Wraps an array and filters it

```php
$filter = new Lune\Osmosis\Filter()
$filter
    ->equals('a', 1)
    ->greaterThan('b', 100);

$array = [
    ['a'=>1, 'b'=>20],
    ['a'=>1, 'b'=>120],
    ['a'=>3, 'b'=>120]        
];

//Convert our array to a DataSourceInterface object
$source = new Lune\Osmosis\DataSource\ArrayDataSource($array);

//Apply the filter to our datasource
$result = $filter->apply($source);

print_r((array) $result);
//[['a'=>1, 'b'=>'120']];

```
### SQLDataSource
Creates partial sql:

```php
$filter = new Lune\Osmosis\Filter()
$filter->equals('ID', 1);

$source = new Lune\Osmosis\DataSource\SQLDataSource();
$result = $filter->apply($source);

//Execution example
$pdo = new \PDO(...);
$statement = $pdo->prepare("SELECT * FROM `users` WHERE {$result}");
$statement->execute($result->getVariables())->fetchAll();
```
**Please note**
Osmosis is by no means a complete query builder, nor does it aim to be one.

## Defining filters

To add filters, simply use the methods provided:

```php
$filter = new Lune\Osmosis\Filter()
$filter
    ->equals('a', 1)
    ->greaterThan('b', 100);
```

You can also use a callable as the constructor parameter:
```php
$filter = new Lune\Osmosis\Filter(function(FilterInterface $f){
        $f->equals('a', 1)->greaterThan('b', 100);
});
```