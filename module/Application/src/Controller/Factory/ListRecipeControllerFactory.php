<?php

namespace Application\Controller\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Class ListRecipeControllerFactory
 * @package Application\Controller\Factory
 */
class ListRecipeControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var $listService */
        $listService = $container->get('Application\Service\ListService');

        return new $requestedName($listService);
    }

}