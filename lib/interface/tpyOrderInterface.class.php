<?php

interface timpanyOrderInterface extends timpanyCartInterface
{
  /**
   * @return boolean
   */
  public function isPaid();

  /**
   * @return boolean
   */
  public function isOrdered();

  /**
   * @return boolean
   */
  public function isSent();

  /**
   * @return boolean
   */
  public function isReadyToSend();

  /**
   * @return boolean
   */
  public function isClosed();

  /**
   * @return boolean
   */
  public function isCanceled();

  /**
   * @return boolean
   */
  public function isInvoiced();
}
