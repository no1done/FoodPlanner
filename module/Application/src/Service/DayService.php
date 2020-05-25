<?php

namespace Application\Service;

use Lib\DayPlanRecipe;
use Propel\Runtime\Exception\PropelException;

/**
 * Class DayService
 * @package Application\Service
 */
class DayService {

    /**
     * @param int $recipeId
     * @param int $categoryId
     * @param int $dayPlanId
     * @param int $servings
     * @throws PropelException
     */
    public function addMealToPlan(
        int $recipeId,
        int $categoryId,
        int $dayPlanId,
        int $servings
    ) {

        $dayPlanRecipe = new DayPlanRecipe();
        $dayPlanRecipe->setRecipeId($recipeId)
            ->setCategoryId($categoryId)
            ->setDayPlanId($dayPlanId)
            ->setServers($servings)
            ->save();

        // Add to shopping list using existing recipe functionality here?
    }

}