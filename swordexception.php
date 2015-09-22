<?php

/**
 * @file
 * swordexception.php
 *
 * @see https://gist.github.com/henriquemoody/6580735
 */

class SwordException extends \Exception {

}

class SwordHttpException extends \SwordException {

  /**
   * HTTP Body message
   *
   * @var string
   */
  private $body = '';

  /**
   * @param int $statusCode
   *   If NULL will use 500 as default
   *
   * @param string $statusMessage
   *   If NULL will use the default status phrase
   *
   * @param string $body
   *   The HTTP body
   *
   * @param array $headers
   *   List of additional headers
   */
  public function __construct($statusCode = 500, $statusMessage = NULL, $body = NULL) {
    if (NULL === $statusMessage && isset($this->status[$statusCode])) {
        $statusMessage = $this->status[$statusCode];
    }

    parent::__construct($statusMessage, $statusCode);

    if (NULL !== $body) {
      $this->setBody($body);
    }
  }

  /**
   * Return the body message.
   *
   * @return string
   */
  public function getBody() {
    return $this->body;
  }

  /**
   * Define a body message.
   *
   * @param string $body
   *
   * @return self
   */
  public function setBody($body) {
    $this->body = (string) $body;
    return $this;
  }
}
