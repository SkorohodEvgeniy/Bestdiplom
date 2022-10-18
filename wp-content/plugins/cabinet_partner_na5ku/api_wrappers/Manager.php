<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10.04.2019
 * Time: 17:47
 */
require_once __DIR__ . '/BaseApiWrapper.php';

class Manager extends BaseApiWrapper
{
    public function get()
    {
        return $this->api->make('manager/get')->send();
    }


}

