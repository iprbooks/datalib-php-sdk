<?php

namespace Datalib\Sdk\Core;

use Exception;
use Datalib\Sdk\Client;
use Iterator;

abstract class Collection extends Response implements Iterator
{

    /*
     * Массив параметров для фильтрации
     */
    private $filter = array();

    /*
     * Индекс для Iterator
     */
    private $position = 0;

    /*
     * Страница
     */
    private $page;

    /*
     * Кол-во элементов на страницу
     */
    private $perPage;


    /**
     * Конструктор Collection
     * @param Client $client
     * @return Collection
     * @throws Exception
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->page = 1;
        $this->perPage = 20;
        return $this;
    }


    /**
     * Страница
     * @param int $page
     * @return Collection
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Установка кол-ва элементов на страницу
     * @param $perPage
     * @return Collection
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Возвращает кол-во элементов в ответе
     * @return int
     */
    public function getTotalCount()
    {
        if ($this->data) {
            return $this->data['total'];
        } else {
            return 0;
        }
    }

    /**
     *  Отправка запроса
     * @param null $id
     */
    public function get($id = null)
    {
        $apiMethod = $this->getApiMethod();
        if ($id) {
            $apiMethod = str_replace('{id}', $id, $apiMethod);
        }

        $params = array('page' => $this->page, 'per_page' => $this->perPage);
        $params = array_merge($params, $this->filter);

        $this->response = $this->getClient()->makeRequest($apiMethod, $params);
        if (isset($this->response['data'])) {
            $this->data = $this->response['data'];
        } else {
            $this->data = null;
        }
    }

    /**
     * Возвращает элемент выборки, переопределяется в потомках
     * @param $index
     * @return mixed
     * @throws Exception
     */
    public function getItem($index)
    {
        if ($index < 0 && $index >= $this->getTotalCount()) {
            throw new Exception('out of bounds');
        }
    }

    /**
     * Возвращает метод api
     * @return string
     */
    abstract protected function getApiMethod();

    /**
     * Проверка значений фильтра
     * @param $field
     * @return boolean
     */
    abstract protected function checkFilterFields($field);

    /**
     * Установка значений фильра
     * @param $field - поле
     * @param $value - значение
     * @return Collection
     */
    public function setFilter($field, $value)
    {
        if ($this->checkFilterFields($field)) {
            $this->filter[$field] = $value;
        }
        return $this;
    }

    /**
     * Сброс параметров фильтрации
     */
    public function resetFilter()
    {
        unset($this->filter);
        $this->filter = array();
    }

    /**
     * Обертка для инициализации модели
     * @param $data
     * @return array
     */
    protected function createModelWrapper($data)
    {
        return array(
            'meta' => array(
                'success' => true,
                'message' => '',
            ),
            'data' => $data
        );
    }


    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     * @throws Exception
     */
    public function current()
    {
        return $this->getItem($this->position);
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->data['list'][$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }

}