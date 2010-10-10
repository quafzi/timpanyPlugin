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

    /**
     * return tax by class id and region
     * @param int $taxClassId
     * @param string $region
     * @return Doctine_Collection
     */
    public function retrieveByIdAndRegion($taxClassId, $region) {
      $taxClassId = intval($taxClassId);

      return $this->createQuery()->where("tax_class_id = ? AND region = ?", array($taxClassId, $region))->execute();
    }
}