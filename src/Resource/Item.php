<?php

namespace Responsible\Rsvp\Resource;

class Item extends ResourceAbstract
{

    /**
     * Included resources
     *
     * @var array
     */
    protected $included = [];

    /**
     * Set the resource included data
     *
     * @param array $value
     * @return $this
     */
    public function setIncluded(Array $value)
    {
        $this->included = $value;

        return $this;
    }

    /**
     * Set a specified resource included data by key
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setIncludedValue($key, $value)
    {
        $this->included[$key] = $value;

        return $this;
    }

    /**
     * Get the resource included data
     *
     * @return array
     */
    public function getIncluded()
    {
        return $this->included;
    }

    /**
     * Set the includes to be parsed
     *
     * @param Item $item
     * @return array
     */
    public function parseIncludes()
    {
        $data = [];
        $includes = $this->getIncludes();

        if (!$includes) {
            return $includes;
        }

        foreach ($includes->getData() as $key => $params) {
            $method = 'include' . ucfirst($key);
            $transformer = $this->getTransformer();
            $allowed = $transformer->getAllowedIncludes();

            if (in_array($key, $allowed) && method_exists($transformer, $method)) {
                $result = $transformer->$method($this->getData(), $params);
                $data[$key] = $result;
            }
        }

        if ($data) {
            $this->setIncluded($data);
        }

        return $this;
    }

}