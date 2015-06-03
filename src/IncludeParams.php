<?php

namespace Mickeyhead7\Rsvp;

class IncludeParams
{

    /**
     * Include paramters data
     *
     * @var array
     */
    protected $data;

    /**
     * Costructor
     *
     * @param array $data
     */
    public function __construct(Array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Set the include paramter data
     *
     * @param array $data
     * @return $this
     */
    public function setData(Array $data = [])
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set a specific include paramter
     *
     * @param $key
     * @param array $value
     * @return $this
     */
    public function setDataValue($key, Array $value = [])
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get the include paramter data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get a specific include parameter
     *
     * @param $key
     * @return null
     */
    public function get($key)
    {
        if (isset($this->getData()[$key])) {
            return $this->getData()[$key];
        }

        return null;
    }

}
