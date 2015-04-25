<?php

namespace Responsible\Rsvp\Pagination;

class Pagination
{

    /**
     * Paginator object
     *
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * Constructor
     *
     * @param PaginatorInterface $paginator
     */
    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Get the paginator object
     *
     * @return PaginatorInterface
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * Generate URL links for a resource collection
     *
     * @return array
     */
    public function generateCollectionLinks()
    {
        $links = [
            'self' => $this->getPaginator()->getSelf(),
        ];

        if ($first = $this->getPaginator()->getFirst()) {
            $links['first'] = $first;
        }

        if ($previous = $this->getPaginator()->getPrevious()) {
            $links['previous'] = $previous;
        }

        if ($next = $this->getPaginator()->getNext()) {
            $links['next'] = $next;
        }

        if ($last = $this->getPaginator()->getLast()) {
            $links['last'] = $last;
        }

        return $links;
    }

    /**
     * Generate URL links for a resource item
     *
     * @return array
     */
    public function generateItemLinks()
    {
        $links = [
            'self' => $this->getPaginator()->getSelf(),
        ];

        return $links;
    }

}
