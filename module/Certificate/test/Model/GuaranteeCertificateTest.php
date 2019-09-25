<?php
namespace CertificateTest\Model;

use Certificate\Model\GuaranteeCertificate;

class GuaranteeCertificateTest
{
    /**
     * Should throw an Exception since GuaranteeCertificate cannot be exported as xml
     */
    public function testShouldThrowExceptionWhenExportedToXml()
    {
        $cert = new GuaranteeCertificate();
        $cert->buildXml();
    }
}
