<?php
/**
 * Model Class for Documents of the Certificate
 * @author subash.koutilya
 */
namespace Certificate\Model;

use Zend\Db\ResultSet\ResultSet;

class Document extends ResultSet
{
    /** @var string| Should contain the document type of the certificate */
    public $document_type;
    
    /** @var string| Should contain the document name of the certificate */
    public $document_name;
    
    /**
     * Returns the document type of the certificate
     * @return string
     */
    public function getDocumentType()
    {
        return $this->document_type;
    }
    
    /**
     * Retuens the document name of the certificate
     * @return string
     */
    public function getDocumentName()
    {
        return $this->document_name;
    }
}
