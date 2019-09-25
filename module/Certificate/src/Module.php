<?php
namespace Certificate;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\CertificateTable::class => function ($container) {
                    $certificateTableGateway = $container->get('CertificateTableGateway');
                    return new \Certificate\Model\CertificateTable($certificateTableGateway);
                },
                'CertificateTableGateway' => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Certificate());
                    return new TableGateway('certificate', $dbAdapter, null, $resultSetPrototype);
                }
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\CertificateController::class => function ($container) {
                    return new Controller\CertificateController($container->get(\Certificate\Model\CertificateTable::class));
                }
            ]
        ];
    }
}