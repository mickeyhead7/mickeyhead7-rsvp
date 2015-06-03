<?php

namespace Mickeyhead7\Rsvp;

class ResponseBag
{

    /**
     * Resource data
     *
     * @var
     */
    public $data;

    /**
     * Resource links
     *
     * @var
     */
    public $links;

    /**
     * Resource meta data
     *
     * @var
     */
    public $meta;

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
