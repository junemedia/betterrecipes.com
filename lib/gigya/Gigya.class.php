<?php

/**
 * 
 */
class Gigya {
  
  protected $gigya_UID;
  protected $user_ID;

  protected $api_key;
  protected $secret_key;
  protected $partner_id;
  
  protected $last_request;

  /**
   * Constructor
   * 
   * @param string $api_key
   * @param string $secret_key
   * @param string $partner_id 
   */
  public function __construct($api_key, $secret_key, $partner_id) {
    $this->api_key = $api_key;
    $this->secret_key = $secret_key;
    $this->partner_id = $partner_id;
  }
  
  /**
   *
   * @return string 
   */
  public function getApiKey() {
    return $this->api_key;
  }
  
  /**
   *
   * @return string 
   */
  public function getSecretKey() {
    return $this->secret_key;
  }
  
  /**
   * Creates a new GSRequest instance
   * 
   * @see http://developers.gigya.com/032_SDKs/PHP/Reference/Class_GSRequest
   * @param array $params
   * @param boolean $useHTTPS
   * @return GSRequest 
   */
  public function request($apiMethod, array $params, $useHTTPS = false) {
    $request = new GSRequest($this->api_key, $this->secret_key, $apiMethod);
    foreach( $params as $index => $value )
    {
      $request->setParam($index, $value);
    }

    return $this->last_request = $request->send();
  }
  
  /**
   * Get the last GSRequest object
   * 
   * @return GSRequest
   */
  public function getLastRequest() {
    return $this->last_request;
  }
  
  /**
   * validate User Signature
   * 
   * @param string $UID
   * @param string $timestamp
   * @param string $secret
   * @param string $signature
   * @return boolean 
   */
  public static function validateUserSignature($UID, $timestamp, $secret, $signature) {
    return SigUtils::validateUserSignature($UID, $timestamp, $secret, $signature);
  }

  /**
   * validate Friend Signature
   * 
   * @param string $UID
   * @param string $timestamp
   * @param string $friendUID
   * @param string $secret
   * @param string $signature
   * @return boolean 
   */
  public static function validateFriendSignature($UID, $timestamp, $friendUID, $secret, $signature) {
    return SigUtils::validateFriendSignature($UID, $timestamp, $friendUID, $secret, $signature);
  }

  /**
   * calculate Signature
   * 
   * @param string $baseString
   * @param string $key
   * @return string 
   */
  public static function calcSignature($baseString, $key) {
    return SigUtils::calcSignature($baseString, $key);
  }
  
}