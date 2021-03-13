<?php

ini_set('display_errors', 1);

// CHANGE THIS WHEN MIGRATING !!
define( "BASE_URL", "http://localhost/webtech/zadanie2" );
define( "ROUTING_PREFIX", 'webtech/zadanie2' );



require __DIR__ . '/../vendor/autoload.php';
require_once 'functions.php';
require_once 'helper-router-functions.php';

// Start a Session
if (!session_id()) @session_start();

$GLOBALS['msg'] = new \Plasticbrain\FlashMessages\FlashMessages();
