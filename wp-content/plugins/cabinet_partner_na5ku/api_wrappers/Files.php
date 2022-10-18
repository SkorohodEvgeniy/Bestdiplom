<?php

class Files extends BaseApiWrapper
{
    /**
     * @var array
     */
    private $allowedFilesStr;

    /**
     * @return array|bool|mixed|string
     */
    private function getFilesWhiteList()
    {
        if ($this->allowedFilesStr) {
            return $this->allowedFilesStr;
        }

        $this->allowedFilesStr = $this->api->make('generalSettings/whiteList')->send();

        return $this->allowedFilesStr;
    }

    /**
     * @param $name
     * @return array
     */
    public function upload_file($name)
    {
        global $files_white_list;
        global $script_folder;

        $link = array();

        $extSTR = $this->getFilesWhiteList();
        $files_white_list = explode(',', $extSTR['value']);

        $_SESSION['upload_file_wf'] = "";
        $uploaddir = dirname(__FILE__) . '/../cabinet/ups/';
        for ($i = 0; $i < count($_FILES[$name]['tmp_name']); $i++) {
            if (strlen($_FILES[$name]['tmp_name'][$i]) > 2) {
                $extArr = explode('.', strtolower($_FILES[$name]['name'][$i]));
                $ext = end($extArr);
                $uploadfile_name = "attach_" . time() . rand(1000, 9999) . ".$ext";
                $uploadfile = $uploaddir . $uploadfile_name;
                $uploadfile2 = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://" . $_SERVER['HTTP_HOST'] . "/$script_folder/ups/$uploadfile_name";
                for ($iii = 0; $iii < 5; $iii++) $uploadfile2 = str_replace("//", "/", $uploadfile2);
                $uploadfile2 = str_replace("https:/", "https://", $uploadfile2);
                $uploadfile2 = str_replace("http:/", "http://", $uploadfile2);

                if (in_array($ext, $files_white_list)) {
                    if (move_uploaded_file($_FILES[$name]['tmp_name'][$i], $uploadfile)) {
                        $link[] = $uploadfile2;
                    } else $_SESSION['upload_file_wf'] .= "<center><span style='color:red'>Ошибка загрузки файла <b>" . $_FILES[$name]['name'][$i] . "</b>. Проблема при копировании</span></center><br>";
                } else $_SESSION['upload_file_wf'] .= "<div class='alert alert-danger'>Ошибка загрузки файла <b>" . $_FILES[$name]['name'][$i] . "</b>. Запрешенный формат файла: <b>$ext</b></div>";
            }
        }

        if ($_SESSION['upload_file_wf'] == "") unset($_SESSION['upload_file_wf']);

        return $link;

    }

    /**
     * Checks if file can be uploaded to API
     * @param $name
     * @return array
     */
    public function checkUploadedFiles($name)
    {
        global $files_white_list;

        $result = array(
            'names' => array(),
            'links' => array(),
        );

        $extSTR = $this->getFilesWhiteList();
        $files_white_list = explode(',', $extSTR['value']);

        $_SESSION['upload_file_wf'] = "";
        for ($i = 0; $i < count($_FILES[$name]['tmp_name']); $i++) {
            if (strlen($_FILES[$name]['tmp_name'][$i]) > 2) {
                $extArr = explode('.', strtolower($_FILES[$name]['name'][$i]));
                $ext = end($extArr);

                if (in_array($ext, $files_white_list)) {
                    $result['links'][] = $_FILES[$name]['tmp_name'][$i];
                    $result['names'][] = $_FILES[$name]['name'][$i];
                } else {
                    $_SESSION['upload_file_wf'] .= "<div class='alert alert-danger'>Ошибка загрузки файла <b>" . $_FILES[$name]['name'][$i] . "</b>. Запрешенный формат файла: <b>$ext</b></div>";
                }
            }
        }

        if (!$_SESSION['upload_file_wf']) {
            unset($_SESSION['upload_file_wf']);
        }

        return $result;
    }

    /**
     * @param $link
     * @return mixed
     */
    public function cutFileLink($link)
    {
        global $API_URL;
        $link = str_replace('\\', '/', $link);

        $APILink = $API_URL . 'ups/attachment_';
        $APILink = str_replace('http:', 'https:', $APILink);

        //this file is already on API
        //for clever devs: on API link will be checked again :)
        if (strpos($link, $APILink) === 0) {
            return $link;
        }

        $fileLink = explode("/", $link);
        $file_name = end($fileLink);

        return $file_name;
    }

    /**
     * @param $files
     * @return array
     */
    public function uploadFiles($files)
    {
        $answer = $this->api->make('files/uploadFiles', null, $files)->send();
        if (isset($answer['code']) && $answer['code'] == 200) {
            $filesStr = base64_decode($answer['data']);
            return explode(',', $filesStr);
        }

        return array();
    }

    /**
     * @param $link
     * @return mixed
     */
    public function getFileExt($link)
    {
        $extArr = explode('.', $link);

        return end($extArr);
    }
}

