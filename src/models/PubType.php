<?php


namespace Datalib\Sdk\Models;


final class PubType
{
    private $item;

    /**
     * PubType constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }


    function getId()
    {
        return $this->item['id'];
    }

    function getParentId()
    {
        return $this->item['parent_id'];
    }

    function getTitle()
    {
        return $this->item['title'];
    }

}