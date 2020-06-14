<?php

namespace Lib;

use Lib\Base\DayPlan as BaseDayPlan;
use Propel\Runtime\Exception\PropelException;

/**
 * Skeleton subclass for representing a row from the 'day_plan' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */
class DayPlan extends BaseDayPlan
{
    /**
     * Manage day status
     *
     * @return DayPlan
     * @throws PropelException
     */
    public function checkIfComplete(): DayPlan
    {
        $incompleteCount = DayPlanRecipeQuery::create()
            ->filterByDayPlan($this)
            ->filterByComplete(false)
            ->count();

        // Update day if required.
        if ($incompleteCount == 0 && !$this->isComplete()) {
            $this->setComplete(true)->save();
        } elseif ($incompleteCount > 0 && $this->isComplete()) {
            $this->setComplete(false)->save();
        }

        return $this;
    }
}
