<?php

namespace Mickeyhead7\Rsvp\Resource;

class Item extends ResourceAbstract implements ResourceInterface
{

    /**
     * Get the includes to be parsed
     *
     * @param Item $item
     * @return array
     */
    public function getIncluded()
    {
        $data = [];
        $include_params = $this->getIncludeParams();

        if (!$include_params) {
            return $include_params;
        }

        foreach ($include_params->getData() as $key => $params) {
            $method = 'include' . ucfirst($key);
            $transformer = $this->getTransformer();
            $allowed = $transformer->getAllowedIncludes();

            if (in_array($key, $allowed) && method_exists($transformer, $method)) {
                $result = $transformer->$method($this->getData(), $params);
                $data[$key] = $result;
            }
        }

        return $data;
    }

    public function getLinks()
    {
        return $this->getTransformer()->getLinks($this->getData());
    }

    /**
     * Sanitize an item
     *
     * @param Item $item
     * @return mixed
     */
    public function sanitize()
    {
        return $this->getTransformer()->transform($this->getData());
    }

}