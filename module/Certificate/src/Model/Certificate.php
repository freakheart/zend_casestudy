<?php
/**
 * Model class for Certificate.
 * @author subash.koutilya
 */
namespace Certificate\Model;

use Zend\Db\ResultSet\ResultSet;

class Certificate
{

    /** @var int| Should contain the certificate ID */
    public $certificate_id;

    /** @var string| Should contain the ISIN of a certificate */
    public $isin;

    /** @var string| Should contain the Trading Market of a certificate */
    public $trading_market;

    /** @var string| Should contain the Currency of a certificate */
    public $currency;

    /** @var string| Should contain the Issuer of a certificate */
    public $issuer;

    /** @var float| Should contain the Price of certificate Issuing */
    public $issuing_price;
    
    /** @var float| Should contain the Current Price of a certificate */
    public $current_price;

    /** @var string| Should contain the Certificate Type */
    public $certificate_type;

    /** @var ResultSet Object| Should contain the History of certificate */
    public $history;

    /** @var ResultSet Object| Should contain all Documents of a certificate */
    public $documents;

    /**
     * Set all class properties
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
    
    /**
     * Set all class properties
     * @param ResultSetObject $data
     */
    public function setFields($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Set all documents of a Certificate
     * @param ResultSetObject $documents
     */
    public function setDocuments(ResultSet $documents)
    {
        $this->documents = $documents;
    }

    /**
     * Returns documents Object
     * @return ResultSetObject
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Set price history for a Certificate
     * @param ResultSetObject $history
     */
    public function setHistory(ResultSet $history)
    {
        $this->history = $history;
    }

    /**
     * Returns history Object
     * @param ResultSetObject $history
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Builds xml for a Certificate.
     * @return xml as a string
     */
    public function buildXml()
    {
        $dom = new \DOMDocument();
        $dom->formatOutput = true;
        
        $dom->appendChild($dom->createElement('Certificate'));
        $node = simplexml_import_dom($dom);
        foreach ($this as $field => $value) {
            if (!is_object($value)) {
                $node->addChild($field, $value);
            }
        }
       
        if (! empty($this->documents)) {
            $documents = $node->addChild('documents');
            foreach ($this->documents as $document) {
                $doc = $documents->addChild('document');
                $doc->addChild('document_name', $document->document_name);
                $doc->addChild('document_type', $document->document_type);
            }
        }
        
        if (! empty($this->history)) {
            $prices = $node->addChild('prices');
            foreach ($this->history as $price) {
                $doc = $prices->addChild('price');
                $doc->addChild('creation_date', date('d-m-y h:i:s', $price->creation_date));
                $doc->addChild('price', $price->price);
            }
        }
        return $dom->saveXML();
    }
}