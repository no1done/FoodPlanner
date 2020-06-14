<?php

namespace Application\Controller;

use Application\Service\DayService;
use Application\Service\ListService;
use Exception;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Lib\CategoryQuery;
use Lib\DayPlan;
use Lib\DayPlanQuery;
use Lib\DayPlanRecipeQuery;
use Lib\ListRecipeQuery;
use Lib\RecipeQuery;
use Lib\ShoppingListQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use RuntimeException;

/**
 * Class DayController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class DayController extends AbstractActionController {

    /** @var DayService */
    protected DayService $dayService;

    /** @var ListService */
    protected ListService $listService;

    /**
     * DayController constructor.
     * @param DayService $dayService
     * @param ListService $listService
     */
    public function __construct(
        DayService $dayService,
        ListService $listService
    ) {
        $this->dayService = $dayService;
        $this->listService = $listService;
    }

    /**
     * Show the days planned for a list
     *
     * @return array|Response|ViewModel
     */
    public function indexAction()
    {
        try {
            $list_id = $this->params()->fromRoute('list_id');

            $list = ShoppingListQuery::create()->findPk($list_id);

            if (!$list) throw new RuntimeException(
                'List does not exist'
            );

            $days = DayPlanQuery::create()
                ->filterByShoppingList($list)
                ->find();

            return [
                'list' => $list,
                'days' => $days,
                'daysPlanQuery' => DayPlanRecipeQuery::create(),
                'shoppingList' => $this->listService->getShopList($list)
            ];

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('home');
        }
    }

    /**
     * Add a day to planner
     *
     * @return Response
     */
    public function addAction()
    {
        $list_id = $this->params()->fromRoute('list_id');

        try {
            $dayPlan = new DayPlan();
            $dayPlan->setShoppingListId($list_id)->save();

            $this->flashMessenger()->addSuccessMessage('Day Added.');

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('planner', [
            'list_id' => $list_id
        ]);
    }

    /**
     * Delete a day
     */
    public function removeAction()
    {
        $list_id = $this->params()->fromRoute('list_id');

        try {

            if (!$this->getRequest()->isPost()) throw new RuntimeException(
                "Invalid request."
            );

            $day_plan_id = (int) $this->params()->fromPost('rm_day_plan_id');

            $dayPlan = DayPlanQuery::create()->findPk($day_plan_id);

            foreach ($dayPlan->getDayPlanRecipes() as $planRecipe) {

                // Remove planner entry
                $recipe_id = $this->dayService->removeMealFromPlan(
                    $planRecipe->getId()
                );

                // Find ListRecipe table entry and remove it
                $listRecipe = ListRecipeQuery::create()
                    ->filterByShoppingListId($list_id)
                    ->filterByRecipeId($recipe_id)
                    ->filterByRef(null, Criteria::ISNOTNULL)
                    ->findOne();

                $this->listService->removeRecipe($listRecipe->getId());
            }

            // Remove day
            $dayPlan->delete();

            $this->flashMessenger()->addSuccessMessage('Day removed.');

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('planner', [
            'list_id' => $list_id
        ]);
    }

    /**
     * Add Recipe
     *
     * @return Response
     */
    public function addRecipeAction()
    {
        $list_id = $this->params()->fromRoute('list_id');

        try {

            if (!$this->getRequest()->isPost()) throw new RuntimeException(
                'Invalid request.'
            );

            $categoryId = (int) $this->params()->fromPost('category_id');
            $recipeId = (int) $this->params()->fromPost('recipe_id');
            $dayPlanId = (int) $this->params()->fromPost('day_plan_id');
            $servings = (int) $this->params()->fromPost('servings');

            $list = ShoppingListQuery::create()->findPk($list_id);
            $recipe = RecipeQuery::create()->findPk($recipeId);

            if (!$list || !$recipe) throw new RuntimeException(
                'List or Recipe unavailable.'
            );

            // Add to planner..
            $this->dayService->addMealToPlan(
                $recipeId,
                $categoryId,
                $dayPlanId,
                $servings
            );

            // Add to shopping list.
            $this->listService->addToList(
                $list,
                $recipe,
                $servings
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage(
                "{$e->getMessage()}: <br>{$e->getPrevious()}" .
                "<br><br>{$e->getTraceAsString()}"
            );
        }

        return $this->redirect()->toRoute('planner', [
            'list_id' => $list_id
        ]);
    }

    /**
     * POST method catch to remove recipe
     *
     * @return Response
     */
    public function removeRecipeAction()
    {
        $list_id = $this->params()->fromRoute('list_id');

        try {
            if (!$this->getRequest()->isPost()) throw new RuntimeException(
                "Invalid request."
            );

            // Day plan recipe ID we want to delete.
            $dayPlanRecipeId = $this->params()->fromPost('rm_recipe_id');

            // Remove planner entry
            $recipe_id = $this->dayService->removeMealFromPlan($dayPlanRecipeId);

            // Find ListRecipe table entry and remove it
            $listRecipe = ListRecipeQuery::create()
                ->filterByShoppingListId($list_id)
                ->filterByRecipeId($recipe_id)
                ->filterByRef(null, Criteria::ISNOTNULL)
                ->findOne();

            $this->listService->removeRecipe($listRecipe->getId());

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('planner', [
            'list_id' => $list_id
        ]);
    }
}