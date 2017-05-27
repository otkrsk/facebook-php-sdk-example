<?php

require_once __DIR__ . '/vendor/autoload.php';

if(!session_id()) {
  session_start();
}

$fb = new \Facebook\Facebook([
  'app_id' => '125509478022427',
  'app_secret' => '833402786170fbd6a934f98e4c3e3e33',
  'default_graph_version' => 'v2.9',
]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  echo "Graph returned an error: " . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  echo "Facebook SDK returned an error: " . $e->getMessage();
  exit;
}

if( !isset($accessToken) ) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
} else {
  $response = $fb->get('/me', $accessToken->getValue());
  $me = $response->getGraphUser();
  echo "Logged in as " . $me->getName();

  echo "<br>";
  echo "var_dump";
  echo "<br>";
  var_dump($accessToken);
  echo "<br>";
  echo "response";
  echo "<br>";
  var_dump($response);
  echo "<br>";
  echo "me";
  echo "<br>";
  var_dump($me);

  $_SESSION['fb_access_token'] = (string) $accessToken;
}

?>
