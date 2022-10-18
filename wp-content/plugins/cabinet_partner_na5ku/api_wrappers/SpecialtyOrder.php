<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 26.03.2019
 * Time: 18:44
 */

class SpecialtyOrder extends BaseApiWrapper
{
    public function get($id)
    {
        return $this->api->make('specialty/get', $id)->send();
    }

    public function getList()
    {
        return $this->api->make('specialty/getList')->send();
    }
}
