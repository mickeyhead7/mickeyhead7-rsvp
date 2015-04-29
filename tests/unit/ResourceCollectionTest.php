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
        $collection = new \Responsible\Rsvp\Resource\Collection($data, new Transformer());
        $collection->setPaginator(new Paginator());
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

}