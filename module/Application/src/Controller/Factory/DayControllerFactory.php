<?php

namespace Application\Controller\Factory;

use Application\Service\ListService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

/**
 * Class DayControllerFactory
 * @package Application\Controller\Factory
 */
class DayControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var $dayService */
        $dayService = $container->get('Application\Service\DayService');

        /** @var ListService $listService */
        $listService = $container->get('Application\Service\ListService');

        // Renderer
        $renderer = $container->get('Laminas\View\Renderer\PhpRenderer');

        return new $requestedName($dayService, $listService, $renderer);
    }

}