<?php

namespace Responsible\Rsvp\Transformer;

use \Responsible\Rsvp\Resource\Collection;
use \Responsible\Rsvp\Resource\Item;

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
     * Creates a new resource collection
     *
     * @param $data
     * @param TransformerAbstract $transformer
     * @return Collection
     */
    public function collection($data, \Responsible\Rsvp\Transformer\TransformerAbstract $transformer)
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
    public function item($data, \Responsible\Rsvp\Transformer\TransformerAbstract $transformer)
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
