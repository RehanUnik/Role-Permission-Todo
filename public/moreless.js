$(document).ready(function() {
    $('.read-more').on('click', function() {
        var $taskDescription = $(this).closest('.task-description');
        $taskDescription.find('.truncated-description').hide();
        $taskDescription.find('.full-description').show();
        $taskDescription.find('.read-more').hide();
        $taskDescription.find('.read-less').show();
    });

    $('.read-less').on('click', function() {
        var $taskDescription = $(this).closest('.task-description');
        $taskDescription.find('.full-description').hide();
        $taskDescription.find('.truncated-description').show();
        $taskDescription.find('.read-more').show();
        $taskDescription.find('.read-less').hide();
    });
});