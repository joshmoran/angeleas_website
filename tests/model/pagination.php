<?php

namespace src\model;

class pagination
{
    public $current;
    public $total;
    public $itemsPerPage;

    function __construct($current, $total, $itemsPerPage)
    {
        $this->current = $current;
        $this->total = $total;
        $this->itemsPerPage = $itemsPerPage;
    }

    function getTotalPage()
    {
        return ceil($this->total / $this->itemsPerPage);
    }

    function hasPrevPage()
    {
        if ($this->current > 1) {
            return true;
        } else {
            return false;
        }
    }

    function hasNextPage()
    {
        if ($this->current < $this->getTotalPage()) {
            return true;
        } else {
            return false;
        }
    }

    function offset()
    {
        return ($this->current - 1) * $this->itemsPerPage;
    }
}
