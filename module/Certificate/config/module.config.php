<?php
namespace Certificate;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'certificate' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/certificate[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CertificateController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    'view_manager' => [
        'template_path_stack' => [
            'certificate' => __DIR__ . '/../view',
        ],
    ],
];