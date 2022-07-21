<?php


namespace Datalib\Sdk\Collections\Publication\Filter;


use Datalib\Sdk\Client;
use Datalib\Sdk\Core\Collection;
use Datalib\Sdk\Models\Autocomplete;
use Exception;

class CategoryCollection extends Collection
{

    private $apiMethod = '/catalog/autocomplete/title';

    /**
     * TitleCollection constructor.
     * @param Client $client
     * @throws Exception
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }


    protected function getApiMethod()
    {
        return $this->apiMethod;
    }

    protected function checkFilterFields($field)
    {
        return false;
    }

    /**
     * Возвращает элемент выборки
     * @param $index
     * @return Autocomplete
     * @throws Exception
     */
    public function getItem($index)
    {
        // TODO
        return null;
    }

}