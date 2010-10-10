<?php

/**
 * PlugintpyTaxClass
 * 
 * @package    timpany
 * @author     Timpany Core Team <lsdug@googlegroups.com>
 */
abstract class PlugintpyTaxClass extends BasetpyTaxClass
{
  /**
   * get tax rate for region
   * 
   * @param string $region
   * 
   * @return float Tax rate
   */
  public function getTaxRate($region='de')
  {
    return $this->getTaxPercent($region) / 100.0;
  }
  
  /**
   * get tax percent for region
   * 
   * @param string $region
   * 
   * @return float Tax
   */
  public function getTaxPercent($region='de')
  {
    /** @var PlugintpyTax $first **/
    $first = tpyTaxTable::getInstance()->retrieveByIdAndRegion($this->id, $region)->getFirst();
    return ($first !== null) ? $first->getTaxPercent() : 0;
  }
}