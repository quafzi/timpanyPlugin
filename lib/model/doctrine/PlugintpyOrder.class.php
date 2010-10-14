<?php

/**
 * PlugintpyOrder
 * 
 * order
 * 
 * @package    timpany
 * @author     Timpany Core Team <lsdug@googlegroups.com>
 */
abstract class PlugintpyOrder extends BasetpyOrder implements tpyOrderInterface
{
  protected $gross_sum=null;
  
  /**
   * create payment for order
   * 
   * @param string $success_url Url of page to display after successful payment
   * @param string $cancel_url  Url of page to display after canceled payment
   * @param string $subject     Subject of the payment
   * 
   * @return Payment
   */
  public function createPayment($success_url, $cancel_url, $subject=null)
  {
    $paymentdata = new PaypalPaymentData();
    $paymentdata->subject = is_null($subject)
      ? 'Order #' . $this->getId()
      : $subject;
    
    $paymentdata->cancel_url = $cancel_url;
    $paymentdata->return_url = $success_url;
    $payment = Payment::create(
      $this->getGrossSum('de'),
      'EUR',
      $paymentdata);
    $payment->setOrder($this);
    $payment->save();
    return $payment;
  }
  
  public function getState()
  {
    return parent::_get('state');
  }
  
  public function getGrossSum()
  {
    if (true or is_null($this->gross_sum)) {
      $this->gross_sum=0;
      foreach ($this->getItems() as $item) {
        $this->gross_sum += $item->getGrossSum();
      } 
    }
    return $this->gross_sum;  
  }
  
  public function addProduct(tpyProductInterface $product, $count=1) {
    return $this->addItem($product, $count);
  }
  
  /**
   * add a product to the order
   * 
   * @param tpyProductInterface $product
   * @param int                 $count
   */
  public function addItem(tpyProductInterface $product, $count)
  {
      $itemRelation   = $this->getTable()->getRelation('Items');
      if ($this->exists()) {
        $itemCollection = $itemRelation['table']->findByOrderId($this->getId());
        $is_new_item = true;
        foreach ($itemCollection as $item) {
          if ($product->getId() === $item->getProductId()) {
            $is_new_item = false;
            break;
          }
        }
      } else {
        $is_new_item = true;
      }
      if ($is_new_item) {
        $item = new tpyOrderItem();
        $item->setProduct($product);
        $item->setOrder($this);
      }
      $item->setCount($item->setCount() + $count);
      $this->save();
  }
  
  /**
   * clear cart
   * 
   * not to be implemented
   */
  public function clear()
  { }
  
  /**
   * get count of a specific product
   * @param tpyProductInterface $product
   * 
   * @return int Count of product
   * 
   * FIXME: not yet implemented
   */
  public function getCountOfProduct(tpyProductInterface $product)
  {
    
  }

  /**
   * get cart items
   * @return array Array with following structure:
   *       'count'     => integer,
   *       'product'   => timpanyProductInterface,
   *       'net_sum'   => float
   *       'gross_sum' => float
   * 
   * FIXME: not yet implemented
   */
  public function getItems()
  {
    return parent::_get('Items');
  }

  /**
   * get net sum
   * @return float
   * 
   * FIXME: not yet implemented
   */
  public function getNetSum()
  {
    
  }
  
  /**
   * remove item from cart
   * @param string $key Key of items collection
   * FIXME: not yet implemented
   */
  public function removeItem($key)
  {
    
  }
  
  /**
   * get count of products
   * @return int
   * 
   * FIXME: not yet implemented
   */
  public function getProductCount()
  {
    
  }

  /**
   * get count of items
   * @return int
   * 
   * FIXME: not yet implemented
   */
  public function getItemCount()
  {
    
  }
  
  /** 
   * FIXME: not yet implemented
   * @see plugins/timpanyPlugin/lib/interface/tpyOrderInterface::isReadyToSend()
   */
  public function isOrdered()
  {
  	
  }
  
  /** 
   * FIXME: not yet implemented
   * @see plugins/timpanyPlugin/lib/interface/tpyOrderInterface::isReadyToSend()
   */
  public function isPaid()
  {
    
  }
  
  /** 
   * FIXME: not yet implemented
   * @see plugins/timpanyPlugin/lib/interface/tpyOrderInterface::isReadyToSend()
   */
  public function isSent()
  {
    
  }
  
  /** 
   * FIXME: not yet implemented
   * @see plugins/timpanyPlugin/lib/interface/tpyOrderInterface::isReadyToSend()
   */
  public function isInvoiced()
  {
    
  }
  
  /** 
   * FIXME: not yet implemented
   * @see plugins/timpanyPlugin/lib/interface/tpyOrderInterface::isReadyToSend()
   */
  public function isClosed()
  {
    
  }
  
  /** 
   * FIXME: not yet implemented
   * @see plugins/timpanyPlugin/lib/interface/tpyOrderInterface::isReadyToSend()
   */
  public function isCanceled()
  {
    
  }
  
  /**
   * FIXME: not yet implemented
   * @see plugins/timpanyPlugin/lib/interface/tpyOrderInterface::isReadyToSend()
   */
  public function isReadyToSend()
  {
  	
  }
}