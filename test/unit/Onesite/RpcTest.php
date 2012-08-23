<?php

include __DIR__.'/../../bootstrap/unit.php';

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', 'false');
$context = sfContext::createInstance($configuration);
$onesite = $context->getOnesite();

$rpc = $onesite->getRpc();

$t = new lime_test(6);

/**
 * emailCheck
 */
$t->diag('emailCheck()');
$response = $rpc->emailCheck('bkuberek@resolute.com');

$t->ok(
        (array_key_exists('code', $response) && array_key_exists('message', $response) && array_key_exists('response', $response))
        , 'response is valid'
);

/**
 * userCheck
 */
$t->diag('userCheck()');
$response = $rpc->userCheck('bkuberek@resolute.com');

$t->ok(
        (array_key_exists('code', $response) && array_key_exists('message', $response) && array_key_exists('response', $response))
        , 'response is valid'
);

/**
 * subdirCheck
 */
$t->diag('subdirCheck()');
$response = $rpc->subdirCheck('bkuberek');

$t->ok(
        (array_key_exists('code', $response) && array_key_exists('message', $response) && array_key_exists('response', $response))
        , 'response is valid'
);

/**
 * mkUserSessionData 
 */
$t->diag('mkUserSessionData()');
$response = $rpc->mkUserSessionData('bkuberek@resolute.com');

var_dump($onesite->getIp(), $response);

/**
 * sessionCheck
 */
$t->diag('sessionCheck() throws OnesiteError exception');

try {
  $response = $rpc->sessionCheck(array());
  $t->fail('failed to throw an exception');
} catch (OnesiteError $e) {
  $t->pass('OnesiteError thrown');
} catch (Exception $e) {
  $t->fail('failed to throw OnesiteError exception. Thrown exception: '.get_class($e));
}

$response = $rpc->sessionCheck(array('core_x' => '', 'core_u' => ''));

$t->ok(
        (array_key_exists(0, $response) && array_key_exists('code', $response) && array_key_exists('message', $response) && array_key_exists('response', $response))
        , 'response is valid'
);

$t->ok(isset($response[0]) && $response[0] === false, 'Session check returns correct response if cookies are invalid');