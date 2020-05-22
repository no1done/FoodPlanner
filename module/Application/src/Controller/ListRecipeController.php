<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
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
                'recipes' => $recipes
            ];

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('list');
        }
    }

    public function addAction()
    {
        $post = $this->params()->fromPost();
        $list_id = $this->params()->fromRoute('list_id');

        try {
            $recipe = RecipeQuery::create()->findPk($post['recipe_id']);
            $list = ShoppingListQuery::create()->findPk($list_id);

            $total = ListRecipeQuery::create()
                ->filterByShoppingListId($list_id)
                ->filterByRecipeId($post['recipe_id'])
                ->count();

            if ($total > 0) {
                throw new RuntimeException(
                    'Recipe is already in the list'
                );
            }

            $listRecipe = new ListRecipe();
            $listRecipe->setShoppingList($list)
                ->setRecipe($recipe)
                ->setServes($post['servings'])
                ->save();

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
        $list_id = $this->params()->fromRoute('list_id');
        $list_recipe_id = $this->params()->fromRoute('id');

        try {

            $lr = ListRecipeQuery::create()->findPk($list_recipe_id);

            if (!$lr) throw new RuntimeException(
                'List Recipe ID does not exist.'
            );

            $recipeName = $lr->getRecipe()->getName();
            $listName = $lr->getShoppingList()->getName();

            $lr->delete();

            $this->flashMessenger()->addSuccessMessage(
                "{$recipeName} removed from {$listName}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('list-recipe', [
            'list_id' => $list_id
        ]);
    }
}