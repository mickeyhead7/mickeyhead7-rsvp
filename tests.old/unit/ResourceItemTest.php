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
        $item = new \Mickeyhead7\Rsvp\Resource\Item($data, new Transformer());
        $manager = new \Mickeyhead7\Rsvp\Manager();
        $manager->setResource($item);
        $response = $manager->createResponse();

        $this->assertTrue($manager->getResource() instanceof \Mickeyhead7\Rsvp\Resource\Item);
        $this->assertTrue($manager->getResource()->getTransformer() instanceof \Mickeyhead7\Rsvp\Transformer\TransformerAbstract);
        $this->assertTrue($response instanceof \Mickeyhead7\Rsvp\ResponseBag);
        $this->assertTrue(is_array($response->data));
    }

    public function testIncludes()
    {
        $includes = [
            'test' => [],
        ];

        $data_obj = new Data();
        $data = $data_obj->data[0];
        $item = new \Mickeyhead7\Rsvp\Resource\Item($data, new Transformer());
        $item->setIncludes(new \Mickeyhead7\Rsvp\IncludeParams($includes));
        $item->parseIncludes();

        $this->assertTrue(is_array($item->getIncluded()));
    }

}