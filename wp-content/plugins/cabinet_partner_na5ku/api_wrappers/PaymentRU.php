<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 17.04.2019
 * Time: 14:12
 */

class PaymentRU extends BaseApiWrapper
{
    public function getButton($data)
    {
        return $this->api->make('paymentRu/getButton', $data)->send();
    }

}
