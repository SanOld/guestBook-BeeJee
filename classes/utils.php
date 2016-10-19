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
        'get'    => 'выбраны',
        'post'   => 'добавлены',
        'put'    => 'обновлены',
        'update' => 'обновлены',
        'delete' => 'удалены'
    );
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

function placeholder() {

    $args = func_get_args();
    $tmpl = array_shift($args);
    $result = placeholderEx($tmpl, $args, $error);
    if ($result === false)
      return 'ERROR:'.$error;
    else
      return $result;

  }
function placeholderCompile($tmpl) {

    $compiled  = array();
    $p         = 0;
    $i         = 0;
    $has_named = false;

    while (false !== ($start = $p = strpos($tmpl, "?", $p))) {

      switch ($c = substr($tmpl, ++$p, 1)) {
        case '&':
        case '%':
        case '@':
        case '#':
          $type = $c;
          ++$p;
          break;
        default:
          $type = '';
          break;
      }

      if (preg_match('/^((?:[^\s[:punct:]]|_)+)/', substr($tmpl, $p), $pock)) {

        $key = $pock[1];
        if ($type != '#')
          $has_named = true;
        $p += strlen($key);

      } else {

        $key = $i;
        if ($type != '#')
          $i++;

      }

      $compiled[] = array($key, $type, $start, $p - $start);
    }

    return array($compiled, $tmpl, $has_named);

  }
function placeholderEx($tmpl, $args, &$errormsg) {

    if (is_array($tmpl)) {
      $compiled = $tmpl;
    } else {
      $compiled = placeholderCompile($tmpl);
    }

    list ($compiled, $tmpl, $has_named) = $compiled;

    if ($has_named)
      $args = @$args[0];

    $p   = 0;
    $out = '';
    $error = false;

    foreach ($compiled as $num=>$e) {

      list ($key, $type, $start, $length) = $e;

      $out .= substr($tmpl, $p, $start - $p);
      $p = $start + $length;

      $repl = '';
      $errmsg = '';

      do {

        if (!isset($args[$key]))
          $args[$key] = "";

        if ($type === '#') {
          $repl = @constant($key);
          if (NULL === $repl)
            $error = $errmsg = "UNKNOWN_CONSTANT_$key";
          break;
        }

        if (!isset($args[$key])) {
          $error = $errmsg = "UNKNOWN_PLACEHOLDER_$key";
          break;
        }

        $a = $args[$key];
        if ($type === '&') {
          if (strlen($a) === 0) {
            $repl = "null";
          } else {
            $repl = "'".addslashes($a)."'";
          }
          break;
        } else
        if ($type === '') {
          if (is_array($a)) {
            $error = $errmsg = "NOT_A_SCALAR_PLACEHOLDER_$key";
            break;
          } else
          if (strlen($a) === 0) {
            $repl = "null";
          } else {
            $repl = (preg_match('#^[-]?([1-9][0-9]*|[0-9])($|[.,][0-9]+$)#', $a)) ? str_replace(',', '.', $a) : "'".addslashes($a)."'";
          }
          break;
        }

        if (!is_array($a)) {
          $error = $errmsg = "NOT_AN_ARRAY_PLACEHOLDER_$key";
          break;
        }

        if ($type === '@') {
          foreach ($a as $v) {
            $repl .= ($repl===''? "" : ",").(preg_match('#^[-]?([1-9][0-9]*|[0-9])($|[.,][0-9]+$)#', $v) ? str_replace(',', '.', $v):"'".addslashes($v)."'");
          }
        } else
        if ($type === '%') {
          $lerror = array();
          foreach ($a as $k=>$v) {
            if (!is_string($k)) {
              $lerror[$k] = "NOT_A_STRING_KEY_{$k}_FOR_PLACEHOLDER_$key";
            } else {
              $k = preg_replace('/[^a-zA-Z0-9_]/', '_', $k);
            }
            $repl .= ($repl===''? "" : ", ").$k."='".@addslashes($v)."'";
          }
          if (count($lerror)) {
            $repl = '';
            foreach ($a as $k=>$v) {
              if (isset($lerror[$k])) {
                $repl .= ($repl===''? "" : ", ").$lerror[$k];
              } else {
                $k = preg_replace('/[^a-zA-Z0-9_-]/', '_', $k);
                $repl .= ($repl===''? "" : ", ").$k."=?";
              }
            }
            $error = $errmsg = $repl;
          }
        }

      } while (false);

      if ($errmsg)
        $compiled[$num]['error'] = $errmsg;

      if (!$error)
        $out .= $repl;

    }
    $out .= substr($tmpl, $p);

    if ($error) {
      $out = '';
      $p   = 0;
      foreach ($compiled as $num=>$e) {
        list ($key, $type, $start, $length) = $e;
        $out .= substr($tmpl, $p, $start - $p);
        $p = $start + $length;
        if (isset($e['error'])) {
          $out .= $e['error'];
        } else {
          $out .= substr($tmpl, $start, $length);
        }
      }
      $out .= substr($tmpl, $p);
      $errormsg = $out;
      return false;
    } else {
      $errormsg = false;
      return $out;
    }

  }
