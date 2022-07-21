<?php


namespace Datalib\Sdk\Collections\Publication\Filter\Autocomplete;


use Datalib\Sdk\Client;
use Datalib\Sdk\Core\Collection;
use Datalib\Sdk\Models\Autocomplete;
use Exception;

class PublishersCollection extends Collection
{

    const TEXT = 's';

    private $apiMethod = '/catalog/autocomplete/publishers';

    /**
     * PublishersCollection constructor.
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
        return $field == self::TEXT;
    }

    /**
     * Возвращает элемент выборки
     * @param $index
     * @return Autocomplete
     * @throws Exception
     */
    public function getItem($index)
    {
        return new Autocomplete($this->data[$index]);
    }

}