<?php


namespace Datalib\Sdk\Collections\Publication\Filter\Autocomplete;


use Datalib\Sdk\Client;
use Datalib\Sdk\Core\Collection;
use Datalib\Sdk\Models\Autocomplete;
use Exception;

class DisciplinesCollection extends Collection
{

    const TEXT = 's';
    const CATEGORY_ID = 'category_id';
    const RELATED_CATEGORIES = 'related_categories';

    private $apiMethod = '/catalog/autocomplete/disciplines';

    /**
     * DisciplinesCollection constructor.
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
        return $field == self::TEXT || $field == self::CATEGORY_ID || $field == self::RELATED_CATEGORIES;
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