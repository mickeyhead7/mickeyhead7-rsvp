<?php

namespace Mickeyhead7\Rsvp;

use Mickeyhead7\Rsvp\Exceptions\ResourceException;
use \Mickeyhead7\Rsvp\Pagination\Pagination;
use \Mickeyhead7\Rsvp\Resource\Collection;
use \Mickeyhead7\Rsvp\Resource\Item;
use Mickeyhead7\Rsvp\Resource\ResourceAbstract;

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
    public function setResource(\Mickeyhead7\Rsvp\Resource\ResourceAbstract $resource)
    {
        $this->resource = $resource;
        $this->response = new ResponseBag();
//        $this->setResponse();

        return $this;
    }

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
        // Process resource data
        $response = new ResponseBag();

        // Cannot continue if a resource has not been set
        if (!$this->resource instanceof ResourceAbstract) {
            return $response;
        }

        // Process a collection
        elseif ($this->resource instanceof Collection) {
            $collection = [];

            foreach ($this->resource->getData() as $item) {
                $new = new Item($item, $this->resource->getTransformer());
                if ($includes = $this->resource->getIncludes()) {
                    $new->setIncludes($includes);
                    $new->parseIncludes();
                }

                $collection[] = $new;
            }

            $data = $collection;

            // Paginate data if a paginator is set for a collection
            if ($paginator = $this->resource->getPaginator()) {
                $pagination = new Pagination($paginator);
                $response->links = $pagination->generateCollectionLinks();
            }
        }

        // Process an item
        elseif ($this->resource instanceof Item) {
            if ($this->resource->getIncludes()) {
                $this->resource->parseIncludes();
            }

            $data = $this->resource;
        }

        // Sanitize data
        $response->data = $this->sanitizeData($data);

        // Links
        if (!$links = $response->links) {
            unset($response->links);
        }

        // Meta
        if ($meta = $this->resource->getMeta()) {
            $response->meta = $meta;
        } else {
            unset($response->meta);
        }

        $this->response = $response;

        return $response;
    }

    /**
     * Sanitize a data set
     *
     * @param Resource\ResourceAbstract $data
     * @return array|mixed
     */
    public function sanitizeData($data)
    {
        $result = [];

        // Sanitize a collection
        if ($this->resource instanceof Collection)
        {
            foreach ($data as $item) {
                $result[] = $this->sanitizeItem($item);
            }

            // Sanitize an item
        } elseif ($this->resource instanceof Item) {
            $result = $this->sanitizeItem($data);
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
                    $included[$key][] = $include->getTransformer()->transform($item);
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
