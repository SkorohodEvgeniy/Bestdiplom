<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 26.03.2019
 * Time: 17:56
 */

class TypeOrder extends BaseApiWrapper
{
    public function get($id)
    {
        return $this->api->make('type/get', $id)->send();
    }

    public function getList($dbLang = '')
    {
        return $this->api->make('type/list', ['lang' => $dbLang])->send();
    }
}
