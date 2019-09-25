<?php
/**
 * Class that handles all database queries
 * @author subash.koutilya
 */
namespace Certificate\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class CertificateTable
{

    /** @var Object|Should contain the TableGateway object */
    private $tableGateway;

    /** @var Object|Should contain the Adapter object */
    private $adapter;

    /**
     * Set tablegateway and adapter
     * 
     * @param TableGateway $certificateGateway            
     */
    public function __construct(TableGateway $certificateGateway)
    {
        $this->tableGateway = $certificateGateway;
        $this->adapter = $this->tableGateway->getAdapter();
    }

    /**
     * Executes a sql statement and returns a ResultSet
     * 
     * @param string $table            
     * @param int $certificate_id            
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getData($table, $certificate_id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($table);
        $select->where([
            'certificate_id' => $certificate_id
        ]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $sql_result = $statement->execute();
        $results = new ResultSet();
        return $results->initialize($sql_result);
    }

    /**
     * Gets all the certificates present in the database
     * 
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        $sql = "SELECT
        c.certificate_id,
        c.isin,
        c.trading_market,
        c.currency,
        c.issuer,
        c.issuing_price,
        c.certificate_type,
        h.price,
        h.creation_date,
        bc.barrier_level,
        gc.participation_rate
        FROM
        history h
        LEFT JOIN certificate c ON (h.certificate_id = c.certificate_id)
        INNER JOIN history h2 ON (h.certificate_id = h2.certificate_id)
        LEFT JOIN bonus_certificate bc ON (c.certificate_id = bc.certificate_id)
        LEFT JOIN guarantee_certificate gc ON (c.certificate_id = gc.certificate_id)
        WHERE
        h.creation_date = h2.creation_date
        GROUP BY c.certificate_id";
        
        $sql_result = $this->adapter->createStatement($sql)->execute();
        $results = new ResultSet();
        return $results->initialize($sql_result);
    }
}