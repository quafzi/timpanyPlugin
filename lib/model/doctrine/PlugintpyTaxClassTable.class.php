<?php

/**
 * PlugintpyTaxClassTable
 * 
 * @package    timpany
 * @author     Timpany Core Team <lsdug@googlegroups.com>
 */
class PlugintpyTaxClassTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PlugintpyTaxClassTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PlugintpyTaxClass');
    }
}