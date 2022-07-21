<?php

namespace Datalib\Sdk\Core;

use Exception;
use Datalib\Sdk\Client;

class Response
{

    /*
     * Инстанс клиента
     */
    private $client;

    /*
     * Ответ
     */
    protected $response;

    /*
     * Данные ответа
     */
    protected $data;


    /**
     * Конструктор Response
     * @param Client $client
     * @param $response
     * @throws Exception
     */
    public function __construct(Client $client, $response = null)
    {
        if (!$client) {
            throw new Exception('client is not init');
        }

        $this->client = $client;
        $this->response = $response;
        if (isset($response['data'])) {
            $this->data = $response['data'];
        } else {
            $this->data = null;
        }
        return $this;
    }

    /**
     * Получить клиент
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Получить значение по ключу
     * @param $name
     * @return string
     */
    protected function getValue($name)
    {
        if (is_array($this->data) && array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            return '';
        }
    }

    /**
     * Возвращает статус запроса
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->response['meta']['success'];
    }

    /**
     * Возвращает текстовое сообщение ошибки
     * @return mixed
     */
    public function getMessage()
    {
        return $this->response['meta']['message'];
    }

}