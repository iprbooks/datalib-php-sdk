<?php


namespace Datalib\Sdk\Models;


final class Autocomplete
{

    private $item;

    /**
     * Autocomplete constructor.
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


    function getText()
    {
        return $this->item['text'];
    }

}