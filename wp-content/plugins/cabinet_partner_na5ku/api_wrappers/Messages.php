<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22.03.2019
 * Time: 14:14
 */

class Messages extends BaseApiWrapper
{
    public function getCountMessages($data)
    {
        return $this->api->make('messages/count', $data)->send();
    }


}
