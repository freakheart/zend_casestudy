<?php
namespace CertificateTest\Controller;

use Certificate\Controller\CertificateController;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Certificate\Model\Certificate;

class CertificateControllerTest extends AbstractHttpControllerTestCase
{

    protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/certificate');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Certificate');
        $this->assertControllerName(CertificateController::class);
        $this->assertControllerClass('CertificateController');
        $this->assertMatchedRouteName('certificate');
    }
}