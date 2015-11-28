<?php

namespace Mickeyhead7\Rsvp\Transformer;

use \Mickeyhead7\Rsvp\Resource\Collection;
use \Mickeyhead7\Rsvp\Resource\Item;

abstract class TransformerAbstract
{

    protected $allowed_includes = [];

    /**
     * Transform data
     *
     * @param $data
     * @return mixed
     */
    abstract public function transform($data);

    /**
     * Get the API links for a resource
     *
     * @return null
     */
    public function getLinks($data)
    {
        return null;
    }

    /**
     * Creates a new resource collection
     *
     * @param $data
     * @param TransformerAbstract $transformer
     * @return Collection
     */
    public function collection($data, \Mickeyhead7\Rsvp\Transformer\TransformerAbstract $transformer)
    {
        return new Collection($data, $transformer);
    }

    /**
     * Creates a new resource item
     *
     * @param $data
     * @param TransformerAbstract $transformer
     * @return Item
     */
    public function item($data, \Mickeyhead7\Rsvp\Transformer\TransformerAbstract $transformer)
    {
        return new Item($data, $transformer);
    }

    /**
     * Get the list of allowed includes
     *
     * @return mixed
     */
    public function getAllowedIncludes()
    {
        return $this->allowed_includes;
    }

}
