<?php

namespace Lib;

use Lib\Base\ShoppingList as BaseShoppingList;

/**
 * Skeleton subclass for representing a row from the 'shopping_list' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class ShoppingList extends BaseShoppingList
{
    public function getFullItemList()
    {
        $recipes = $this->getListRecipesJoinRecipe();

        $items = [];

        /** @var ListRecipe $recipe */
        foreach ($recipes as $recipe) {
            $recipeItems = $recipe->getRecipe()->getRecipeItems();

            /** @var  $item */
            foreach ($recipeItems as $recipeItem) {


                if (!isset($items[$recipeItem->getItem()->getId()])) {
                    $items[$recipeItem->getItem()->getId()] =
                        $recipeItem->getItem()->toArray();
                }

                $items[
                $recipeItem->getItem()->getId()
                ]['total'] += $recipeItem->getQuantity() * $recipe->getServes();
            }
        }

        return $items;
    }
}
