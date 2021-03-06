<?php

/**
 * PlugintpyProductTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PlugintpyProductTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PlugintpyProductTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PlugintpyProduct');
    }
    
    /**
     * get product object of class depending on object properties itself
     * 
     * @see vendor/doctrine/Doctrine/Doctrine_Table::getRecord()
     * 
     * @return tpyProduct
     */
    public function getRecord()
    {
        $basic_product = parent::getRecord();
        if (
            0 == strlen($basic_product->getClassName())
            or $basic_product->getClassName() == get_class($basic_product)
        ) {
            return $basic_product;
        }
        $class_name = $basic_product->getClassName();
        $special_product = new $class_name($this, false);
        $special_product->setDoctrineRecord($basic_product);
        return $special_product;
    }
}