<?php

function notNullUnique($array){
    if (!$array) return [] ;
    $array = array_unique($array);
    return array_filter($array, function($v) { return !is_null($v); });
}

function br($return = false) {
  if ($return) {
    return PHP_EOL . "<br/>" . PHP_EOL;
  }
  echo PHP_EOL . "<br/>" . PHP_EOL;
}

function hr($return = false) {
  if ($return) {
    return "<hr/>";
  }
  echo "<hr/>";
}


function myDump($var = null, $return = false) {
  //    if($var!=null && $return){
  //        return "<pre>$var</pre>";
  //    }elseif($var!=null && $return==false){
  //        echo "<pre>$var</pre>";
  //    }
  if (is_array($var)) {
    $out = print_r($var, true);
//            ob_start();
//            var_dump($var);
//            $out = ob_get_clean();
  } else if (is_object($var)) {
    $out = var_export($var);
  } else {
    $out = $var;
  }
  if ($return) {
    return "\n<pre style='direction: ltr'>$out</pre>\n";
  } else {
    echo "\n<pre style='direction: ltr'>$out</pre>\n";
  }
}


function getCurrentTime() {
  date_default_timezone_set('Asia/Tehran');
  return date("Y-m-d H:i:s");
}

function baseUrl() {
  global $config;
  return $config['base'];
}

function getFullUrl() {
  return "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}


function getRequestUri() {
  return $_SERVER['REQUEST_URI'];
}

function strhas($string, $search, $caseSenitive = false) {
  if ($caseSenitive) {
    return strpos($string, $search) !== false;
  } else {
    return strpos(strtolower($string), strtolower($search)) !== false;
  }
}

function message($type, $msg, $forcedExite) {
  $data['msg'] = $msg;
  View::renderPartial("/message/$type.php", $data);
  if ($forcedExite) {
    exit;
  }
}


function twoDigitNumber($number) {
  return ($number < 10) ? $number = "0" . $number : $number;
}

function my_jdate($date, $format = "Y-m-d H:i:s") {
  /*1970-01-01 00:00:00 = 1348-10-11 00:00:00
  $date = -1 day => current day
  $day = now => current day +1 ro neshun mide ===> yrooz jolo neshun mide hame chi ro
  BUT =======> har no format gamari ro dorost tabdil mikone be shamsi
  mesal ha:
  $date = now;
  $date = 10 September 2000;  => dagig
  $date = +1 day; => ye rooz jolotare
  $date = +1 week; => ye rooz jolotare
  $date = +1 week 2 days 4 hours 2 seconds; => ye rooz jolotare
  $date = next Thursday; => dagig
  $date = last Monday; => dagig
  $date = 11.12.10; => dagig
  $date = 11/12/10; => dagig
  $date = 11-12-10; => dagig
  $date = 2010-01-31; => dagig
  $date = Friday, October 16, 2015; => dagig
  $date = October 16, 2015; => dagig
  */


  $timestamp = strtotime($date);

  $clock = date(" H:i:s", $timestamp);

  $secondsInOneDay = 24 * 60 * 60;
  $daysPassed = floor($timestamp / $secondsInOneDay) + 1;

  $days = $daysPassed;
  $month = 11;
  $year = 1348;

  $days -= 19;

  $daysInMonths = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

  $monthNames = [
    'فروردین',
    'اردیبهشت',
    'خرداد',
    'تیر',
    'مرداد',
    'شهریور',
    'مهر',
    'آبان',
    'آذر',
    'دی',
    'بهمن',
    'اسفند',
  ];


  while (true) {
    if ($days > $daysInMonths[$month - 1]) {
      $days -= $daysInMonths[$month - 1];
      $month++;
      if ($month == 13) {
        $year++;
        if (($year - 1347) % 4 == 0) {
          $days--;
        }
        $month = 1;
      }
    } else {
      break;
    }
  }


  $month = twoDigitNumber($month);
  $days = twoDigitNumber($days);

  $monthName = $monthNames[$month - 1];

  $output = $format;
  $output = str_replace("Y", $year, $output);
  $output = str_replace("m", $month, $output);
  $output = str_replace("d", $days, $output);
  $output = str_replace("M", $monthName, $output);


  return $output . $clock;
}

function encryptPassword($password) {
  global $config;
  return md5($password . $config['salt']);
}


function buildTree($flat, $pidKey, $idKey = null)
{
    $grouped = array();
    foreach ($flat as $sub){
        $grouped[$sub[$pidKey]][] = $sub;
    }

    $fnBuilder = function($siblings) use (&$fnBuilder, $grouped, $idKey) {
        foreach ($siblings as $k => $sibling) {
            $id = $sibling[$idKey];
            if(isset($grouped[$id])) {
                $sibling['children'] = $fnBuilder($grouped[$id]);
            }
            $siblings[$k] = $sibling;
        }

        return $siblings;
    };

    $tree = $fnBuilder($grouped[0]);

    return $tree;
}


function DBEscape($value) {
  $db = Db::getInstance();
  $link = $db->connection();
  return mysqli_real_escape_string($link, $value);
}

function HTMLEscape($value) {
  return htmlentities($value, ENT_QUOTES, 'utf-8');
}


function MakeHash($value, $salt = '') {
  for ($i = 0; $i < 1000; $i++) {
    $value = md5(PPPR . $value . md5($salt));
  }
  return $value;
}

function AffectedRows() {
  $db = Db::getInstance();
  $link = $db->connection();
  return mysqli_affected_rows($link);
}


function myRedirect($url, $forceExit = true) {
  if ($forceExit) {
    @header('Location: ' . $url);
    exit('<meta http-equiv="Refresh" content="0; url=' . $url . '" />');
  } else {
    @header('Location: ' . $url);
    echo '<meta http-equiv="Refresh" content="0; url=' . $url . '" />';
  }
}

function generateHash($length = 6) {
  $characters = '2345679acdefghjkmnpqrstuvwxyz';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }

  return $randomString;
}

function generateSalt($length = 32) {
  $characters = '1234567890abcdefghijklmnopqrstuvwxyz!@#$%^&*()_+{}|';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }

  return $randomString;
}

function generateHex($length = 6) {
  $characters = 'abcdf1234567890';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }

  return $randomString;
}


function generateCsrfToken() {
  $csrfToken = generateHash(64);
  $_SESSION['csrfToken'] = $csrfToken;

  return $csrfToken;
}

function checkCsrf() {
  if (!isset($_SESSION['csrfToken'])) {
    echo "CSRF Token Error!";
    exit;
  }

  if ($_POST['csrfToken'] == $_SESSION['csrfToken']) {
    unset($_SESSION['csrfToken']);
    return;
  } else {
    echo "CSRF Token Error!";
    exit;
  }
}

function addTime($oldPlayTime, $PlayTimeToAdd) {
  $old = explode(":", $oldPlayTime);
  $play = explode(":", $PlayTimeToAdd);

  $hours = $old[0] + $play[0];
  if ($hours >= 24) {
    $hours -= 24;
  }
  $minutes = $old[1] + $play[1];
  if ($minutes > 59) {
    $minutes = $minutes - 60;
    $hours++;
  }
  if ($minutes < 10) {
    $minutes = "0" . $minutes;
  }
  if ($minutes == 0) {
    $minutes = "00";
  }
  $sum = $hours . ":" . $minutes;
  return $sum;
}

function addTimeArray($times) {
  $minutes = 0 ;
  // loop throught all the times
  foreach ($times as $time) {
    list($hour, $minute) = explode(':', $time);
    $minutes += $hour * 60;
    $minutes += $minute;
  }

  $hours = floor($minutes / 60);
  $minutes -= $hours * 60;

  // returns the time already formatted
  return sprintf('%02d:%02d', $hours, $minutes);
}

function myTrim($string) {
//        delete all White space in string
  $string = preg_replace('/\s+/', '', $string);
  return $string;
}

function convert2english($string) {
  $persinaDigits1 = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
  $persinaDigits2 = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
  $allPersianDigits = array_merge($persinaDigits1, $persinaDigits2);
  $replaces = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
  return str_replace($allPersianDigits, $replaces, $string);
}

function convert2persian($string) {
  $persinaDigits1 = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
  $persinaDigits2 = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
  $allPersianDigits = array_merge($persinaDigits1, $persinaDigits2);
  $replaces = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
  return str_replace($replaces, $allPersianDigits, $string);
}

function piryDate2timeStamp($string, $timeStamp = true) {

//        valid string for piryDate2timeStamp is like this :    1395  /  04  /  24 ( 17:04:20 )

  $string = convert2english($string);

  $clock = preg_replace("/.*\(/", "", $string);
  $clock = str_replace(")", "", $clock);
  $clock = convert2english(myTrim($clock));
  // get clock from inside of brackets

  $fClock = "( " . $clock . " )";
//          $fClock is format that we set clock in string

  $date = str_replace($fClock, "", $string);
  $date = myTrim($date);
  $date = explode("/", $date);
  $d = $date;
  $gDate = jalali_to_gregorian($d[0], $d[1], $d[2], '-');


  $d = DateTime::createFromFormat('Y-m-d  H:i:s', $gDate . "  " . $clock);
  $d->getTimestamp();
  $rTime = $d->getTimestamp();
//        echo  $gDate . "  " . $clock;
//        br();hr();
//       echo  date("d m Y H:m:s" , $rTime);
//        br();hr();
//        echo "<meta charset='utf-8' />";
//        echo jdate("Y / m / d ***  H:i:s",$rTime,"","Asia/Tehran","en");
//        br();
//        echo $string;
//        exit();
  if ($timeStamp) {
    return $rTime;
  } else {
    return date("d m Y H:m:s", $rTime);
  }

}

function piry_jalali2timestamp_zero($string , $timeStamp = true) {

//        valid string for piryDate2timeStamp is like this :    1395/04/24

    if(!$string)
        $string = jdate('Y/m/d' , time());

  $string = convert2english($string);

  $clock = "00:00:00";

  $date = myTrim($string);
  $date = explode("/", $date);
  $d = $date;
  $gDate = jalali_to_gregorian($d[0], $d[1], $d[2], '-');

  $d = DateTime::createFromFormat('Y-m-d  H:i:s', $gDate . "  " . $clock);
  $d->getTimestamp();
  $rTime = $d->getTimestamp();

  if ($timeStamp) {
    return $rTime;
  } else {
    return date("d m Y H:m:s", $rTime);
  }

}

function piry_jalali2timestamp_endOfDay($string, $timeStamp = true) {

    if (!$string)
        return null;

  $string = convert2english($string);

  $clock = "23:59:59";

  $date = myTrim($string);
  $date = explode("/", $date);
  $d = $date;
  $gDate = jalali_to_gregorian($d[0], $d[1], $d[2], '-');

  $d = DateTime::createFromFormat('Y-m-d  H:i:s', $gDate . "  " . $clock);
  $d->getTimestamp();
  $rTime = $d->getTimestamp();

  if ($timeStamp) {
    return $rTime;
  } else {
    return date("d m Y H:m:s", $rTime);
  }

}

function piry_jalali_to_gregorian($string) {
  //        valid string for piryDate2timeStamp is like this :    1395/04/24

  $date = myTrim($string);
  $date = explode("/", $date);
  $d = $date;
  $gDate = jalali_to_gregorian($d[0], $d[1], $d[2], '/');
  return $gDate;

}

function piry_gregorian_to_jalali($timestamp , $delimiter = '/'){
//    @var timestamp format -> 2018-02-06 11:53:17
    $parts = explode(' ' , $timestamp);
    $n = explode('-' ,$parts[0]);
    if(count($n)<3)
        return $timestamp ;

    $x = gregorian_to_jalali($n[0], $n[1], $n[2], $delimiter) ;
    $date = '' ;
    foreach (explode($delimiter, $x) as $item){
        $date = $date . twoDigitNumber($item) . $delimiter ;
    }
    return rtrim($date,$delimiter);
}


function get_currentDay_timestamp($timestamp = null) {
  if ($timestamp !== null && $timestamp > 1000000000) {
    $time = $timestamp;
  } else {
    $time = time();
  }

  $time = jdate("Y/m/d");

  $startOfDay = piry_jalali2timestamp_zero($time);
  $endOfDay = piry_jalali2timestamp_endOfDay($time);

  $result['startOfDay'] = $startOfDay;
  $result['endOfDay'] = $endOfDay;

  return $result;

}



function get_client_ip() {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
    $ipaddress = getenv('HTTP_CLIENT_IP');
  else if (getenv('HTTP_X_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if (getenv('HTTP_X_FORWARDED'))
    $ipaddress = getenv('HTTP_X_FORWARDED');
  else if (getenv('HTTP_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if (getenv('HTTP_FORWARDED'))
    $ipaddress = getenv('HTTP_FORWARDED');
  else if (getenv('REMOTE_ADDR'))
    $ipaddress = getenv('REMOTE_ADDR');
  else
    $ipaddress = 'UNKNOWN';
  return $ipaddress;
}


function minifyContent($content) {

  $search = [
    '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
    '/[^\S ]+\</s',  // strip whitespaces before tags, except space
    '/(\s)+/s'       // shorten multiple whitespace sequences
  ];

  $replace = [
    '>',
    '<',
    '\\1',
  ];

  $content = preg_replace($search, $replace, $content);
  return $content;
}


function searchForId($id, $array) {
  foreach ($array as $key => $val) {
    if ($val['user_id'] === $id) {
      return $key;
    }
  }
  return null;
}


function get_week_name($weekDay) {
  switch ($weekDay) {
    case "0":
      $weekName = "شنبه";
      break;
    case "1":
      $weekName = "یک شنبه";
      break;
    case "2":
      $weekName = "دو شنبه";
      break;
    case "3":
      $weekName = "سه شنبه";
      break;
    case "4":
      $weekName = "چهار شنبه";
      break;
    case "5":
      $weekName = "پنج شنبه";
      break;
    case "6":
      $weekName = "جمعه";
      break;
    default:
      $weekName = "خطا!";
      break;
  }
  return $weekName;
}

function get_week_day_num() {
  $weekNum = jdate("w", time(), "", "", 'en');
  return $weekNum;
}


function melliCodeChecker($code) {
  if (!preg_match('/^[0-9]{10}$/', $code))
    return false;
  for ($i = 0; $i < 10; $i++)
    if (preg_match('/^' . $i . '{10}$/', $code))
      return false;
  for ($i = 0, $sum = 0; $i < 9; $i++)
    $sum += ((10 - $i) * intval(substr($code, $i, 1)));
  $ret = $sum % 11;
  $parity = intval(substr($code, 9, 1));
  if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
    return true;
  return false;
}

function checkPhone($phone) {
  if (!is_numeric($phone)) {
    return false;
  } else {
    if ($phone[0] == 0 && $phone[1] == 9 && strlen($phone) == 11) {
      return true;
    } else if ($phone[0] == '+' && $phone[1] == 9 && $phone[2] == 8 && $phone[3] == 9 && strlen($phone) == 13) {
      return true;
    } else if ($phone[0] == 9 && $phone[1] == 8 && $phone[2] == 9 && strlen($phone) == 12) {
      return true;
    } else {
      return false;
    }
  }

}

function checkEmail($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return false;
  } else {
    return true;
  }
}

function checkEmail2($email) {
  $regex = '/^((?!www\.)[a-zA-Z0-9_\.\-])+\@(yahoo\.com|gmail\.com|uncox\.com|hotmail\.com|email\.com|outlook\.com|persianmail\.ir)+$/';
  if (preg_match($regex, $email)) {
    return true;
  }
  return false;
}

function check_var($variable) {
  try{
      if (isset($variable) && $variable !== null && $variable !== "") {
          return $variable;
      } else {
          return null;
      }
  }catch (\Exception $e){
      return null;
  }

}

function test() {

  $registerApi = [
    'url'  => 'http://dorobar.rezapiryghadim.me/register',
    'post' => [
      'auth'     => 'authenticationCode',
      'name'     => 'firstName',
      'email'    => 'email (validate from mobileApp)',
      'family'   => 'lastName',
      'password' => 'passwordHash (validate form mobileApp) and encrypt with md5',
      'phone'    => 'mobilePhone',
      'gender'   => '1 = man 0 = woman also you can set it 3 = not defined',
    ]
  ];

  $loginApi = [
    'url'  => 'http://dorobar.rezapiryghadim.me/login',
    'post' => [
      'auth'     => 'authenticationCode',
      'userName' => 'phone OR email',
      'password' => 'passwordHash (validate form mobileApp) and encrypt with md5',
    ]
  ];

}


function sendSms($message = "این پیام به صورت خودکار از سایت ایران رزرو ارسال شده است." , $numArray = array() , $user = null , $pass = null , $from = null){

  global $config;
  if($from == null){
    if(check_var($config['operator_num'])){
      $from = $config['operator_num'];
    }else{
      $from = '10009';
    }
  }

  if($user == null || $pass == null){
    $user = $config['smsUser'];
    $pass = $config['smsPass'];
  }

  $url = "37.130.202.188/services.jspd";

  $param = array
  (
    'uname'=>$user,
    'pass'=>$pass,
    'from'=>$from,
    'message'=>$message,
    'to'=>json_encode($numArray),
    'op'=>'send'
  );

  $handler = curl_init($url);
  curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
  curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
  $response2 = curl_exec($handler);

  $response2 = json_decode($response2);
  $res_code = $response2[0];
  $res_data = $response2[1];

  //    save in data base

  //    dump($response2);
  //    exit;
  //    result :
  //    Array
  //    (
  //        [0] => 0,
  //        [1] => 10929800
  //    );

  return $res_data;
}

function get_sms_inbox( $user = null , $pass = null ){

  if($user == null || $pass == null){
    global $config ;
    $user = $config['smsUser'];
    $pass = $config['smsPass'];
  }


  $url = "37.130.202.188/services.jspd";
  $param = array
  (
    'uname'=>$user,
    'pass'=>$pass,
    'op'=>'inboxlist'
  );

  $handler = curl_init($url);
  curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
  curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
  $response2 = curl_exec($handler);

  $response2 = json_decode($response2);
  $res_code = $response2[0];
  $res_data = $response2[1];


  return json_decode($res_data);


}

function sms_deliver_status($user = null , $pass = null){


  if($user == null || $pass == null){
    global $config ;
    $user = $config['smsUser'];
    $pass = $config['smsPass'];
  }

  $url = "37.130.202.188/services.jspd";
  $param = array
  (
    'uname'=>'',
    'pass'=>'',
    'op'=>'delivery',
    'uinqid'=>''
  );

  $handler = curl_init($url);
  curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
  curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
  $response2 = curl_exec($handler);

  $response2 = json_decode($response2);
  $res_code = $response2[0];
  $res_data = $response2[1];

  return $res_data;
}

function get_sms_lines($user = null , $pass = null){

  if($user == null || $pass == null){
    global $config ;
    $user = $config['smsUser'];
    $pass = $config['smsPass'];
  }


  $url = "37.130.202.188/services.jspd";
  $param = array
  (
    'uname'=>'',
    'pass'=>'',
    'op'=>'lines'
  );

  $handler = curl_init($url);
  curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
  curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
  $response2 = curl_exec($handler);

  $response2 = json_decode($response2);
  $res_code = $response2[0];
  $res_data = $response2[1];
  return $res_data;
}

function get_sms_credit( $user = null , $pass = null ){
  if($user == null || $pass == null){
    global $config ;
    $user = $config['smsUser'];
    $pass = $config['smsPass'];
  }

  $url = "37.130.202.188/services.jspd";
  $param = array
  (
    'uname'=>$user,
    'pass'=>$pass,
    'op'=>'credit'
  );

  $handler = curl_init($url);
  curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
  curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
  $response2 = curl_exec($handler);

  $response2 = json_decode($response2);
  $res_code = $response2[0];
  $res_data = $response2[1];


  return $res_data;

}

function myResponse($status='',$data =[] , $message = '' , $errors = '' , $headerCode= null , $acceptArray = true){

    http_response_code(200);
  if ($status == 'failed' || $status == 'error' || $status == 'fail')
      http_response_code(400);


  if ($headerCode) http_response_code($headerCode);

  $response = [
    'status'=>$status,
    'data' => $data,
    'meta'=>[
      'message'=>$message,
      'errors'=>$errors
    ]
  ];

  if($acceptArray){
    return response($response, http_response_code());
  }else{
    return response(json_encode($response) , http_response_code());
  }
}
function myResponseSuccess($data =[] , $message = '' , $errors = '' , $headerCode=200 , $acceptArray = true){
//  http_response_code($headerCode);
//  header("HTTP/1.0 404 Not Found");
//  http_response_code(404);
  $response = [
    'status'=>'success',
    'data' => $data,
    'meta'=>[
      'message'=>$message,
      'errors'=>$errors
    ]
  ];

  if($acceptArray){
    return $response;
  }else{
    return json_encode($response);
  }
}
function myResponseFail($data =[] , $message = '' , $errors = '' , $headerCode=200 , $acceptArray = true){
//  http_response_code($headerCode);
  $response = [
    'status'=>'fail',
    'data' => $data,
    'meta'=>[
      'message'=>$message,
      'errors'=>$errors
    ]
  ];

  if($acceptArray){
    return $response;
  }else{
    return json_encode($response);
  }
}

function convert_from_latin1_to_utf8_recursively($dat)
{
    if (is_string($dat)) {
        return utf8_encode($dat);
    } elseif (is_array($dat)) {
        $ret = [];
        foreach ($dat as $i => $d) $ret[ $i ] = convert_from_latin1_to_utf8_recursively($d);

        return $ret;
    } elseif (is_object($dat)) {
        foreach ($dat as $i => $d) $dat->$i = convert_from_latin1_to_utf8_recursively($d);

        return $dat;
    } else {
        return $dat;
    }
}

function responseStructure($status = 'success' , $data =[] , $message = '' , $errors = ''){

  $response = [
    'status'=>$status,
    'data' => $data,
    'meta'=>[
      'message'=>$message,
      'errors'=>$errors
    ]
  ];
  return $response;
//  return convert_from_latin1_to_utf8_recursively($response);
}




//function kavenegar_send_array_sms($receivers=[] , $message='تست پیامک گروهی'){
//
//  if($receivers == [] ){
//    $receivers[0] = '09145868074';
//    $receivers[1] = '09021112648';
//  }
//  foreach ($receivers as $receiver){
//    $messages[] = htmlentities($message);
//  }
//
//  return json_encode($receivers) . '<br>' . json_encode($messages);
//
//  $url = 'https://api.kavenegar.com/v1/317A4F43726774644C4A6B6D3344687256442B337347654E72574644376A2F46/sms/sendarray.json';
//  $param = [
//    'receptor'=>($receivers),
//    'sender'=>(['10004444000044' , '10004346']),
//    'message'=>($messages),
//    'date'=>time(),
//  ];
//
//  $handler = curl_init($url);
//  curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
//  curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($param));
//  curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
//  $response2 = curl_exec($handler);
//
//  $response2 = json_decode($response2 , true);
////  $res_code = $response2[0];
////  $res_data = $response2[1];
//
//
//  return $response2;
//}

function load_nusoap(){
  require_once(getcwd() . '/lib/nusoap/nusoap.php');
}

function customRequestCaptcha(){
  return new \ReCaptcha\RequestMethod\Post();
}


function arabicToPersian($string)
{
    $characters = [
        '‌'  => ' ',
        'ك' => 'ک',
        'دِ' => 'د',
        'بِ' => 'ب',
        'زِ' => 'ز',
        'ذِ' => 'ذ',
        'شِ' => 'ش',
        'سِ' => 'س',
        'ى' => 'ی',
        'ي' => 'ی',
        '١' => '۱',
        '٢' => '۲',
        '٣' => '۳',
        '٤' => '۴',
        '٥' => '۵',
        '٦' => '۶',
        '٧' => '۷',
        '٨' => '۸',
        '٩' => '۹',
        '٠' => '۰',
    ];
    return str_replace(array_keys($characters), array_values($characters),$string);
}


function google_time($str){
    //  0800 => 08:00

    $part1 = mb_substr($str, 0, 2);
    $part2 = mb_substr($str, 2, 4);
    return $part1 . ':' . $part2;
}

function removeEmoji($text){
    return preg_replace('/[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0077}\x{E006C}\x{E0073}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0073}\x{E0063}\x{E0074}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0065}\x{E006E}\x{E0067}\x{E007F})|[\x{1F3F4}](?:\x{200D}\x{2620}\x{FE0F})|[\x{1F3F3}](?:\x{FE0F}\x{200D}\x{1F308})|[\x{0023}\x{002A}\x{0030}\x{0031}\x{0032}\x{0033}\x{0034}\x{0035}\x{0036}\x{0037}\x{0038}\x{0039}](?:\x{FE0F}\x{20E3})|[\x{1F441}](?:\x{FE0F}\x{200D}\x{1F5E8}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F468})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F468})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B0})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2640}\x{FE0F})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FF}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FE}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FD}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FC}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FB}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F9B8}\x{1F9B9}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FF}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FE}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FD}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FC}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FB}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F9B8}\x{1F9B9}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{200D}\x{2642}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2695}\x{FE0F})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FF})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FE})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FD})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FC})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FB})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FA}](?:\x{1F1FF})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1FA}](?:\x{1F1FE})|[\x{1F1E6}\x{1F1E8}\x{1F1F2}\x{1F1F8}](?:\x{1F1FD})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F9}\x{1F1FF}](?:\x{1F1FC})|[\x{1F1E7}\x{1F1E8}\x{1F1F1}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1FB})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1FB}](?:\x{1F1FA})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FE}](?:\x{1F1F9})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FA}\x{1F1FC}](?:\x{1F1F8})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F7})|[\x{1F1E6}\x{1F1E7}\x{1F1EC}\x{1F1EE}\x{1F1F2}](?:\x{1F1F6})|[\x{1F1E8}\x{1F1EC}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}](?:\x{1F1F5})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EE}\x{1F1EF}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1F8}\x{1F1F9}](?:\x{1F1F4})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1F3})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F4}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FF}](?:\x{1F1F2})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F1})|[\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FD}](?:\x{1F1F0})|[\x{1F1E7}\x{1F1E9}\x{1F1EB}\x{1F1F8}\x{1F1F9}](?:\x{1F1EF})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EB}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F3}\x{1F1F8}\x{1F1FB}](?:\x{1F1EE})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1ED})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1EC})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F9}\x{1F1FC}](?:\x{1F1EB})|[\x{1F1E6}\x{1F1E7}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FB}\x{1F1FE}](?:\x{1F1EA})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1E9})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FB}](?:\x{1F1E8})|[\x{1F1E7}\x{1F1EC}\x{1F1F1}\x{1F1F8}](?:\x{1F1E7})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F6}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}\x{1F1FF}](?:\x{1F1E6})|[\x{00A9}\x{00AE}\x{203C}\x{2049}\x{2122}\x{2139}\x{2194}-\x{2199}\x{21A9}-\x{21AA}\x{231A}-\x{231B}\x{2328}\x{23CF}\x{23E9}-\x{23F3}\x{23F8}-\x{23FA}\x{24C2}\x{25AA}-\x{25AB}\x{25B6}\x{25C0}\x{25FB}-\x{25FE}\x{2600}-\x{2604}\x{260E}\x{2611}\x{2614}-\x{2615}\x{2618}\x{261D}\x{2620}\x{2622}-\x{2623}\x{2626}\x{262A}\x{262E}-\x{262F}\x{2638}-\x{263A}\x{2640}\x{2642}\x{2648}-\x{2653}\x{2660}\x{2663}\x{2665}-\x{2666}\x{2668}\x{267B}\x{267E}-\x{267F}\x{2692}-\x{2697}\x{2699}\x{269B}-\x{269C}\x{26A0}-\x{26A1}\x{26AA}-\x{26AB}\x{26B0}-\x{26B1}\x{26BD}-\x{26BE}\x{26C4}-\x{26C5}\x{26C8}\x{26CE}-\x{26CF}\x{26D1}\x{26D3}-\x{26D4}\x{26E9}-\x{26EA}\x{26F0}-\x{26F5}\x{26F7}-\x{26FA}\x{26FD}\x{2702}\x{2705}\x{2708}-\x{270D}\x{270F}\x{2712}\x{2714}\x{2716}\x{271D}\x{2721}\x{2728}\x{2733}-\x{2734}\x{2744}\x{2747}\x{274C}\x{274E}\x{2753}-\x{2755}\x{2757}\x{2763}-\x{2764}\x{2795}-\x{2797}\x{27A1}\x{27B0}\x{27BF}\x{2934}-\x{2935}\x{2B05}-\x{2B07}\x{2B1B}-\x{2B1C}\x{2B50}\x{2B55}\x{3030}\x{303D}\x{3297}\x{3299}\x{1F004}\x{1F0CF}\x{1F170}-\x{1F171}\x{1F17E}-\x{1F17F}\x{1F18E}\x{1F191}-\x{1F19A}\x{1F201}-\x{1F202}\x{1F21A}\x{1F22F}\x{1F232}-\x{1F23A}\x{1F250}-\x{1F251}\x{1F300}-\x{1F321}\x{1F324}-\x{1F393}\x{1F396}-\x{1F397}\x{1F399}-\x{1F39B}\x{1F39E}-\x{1F3F0}\x{1F3F3}-\x{1F3F5}\x{1F3F7}-\x{1F3FA}\x{1F400}-\x{1F4FD}\x{1F4FF}-\x{1F53D}\x{1F549}-\x{1F54E}\x{1F550}-\x{1F567}\x{1F56F}-\x{1F570}\x{1F573}-\x{1F57A}\x{1F587}\x{1F58A}-\x{1F58D}\x{1F590}\x{1F595}-\x{1F596}\x{1F5A4}-\x{1F5A5}\x{1F5A8}\x{1F5B1}-\x{1F5B2}\x{1F5BC}\x{1F5C2}-\x{1F5C4}\x{1F5D1}-\x{1F5D3}\x{1F5DC}-\x{1F5DE}\x{1F5E1}\x{1F5E3}\x{1F5E8}\x{1F5EF}\x{1F5F3}\x{1F5FA}-\x{1F64F}\x{1F680}-\x{1F6C5}\x{1F6CB}-\x{1F6D2}\x{1F6E0}-\x{1F6E5}\x{1F6E9}\x{1F6EB}-\x{1F6EC}\x{1F6F0}\x{1F6F3}-\x{1F6F9}\x{1F910}-\x{1F93A}\x{1F93C}-\x{1F93E}\x{1F940}-\x{1F945}\x{1F947}-\x{1F970}\x{1F973}-\x{1F976}\x{1F97A}\x{1F97C}-\x{1F9A2}\x{1F9B0}-\x{1F9B9}\x{1F9C0}-\x{1F9C2}\x{1F9D0}-\x{1F9FF}]/u', '', $text);
}

function curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $return = curl_exec($ch);
    curl_close ($ch);
    return $return;
}

function get_month_name($date){
    // 1398/12/12
    try{
        $m = explode('/',$date)[1];
        $m = (integer)$m;
        $monthNames = [
            'فروردین',
            'اردیبهشت',
            'خرداد',
            'تیر',
            'مرداد',
            'شهریور',
            'مهر',
            'آبان',
            'آذر',
            'دی',
            'بهمن',
            'اسفند',
        ];

        return $monthNames[$m-1];

    }catch (\Exception $e){
        echo $e->getMessage();
        return null;
    }



}

function get_percent($total , $retail){
    try{
        $p = $retail / $total;
        if ( $p >= 1)
            return 100;

        return $p * 100;
    }catch (\Exception $e) {
//        echo $e->getMessage();
        return 0;
    }
}

function twodshuffle($array)
{
    // Get array length
    $count = count($array);
    // Create a range of indicies
    $indi = range(0,$count-1);
    // Randomize indicies array
    shuffle($indi);
    // Initialize new array
    $newarray = array($count);
    // Holds current index
    $i = 0;
    // Shuffle multidimensional array
    foreach ($indi as $index)
    {
        $newarray[$i] = $array[$index];
        $i++;
    }
    return $newarray;
}


function array_quake(&$array) {
    if (is_array($array)) {
        $keys = array_keys($array); // We need this to preserve keys
        $temp = $array;
        $array = NULL;
        shuffle($temp); // Array shuffle
        foreach ($temp as $k => $item) {
            $array[$keys[$k]] = $item;
        }
        return;
    }
    return false;
}

function NewYearRemaining($date = '1396/01/01'){

    $days_in_months = [ 31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29 ];

    $parts = explode('/' , $date);

    $year  = (integer)$parts[0] ;
    $month = (integer)$parts[1] ;
    $day   = (integer)$parts[2] ;

    if ($year <= 1396) return 365; // like example

    $remaining_days = 0 ;


    for($m = $month-1  ; $m <= 11 ; $m ++){
        $remaining_days += $days_in_months[$m];

    }

    $remaining_days -= $day ;
    $remaining_days++; // in the example current day observed as remained day

    return $remaining_days;

}

function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}
