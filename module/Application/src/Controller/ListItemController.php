<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Service\ListService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Laminas\View\Model\JsonModel;
use Exception;

/**
 * Class RecipeController
 * @method FlashMessenger flashMessenger()
 * @package Application\Controller
 */
class ListItemController extends AbstractActionController
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
     * Remove a shopping list item
     *
     * AJAX route only
     *
     * @return JsonModel
     */
    public function removeAction()
    {
        try {

            $item_id = (int) $this->params()->fromPost('itemId');
            $list_id = (int) $this->params()->fromPost('listId');

            $this->listService->removeItemFromList($item_id, $list_id);

            return new JsonModel([
                'status' => 'ok',
                'message' => 'Item removed'
            ]);

        } catch (Exception $e) {

            return new JsonModel([
                'status' => 'error',
                'message' => 'failed to remove item: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX route for marking items as checked
     *
     * @return JsonModel
     */
    public function checkAction()
    {
        try {

            $item_id = (int) $this->params()->fromPost('itemId');
            $list_id = (int) $this->params()->fromPost('listId');
            $checked = (bool) filter_var(
                $this->params()->fromPost('checked'),
                FILTER_VALIDATE_BOOLEAN
            );

            $this->listService->updatePurchasedItem(
                $item_id,
                $list_id,
                $checked
            );

            return new JsonModel([
                'status' => 'ok',
                'message' => 'Item status updated'
            ]);

        } catch (Exception $e) {

            return new JsonModel([
                'status' => 'error',
                'message' => 'failed to update item: ' . $e->getMessage()
            ]);
        }
    }

}