<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 19.03.2019
 * Time: 17:56
 */

class Order extends BaseApiWrapper
{
    public function getList($data)
    {
        return $this->api->make('orders/list')->send();
    }

    /**
     * получить заказ по id_for_client
     * @param $id - id_for_client
     * @return array|
     */
    public function get($id)
    {
        return $this->api->make('orders/get', ['id' => $id])->send();
    }

    public function getCount($id)
    {
        return $this->api->make('orders/getCount', ['id' => $id])->send();
    }

    /**
     * получить заказ по id
     * @param $id - id
     * @return array|
     */
    public function getId($id)
    {
        return $this->api->make('orders/getId', ['id' => $id])->send();
    }

    /**
     * кол-во активных заказов
     * @param $id
     * @return array
     */
    public function activeCount($id)
    {
        return $this->api->make('orders/activeCount', $id)->send();
    }

    /**
     * Кол-во завершенных заказов
     * @param $id
     * @return array
     */
    public function finishedCount($id)
    {
        return $this->api->make('orders/finishedCount', $id)->send();
    }

    /**
     * Кол-во отмененных заказов
     * @param $id
     * @return array
     */
    public function canceledCount($id)
    {
        return $this->api->make('orders/canceledCount', $id)->send();
    }

    public function active($id)
    {
        return $this->api->make('orders/active', $id)->send();
    }

    public function finished($id)
    {
        return $this->api->make('orders/finished', $id)->send();
    }

    public function canceled($id)
    {
        return $this->api->make('orders/canceled', $id)->send();
    }

    /**
     * Кол-во оплаченных заказов
     * @param User $id
     * @return array
     */
    public function paidCount($id)
    {
        return $this->api->make('orders/paidCount', $id)->send();
    }

    /**
     * Все заказы локального партнера
     * @param $promo ['promo']
     * @param $promo ['valuta']
     * @return array
     */
    public function localPartnerOrder($promo)
    {
        return $this->api->make('orders/localPartnerOrder', $promo)->send();
    }

    /**
     * Сумма стоимости всех оплаченных заказов
     * @param User $id
     * @return array|
     */
    public function sumPaidForOrder($id)
    {
        return $this->api->make('orders/sumPaidForOrder', $id)->send();
    }

    public function getOrderPromo($id)
    {
        return $this->api->make('orders/getOrderPromo', $id)->send();
    }

    /**
     * Обновление заказпосле добавления нового комментария
     * @param $id
     * @return array|
     */
    public function updateStatus($id)
    {
        return $this->api->make('orders/updateStatus', $id)->send();
    }

    public function setAttachment($data, $files)
    {
        return $this->api->make('orders/setAttachment', $data, $files)->send();
    }

    public function setOrderAttach($data)
    {
        return $this->api->make('orders/setOrderAttach', $data)->send();
    }

    /**
     * Проверка наличия промокода
     * @param $data
     * @return array|bool|mixed|object|string
     */
    public function checkedPromocode($data)
    {
        return $this->api->make('orders/checkedPromocode', $data)->send();
    }

    public function newPromo($data)
    {
        return $this->api->make('orders/newPromo', $data)->send();
    }

    public function notif($data)
    {
        return $this->proceedResponce($this->api->make('orders/notif', $data)->send());
    }

    public function notifRead($data)
    {
        return $this->proceedResponce($this->api->make('orders/notifRead', $data)->send());
    }
}
