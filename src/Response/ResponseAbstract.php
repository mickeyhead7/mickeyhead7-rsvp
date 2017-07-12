<?php

namespace Mickeyhead7\Rsvp\Response;

use Mickeyhead7\Rsvp\Resource\ResourceInterface;

abstract class ResponseAbstract
{
    /**
     * Resource object
     *
     * @var
     */
    protected $resource;

    /**
     * Set the resource object
     *
     * @param ResourceInterface $resource
     * @return $this
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    abstract public function create();

    /**
     * Returns self as a JSON object
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this);
    }

}
