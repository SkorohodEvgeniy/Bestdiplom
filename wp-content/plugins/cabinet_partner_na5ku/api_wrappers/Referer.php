<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22.04.2019
 * Time: 19:13
 */

require_once __DIR__ . '/BaseApiWrapper.php';

class Referer extends BaseApiWrapper
{
    public function get($data)
    {
        return $this->api->make('referer/get', $data)->send();
    }
}
