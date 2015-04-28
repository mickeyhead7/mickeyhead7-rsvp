<?php

// This is global bootstrap for autoloading
require_once (__DIR__ . '/../vendor/autoload.php');

/**
 * Dummy test data
 *
 * Class DataTest
 */
class DataTest {

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
 * Class TransformerTest
 */
class TransformerTest extends \Responsible\Rsvp\Transformer\TransformerAbstract
{

    public function transform($item)
    {
        return $item;
    }

}

/**
 * Test paginator
 *
 * Class PaginatorTest
 */
class PaginatorTest implements \Responsible\Rsvp\Pagination\PaginatorInterface
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
