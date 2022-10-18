<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 26.03.2019
 * Time: 18:44
 */

class SubjectOrder extends BaseApiWrapper
{
    public function get($id)
    {
        return $this->api->make('subject/get', $id)->send();
    }

    public function getList()
    {
        return $this->api->make('subject/getList')->send();
    }
}
