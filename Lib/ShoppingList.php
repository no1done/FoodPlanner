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
    public function getFullIngredientList()
    {
        $recipes = $this->getListRecipesJoinRecipe();

        $ingredients = [];

        /** @var ListRecipe $recipe */
        foreach ($recipes as $recipe) {
            $recipeIngredients = $recipe->getRecipe()->getRecipeIngredients();

            /** @var  $ingredient */
            foreach ($recipeIngredients as $recipeIngredient) {


                if (!isset($ingredients[$recipeIngredient->getIngredient()->getId()])) {
                    $ingredients[$recipeIngredient->getIngredient()->getId()] =
                        $recipeIngredient->getIngredient()->toArray();
                }

                $ingredients[
                $recipeIngredient->getIngredient()->getId()
                ]['total'] += $recipeIngredient->getQuantity() * $recipe->getServes();
            }
        }

        return $ingredients;
    }
}
