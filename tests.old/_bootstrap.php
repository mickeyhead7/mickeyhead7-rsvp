<?php

// This is global bootstrap for autoloading
require_once (__DIR__ . '/../vendor/autoload.php');

/**
 * Dummy test data
 *
 * Class Data
 */
class Data {

    public $data = [
        [
            'id'    => 1,
            'title' => 'First Item',
            'links' => [
                'self' => 'http://www.test.com/test/1',
            ],
        ],
        [
            'id'    => 2,
            'title' => 'Second Item',
            'links' => [
                'self' => 'http://www.test.com/test/2',
            ],
        ],
    ];

}

/**
 * Test transformer
 *
 * Class Transformer
 */
class Transformer extends \Mickeyhead7\Rsvp\Transformer\TransformerAbstract
{

    protected $allowed_includes = ['test'];

    public function transform($item)
    {
        return $item;
    }

    public function includeTest($item)
    {
        return [
            'test' => true,
        ];
    }

}

/**
 * Test paginator
 *
 * Class PaginatorTest
 */
class Paginator implements \Mickeyhead7\Rsvp\Pagination\PaginatorInterface
{

    public function getSelf()
    {
        return 'http://www.test.com/tests?page=2';
    }

    public function getFirst()
    {
        return 'http://www.test.com/tests';
    }

    public function getPrevious()
    {
        return 'http://www.test.com/tests?pg=1';
    }

    public function getNext()
    {
        return 'http://www.test.com/tests?page=3';
    }

    public function getLast()
    {
        return 'http://www.test.com/tests?page=4';
    }

}
