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
            'id' => 1,
            'title' => 'First Item',
        ],
        [
            'id' => 2,
            'title' => 'Second Item',
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
