<?php
require '../vendor/autoload.php';

use AppYMBL\Others\Client;

$client = new Client();

$request = $client->request('auth');

var_dump($request);