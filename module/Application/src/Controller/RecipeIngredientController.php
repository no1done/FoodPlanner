<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Lib\IngredientQuery;
use Lib\Recipe;
use Lib\RecipeIngredient;
use Lib\RecipeIngredientQuery;
use Lib\RecipeQuery;
use RuntimeException;
use Exception;

/**
 * Class RecipeController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class RecipeIngredientController extends AbstractActionController
{
    public function indexAction()
    {
        try {
            $recipe_id = $this->params()->fromRoute('recipe_id');

            $recipe = RecipeQuery::create()
                ->leftJoinWithRecipeIngredient()
                ->findPk($recipe_id);

            if (!$recipe) throw new RuntimeException(
                "Recipe does not exist"
            );

            $ingredients = IngredientQuery::create()->findByRemoved(false);

            return [
                'recipe' => $recipe,
                'ingredients' => $ingredients
            ];
        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('recipe');
        }
    }

    public function addAction()
    {
        $post = $this->params()->fromPost();
        $recipe_id = $this->params()->fromRoute('recipe_id');

        try {

            $ing = IngredientQuery::create()->findPk($post['ingredient_id']);
            $recipe = RecipeQuery::create()->findPk($recipe_id);

            if (!$ing || !$recipe) {
                throw new RuntimeException(
                    'Ingredient or Recipe did not exist.'
                );
            }

            $total = RecipeIngredientQuery::create()
                ->filterByRecipeId($recipe_id)
                ->filterByIngredientId($post['ingredient_id'])
                ->count();

            if ($total > 0) {
                throw new RuntimeException(
                    'Ingredient is already in the recipe'
                );
            }

            $recipeIngredient = new RecipeIngredient();
            $recipeIngredient
                ->setRecipe($recipe)
                ->setIngredient($ing)
                ->setQuantity($post['quantity'])
                ->save();

            $this->flashMessenger()->addSuccessMessage(
                "{$ing->getName()} added to {$recipe->getName()}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('recipe-ingredient', [
            'recipe_id' => $recipe_id
        ]);
    }

    public function removeAction()
    {
        $recipe_id = $this->params()->fromRoute('recipe_id');
        $recipe_ingredient_id = $this->params()->fromRoute('id');

        try {
            $ri = RecipeIngredientQuery::create()->findPk($recipe_ingredient_id);

            if (!$ri) throw new RuntimeException(
                'Recipe ingredient ID does not exist.'
            );

            $recipeName = $ri->getRecipe()->getName();
            $ingName = $ri->getIngredient()->getName();

            $ri->delete();

            $this->flashMessenger()->addSuccessMessage(
                "{$ingName} removed from {$recipeName}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('recipe-ingredient', [
            'recipe_id' => $recipe_id
        ]);
    }
}