<?php
include_once __DIR__ . "/cabinet/baza.php";

class setInfo
{
    private $url;
    private $data;
    private $files;
    private $directRequestData;

    public function make($url, $data = null, $files = null, $directRequestData = false)
    {
        $this->url = $url;
        $this->data = $data;
        $this->files = $files;
        $this->directRequestData = $directRequestData;
        return $this;
    }

    public function send($debug = false)
    {
        global $API_URL;

        $startTime = microtime(true);

        $ch = curl_init();
        $url = $API_URL . $this->url;

        if ($this->directRequestData) {
            $requestData = $this->data;
            $requestData ['action'] = '';
            $requestData ['SITE_API_KEY'] = NA5KU_SITE_API_KEY;
            $requestData ['type'] = 'post_action';
        } else {
            $requestData = array(
                'data' => $this->data,
                'action' => '',
                'SITE_API_KEY' => NA5KU_SITE_API_KEY,
                'type' => 'post_action'
            );
        }

        $API_TOKEN = '';
        if (isset($_COOKIE['api_token']) && $_COOKIE['api_token']) {
            $API_TOKEN = $_COOKIE['api_token'];
        } elseif (isset($_SESSION['api_token']) && $_SESSION['api_token']) {
            $API_TOKEN = $_SESSION['api_token'];
        }


        $header = [
            'Authorization: Bearer ' . $API_TOKEN
        ];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);

        if (!empty($this->files)) {
            $requestData = $this->data;
            foreach ($this->files as $key => $fileData) {
                $path = $fileData['tmp_name'];
                $name = $fileData['name'];

                $filename = realpath($path);
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimetype = $finfo->file($filename);
                $cfile = curl_file_create($filename, $mimetype, $name);
                $requestData[$key] = $cfile;
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                http_build_query($requestData)
            );
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);


        $deltaTime = microtime(true) - $startTime;

//        вывод времени отработки запроса
//        echo '<div style="width:100%">' . $this->url . ': ' . $deltaTime . '</div>';

        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);
//        echo PHP_EOL;
//        var_dump($url);
//        var_dump($response);
//        echo PHP_EOL;
        if ($debug) {
            var_dump($response);
        }

        if ($response) {
            return json_decode($response, true);
        }
        return $response;
    }
}
