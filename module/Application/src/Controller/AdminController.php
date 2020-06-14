<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Lib\DayPlanQuery;
use Lib\DayPlanRecipeQuery;
use Lib\ListRecipeQuery;

/**
 * Class AdminController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class AdminController extends AbstractActionController {

    public function indexAction()
    {
        return [];
    }

    public function resetAllCompletedAction()
    {
        try {
            // Reset days
            DayPlanQuery::create()
                ->update(['Complete' => false]);

            ListRecipeQuery::create()
                ->update(['Complete' => false]);

            DayPlanRecipeQuery::create()
                ->update(['Complete' => false]);

            $this->flashMessenger()->addSuccessMessage("All recipes reset.");

        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('admin');
    }

}