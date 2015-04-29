<?php

class TransformerTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {

    }

    protected function _after()
    {

    }

    /**
     * Test the Transformer
     */
    public function testTransformer()
    {
        $data_obj = new Data();
        $data = $data_obj->data[0];
        $item = new \Responsible\Rsvp\Resource\Item($data, new Transformer());
        $transformed = $item->getTransformer()->transform($item->getData());

        $this->assertTrue(is_array($transformed));
    }

}