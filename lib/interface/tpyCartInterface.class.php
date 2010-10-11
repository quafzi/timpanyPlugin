<?php

interface tpyCartInterface
{
  /**
   * add a product to the cart
   * 
   * @param tpyProductInterface $product
   * @param int                 $count
   */
  public function addProduct(tpyProductInterface $product, $count=1);
  
  /**
   * clear cart
   */
  public function clear();
  
  /**
   * get count of a specific product
   *
   * @param timpanyProductInterface $product
   * @return int Count of product
   */
  public function getCountOfProduct(tpyProductInterface $product);

  /**
   * get cart items
   *
   * @return array Array with following structure:
   *       'count'     => integer,
   *       'product'   => timpanyProductInterface,
   *       'net_sum'   => float
   *       'gross_sum' => float
   */
  public function getItems();

  /**
   * get net sum
   *
   * @return float
   */
  public function getNetSum();
  
  /**
   * get gross sum
   *
   * @return float
   */
  public function getGrossSum();
  
  /**
   * remove item from cart
   *
   * @param int $key Key of item collection
   */
  public function removeItem($key);
  
  /**
   * get count of products
   *
   * @return int
   */
  public function getProductCount();

  /**
   * get count of items
   *
   * @return int
   */
  public function getItemCount();
  
  /**
   * turn cart into an array
   *
   * @param boolean $deep
   *
   * @return array
   */
  public function toArray($deep=true);
}
