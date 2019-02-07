<?php
$config = require_once('config.php');

$vk = new \VK\Client\VKApiClient;

$core = new \VkBot\Core($vk, $config);

$data = json_decode(file_get_contents("php://input"));

$core->parse($data);