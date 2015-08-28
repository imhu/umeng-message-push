<?php

namespace imhu\UmengMessage;

trait HelperTrait
{

    /**
     * 构造curl请求header
     * @return array
     */
    public function getHeader()
    {
        $header = array(
            'Host:' . $this->apiUrl,
            'Accept:application/json',
            'Content-Type:application/json;charset=utf-8',
        );

        return $header;
    }

    /**
     * curl get
     * @param $url
     * @param $data
     * @return mixed
     */
    public function getJson($url, $data)
    {

        $curl = curl_init($url . '&' . http_build_query($data));

        curl_setopt($curl, CURLOPT_HEADER, $this->getHeader());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $responseText = curl_exec($curl);

        curl_close($curl);

        return $responseText;

    }

    /**
     * curl post
     * @param $url
     * @param $data
     * @return mixed
     */
    public function postJson($url, $data)
    {

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeader());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $responseText = curl_exec($curl);

        curl_close($curl);

        return $responseText;
    }

    /**
     * 构造请求链接
     * @param $uri
     * @return string
     */
    public function getRequestUrl($data)
    {
        $method = $this->method;
        $apiUrl = $this->apiUrl;
        $app_master_secret = $this->config['app_master_secret'];
        $sign = md5($method . $apiUrl . json_encode($data) . $app_master_secret);

        $url = "{$apiUrl}?sign={$sign}";

        return $url;
    }

    /**
     * 以Get方式请求api
     * @param $uri
     * @param $data
     * @return mixed
     */
    public function responseGet($data)
    {
        $url = $this->getRequestUrl($data);

        $response = $this->getJson($url, $data);

        return json_decode($response);

    }

    /**
     * 以Post方式请求api
     * @param $uri
     * @param $data
     * @return mixed
     */
    public function responsePost($data)
    {
        $url = $this->getRequestUrl($data);

        $response = $this->postJson($url, $data);

        return json_decode($response);
    }
}