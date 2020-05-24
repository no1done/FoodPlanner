<?php

declare(strict_types=1);

namespace Application\Controller;

use Exception;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\ViewModel;
use Lib\Ingredient;
use Lib\IngredientQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use RuntimeException;

/**
 * Class IngredientController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class IngredientController extends AbstractActionController
{
    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $ing = IngredientQuery::create()
            ->orderByName(Criteria::ASC)
            ->findByRemoved(false);

        return [
            'ingredients' => $ing
        ];
    }

    /**
     * Show form for creating ingredient
     *
     * @return array
     */
    public function createAction()
    {
        return [];
    }

    /**
     * @return array
     */
    public function editAction()
    {
        return [];
    }

    /**
     * @return Response
     */
    public function saveAction()
    {
        $post = $this->params()->fromPost();

        try {

            if (isset($post['id'])) {
                $ingredient = IngredientQuery::create()->findPk($post['id']);
            } else {
                $ingredient = new Ingredient();
            }

            $ingredient->setName($post['name'])
                ->setUnit($post['unit'])
                ->save();

            $this->flashMessenger()->addSuccessMessage('Item Saved.');

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('ingredient');
    }

    /**
     * Delete a list
     *
     * @return Response
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        try {

            $list = IngredientQuery::create()->findPk($id);

            if (!$list) throw new RuntimeException(
                "Item does not exist."
            );

            $list->setRemoved(true)->save();

            $undoButton = "<a href=\"/ingredient/restore/{$id}\" class=\"alert-link\">Undo</a>";

            $this->flashMessenger()->addSuccessMessage(
                "Item Removed. {$undoButton}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('ingredient');
    }

    /**
     * Restore a removed list
     *
     * @return Response
     */
    public function restoreAction()
    {
        $id = $this->params()->fromRoute('id');

        try {

            $list = IngredientQuery::create()->findPk($id);

            if (!$list) throw new RuntimeException(
                "Item does not exist."
            );

            $list->setRemoved(false)->save();

            $this->flashMessenger()->addSuccessMessage(
                "Item Restored."
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('ingredient');
    }
}