<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 19.03.2019
 * Time: 18:01
 */
require_once __DIR__ . '/BaseApiWrapper.php';

class User extends BaseApiWrapper
{
    public function getCurrent($data = NULL)
    {
        return $this->api->make('user/current', $data)->send();
    }

    public function get_ref_money($data = NULL)
    {
        return $this->api->make('user/ref_money', $data)->send();
    }

    public function updateManager($data)
    {
        return $this->api->make('user/updateManager', $data)->send();
    }

    public function updateProfile($data)
    {
        return $this->api->make('user/updateProfile', $data)->send();
    }

    public function updateName($data)
    {
        return $this->api->make('user/updateName', $data)->send();
    }

    public function updatePhone($data)
    {
        return $this->api->make('user/updatePhone', $data)->send();
    }

    public function updateNews($data)
    {
        return $this->api->make('user/updateNews', $data)->send();
    }

    public function updatePassword($data)
    {
        return $this->api->make('user/updatePassword', $data)->send();
    }

    public function checkedForgotPassword($data)
    {
        return $this->api->make('user/checkedForgotPassword', $data)->send();
    }

    public function register($data)
    {
        return $this->api->make('register', $data, null, true)->send();
    }

    public function getOrderNotifs()
    {
        return $this->proceedResponce($this->api->make('user/allOrderNotifs')->send());
    }
}
