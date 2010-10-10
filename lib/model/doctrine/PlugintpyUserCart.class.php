<?php

/**
 * PlugintpyUserCart
 * 
 * @package    timpany
 * @author     Timpany Core Team <lsdug@googlegroups.com>
 */
abstract class PlugintpyUserCart extends BasetpyUserCart
{
  public function clear()
  {
    foreach ($this->getItems() as $key=>$item) {
      $item->delete();
    }
    $this->refreshRelated('Items');
  }
  
  /**
   * get count of cart products
   * 
   * @return int
   */
  public function getProductCount()
  {
    $count = 0;
    foreach ($this->getItems() as $item) {
      $count += $item->getCount();
    }
    return $count;
  }
  
  /**
   * get count of cart items
   * 
   * @return int
   */
  public function getItemCount()
  {
    return $this->getItems()->count();
  }
  
  /**
   * add product
   * 
   * @param tpyProductInterface $product
   * @param int                     $count
   * 
   * @return tpyCartInterface
   */
  public function addProduct(tpyProductInterface $product, $count=1) {
    foreach ($this->getItems() as $item) {
      if ($item->getProductIdentifier() == $product->getIdentifier()) {
        $cartItem = $item;
        break;
      }
    }
    if (isset($cartItem)) {
      $cartItem->increaseCount($count);
    } else {
      $cartItem = new tpyCartItem();
      $cartItem
        ->setCount($count)
        ->setProductIdentifier($product->getIdentifier())
        ->setProductData($product->toJson());
      $this->getItems()->add($cartItem);
    }
    return $this;
  }
  
  /**
   * get net sum
   * @return float
   */
  public function getNetSum()
  {
    $net_sum = 0;
    foreach ($this->getItems() as $item) {
      $net_sum += $item->getNetSum();
    }
    return $net_sum;
  }
  
  /**
   * get gross sum
   * @return float
   */
  public function getGrossSum($region='de')
  {
    $net_sum = 0;
    foreach ($this->getItems() as $item) {
      $net_sum += $item->getGrossSum($region);
    }
    return $net_sum;
  }
  
  /**
   * remove item from cart
   * @param tpyProductInterface $product
   */
  public function removeItem($product_key)
  {
    $items = $this->getItems();
    unset($items[$product_key]);
    $this->setItems($items);
  }
  
  public function setItems($items)
  {
    parent::_set('Items', $items);
  }
  
  public function getCountOfProduct(tpyProductInterface $product)
  {
    $count = 0;
    foreach ($this->getItems() as $item) {
      if ($item->getProductIdentifier() == $product->getIdentifier()) {
        return $item->getCount();
      }
    }
    return 0;
  }
  
  public function getItems()
  {
    return parent::_get('Items');
  }
}