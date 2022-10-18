<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 16.04.2019
 * Time: 14:08
 */

class Promo extends BaseApiWrapper
{
    public function getPromo($data)
    {
        return $this->api->make('promo/getPromo', $data)->send();
    }


}
