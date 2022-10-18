<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 19.03.2019
 * Time: 17:56
 */
require_once(__DIR__ . '/../setInfo.php');

class BaseApiWrapper
{
    protected $api;

    public function __construct()
    {
        $this->api = new setInfo();
    }

    public function proceedResponce($data){
        if(isset($data['data'])){
            return $data['data'];
        }

        return null;
    }
}
