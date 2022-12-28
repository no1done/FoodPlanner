<?php

namespace Application\Helper;

use Lib\CategoryQuery;

class Categories {

    const BREAKFAST_KEY = "MEAL_BREAKFAST";
    const LUNCH_KEY = "MEAL_LUNCH";
    const DINNER_KEY = "MEAL_DINNER";
    const SNACK_KEY = "MEAL_SNACK";

    public static function getAll()
    {
        return CategoryQuery::create()->find();
    }

}