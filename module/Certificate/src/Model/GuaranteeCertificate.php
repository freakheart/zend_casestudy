<?php
/**
 * Model Class for Guarantee Certificate
 * @author subash.koutilya
 */
namespace Certificate\Model;

class GuaranteeCertificate extends Certificate
{

    /** @var float| Should contain the participation rate of a certificate */
    public $participation_rate;

    public function setParticipationRate($participation_rate)
    {
        $this->participation_rate = $participation_rate;
    }
    
    /**
     * Raises exception because Guarantee Certificate cannot be displayed as XML
     * {@inheritDoc}
     * @see \Certificate\Model\Certificate::buildXml()
     */
    public function buildXml()
    {
        throw new \Exception('Guarantee Certificate cannot be displayed as XML');
    }
}