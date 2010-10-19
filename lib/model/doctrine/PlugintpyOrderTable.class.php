<?php

/**
 * PlugintpyOrderTable
 * 
 * @package    timpany
 * @author     Timpany Core Team <lsdug@googlegroups.com>
 */
class PlugintpyOrderTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PlugintpyOrderTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PlugintpyOrder');
    }
    
    /**
     * turn a cart into an order
     * 
     * @param tpyCartInterface $cart
     * @param sfGuardUser      $guardUser
     * 
     * @return tpyOrder
     */
    public function createOrder(tpyCartInterface $cart, sfGuardUser $guardUser=null)
    {
        $order = self::create();
        $order->setUser($guardUser);
        $order->setNetSum($cart->getNetSum());
        foreach ($cart->getItems() as $item)
        {
            $frozen_data = $item->getProductData();
            if (is_array($frozen_data)) {
              $frozen_data = json_encode($frozen_data);
            }
            $orderItem = tpyOrderItemTable::getInstance()->create(array(
                'count'       => $item->getCount(),
                'frozen_data' => $frozen_data,
            ));
            
            $order->getItems()->add($orderItem);
        }
        return $order;
    }
}