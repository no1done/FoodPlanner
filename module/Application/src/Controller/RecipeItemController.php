<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\ViewModel;
use Lib\ItemQuery;
use Lib\RecipeItem;
use Lib\RecipeItemQuery;
use Lib\RecipeQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use RuntimeException;
use Exception;

/**
 * Class RecipeController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class RecipeItemController extends AbstractActionController
{
    /**
     * @return array|Response|ViewModel
     */
    public function indexAction()
    {
        try {
            $recipe_id = $this->params()->fromRoute('recipe_id');

            $recipe = RecipeQuery::create()
                ->leftJoinWithRecipeItem()
                ->findPk($recipe_id);

            if (!$recipe) throw new RuntimeException(
                "Recipe does not exist"
            );

            $items = ItemQuery::create()
                ->orderByName(Criteria::ASC)
                ->findByRemoved(false);

            return [
                'recipe' => $recipe,
                'items' => $items
            ];
        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('recipe');
        }
    }

    /**
     * @return Response
     */
    public function addAction()
    {
        $post = $this->params()->fromPost();
        $recipe_id = $this->params()->fromRoute('recipe_id');

        try {

            $ing = ItemQuery::create()->findPk($post['item_id']);
            $recipe = RecipeQuery::create()->findPk($recipe_id);

            if (!$ing || !$recipe) {
                throw new RuntimeException(
                    'Item or Recipe did not exist.'
                );
            }

            $total = RecipeItemQuery::create()
                ->filterByRecipeId($recipe_id)
                ->filterByItemId($post['item_id'])
                ->count();

            if ($total > 0) {
                throw new RuntimeException(
                    'Item is already in the recipe'
                );
            }

            $recipeItem = new RecipeItem();
            $recipeItem
                ->setRecipe($recipe)
                ->setItem($ing)
                ->setQuantity($post['quantity'])
                ->save();

            $this->flashMessenger()->addSuccessMessage(
                "{$ing->getName()} added to {$recipe->getName()}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('recipe-item', [
            'recipe_id' => $recipe_id
        ]);
    }

    /**
     * @return Response
     */
    public function removeAction()
    {
        $recipe_id = $this->params()->fromRoute('recipe_id');
        $recipe_item_id = $this->params()->fromRoute('id');

        try {
            $ri = RecipeItemQuery::create()->findPk($recipe_item_id);

            if (!$ri) throw new RuntimeException(
                'Recipe item ID does not exist.'
            );

            $recipeName = $ri->getRecipe()->getName();
            $ingName = $ri->getItem()->getName();

            $ri->delete();

            $this->flashMessenger()->addSuccessMessage(
                "{$ingName} removed from {$recipeName}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('recipe-item', [
            'recipe_id' => $recipe_id
        ]);
    }
}