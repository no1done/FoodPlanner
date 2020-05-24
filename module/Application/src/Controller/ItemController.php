<?php

declare(strict_types=1);

namespace Application\Controller;

use Exception;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\ViewModel;
use Lib\ItemQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use RuntimeException;

/**
 * Class ItemController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class ItemController extends AbstractActionController
{
    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $items = ItemQuery::create()
            ->orderByName(Criteria::ASC)
            ->findByRemoved(false);

        return [
            'items' => $items
        ];
    }

    /**
     * Show form for creating item
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
                $item = ItemQuery::create()->findPk($post['id']);
            } else {
                $item = new Item();
            }

            $item->setName($post['name'])
                ->setUnit($post['unit'])
                ->save();

            $this->flashMessenger()->addSuccessMessage('Item Saved.');

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('item');
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

            $list = ItemQuery::create()->findPk($id);

            if (!$list) throw new RuntimeException(
                "Item does not exist."
            );

            $list->setRemoved(true)->save();

            $undoButton = "<a href=\"/item/restore/{$id}\" class=\"alert-link\">Undo</a>";

            $this->flashMessenger()->addSuccessMessage(
                "Item Removed. {$undoButton}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('item');
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

            $list = ItemQuery::create()->findPk($id);

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

        return $this->redirect()->toRoute('item');
    }
}