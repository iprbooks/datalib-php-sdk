<?php

namespace Datalib\Sdk;

use Datalib\Sdk\Core\Curl;

final class Client
{

    /*
     * jwt token
     */
    private $token;


    /**
     * Конструктор Client
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function makeRequest($apiMethod, array $params)
    {
        return Curl::exec($apiMethod, $this->token, $params);
    }

}
