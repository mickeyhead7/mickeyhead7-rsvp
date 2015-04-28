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
        try {
            // Dummy collection data fail
            $data_obj = new DataTest();
            $data = $data_obj->data;
            $collection = new \Responsible\Rsvp\Resource\Collection($data, new TransformerTest());
            $manager = new \Responsible\Rsvp\Manager();
            $manager->setResource($collection);
        } catch(Exception $e) {
            $this->assertTrue($this->manager->getResource());
        }
    }

}