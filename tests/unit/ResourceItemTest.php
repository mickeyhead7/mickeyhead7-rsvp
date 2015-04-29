<?php

class ResourceItemTest extends \Codeception\TestCase\Test
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
     * Test an item resource
     */
    public function testResourceItem()
    {
        $data_obj = new Data();
        $data = $data_obj->data[0];
        $item = new \Responsible\Rsvp\Resource\Item($data, new Transformer());
        $manager = new \Responsible\Rsvp\Manager();
        $manager->setResource($item);
        $response = $manager->getResponse();

        $this->assertTrue($manager->getResource() instanceof \Responsible\Rsvp\Resource\Item);
        $this->assertTrue($manager->getResource()->getTransformer() instanceof \Responsible\Rsvp\Transformer\TransformerAbstract);
        $this->assertTrue($response instanceof \Responsible\Rsvp\ResponseBag);
        $this->assertTrue(is_array($response->data));
    }

    public function testIncludes()
    {
        $includes = [
            'test' => [],
        ];

        $data_obj = new Data();
        $data = $data_obj->data[0];
        $item = new \Responsible\Rsvp\Resource\Item($data, new Transformer());
        $item->setIncludes(new \Responsible\Rsvp\IncludeParams($includes));
        $item->parseIncludes();

        $this->assertTrue(is_array($item->getIncluded()));
    }

}