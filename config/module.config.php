<?php
/**
 * module.config.php - Worktime Config
 *
 * Main Config File for Worktime Module
 *
 * @category Config
 * @package Worktime
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Worktime;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Worktime Module - Routes
    'router' => [
        'routes' => [
            # Module Basic Route
            'worktime' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/worktime[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\WorktimeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'worktime-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/worktime/api[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'worktime' => __DIR__ . '/../view',
        ],
    ],
];
