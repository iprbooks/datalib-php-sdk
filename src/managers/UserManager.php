<?php


namespace Datalib\Sdk\Managers;

use Exception;
use Datalib\Sdk\Client;
use Datalib\Sdk\Core\Response;

class UserManager extends Response
{

    /**
     * Конструктор UserManager
     * @param $client
     * @return UserManager
     * @throws Exception
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
        if (!$client) {
            throw new Exception('client is not init');
        }
        return $this;
    }

    /**
     * @param $email
     * @param $fullname
     * @param ?int $publicationId
     * @return mixed
     */
    public function generateAutoAuthUrl($email, $fullname, $publicationId = null)
    {
        $apiMethod = '/security/generateAutoAuthUrl';

        $params = array(
            'email' => $email,
            'fullname' => $fullname
        );

        if ($publicationId) {
            $params['publication_id'] = $publicationId;
        }

        $this->response = $this->getClient()->makeRequest($apiMethod, $params);
        $this->data = $this->response['data'];
        return $this->data;
    }

}