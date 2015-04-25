<?php

namespace Responsible\Rsvp\Pagination;

interface PaginatorInterface
{

    /**
     * Get the URL for the current resource
     *
     * @return mixed
     */
    public function getSelf();

    /**
     * Get the URL for the first resource
     *
     * @return mixed
     */
    public function getFirst();

    /**
     * Get the URL for the previous resource
     *
     * @return mixed
     */
    public function getPrevious();

    /**
     * Get the URL for the next resource
     *
     * @return mixed
     */
    public function getNext();

    /**
     * Get the URL for the last resource
     *
     * @return mixed
     */
    public function getLast();

}
