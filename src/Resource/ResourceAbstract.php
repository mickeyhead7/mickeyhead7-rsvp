<?php

namespace Mickeyhead7\Rsvp\Resource;

use \Mickeyhead7\Rsvp\Transformer\TransformerAbstract;
use \Mickeyhead7\Rsvp\IncludeParams;

abstract class ResourceAbstract
{

    /**
     * Transformer object
     *
     * @var TransformerAbstract
     */
    private $transformer;

    /**
     * Includes for parsing
     *
     * @var array
     */
    private $includes;

    /**
     * Resource data
     *
     * @var
     */
    protected $data;

    /**
     * Resource links
     *
     * @var array
     */
    protected $links = [];

    /**
     * Resource meta data
     *
     * @var array
     */
    protected $meta = [];

    /**
     * Constructor
     *
     * @param $data
     * @param TransformerAbstract $transformer
     */
    public function __construct($data, TransformerAbstract $transformer)
    {
        $this->data = $data;
        $this->transformer = $transformer;
    }

    /**
     * Get the resource data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the transformer object
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * Set the list of includes to be parsed
     *
     * @param IncludeParams $includes
     * @return $this
     */
    public function setIncludes(Array $includes = [])
    {
        $this->includes = $includes;

        return $this;
    }

    /**
     * Get the list of includes for parsing
     *
     * @return array
     */
    public function getIncludes()
    {
        return $this->includes;
    }

    /**
     * Set the resource links
     *
     * @param array $value
     * @return $this
     */
    public function setLinks(Array $value)
    {
        $this->links = $value;

        return $this;
    }

    /**
     * Set a specified resource link by key
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setLinkValue($key, $value)
    {
        $this->links[$key] = $value;

        return $this;
    }

    /**
     * Get the resource links
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set the resource meta data
     *
     * @param array $value
     * @return $this
     */
    public function setMeta(Array $value)
    {
        $this->meta = $value;

        return $this;
    }

    /**
     * Set a specified meta data by key
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setMetaValue($key, $value)
    {
        $this->meta[$key] = $value;

        return $this;
    }

    /**
     * Get the resource meta data
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

}