<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Service\ListService;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\ViewModel;
use Lib\ListRecipe;
use Lib\ListRecipeQuery;
use Lib\Recipe;
use Lib\RecipeQuery;
use Lib\ShoppingListQuery;
use RuntimeException;
use Exception;

/**
 * Class RecipeController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class ListRecipeController extends AbstractActionController
{
    /** @var ListService */
    protected ListService $listService;

    /**
     * ListRecipeController constructor.
     * @param ListService $listService
     */
    public function __construct(ListService $listService)
    {
        $this->listService = $listService;
    }

    /**
     * Show edit page for lists recipes
     *
     * @return array|Response|ViewModel
     */
    public function indexAction()
    {
        try {
            $list_id = $this->params()->fromRoute('list_id');

            $list = ShoppingListQuery::create()
                ->leftJoinWithListRecipe()
                ->findPk($list_id);

            if (!$list) throw new RuntimeException(
                "Shopping list does not exist"
            );

            $recipes = RecipeQuery::create()->findByRemoved(false);

            return [
                'list' => $list,
                'recipes' => $recipes,
                'shoppingList' => $this->listService->getShopList($list)
            ];

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('list');
        }
    }

    public function addAction()
    {
        $list_id = $this->params()->fromRoute('list_id');

        try {

            if (!$this->getRequest()->isPost()) throw new RuntimeException(
                'Invalid Request'
            );

            $post = $this->params()->fromPost();

            $recipe = RecipeQuery::create()->findPk($post['recipe_id']);
            $list = ShoppingListQuery::create()->findPk($list_id);

            $this->listService->addToList(
                $list,
                $recipe,
                (int) $post['servings']
            );

            $this->flashMessenger()->addSuccessMessage(
                "{$recipe->getName()} added to {$list->getName()}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('list-recipe', [
            'list_id' => $list_id
        ]);
    }

    public function removeAction()
    {
        $list_id = (int) $this->params()->fromRoute('list_id');
        $list_recipe_id = (int) $this->params()->fromRoute('id');

        try {

            $info = $this->listService->removeRecipe($list_recipe_id);

            $this->flashMessenger()->addSuccessMessage(
                "{$info['recipe']} removed from {$info['list']}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('list-recipe', [
            'list_id' => $list_id
        ]);
    }
}