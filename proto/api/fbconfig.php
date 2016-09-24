<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

include_once('../config/init.php');
include_once('../database/users.php');

// init app with app id and secret
FacebookSession::setDefaultApplication( '718476411611394', 'd0a373cf692f5cf2404bfa48a8a75e1d' );
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper('http://gnomo.fe.up.pt/~lbaw1465/proto/api/fbconfig.php' );
    
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}

// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $fbuser = $response->getGraphObject();
     	$fbid = $fbuser->getProperty('id');         // To Get Facebook ID
 	    $fbfullname = $fbuser->getProperty('name'); // To Get Facebook full name
      
      /* ---- Session Variables ----- */
	    $_SESSION['FBID'] = $fbid;           
      $_SESSION['FULLNAME'] = $fbfullname;
      $_SESSION['username'] = $fbfullname;                    // store the username
      
      // If user is already a registered user
      if(userExists($fbid)){
        $_SESSION['userId'] = getUserId($fbid);
      } else {      // otherwise we need to register the user
        createUser($fbuser->getProperty('first_name'), $fbuser->getProperty('last_name'), date('Y-m-d H:i:se'), $fbid, ucwords($fbuser->getProperty('gender'))[0], $fbid, $fbid, date('Y-m-d H:i:se'), NULL);
        $_SESSION['userId'] = getUserId($fbid);
      }
      
      /* ---- header location after session ----*/
  header("Location: http://gnomo.fe.up.pt/~lbaw1465/proto/pages/wallPage.php");
} else {
 $loginUrl = $helper->getLoginUrl();
 header("Location: ".$loginUrl);
}
?>