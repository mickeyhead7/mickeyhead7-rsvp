<?php

namespace Mickeyhead7\Rsvp;

use Mickeyhead7\Rsvp\Response\JsonapiResponse;
use Mickeyhead7\Rsvp\Response\ResponseAbstract;
use Mickeyhead7\Rsvp\Resource\ResourceInterface;

class Manager
{

    /**
     * Response object
     *
     * @var
     */
    private $response;

    /**
     * The current resource being processed
     *
     * @var
     */
    private $resource;

    public function __construct(ResponseAbstract $response = null)
    {
        if ($response) {
            $this->response = $response;
        } else {
            $this->response = new JsonapiResponse();
        }
    }

    /**
     * Set the resource data
     *
     * @param Resource\ResourceAbstract $resource
     * @return $this
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Gret the resource object
     *
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Create and return the resource data
     *
     * @return ResponseBag
     */
    public function createResponse()
    {
        // Cannot continue if a resource has not been set
        if (!$this->resource instanceof ResourceInterface) {
            return $this->response;
        }

        return $this->response
            ->setResource($this->resource)
            ->create();
    }

}
