<?php
/**
 * Model Class for Bonus Certificate
 * @author subash.koutilya
 */
namespace Certificate\Model;

class BonusCertificate extends Certificate
{

    /** @var string| Should contain the barrier level of a certificate */
    public $barrier_level;

    /** @var string| Should contain the value yes or no */
    public $barrier_hit;

    /**
     * Set the variable $barrier_level
     * 
     * @param Float $barrier_level            
     */
    public function setBarrierLevel($barrier_level)
    {
        $this->barrier_level = $barrier_level;
    }

    /**
     * Set the variable $barrier_hit
     */
    public function setBarrierHit()
    {
        $this->barrier_hit = $this->isBarrierHit() ? 'Yes' : 'No';
    }

    /**
     * If current_price is greater than barrier_level then it returns true else returns false
     * 
     * @return boolean
     */
    public function isBarrierHit()
    {
        return $this->current_price >= $this->barrier_level;
    }
}