<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;


$title = 'City of Corvallis';
$app = 'drupal';
$env = 'terra';
$alias = '@'. $app .'.'. $env;
$path = "'/home/jeff/Apps/$app/$env'";

$data = array(
  array(
    'key' => 'enviornment add',
    'nid' => 1,
    'uid' => 1,
    'callback' => '',
    'cmd' => array(
      'cmd' => 'terra',
      'args' => array('environment:add', $app, $env, $path),
      'flags' => array(
        '--no-interaction' => TRUE,
        '--enable' => 'ENABLE',
      ),
    ),
  ),
  /*array(
    'cmd' => "drush $alias sqlc < /home/jeff/Downloads/goredmond.sql",
  ),
  array(
    'cmd' => "drush $alias cc all",
  ),
  array(
    'cmd' => "drush $alias vset site_name '$title'",
  ),*/
  
);
$data = json_encode($data);


$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
$msg = new AMQPMessage($data);
$channel->basic_publish($msg, '', 'hello');
echo " [x] Posted original commands'\n";
$channel->close();
$connection->close();