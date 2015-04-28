<?php

namespace Responsible\Rsvp;

use Api\Controllers\Resource;
use \Symfony\Component\HttpFoundation\Request;
use \Responsible\Rsvp\Pagination\Pagination;
use \Responsible\Rsvp\Resource\Collection;
use \Responsible\Rsvp\Resource\Item;

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
     * Set the inital data from the resource into the ResponseBag object
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
                $new->setIncluded($this->parseIncludes($new));
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
            $this->resource->setIncluded($this->parseIncludes($this->resource));
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

        // Sanitize a collection
        if ($this->resource instanceof Collection) {
            $data = [];
            foreach ($this->response->data as $item) {
                $data[] = $this->sanitizeData($item);
            }
            $response->data = $data;
        }

        // Sanitize an Item
        elseif ($this->resource instanceof Item) {
            $response->data = $this->sanitizeData($this->response->data);
        }

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
    public function sanitizeData(\Responsible\Rsvp\Resource\ResourceAbstract $data)
    {
        $result = [];

        // Sanitize a collection
        if ($data instanceof Collection)
        {
            foreach ($data as $item) {
                $sanitized = $data->getTransformer()->transform($item->getData());
                $result[] = $sanitized;
            }

            // Sanitize an item
        } elseif ($data instanceof Item) {
            $sanitized = $data->getTransformer()->transform($data->getData());
            $included = [];

            foreach($data->getIncluded() as $key => $include) {
                $included[$key] = $include->getTransformer()->transform($include->getData());
            }

            $sanitized['included'] = $included;
            $result = $sanitized;
        }

        return $result;
    }

    /**
     * Set the includes to be parsed
     *
     * @param Item $item
     * @return array
     */
    public function parseIncludes(\Responsible\Rsvp\Resource\Item $item)
    {
        $data = [];
        $includes = explode(',', Request::createFromGlobals()->query->get('includes'));

        foreach ($includes as $include) {
            $method = 'include' . ucfirst($include);
            $transformer = $item->getTransformer();
            $allowed = $transformer->getAllowedIncludes();

            if (in_array($include, $allowed) && method_exists($transformer, $method)) {
                $result = $transformer->$method($item->getData());
                $data[$include] = $result;
            }
        }

        return $data;
    }

}
