$(function() {

    $('.add_to_meal_btn').on('click', function() {

        let id = $(this).data('id');

        // Show the form
        $('#hidden-add-form-' + id).show();
    });

    $('.submit-meal-to-planner').on('click', function() {

        let id = $(this).data('id');

        let form = $('#add_recipe_' + id);

        form.submit();
    });

    $('.remove-day').on('click', function() {

        let dayPlanId = $(this).data('id');

        console.log(dayPlanId);
        $('#rm_dayplan_id').val(dayPlanId);

        $('#removeDayModal').modal('show')
    });

    $('.remove-recipe').on('click', function() {

        let dayRecipeId = $(this).data('id');
        let name = $(this).data('name');

        console.log(dayRecipeId,name);

        // Set values on modal
        $('#rm_recipe_id').val(dayRecipeId);
        $('#rm_recipe_name').html(name);

        // Show the modal
        $('#removeRecipeModal').modal('show');
    });

    $('.recipe-done').on('click', async function() {

        let recipeId = $(this).data('id')
        let rowSelector = $('#dpr_row_'+recipeId);
        let btnSelector = $('#dpr_done_btn_'+recipeId);

        console.log('checking off recipe', recipeId);

        // Make ajax call to toggle the status of this recipe.
        let res = await toggleRecipeStatus(recipeId);

        if (res.status === 'ok') {

            let dayCardSelector = $('#day_card_' + res['dayId']);
            let dayBtnSelector = $('#day_btn_' + res['dayId']);
            let dayCardBodySelector = $('#day_card_body_' + res['dayId']);
            let dayCardTitleSelector = $('#day_title_' + res['dayId']);

            if (res['isComplete'] === false) {
                // Uncheck row
                rowSelector.removeClass('table-success');
                btnSelector.removeClass('btn-success')
                    .addClass('btn-outline-success')
                    .html('<i class="fa fa-check"></i>');

                // Mark day stuff as incomplete since we've toggled something off?
                dayCardSelector.removeClass('text-white')
                    .removeClass('bg-success');
                dayBtnSelector.removeClass('btn-success')
                    .addClass('btn-outline-success')
                    .html('<i class="fa fa-check"></i>');

                dayCardTitleSelector.removeClass('text-white').addClass('text-dark');

            } else {
                // Mark row as complete
                rowSelector.addClass('table-success');
                btnSelector.addClass('btn-success')
                    .removeClass('btn-outline-success')
                    .html('<i class="fa fa-times"></i>');

                if (res['dayComplete'] === true) {
                    // Mark day as complete
                    dayCardSelector.addClass('text-white')
                        .addClass('bg-success');
                    dayBtnSelector.addClass('btn-success')
                        .removeClass('btn-outline-success')
                        .html('<i class="fa fa-times"></i>');

                    dayCardTitleSelector.addClass('text-white').removeClass('text-dark');
                    dayCardBodySelector.collapse('hide');
                }
            }

            $('#shopping-list-holder').html(res['new_list']);

        } else {
            alert(res.message);
        }
    });

    $('.day-done').on('click', async function() {

        let dayId = $(this).data('id');
        let cardSelector = $('#day_card_' + dayId);
        let btnSelector = $('#day_btn_' + dayId);

        console.log('Updating day status for ', dayId);

        let res = await toggleDayStatus(dayId);

        if (res.status === 'ok') {

            if (res['isComplete'] === false) {
                // Uncheck row
                cardSelector.removeClass('text-white')
                    .removeClass('bg-success');
                btnSelector.removeClass('btn-success')
                    .addClass('btn-outline-success')
                    .html('<i class="fa fa-check"></i>');

                // Mark all recipes as uncomplete
                $('.day_row_' + dayId).removeClass('table-success');
                $('.day_btn_' + dayId).removeClass('btn-success')
                    .addClass('btn-outline-success')
                    .html('<i class="fa fa-check"></i>');

            } else {
                // Mark row as complete
                cardSelector.addClass('text-white')
                    .addClass('bg-success');
                btnSelector.addClass('btn-success')
                    .removeClass('btn-outline-success')
                    .html('<i class="fa fa-times"></i>');

                // Mark all recipes as complete
                $('.day_row_' + dayId).addClass('table-success');
                $('.day_btn_' + dayId).addClass('btn-success')
                    .removeClass('btn-outline-success')
                    .html('<i class="fa fa-times"></i>');
            }

            $('#shopping-list-holder').html(res['new_list']);

        } else {
            alert(res.message);
        }
    });
});

/**
 * Toggle recipe status
 *
 * This method will toggle the recipe status
 *
 * @param dayPlanRecipeId
 * @returns {Promise}
 */
const toggleRecipeStatus = async (
    dayPlanRecipeId
) => new Promise(resolve => {

    let url = '/planner/recipe/status/update';

    console.log('Attempting to toggle recipe status');

    $.post(url, {id: dayPlanRecipeId}, async function(data) {

        return resolve(data);
    });
});

/**
 * Toggle Day status
 *
 * This method will toggle the day status
 *
 * @param dayPlanId
 * @returns {Promise}
 */
const toggleDayStatus = async (
    dayPlanId
) => new Promise(resolve => {

    let url = '/planner/day/status/update';

    console.log('Attempting to toggle day status');

    $.post(url, {id: dayPlanId}, async function(data) {

        return resolve(data);
    });
});
