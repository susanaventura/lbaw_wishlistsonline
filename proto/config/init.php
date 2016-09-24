<?php
  //secure session start
  //session_set_cookie_params(3600, '/~lbaw1465');
  session_set_cookie_params(3600, '/');
  session_start(); 

  $BASE_DIR = ;
  $BASE_URL = ;
  $BASE_DOMAIN = 'http://gnomo.fe.up.pt';

  $conn = new PDO('', '', '');
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $conn->exec('SET SCHEMA \'wishlists_online_dev\'');
    
  
  include_once($BASE_DIR . 'lib/smarty/Smarty.class.php');
  include_once($BASE_DIR . 'lib/password/password.php');
  
  include_once($BASE_DIR . 'config/tokenHandling.php');
  
  if (isset($_SESSION['userId'])) {
	include_once($BASE_DIR . 'database/users.php');
	userOnlineNow($_SESSION['userId']);
  }
  
  
  $smarty = new Smarty;
  $smarty->template_dir = $BASE_DIR . 'templates/';
  $smarty->compile_dir = $BASE_DIR . 'templates_c/';
  $smarty->assign('BASE_URL', $BASE_URL);
  $smarty->assign('BASE_DIR', $BASE_DIR);
    
  if(isset($_SESSION['error_messages'])) $smarty->assign('ERROR_MESSAGES', $_SESSION['error_messages']);  
  if(isset($_SESSION['field_errors'])) $smarty->assign('FIELD_ERRORS', $_SESSION['field_errors']);
  if(isset($_SESSION['success_messages'])) $smarty->assign('SUCCESS_MESSAGES', $_SESSION['success_messages']);
  if(isset($_SESSION['form_values'])) $smarty->assign('FORM_VALUES', $_SESSION['form_values']);
  if(isset($_SESSION['username'])) $smarty->assign('USERNAME', $_SESSION['username']);
   
  
  unset($_SESSION['success_messages']);
  unset($_SESSION['error_messages']);  
  unset($_SESSION['field_errors']);
  unset($_SESSION['form_values']);
  
  ini_set('log_errors', 1);
  ini_set('error_log', $BASE_DIR . 'log/error.log');

?>
