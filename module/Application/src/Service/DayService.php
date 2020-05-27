<?php

namespace Application\Service;

use Lib\DayPlanRecipe;
use Lib\DayPlanRecipeQuery;
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
    }

    /**
     * Remove meal from plan
     *
     * Return recipe ID so we can remove it from
     * shopping list
     *
     * @param int $dprId
     * @return int
     * @throws PropelException
     */
    public function removeMealFromPlan(int $dprId): int
    {
        $dpr = DayPlanRecipeQuery::create()
            ->findPk($dprId);

        $recipeId = $dpr->getRecipeId();

        $dpr->delete();

        return $recipeId;
    }
}