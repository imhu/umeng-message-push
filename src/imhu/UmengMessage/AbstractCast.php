<?php

namespace imhu\UmengMessage;

use Illuminate\Support\Facades\Config;

abstract class AbstractCast
{

    use HelperTrait;

    protected $postData = [];

    protected $config = [];

    protected $apiUrl = "http://msg.umeng.com/api/send";

    protected $method = "POST";

    public function __construct()
    {
        $this->config = Config::get("umengMessage");

        $this->postData['appkey'] = $this->config['appkey'];
        $this->postData['timestamp'] = time();
    }

    public function __set($key, $value)
    {
        $this->postData[$key] = $value;
    }

    public function __get($key)
    {
        return $this->postData[$key];
    }

    public function getPostData()
    {
        return $this->postData;
    }

    /**
     * 发送请求
     * 必要的时候子类可以重写该方法（如实现filecast）
     * @return json
     */
    protected function send()
    {
        return $this->responsePost($this->postData);
    }

}