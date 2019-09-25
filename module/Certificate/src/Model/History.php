<?php
/**
 * Model Class for History of the Certificate
 * @author subash.koutilya
 */
namespace Certificate\Model;

use Zend\Db\ResultSet\ResultSet;

class History extends ResultSet
{
    /** @var float| Should contain the current price of the certificate */
    public $price;
    
    /** @var timestamp| Should contain the creation date of the certificate */
    public $creation_date;
    
    /**
     * Returns the current_price of the Certificate
     * @return float
     */
    public function getCurrentPrice()
    {
        return (float)$this->price;
    }
    
    /**
     * Returns the creation date of the certificate
     * @return timestamp
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }
}
