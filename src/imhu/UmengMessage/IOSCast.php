<?php

namespace imhu\UmengMessage;

class IOSCast extends AbstractCast
{

    public function listCast(array $device_tokens, $alert, $body = array())
    {
        $payload = [
            'aps' => ['alert' => $alert]
        ];
        $this->postData['type'] = 'listcast';
        $this->postData['device_tokens'] = implode(',', $device_tokens);
        $this->postData['payload'] = array_merge($payload, $body);

        $this->send();
    }

}