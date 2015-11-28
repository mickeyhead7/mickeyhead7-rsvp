<?php

class ResourceCollectionTest extends \Codeception\TestCase\Test
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
     * Test an collection resource
     */
    public function testResourceCollection()
    {
        $data_obj = new Data();
        $data = $data_obj->data;
        $collection = new \Mickeyhead7\Rsvp\Resource\Collection($data, new Transformer());
        $collection->setPaginator(new Paginator());
        $manager = new \Mickeyhead7\Rsvp\Manager();
        $manager->setResource($collection);
        $response = $manager->createResponse();

        $this->assertTrue($manager->getResource() instanceof \Mickeyhead7\Rsvp\Resource\Collection);
        $this->assertTrue($manager->getResource()->getTransformer() instanceof \Mickeyhead7\Rsvp\Transformer\TransformerAbstract);
        $this->assertTrue($manager->getResource()->getPaginator() instanceof \Mickeyhead7\Rsvp\Pagination\PaginatorInterface);
        $this->assertTrue($response instanceof \Mickeyhead7\Rsvp\ResponseBag);
        $this->assertTrue(is_array($response->data));
        $this->assertTrue(is_array($response->links));
    }

}