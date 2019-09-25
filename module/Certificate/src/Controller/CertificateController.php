<?php
/**
 * CertificateControllerClass that handles all actions and corresponding views.
 * @author subash.koutilya
 */
namespace Certificate\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Certificate;
use Zend\Config\Reader\Xml;
use Certificate\Model\CertificateTable;

class CertificateController extends AbstractActionController
{

    /** @var Object| Should contain the CertificateTable object */
    private $table;

    /**
     *
     * @param CertificateTable $table            
     */
    public function __construct(CertificateTable $table)
    {
        $this->table = $table;
    }

    /**
     * Default Index Action handler, Shows all certificates
     * 
     * {@inheritdoc}
     *
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        return new ViewModel([
            'certificates' => $this->table->fetchAll()
        ]);
    }

    /**
     * HTML action handler, Shows details of a certificate in HTML
     * 
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function getHtmlAction()
    {
        $certificate_id = (int) $this->params()->fromRoute('id', 0);
        
        if (0 === $certificate_id) {
            return $this->redirect()->toRoute('certificate');
        }
        $certificate = $this->actionHelper($certificate_id);
        
        return new ViewModel([
            'certificate' => $certificate
        ]);
    }

    /**
     * XML action handler, shows details of a certificate in XML
     * 
     * @return Xml
     */
    public function getXmlAction()
    {
        $certificate_id = (int) $this->params()->fromRoute('id', 0);
        
        if (0 === $certificate_id) {
            return $this->redirect()->toRoute('certificate');
        }
        $certificate = $this->actionHelper($certificate_id);
        $xml = $certificate->buildXml($certificate);
        $this->response->getHeaders()->addHeaderLine('Content-type', 'application/xml');
        return $this->response->setContent($xml);
    }

    /**
     * Sets all required fields based on the certificate type
     * 
     * @param int $certificate_id            
     * @return \Certificate\Model\Certificate|\Certificate\Model\BonusCertificate|\Certificate\Model\GuaranteeCertificate
     */
    public function actionHelper($certificate_id)
    {
        $certificate_data = $this->table->getData('certificate', $certificate_id)->current();
        $documents = $this->table->getData('document', $certificate_id);
        $history = $this->table->getData('history', $certificate_id);
        
        switch ($certificate_data->certificate_type)
        {
            //Standard Certificate
            case 'StandardCertificate':
                $certificate = new \Certificate\Model\Certificate();
                $certificate->setFields($certificate_data);
                $certificate->setDocuments($documents);
                $certificate->setHistory($history);
                return $certificate;
            
            //Bonus Certificate
            case 'BonusCertificate':
                $certificate = new \Certificate\Model\BonusCertificate();
                $bonus_certificate = $this->table->getData('bonus_certificate', $certificate_id)->current();
                $certificate->setFields($certificate_data);
                $certificate->setBarrierLevel($bonus_certificate->barrier_level);
                $certificate->setBarrierHit();
                $certificate->setDocuments($documents);
                $certificate->setHistory($history);
                return $certificate;
            
            // Guarantee Certificate
            case 'GuaranteeCertificate':
                $certificate = new \Certificate\Model\GuaranteeCertificate();
                $guarantee_certificate = $this->table->getData('guarantee_certificate', $certificate_id)->current();
                $certificate->setFields($certificate_data);
                $certificate->setParticipationRate($guarantee_certificate->participation_rate);
                $certificate->setDocuments($documents);
                $certificate->setHistory($history);
                return $certificate;
            
            //Invalid Certificate
            default:
                throw new \Exception('Invalid Certificate type found in data.');
            break;
        }
    }
}