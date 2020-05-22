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
            'ingredient' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/ingredient[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\IngredientController::class,
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

            'recipe-ingredient' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/recipe/:recipe_id/ingredients[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\RecipeIngredientController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\ListController::class => InvokableFactory::class,
            Controller\RecipeController::class => InvokableFactory::class,
            Controller\IngredientController::class => InvokableFactory::class,

            // Management controllers
            Controller\ListRecipeController::class => InvokableFactory::class,
            Controller\RecipeIngredientController::class => InvokableFactory::class,
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
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
