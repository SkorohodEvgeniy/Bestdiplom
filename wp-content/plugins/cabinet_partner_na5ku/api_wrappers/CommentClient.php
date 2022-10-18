<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.03.2019
 * Time: 18:20
 */
require_once __DIR__ . '/BaseApiWrapper.php';

class CommentClient extends BaseApiWrapper
{
    public function countNoRead($id)
    {
        return $this->api->make('commentClient/countNoRead', $id)->send();
    }

    public function countAllComment($id)
    {
        return $this->api->make('commentClient/countAll', $id)->send();
    }

    public function show_old($id)
    {
        return $this->api->make('commentClient/show_old', $id)->send();
    }

    public function set($data, $files)
    {
        return $this->api->make('commentClient/set', $data, $files)->send();
    }
//    public function sendNew($data){
//        return $this->api->make('commentClient/sendNew',$data)->send();
//    }
}
