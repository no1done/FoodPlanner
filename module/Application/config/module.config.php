<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'list' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/list[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\ListController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'recipe' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/recipe[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\RecipeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'item' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/item[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\ItemController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            // Join Management Controller Routes
            'list-recipe' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/list/:list_id/recipes[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\ListRecipeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'recipe-item' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/recipe/:recipe_id/items[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\RecipeItemController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            // Static AJAX route for removing item
            'list-item-remove' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/shopping/item/remove',
                    'defaults' => [
                        'controller' => Controller\ListItemController::class,
                        'action'     => 'remove',
                    ],
                ],
            ],

            'list-item-check' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/shopping/item/checked',
                    'defaults' => [
                        'controller' => Controller\ListItemController::class,
                        'action'     => 'check',
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\ListController::class => Controller\Factory\ListRecipeControllerFactory::class,
            Controller\RecipeController::class => InvokableFactory::class,
            Controller\ItemController::class => InvokableFactory::class,

            // Management controllers
            Controller\ListRecipeController::class => Controller\Factory\ListRecipeControllerFactory::class,
            Controller\RecipeItemController::class => InvokableFactory::class,
            Controller\ListItemController::class => Controller\Factory\ListRecipeControllerFactory::class
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'shopping/list'           => __DIR__ . '/../view/application/list/partial/shopping-list.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ],
    ],
];
