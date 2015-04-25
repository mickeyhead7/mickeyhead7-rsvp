<?php

namespace Responsible\Rsvp\Resource;

use \Responsible\Rsvp\Pagination\PaginatorInterface;

class Collection extends ResourceAbstract
{

    /**
     * Paginator object
     *
     * @var
     */
    private $paginator;

    /**
     * Set the paginator object
     *
     * @param PaginatorInterface $paginator
     * @return $this
     */
    public function setPaginator(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;

        return $this;
    }

    /**
     * Set the paginator object
     *
     * @return mixed
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

}