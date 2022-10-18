<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 13.06.2019
 * Time: 14:33
 */

class PaymentUA extends BaseApiWrapper
{
    public function getButton($data)
    {
        return $this->api->make('paymentUa/getButton', $data)->send();
    }
}
