<?php
function array_change_case($params,$case=CASE_UPPER) {
  $params = array_change_key_case($params, $case);
  foreach ( $params as &$value ) {
    if (is_scalar($value)) {
      if ($case == CASE_UPPER){
        $value = strtoupper($value);
      } else {
        $value = strtolower($value);
      }
    } elseif (is_array($value)) {
        if ($case == CASE_UPPER) {
          $value = array_map("strtoupper", $value);
        } else {
          $value = array_map("strtolower", $value); 
        }
    }
  }
  unset($value);
  return $params;
}
function tokenGenerate($length){
  $max = ceil($length / 32);
  $random = '';
  for ($i = 0; $i < $max; $i ++) {
    $random .= md5(microtime(true).mt_rand(10000,90000));
  }
  return substr($random, 0, $length);
}
function get($name, $default = null) { 
  
  if (isset($_GET[$name])) {
    if (is_array($_GET[$name])) {
      $res_array = array();
      foreach($_GET[$name] as $key => $value) {
        $res_array[$key] = trim($value);
      }
      return $res_array;
    } else {
      return trim($_GET[$name]);
    }
  } else {
    return $default;
  }
  
}
function set_get($name, $value = null) { $_GET[$name] = $value; }
function session($name, $default = null) { return isset($_SESSION[$name]) ? $_SESSION[$name] : $default; }
function cookie($name, $default = null) { return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default; }
function post($name, $default = null) { return isset($_POST[$name]) ? $_POST[$name] : $default; }
function set_post($name, $value = null) { $_POST[$name] = $value; }
function request($name, $default = null) {
  if(isset($_GET[$name])) return get($name, $default);
  return post($name, $default);
}
function safe($array, $name, $default = null) { 
  return (is_array($array) && strlen($name) && array_key_exists($name, $array) && ($array[$name] || (is_scalar($array[$name]) and strlen($array[$name])))) ? $array[$name] : $default;
}

function responseText($code, $method = '') {
    $methods = array (
        'get' => 'Получение',
        'post' => 'Добавление',
        'put' => 'Обновление',
        'update' => 'Обновление',
        'delete' => 'Удаление'
    );

    $methodsDone = array (
        'get'    => 'Выбраны',
        'post'   => 'Добавлены',
        'put'    => 'Обновлены',
        'update' => 'Обновлены',
        'delete' => 'Удалены'
    );
echo ($method);
    $method = $method?$method:'get';
    $message = '';
    switch ($code) {
      case 'SUCCESSFUL' :
            $message = 'Данные успешно ' . $methodsDone[$method];
        break;
      case 'ERROR' :
        $message = $methods [$method] . ' Ошибка: операция не выполнена';
        break;
      case 'ERR_NOT_EXISTS' :
            $message = $methods [$method] . ' Ошибка: Эта база данных не существует';
        break;
      case 'ERR_DUPLICATED' :
            $message = $methods [$method] . ' Ошибка: Эта запись уже существует';
        break;
      case 'ERR_DUPLICATED_EMAIL' :
            $message = $methods [$method] . ' Ошибка: Этот адрес уже зарегистрирован ';
        break;
      default :
            $text = array (
                'LOGIN_SUCCESSFUL' => 'аутентификация прошла успешно',
                'ERR_OUT_OF_DATE' => 'срок действия ключа истек',
            );
            $message = isset ( $text [$code] ) ? $text [$code] : $code;
    }

    echo $message;
  }