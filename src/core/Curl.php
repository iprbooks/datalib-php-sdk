<?php

namespace Datalib\Sdk\Core;

class Curl
{

    const HOST = 'https://dev.api.datalib.ru/api';


    /**
     * Отправка запроса
     * @param $apiMethod
     * @param $token
     * @param array $params
     * @return array|mixed
     */
    public static function exec($apiMethod, $token, array $params)
    {
        if (!empty($params)) {
            $apiMethod = sprintf("%s?%s", $apiMethod, http_build_query($params, '', '&'));
        };

        $headers = array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
            'Accept: application/json'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_URL, self::HOST . $apiMethod);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curlResult = curl_exec($curl);


        if (curl_errno($curl)) {
            return Curl::getError('Curl error ' . curl_errno($curl) . ': ' . curl_error($curl));
        }

        return json_decode($curlResult, true);
    }


    /**
     * Формирование сообщения в случае ошибки
     * @param $message
     * @return array
     */
    private static function getError($message)
    {
        return array(
            'meta' => array(
                'success' => false,
                'message' => $message,
            ),
            'data' => null
        );
    }
}
