<?php

require_once __DIR__ . '/vendor/autoload.php';

if(!session_id()) {
  session_start();
}

include_once "credentials.php";

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://54.169.78.235/callback.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
