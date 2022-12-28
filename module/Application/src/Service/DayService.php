<?php

namespace Application\Service;

use Lib\DayPlan;
use Lib\DayPlanQuery;
use Lib\DayPlanRecipe;
use Lib\DayPlanRecipeQuery;
use Lib\ListRecipe;
use Lib\ListRecipeQuery;
use Propel\Runtime\ActiveQuery\Criteria;
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

    /**
     * Mark a recipe as complete on planner
     *
     * This must also mark the corresponding shopping list recipe as
     * complete so that we can "filter down" the remaining items on the
     * shopping list. This is useful to see what items we should have
     * remaining in stock for upcoming days recipes.
     *
     * @param int $day_plan_recipe_id
     * @return array
     * @throws PropelException
     */
    public function markRecipeComplete(
        int $day_plan_recipe_id
    ) {

        // Fetch the day plan recipe.
        $dpr = DayPlanRecipeQuery::create()->findPk($day_plan_recipe_id);

        // Toggle status.
        $dpr->setComplete(!$dpr->isComplete())->save();

        // Find ListRecipe table entry.
        $listRecipe = ListRecipeQuery::create()
            ->filterByShoppingListId($dpr->getDayPlan()->getShoppingListId())
            ->filterByRecipeId($dpr->getRecipe()->getId())
            ->filterByComplete(!$dpr->getComplete())
            // Filter by opposite of what we just set day plan - sync them
            ->filterByRef(null, Criteria::ISNOTNULL)
            ->findOne();

        $listRecipe->setComplete($dpr->getComplete())->save();

        // If all items marked complete, update day to complete
        $dpr->getDayPlan()->checkIfComplete();

        // Return the list recipe object.
        return [
            'listRecipe' => $listRecipe,
            'dayPlanRecipe' => $dpr
        ];
    }

    /**
     * @param int $day_id
     * @return array|DayPlan|mixed|null
     * @throws PropelException
     */
//    public function updateDayStatus(int $day_id): DayPlan
//    {
//        $dayPlan = DayPlanQuery::create()->findPk($day_id);
//
//        $newStatus = !$dayPlan->isComplete();
//
//        // Update all day plan recipes
//        DayPlanRecipeQuery::create()
//            ->filterByDayPlan($dayPlan)
//            ->update([
//                'completed' => $newStatus
//            ]);
//
//        // Update all list recipes
//
//        $dayPlan->setComplete($newStatus)->save();
//
//        return $dayPlan;
//    }
}