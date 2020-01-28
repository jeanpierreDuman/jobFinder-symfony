$(document).ready(function() {

    $collectionExperiencesHolder = $('ul.experiences');
    $collectionExperiencesHolder.data('index', $collectionExperiencesHolder.find(':input').length);

    $(".addExperience").on('click', function(e) {
        addExperienceForm($collectionExperiencesHolder, 'ul.experiences');
    });

    $(".removeExperience").on('click', function(e) {
        $(this).prev().remove();
        $(this).remove();
    });

    function addExperienceForm($collectionExperiencesHolder, place) {
        var prototype = $collectionExperiencesHolder.data('prototype');
        var index = $collectionExperiencesHolder.data('index');
        var newForm = prototype;

        newForm = newForm.replace(/__name__/g, index);
        $collectionExperiencesHolder.data('index', index + 1);
        $(place).append(newForm);
        $collectionExperiencesHolder.append("<button class='removeExperience'>supprimer la question</button>");


        $(".removeExperience").on('click', function(e) {
            $(this).prev().remove();
            $(this).remove();
        });
    }
});
