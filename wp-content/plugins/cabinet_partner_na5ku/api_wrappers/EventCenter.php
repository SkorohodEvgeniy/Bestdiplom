<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 08.04.2019
 * Time: 16:03
 */
require_once __DIR__ . '/BaseApiWrapper.php';

class EventCenter extends BaseApiWrapper
{
    public function set($data)
    {
        return $this->api->make('eventCenter/set', $data)->send();
    }
}
