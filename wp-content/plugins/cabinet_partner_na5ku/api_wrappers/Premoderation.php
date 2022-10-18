<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 26.03.2019
 * Time: 11:42
 */

class Premoderation extends BaseApiWrapper
{
    public function count($id)
    {
        return $this->api->make('premoderation/count', $id)->send();
    }

    /**
     * Все заказы клиента по id клиента
     * @param $id Client
     * @return array|
     */
    public function get($id)
    {
        return $this->api->make('premoderation/get', $id)->send();
    }

    public function getOne($id)
    {
        return $this->api->make('premoderation/getOne', $id)->send();
    }

    public function set($data, $file = null)
    {
        return $this->api->make('premoderation/set', $data, $file)->send();
    }
}
