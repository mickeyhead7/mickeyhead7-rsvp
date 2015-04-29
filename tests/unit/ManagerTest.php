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
        $manager = new \Responsible\Rsvp\Manager();

        $this->assertTrue($manager instanceof \Responsible\Rsvp\Manager);
    }

}