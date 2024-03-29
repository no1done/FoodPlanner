<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\ViewModel;
use Lib\Recipe;
use Lib\RecipeQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use RuntimeException;
use Exception;

/**
 * Class RecipeController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class RecipeController extends AbstractActionController
{
    public function indexAction()
    {
        $recipes = RecipeQuery::create()
            ->orderByName(Criteria::ASC)
            ->findByRemoved(false);

        return [
            'recipes' => $recipes
        ];
    }

    public function createAction()
    {
        return [];
    }

    public function editAction()
    {
        try {
            $id = $this->params()->fromRoute('id');

            $recipe = RecipeQuery::create()->findPk($id);

            if (!$recipe) throw new RuntimeException(
                "Recipe does not exist"
            );

            return [
                'recipe' => $recipe
            ];
        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('recipe');
        }
    }

    public function viewAction()
    {
        try {
            $id = $this->params()->fromRoute('id');

            $servings = (int) $this->params()->fromQuery('servings') ?: 1;

            $recipe = RecipeQuery::create()->findPk($id);

            if (!$recipe) throw new RuntimeException(
                "Recipe does not exist"
            );

            return [
                'recipe' => $recipe,
                'servings' => $servings
            ];
        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('recipe');
        }
    }

    /**
     * Save a recipe
     *
     * @return Response
     */
    public function saveAction()
    {
        $post = $this->params()->fromPost();

        try {

            if (isset($post['id'])) {
                $recipe = RecipeQuery::create()->findPk($post['id']);
            } else {
                $recipe = new Recipe();
            }

            $recipe->setName($post['name'])
                ->setCalories($post['calories']);

            if (isset($post['instructions'])) {
                $recipe->setInstructions($post['instructions']);
            }

            $recipe->save();

            $this->flashMessenger()->addSuccessMessage('Recipe Saved.');

            return $this->redirect()->toRoute('recipe-item', [
                'recipe_id' => $recipe->getId()
            ]);

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('recipe');
        }
    }

    public function printAction()
    {
        $id = $this->params()->fromRoute('id');

        $recipe = RecipeQuery::create()->findPk($id);

        $view = new ViewModel([
            'recipe' => $recipe
        ]);
        $view->setTerminal(true);
        return $view;
    }

    /**
     * Delete a recipe
     *
     * @return Response
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        try {

            $recipe = RecipeQuery::create()->findPk($id);

            if (!$recipe) throw new RuntimeException(
                "Recipe does not exist."
            );

            $recipe->setRemoved(true)->save();

            $undoButton = "<a href=\"/recipe/restore/{$id}\" class=\"alert-link\">Undo</a>";

            $this->flashMessenger()->addSuccessMessage(
                "Recipe Removed. {$undoButton}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('recipe');
    }

    /**
     * Restore a removed recipe
     *
     * @return Response
     */
    public function restoreAction()
    {
        $id = $this->params()->fromRoute('id');

        try {

            $recipe = RecipeQuery::create()->findPk($id);

            if (!$recipe) throw new RuntimeException(
                "Recipe does not exist."
            );

            $recipe->setRemoved(false)->save();

            $this->flashMessenger()->addSuccessMessage(
                "Recipe Restored."
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('recipe');
    }
}