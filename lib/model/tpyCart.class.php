<?php

class tpyCart implements tpyCartInterface
{
  const SESSION_NS = 'tpyCart';
  
  /**
   * singleton instance
   * @var tpyCart
   */
  protected static $_instance=null;
  
  /**
   * owning user
   * @var sfUser
   */
  protected $_user;
  
  /**
   * cart items
   * @var array
   */
  protected $_items=array();
  
  /**
   * order state
   */
  protected $_orderState;
  
  /**
   * @var tpyOrder $_order
   */
  protected $_order;
  
  /**
   * get singleton instance
   * @param sfUser $sfUser
   * @return tpyCart
   */
  public static function getInstance(sfUser $sfUser)
  {
    if (is_null(self::$_instance)) {
	    if ($sfUser->isAuthenticated()) {
        self::$_instance = tpyUserCartTable::getInstance()->findOneBySfGuardUserId($sfUser->getGuardUser()->getId());
        if (false == self::$_instance) {
        	self::$_instance = new tpyUserCart();
        	self::$_instance->setSfGuardUserId($sfUser->getGuardUser()->getId());
        }
	    } else {
	      self::$_instance = new tpyCart();
	      self::$_instance->_user = $sfUser;
		    self::$_instance->_items = $sfUser->getAttribute(
		      'cart_items',
		      array(),
		      tpyCart::SESSION_NS
		    );
	    }
    }
    return self::$_instance;
  }
  protected function __construct() {}
  private function __clone() {}
  
  /**
   * save cart to session
   */
  public function save()
  {
    $this->_user->setAttribute(
      'cart_items',
      $this->_items,
      tpyCart::SESSION_NS
    );
  }
  
  /**
   * add a product to the cart
   * 
   * @param tpyProductInterface $product
   * @param int                     $count
   */
  public function addProduct(tpyProductInterface $product, $count=1)
  {
    if (false == array_key_exists($product->getUid(), $this->_items)) {
    	$this->_items[$product->getUid()] = new tpyCartItem();
    	$this->_items[$product->getUid()]
    	  ->setCount($count)
        ->setProductData($product->toCartItem());
    } else {
      $this->_items[$product->getUid()]->increaseCount($count);
    }
  }
  
  /**
   * clear cart
   */
  public function clear()
  {
    $this->setItems(array());
  }
  
  /**
   * set cart items
   * @param array $items
   */
  public function setItems($items)
  {
  	$this->_items = $items;
  }
  
  /**
   * get count of a specific product
   * @param tpyProductInterface $product
   * @return int Count of product
   */
  public function getCountOfProduct(tpyProductInterface $product)
  {
    return $this->_items[$product->getUid()]['count'];
  }
  
  /**
   * get cart items
   * @return array Array with following structure:
   *       'count'     => integer,
   *       'product'   => tpyProductInterface,
   *       'net_sum'   => float
   *       'gross_sum' => float
   */
  public function getItems()
  {
  	return $this->_items;
  }
  
  /**
   * get net sum
   * @return float
   */
  public function getNetSum()
  {
    $net_sum = 0;
    foreach ($this->getItems() as $item) {
      $net_sum += $item['count']*$item['product_data']['net_price'];
    }
    return $net_sum;
  }
  
  /**
   * get gross sum
   * @return float
   */
  public function getGrossSum()
  {
    $gross_sum = 0;
    foreach ($this->getItems() as $item) {
      $gross_sum += $item->getGrossSum();
    }
    return $gross_sum;
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
  
  /**
   * get count of products
   * @return int
   */
  public function getProductCount()
  {
    $count = 0;
  	foreach ($this->getItems() as $item) {
  	  $count += $item['count'];
  	}
  	return $count;
  }
  
  /**
   * get count of items
   * @return int
   */
  public function getItemCount()
  {
    return count($this->_items);
  }
  
  /**
   * turn cart into an array
   * @param boolean $deep
   * @return array
   */
  public function toArray($deep=true)
  {
    return $this->getContent();
  }
  
  /**
   * if cart is empty
   * @return boolean
   */
  public function isEmpty()
  {
  	return 0 == $this->getItemCount();
  }
}
