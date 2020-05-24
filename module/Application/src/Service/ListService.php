<?php

namespace Application\Service;

use Lib\ListRecipe;
use Lib\ListRecipeQuery;
use Lib\Recipe;
use Lib\ShoppingList;
use Lib\ShoppingListItem;
use Lib\ShoppingListItemQuery;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Exception\PropelException;
use RuntimeException;

/**
 * Service to help build and manage lists
 *
 * Class ListService
 * @package Application\Service
 */
class ListService {

    /**
     * @param ShoppingList $list
     * @param Recipe $recipe
     * @param int $serves
     * @return ListRecipe
     * @throws PropelException
     */
    public function addToList(
        ShoppingList $list,
        Recipe $recipe,
        int $serves
    ): ListRecipe {

        $uniqueRef = hash('md5', date('YmdHis'));

        $listRecipe = new ListRecipe();
        $listRecipe->setShoppingList($list)
            ->setRecipe($recipe)
            ->setServes($serves)
            ->setRef($uniqueRef)
            ->save();

        foreach ($recipe->getRecipeItemsJoinItem() as $recipeItem) {

            // Quantity should be recipe quantity x servings.
            $qty = $recipeItem->getQuantity() * $serves;

            $listItem = new ShoppingListItem();
            $listItem->setQuantity($qty)
                ->setShoppingList($list)
                ->setItemId($recipeItem->getItemId())
                ->setRef($uniqueRef)
                ->save();
        }

        return $listRecipe;
    }

    /**
     * @param ShoppingList $list
     * @return ShoppingListItem[]|ObjectCollection
     * @throws PropelException
     */
    public function getShopList(ShoppingList $list)
    {
        return ShoppingListItemQuery::create()
            ->filterByShoppingList($list)
            ->innerJoinWithItem()
            ->withColumn('SUM(quantity)', 'total')
            ->groupByPurchased()
            ->groupByItemId()
            ->find();
    }

    /**
     * @param int $listRecipeId
     * @return array
     * @throws PropelException
     */
    public function removeRecipe(int $listRecipeId): array
    {
        $lr = ListRecipeQuery::create()->findPk($listRecipeId);

        if (!$lr) throw new RuntimeException(
            'List Recipe ID does not exist.'
        );

        $ref = $lr->getRef();
        $recipeName = $lr->getRecipe()->getName();
        $listName = $lr->getShoppingList()->getName();

        $this->removeRecipeItemsFromList($ref);
        $lr->delete();

        return [
            'recipe' => $recipeName,
            'list' => $listName
        ];
    }

    /**
     * Delete all items with recipe ref
     *
     * @param string $ref
     * @throws PropelException
     */
    public function removeRecipeItemsFromList(string $ref)
    {
        ShoppingListItemQuery::create()
            ->filterByRef($ref)
            ->delete();
    }

    /**
     * @param int $item_id
     * @param int $list_id
     * @throws PropelException
     */
    public function removeItemFromList(int $item_id, int $list_id)
    {
        ShoppingListItemQuery::create()
            ->filterByItemId($item_id)
            ->filterByShoppingListId($list_id)
            ->delete();
    }

    /**
     * @param int $item_id
     * @param int $list_id
     * @param bool $checked
     * @throws PropelException
     */
    public function updatePurchasedItem(
        int $item_id,
        int $list_id,
        bool $checked
    ) {
        ShoppingListItemQuery::create()
            ->filterByItemId($item_id)
            ->filterByShoppingListId($list_id)
            ->update([
                'Purchased' => $checked
            ]);
    }
}