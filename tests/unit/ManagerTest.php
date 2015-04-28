<?php

class ManagerTest extends \Codeception\TestCase\Test
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
     * Ensure the Manager class is instantiated
     */
    public function testManager()
    {
        try {
            $manager = new \Responsible\Rsvp\Manager();
        } catch(Exception $e) {}

        $this->assertTrue($manager instanceof \Responsible\Rsvp\Manager);
    }

    /**
     * Test a dummy collection resource
     */
    public function testResourceCollection()
    {
        $data_obj = new DataTest();
        $data = $data_obj->data;
        $collection = new \Responsible\Rsvp\Resource\Collection($data, new TransformerTest());
        $collection->setPaginator(new PaginatorTest());
        $manager = new \Responsible\Rsvp\Manager();
        $manager->setResource($collection);
        $response = $manager->getResponse();

        $this->assertTrue($manager->getResource() instanceof \Responsible\Rsvp\Resource\Collection);
        $this->assertTrue($manager->getResource()->getTransformer() instanceof \Responsible\Rsvp\Transformer\TransformerAbstract);
        $this->assertTrue($manager->getResource()->getPaginator() instanceof \Responsible\Rsvp\Pagination\PaginatorInterface);
        $this->assertTrue($response instanceof \Responsible\Rsvp\ResponseBag);
        $this->assertTrue(is_array($response->data));
        $this->assertTrue(is_array($response->links));
    }

    /**
     * Test a dummy item resource
     */
    public function testResourceItem()
    {
        $data_obj = new DataTest();
        $data = $data_obj->data[0];
        $item = new \Responsible\Rsvp\Resource\Item($data, new TransformerTest());
        $manager = new \Responsible\Rsvp\Manager();
        $manager->setResource($item);
        $response = $manager->getResponse();

        $this->assertTrue($manager->getResource() instanceof \Responsible\Rsvp\Resource\Item);
        $this->assertTrue($manager->getResource()->getTransformer() instanceof \Responsible\Rsvp\Transformer\TransformerAbstract);
        $this->assertTrue($response instanceof \Responsible\Rsvp\ResponseBag);
        $this->assertTrue(is_array($response->data));
    }

}