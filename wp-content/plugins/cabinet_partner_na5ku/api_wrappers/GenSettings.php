<?php

class GenSettings extends BaseApiWrapper
{
    /**
     * @var array
     */
    private $allowedFilesStr;
    private $garantyTextUA;
    private $garantyTextRU;
    private $country;

    /**
     * @return array|bool|mixed|string
     */
    public function getFilesWhiteList()
    {
        if ($this->allowedFilesStr) {
            return $this->allowedFilesStr;
        }

        $this->allowedFilesStr = $this->api->make('generalSettings/whiteList')->send();

        return $this->allowedFilesStr;
    }

    public function garantyTextUA()
    {
        if ($this->garantyTextUA) {
            return $this->garantyTextUA;
        }

        $this->garantyTextUA = $this->api->make('generalSettings/garantyTextUA')->send();

        return $this->garantyTextUA;
    }

    public function garantyTextRU()
    {
        if ($this->garantyTextRU) {
            return $this->garantyTextRU;
        }

        $this->garantyTextRU = $this->api->make('generalSettings/garantyTextRU')->send();

        return $this->garantyTextRU;
    }

    public function getCountry($id)
    {
        if ($this->country) {
            return $this->country;
        }
        if (strtoupper($id) == 'usd') {
            $id = 3;
        } elseif (strtoupper($id) == 'ru') {
            $id = 2;
        } elseif (strtoupper($id) == 'ua') {
            $id = 1;
        } elseif ($id != 2 && $id != 3) {
            $id = 1;
        }

        $this->country = $this->api->make('generalSettings/sysCountry/' . $id)->send();

        return $this->country;
    }
}

