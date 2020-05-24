<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Service\ListService;
use Exception;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\ViewModel;
use Lib\ShoppingList;
use Lib\ShoppingListQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use RuntimeException;

/**
 * Class ListController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class ListController extends AbstractActionController
{
    /** @var ListService */
    protected ListService $listService;

    /**
     * ListController constructor.
     * @param ListService $listService
     */
    public function __construct(ListService $listService)
    {
        $this->listService = $listService;
    }

    /**
     * List all shopping lists
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $lists = ShoppingListQuery::create()
            ->orderById(Criteria::DESC)
            ->findByRemoved(false);

        return [
            'lists' => $lists
        ];
    }

    /**
     * View a list
     * @return array|Response
     */
    public function viewAction()
    {
        try {
            $id = $this->params()->fromRoute('id');

            $list = ShoppingListQuery::create()->findPk($id);

            if (!$list) throw new RuntimeException("List does not exist");

            return [
                'list' => ShoppingListQuery::create()->findPk($id),
                'shoppingList' => $this->listService->getShopList($list)
            ];
        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('list');
        }
    }

    /**
     * Display a form for creating a list
     *
     * @return array
     */
    public function createAction()
    {
        return [];
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');

        return [];
    }

    /**
     * Save a list
     *
     * @return Response
     */
    public function saveAction()
    {
        $post = $this->params()->fromPost();

        try {

            if (isset($post['id'])) {
                $list = ShoppingListQuery::create()->findPk($post['id']);
            } else {
                $list = new ShoppingList();
            }

            $list->setName($post['name'])
                ->save();

            $this->flashMessenger()->addSuccessMessage('List Saved.');

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('list');
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

            $list = ShoppingListQuery::create()->findPk($id);

            if (!$list) throw new RuntimeException(
                "List does not exist."
            );

            $list->setRemoved(true)->save();

            $undoButton = "<a href=\"/list/restore/{$id}\" class=\"alert-link\">Undo</a>";

            $this->flashMessenger()->addSuccessMessage(
                "List Removed. {$undoButton}"
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('list');
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

            $list = ShoppingListQuery::create()->findPk($id);

            if (!$list) throw new RuntimeException(
                "List does not exist."
            );

            $list->setRemoved(false)->save();

            $this->flashMessenger()->addSuccessMessage(
                "List Restored."
            );

        } catch (Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return $this->redirect()->toRoute('list');
    }
}