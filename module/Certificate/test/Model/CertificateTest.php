<?php
namespace CertificateTest\Model;

use Certificate\Model\Certificate;

class CertificateTest
{

    public function testBuildXml()
    {
        $display = new Certificate();
        
        $cert = new Certificate();
        $cert->exchangeArray(array(
            'isin' => '12345',
            'trading_market' => 'Germany',
            'currency' => 'EUR',
            'issuer' => 'Test',
            'issuing_price' => 100,
            'currentPrice' => 600
        ));
        
        $xml = '<?xml version="1.0"?>
                <Certificate>
                  <isin>12345</isin>
                  <trading_market>Germany</trading_market>
                  <currency>EUR</currency>
                  <issuer>Test</issuer>
                  <issuing_price>100</issuing_price>
                  <currentPrice>600</currentPrice>
                </Certificate>
                ';
        $result = $cert->buildXml();
        $this->assertEquals($xml, $result, $result);
    }
}
