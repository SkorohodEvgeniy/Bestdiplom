<?php
error_reporting(error_reporting() & ~E_NOTICE);
require_once('f.php');
?>
<?php
$uploaddir = dirname(__FILE__) . '/ups/';


$db = db_connect();
$q = 'SELECT value from `general_settings` where `param`="CLIENT_EXT_ALLOWED"';
$extSTR = baza_do_one($q);
$files_white_list = explode(',', $extSTR['value']);
db_disconnect($db);


for ($i = 0; $i < count($_FILES['userfile']['tmp_name']); $i++) {

//echo "<Br>$i - ".strlen($_FILES['userfile']['tmp_name']).$_FILES['userfile']['tmp_name'];


    if (strlen($_FILES['userfile']['tmp_name']) > 1) {
        $ext = end(explode('.', strtolower($_FILES['userfile']['name'])));
        $ext2 = explode('.', strtolower($_FILES['userfile']['name']));
        for ($j = 0; $j < count($ext2) - 1; $j++) {
            $name .= $ext2[$j];
            if ($j != count($ext2) - 2) $name .= ".";
        }

        $uploadfile_name = md5($name . rand()) . rand() . ".$ext";
        $uploadfile = $uploaddir . $uploadfile_name;
        $uploadfile2 = "http://" . $_SERVER['HTTP_HOST'] . "/$script_folder/ups/$uploadfile_name";
        for ($iii = 0; $iii < 5; $iii++) $uploadfile2 = str_replace("//", "/", $uploadfile2);
        $uploadfile2 = str_replace("http:/", "http://", $uploadfile2);

        if (!in_array($ext, $files_white_list)) die(header('HTTP/1.0 403 Forbidden'));
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            $link = $uploadfile2;
            echo "$link";
        } else header('HTTP/1.0 403 Forbidden');
    }

    unset($ext);
    unset($ext2);
    unset($uploadfile);
    unset($name);
    //fopen($uploaddir.".htpasswd","a+");
}
?>
