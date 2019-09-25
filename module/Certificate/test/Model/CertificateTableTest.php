<?php
namespace CertificateTest\Model;

use Certificate\Model\Certificate;
use Certificate\Model\CertificateTable;
use RuntimeException;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGatewayInterface;

class CertificateTableTest 
{

    protected function setUp()
    {
        $this->tableGateway = $this->prophesize(TableGatewayInterface::class);
        $this->adapter = $this->prophesize($this->tableGateway->getAdapter());
        $this->certificateTable = new CertificateTable($this->tableGateway->reveal());
    }

    public function testFetchAllReturnsAllCertificates()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class)->reveal();
        $this->tableGateway->select()->willReturn($resultSet);
        
        $this->assertSame($resultSet, $this->albumTable->fetchAll());
    }

    public function testExceptionIsThrownWhenGettingNonExistentCertificate()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn(null);
        
        $this->tableGateway->select([
            'certificate_id' => 123
        ])->willReturn($resultSet->reveal());
        
        $this->setExpectedException(RuntimeException::class, 'Could not find row with id 123');
        $this->certificateTable->getData('certificate', 123);
    }
}