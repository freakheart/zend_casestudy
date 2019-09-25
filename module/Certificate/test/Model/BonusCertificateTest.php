<?php
namespace CertificateTest\Model;

use Certificate\Model\BonusCertificate;

class BonusCertificateTest
{
    public function testCertificateHitsBarrier()
    {
        $cert = new BonusCertificate(array(
            'current_price' => 150.02,
            'barrier_level' => 75.15
        ));
        
        $this->assertEquals(true, $cert->isBarrierHit());
    }
    
    public function testCertificateHitsBarrierNot()
    {
        $cert = new BonusCertificate(array(
            'barrier_level' => 11.05,
            'current_price' => 11.02
        ));
        
        $this->assertEquals(false, $cert->isBarrierHit());
    }
}
