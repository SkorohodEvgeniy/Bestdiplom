<?php
// require_once (__DIR__ . '/f2.php');
// require_once ('f3.php');
require_once("baza.php");
// die(var_dump($baza_host,$baza_user,$baza_password,$baza_table));

// die(var_dump($baza_host,$baza_user,$baza_password,$baza_table));
$loggedIn = check_session($baza_host, $baza_user, $baza_password, $baza_table);

// $q = "SELECT * FROM $_COOKIE['clients'] WHERE ``"

if ($loggedIn):
    ?>

    <li>
        <a class="login-btn" href="/cabinet" style="font-size: 13px; padding: 19px 6px;">Кабинет</a>
    </li>
    <li>
        <a class="reg-btn" href="/exit">Выход</a>
    </li>
<?php else: ?>
    <li>
        <a class="login-btn" href="#" data-toggle="modal" data-target="#login">Вход</a>
    </li>
    <li>
        <a class="reg-btn" href="#" data-toggle="modal" data-target="#register">Регистрация</a>
    </li>
<? endif; ?><?
function check_session($baza_host, $baza_user, $baza_password, $baza_table)
{
    global $user_data;
    global $_SESSION;
    global $_COOKIE;
    $r = false;
    $db = db_connect($baza_host, $baza_user, $baza_password, $baza_table);
    $ip = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ?
        $_SERVER["HTTP_CF_CONNECTING_IP"] :
        $_SERVER["REMOTE_ADDR"];
    //$_SESSION['zakaz_data']="5b843956e103e564c8ed5f028e9747ea";

    if (isset($_GET['zakaz_key'])) {
        $_SESSION['zakaz_data'] = $_GET['zakaz_data'];
//            setcookie('zakaz_data', $_REQUEST['zakaz_data'], $cookieTime);
        $_SESSION['zakaz_type'] = $_GET['zakaz_type'];
//            setcookie('zakaz_type', $_REQUEST['zakaz_type'], $cookieTime);
        $_SESSION['zakaz_key'] = $_GET['zakaz_key'];
//            setcookie('zakaz_key', $_REQUEST['zakaz_key'], $cookieTime);
        $_SESSION['zakaz_key2'] = $_GET['zakaz_key2'];
//            setcookie('zakaz_key2', $_REQUEST['zakaz_key2'], $cookieTime);
        $_SESSION['zakaz_id'] = $_GET['zakaz_id'];
//            setcookie('zakaz_id', $_REQUEST['zakaz_id'], $cookieTime);
        $_SESSION['zakaz_ip'] = $_GET['zakaz_ip'];

    }
    $sess_name = $_SESSION['zakaz_data'];
    $sess_type = $_SESSION['zakaz_type'];
    $sess_key = $_SESSION['zakaz_key'];
    $sess_key2 = $_SESSION['zakaz_key2'];
    $sess_id = $_SESSION['zakaz_id'];

    //echo $_SESSION['zakaz_key'];
    if (strlen($_SESSION['zakaz_key']) > 32) {

        $sess_name = $_SESSION['zakaz_data'];
        $sess_type = $_SESSION['zakaz_type'];
        $sess_key = $_SESSION['zakaz_key'];
        $sess_key2 = $_SESSION['zakaz_key2'];
        $sess_id = $_SESSION['zakaz_id'];
    } else {
        //$dddd="zakaz_key";
        //echo $_SESSION[$dddd]."<br>".$_COOKIE[$dddd];
        //die();
        $sess_name = $_COOKIE['zakaz_data'];
        $sess_type = $_COOKIE['zakaz_type'];
        $sess_key = $_COOKIE['zakaz_key'];
        $sess_key2 = $_COOKIE['zakaz_key2'];
        $sess_id = $_COOKIE['zakaz_id'];/**/
    }

    /**/

    if (!is_numeric($sess_id)) $sess_id = (int)$sess_id;
    $sess_type = post($sess_type);

    $query = "Select * From `clients` Where `id`='$sess_id'";
    $tmp3 = $db->query($query);
    $result3 = obrabotka($tmp3);

    $result = $result3[0];
    //print_r($result3);
    //die();

    $user_pass = $result['password'];
    $user_login = $result['login'];


    $check = md5(strtolower($user_login) . md5($user_pass));
    $name = md5(strtolower($user_login) . $check) . md5(strtolower($user_login) . $sess_id);

    $true_key = md5($name . $name . $sess_id . $check . $sess_key2 . $ip) . md5($sess_type . $name . $sess_type . $sess_type . $check . $sess_key2 . $ip);
    //$true_key=md5($name.$name.$result[0]['id'].$check).md5($baza.$name.$baza.$baza.$check);
    //$sess_key=md5($sess_name.$sess_name.$sess_id.$check2).md5($sess_type.$sess_name.$sess_type.$sess_type.$check2);
    //echo "<br>$true_key<br>$sess_key";
    if ($true_key == $sess_key) {
        $r = true;
        $user_data = $result;
    } else $r = false;


    db_disconnect($db);
    $user_data['types'] = $t;
    $tt = $user_data['type'];
    $all_t[1] = "users";
    $all_t[2] = "guests";
    $all_t[3] = "managers";
    $all_t[4] = "admins";
    $all_t[5] = "clienst";
    $user_data['type2'] = $all_t[$tt];
    return $r;
}

function db_connect($baza_host, $baza_user, $baza_password, $baza_table)
{

    // die(var_dump($baza_host,$baza_user,$baza_password,$baza_table));

    $db_connect_result = new mysqli($baza_host, $baza_user, $baza_password, $baza_table);

    $db_connect_result->query("SET NAMES 'utf8'");
    return $db_connect_result;
}


function post($data)
{
    while (true) {
        if (is_array($data)) $data = $data[0];
        else break;
    }
    $result = str_replace('\'', "", $data);
    $len = strlen($data) - 1;
    if ($len < 0) $len = 0;
    if ($result[$len] == '\\') $result[$len] = '';
    //$result=str_replace('"',"",$result);
    $result = show_good($result);
    $result = trim($result);
    $result = htmlspecialchars($result, ENT_QUOTES, 'ISO-8859-1');

    return $result;
}

function obrabotka($obrabotka_dannie)
{
    if ($obrabotka_dannie == null) return false;
    while (($obrabotka_dannie_stroka = $obrabotka_dannie->fetch_assoc()) != false) {
        $obrabotka_dannie_result[] = $obrabotka_dannie_stroka;

    }
    return $obrabotka_dannie_result;
}

function db_disconnect($dase_db)
{
    $dase_db->close();
}

function show_good($text)
{
    $symbol = htmlspecialchars('&#774;', ENT_QUOTES, 'ISO-8859-1');
    $text = str_replace($symbol, "�", $text);
    $symbol = htmlspecialchars('&#776;', ENT_QUOTES, 'ISO-8859-1');
    $text = str_replace($symbol, "�", $text);
    $symbol = htmlspecialchars('&#8722;', ENT_QUOTES, 'ISO-8859-1');
    $text = str_replace($symbol, "-", $text);
    $symbol = htmlspecialchars('&#239;', ENT_QUOTES, 'ISO-8859-1');
    $text = str_replace($symbol, "�", $text);
    $symbol = '&#922;';
    $text = str_replace($symbol, "�", $text);
    $symbol = '&#8722;';
    $text = str_replace($symbol, "-", $text);
    $symbol = '&#774;';
    $text = str_replace($symbol, "�", $text);
    $symbol = '&#776;';
    $text = str_replace($symbol, "�", $text);
    $symbol = '&#239;';
    $text = str_replace($symbol, "�", $text);

    $symbol = '&#1104;';
    $text = str_replace($symbol, "�", $text);
    return $text;
}

?>
<script>
    var window
    .API_LINK = <?=$API_URL?>;
</script>
