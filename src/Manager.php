<?php

namespace Responsible\Rsvp;

use Responsible\Rsvp\Exceptions\ResourceException;
use \Responsible\Rsvp\Pagination\Pagination;
use \Responsible\Rsvp\Resource\Collection;
use \Responsible\Rsvp\Resource\Item;
use Responsible\Rsvp\Resource\ResourceAbstract;

class Manager
{

    /**
     * The current resource being processed
     *
     * @var
     */
    private $resource;

    /**
     * Response bag
     *
     * @var
     */
    private $response;

    /**
     * Set the resource data
     *
     * @param Resource\ResourceAbstract $resource
     * @return $this
     */
    public function setResource(\Responsible\Rsvp\Resource\ResourceAbstract $resource)
    {
        $this->resource = $resource;
        $this->response = new ResponseBag();
        $this->setResponse();

        return $this;
    }

    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set the initial data from the resource into the ResponseBag object
     *
     * @return $this
     */
    public function setResponse()
    {
        // Process a collection
        if ($this->resource instanceof Collection) {
            $collection = [];

            foreach ($this->resource->getData() as $item) {
                $new = new Item($item, $this->resource->getTransformer());
                if ($includes = $this->resource->getIncludes()) {
                    $new->setIncludes($includes);
                    $new->parseIncludes();
                }

                $collection[] = $new;
            }

            $this->response->data = $collection;

            // Paginate data if a paginator is set for a collection
            if ($paginator = $this->resource->getPaginator()) {
                $pagination = new Pagination($paginator);
                $this->response->links = $pagination->generateCollectionLinks();
            }

        // Process an item
        } else if ($this->resource instanceof Item) {
            if ($this->resource->getIncludes()) {
                $this->resource->parseIncludes();
            }

            $this->response->data = $this->resource;
        }

        // Meta
        if ($meta = $this->resource->getMeta()) {
            $this->response->meta = $meta;
        }

        return $this;
    }

    /**
     * Parse and return the resource data
     *
     * @return ResponseBag
     */
    public function getResponse()
    {
        // Process resource data
        $response = new ResponseBag();

        // Cannot continue if a resource has not been set
        if (!$this->resource instanceof ResourceAbstract) {
            return $response;
        }

        // Sanitize data
        $response->data = $this->sanitizeData();

        // Links
        if ($links = $this->response->links) {
            $response->links = $links;
        } else {
            unset($response->links);
        }

        // Meta
        if ($meta = $this->response->meta) {
            $response->meta = $meta;
        } else {
            unset($response->meta);
        }

        return $response;
    }

    /**
     * Sanitize a data set
     *
     * @param Resource\ResourceAbstract $data
     * @return array|mixed
     */
    public function sanitizeData()
    {
        $resource = $this->response->data;
        $result = [];

        // Sanitize a collection
        if ($this->resource instanceof Collection)
        {
            foreach ($resource as $item) {
                $result[] = $this->sanitizeItem($item);
            }

            // Sanitize an item
        } elseif ($this->resource instanceof Item) {
            $result = $this->sanitizeItem($resource);
        }

        return $result;
    }

    /**
     * Sanitize an item
     *
     * @param Item $item
     * @return mixed
     */
    private function sanitizeItem(Item $item)
    {
        $sanitized = $item->getTransformer()->transform($item->getData());
        $included = [];

        foreach($item->getIncluded() as $key => $include) {
            if ($include instanceof Collection) {
                foreach ($include->getData() as $item) {
                    $included[$key] = $include->getTransformer()->transform($item);
                }
            } elseif ($include instanceof Item) {
                $included[$key] = $include->getTransformer()->transform($include->getData());
            }
        }

        if ($included) {
            $sanitized['included'] = $included;
        }

        return $sanitized;
    }

}
