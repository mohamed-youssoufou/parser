<?php
require '../vendor/autoload.php';

use AppYMBL\Others\Client;

$client = new Client();

$request = $client->request('infos_by_fixe_number');

var_dump($request);