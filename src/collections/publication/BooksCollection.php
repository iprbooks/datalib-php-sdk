<?php

namespace Datalib\Sdk\Collections\Publication;

use Datalib\Sdk\Client;
use Datalib\Sdk\Core\Collection;
use Datalib\Sdk\Models\Book;
use Exception;

class BooksCollection extends Collection
{

    /*
     * Фильтрация по названию
     */
    const TITLE = 'title';

    /*
     * Фильтрация по категории (id, int)
     */
    const CATEGORY = 'category_id';

    /*
     * Фильтр смежные категории (id, int|array)
     */
    const RELATED_CATEGORIES = 'related_categories';

    /*
     * Фильтрация по авторам (id, int)
     */
    const AUTHOR = 'author';

    /*
     * Фильтрация издательству (id, int)
     */
    const PUBLISHER = 'publisher';

    /*
     * Фильтр по дисциплинам (id, int)
     */
    const DISCIPLINES = 'disciplines';

    /*
     * Ограничение года издания слева (int)
     */
    const YEAR_LEFT = 'year_from';

    /*
     * Ограничение года издания слева (int)
     */
    const YEAR_RIGHT = 'year_before';


    private $apiMethod = '/catalog/books';


    /**
     * Конструктор BooksCollection
     * @param Client $client
     * @return BooksCollection
     * @throws Exception
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
        return $this;
    }

    /**
     * Возвращает метод api
     * @return string
     */
    protected function getApiMethod()
    {
        return $this->apiMethod;
    }

    /**
     * Проверка значений фильтра
     * @param $field
     * @return boolean
     */
    protected function checkFilterFields($field)
    {
        if (
            $field == self::TITLE
            || $field == self::CATEGORY
            || $field == self::RELATED_CATEGORIES
            || $field == self::DISCIPLINES
            || $field == self::PUBLISHER
            || $field == self::AUTHOR
            || $field == self::YEAR_LEFT
            || $field == self::YEAR_RIGHT
        ) {
            return true;
        }
        return false;
    }

    /**
     * Возвращает элемент выборки
     * @param $index
     * @return Book
     * @throws Exception
     */
    public function getItem($index)
    {
        parent::getItem($index);
        $response = $this->createModelWrapper($this->data['list'][$index]);
        return new Book($this->getClient(), $response);
    }

}