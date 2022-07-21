<?php


namespace Datalib\Sdk\Collections\Publication\Filter;


use Datalib\Sdk\Client;
use Datalib\Sdk\Core\Collection;
use Datalib\Sdk\Models\PubType;
use Exception;

class PubTypeCollection extends Collection
{

    private $apiMethod = '/catalog/pubtypes';

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
     * @return PubType
     */
    public function getItem($index)
    {
        return new PubType($this->data[$index]);
    }

}