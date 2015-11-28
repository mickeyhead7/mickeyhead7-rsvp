<?php

namespace Mickeyhead7\Rsvp\Response;

use \Mickeyhead7\Rsvp\Resource\Collection;
use \Mickeyhead7\Rsvp\Resource\Item;
use \Mickeyhead7\Rsvp\Pagination\Pagination;

class JsonapiResponse extends ResponseAbstract
{

    /**
     * @var Resource data
     */
    public $data;

    /**
     * @var Resource links
     */
    public $links;

    /**
     * @var Resource meta data
     */
    public $meta;

    /**
     * @var Included data
     */
    public $included = [];

    /**
     * Create the response
     *
     * @return $this
     */
    public function create()
    {
        return $this
            ->setData()
            ->setLinks()
            ->setMeta();
    }

    /**
     * Creates the response
     *
     * @return $this Instance of self
     */
    public function setData()
    {
        // Process a collection
        if ($this->resource instanceof Collection) {
            $this->data = [];

            foreach ($this->resource->getData() as $resource) {
                $this->parseItem(new Item($resource, $this->resource->getTransformer()));
            }
        }

        // Process an item
        elseif ($this->resource instanceof Item) {
            $this->parseItem($this->resource);
        }

        return $this;
    }

    /**
     * Parses an item into response data
     *
     * @param Item $item Resource item
     * @return $this Instance of self
     */
    private function parseItem(Item $item)
    {
        // Get and format an item
        $tmp = $this->getFormattedItem($item);

        // Get related data
        $relationships = $this->getIncluded($item);
        $included = [];

        // Closure function to internally parse related includes
        $parseIncluded = function($key, Item $item, array $included = []) {
            $related = $this->getFormattedItem($item);

            if (!in_array($related, $this->included)) {
                $this->included[] = $related;
            }

            unset($related['attributes']);
            unset($related['links']);
            $included[$key][] = $related;

            return $included;
        };

        // Loop data to create includes response data
        foreach ($relationships as $key => $value) {
            if ($value instanceof Collection) {
                foreach ($value->getData() as $include_value) {
                    $included = $parseIncluded($key, new Item($include_value, $value->getTransformer()), $included);
                }
            } else if ($value instanceof Item) {
                $included = $parseIncluded($key, $value, $included);
            }
        }

        // Pass the included data into the item
        $tmp['relationships'] = $included;

        // Set the response data
        if (is_array($this->data)) {
            $this->data[] = $tmp;
        } else {
            $this->data = $tmp;
        }

        return $this;
    }

    /**
     * Formats an item ready for response
     *
     * @param Item $item Resource item
     * @return array Formatted item data
     */
    private function getFormattedItem(Item $item)
    {
        $data = [
            'type'       => $this->getFormattedName($item->getTransformer()),
            'id'         => $item->getData()->id,
            'attributes' => $item->sanitize(),
        ];

        if ($links = $item->getLinks()) {
            $data['links'] = $links;
        }

        return $data;
    }

    /**
     * Formats a class name for readable use in the response
     *
     * @param $class Class name to format
     * @return string Formatted name
     */
    private function getFormattedName($class)
    {
        $class_name = (substr(strrchr(get_class($class), "\\"), 1));
        $underscored = preg_replace('/([a-z])([A-Z])/', '$1_$2', $class_name);

        return strtolower($underscored);
    }

    /**
     * Gets the related data for a resource item
     *
     * @param Item $item Resource item
     * @return array|null Included data
     */
    private function getIncluded(Item $item)
    {
        if ($include_params = $this->resource->getIncludeParams()) {
            $item->setIncludeParams($include_params);

            return $item->getIncluded();
        }

        return null;
    }

    /**
     * Set the response links data
     *
     * @return $this Instance of self
     */
    public function setLinks()
    {
        // Only required for collections as items contain links by default
        if ($this->resource instanceof Collection && $paginator = $this->resource->getPaginator()) {
            $pagination = new Pagination($paginator);
            $this->links = $pagination->generateCollectionLinks();
        } else {
            unset($this->links);
        }

        return $this;
    }

    /**
     * Set the response meta data
     *
     * @return $this Instance of self
     */
    public function setMeta()
    {
        if ($meta = $this->resource->getMeta()) {
            $this->meta = $meta;
        } else {
            unset($this->meta);
        }

        return $this;
    }

}
