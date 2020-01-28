$(document).ready(function() {

    $collectionCriteriasHolder = $('ul.criterias');
    $collectionCriteriasHolder.data('index', $collectionCriteriasHolder.find(':input').length);

    $(".addCriteria").on('click', function(e) {
        addFormationForm($collectionCriteriasHolder, 'ul.criterias');
    });

    $(".removeCriteria").on('click', function(e) {
        $(this).prev().remove();
        $(this).remove();
    });

    function addFormationForm($collectionCriteriasHolder, place) {
        var prototype = $collectionCriteriasHolder.data('prototype');
        var index = $collectionCriteriasHolder.data('index');
        var newForm = prototype;

        newForm = newForm.replace(/__name__/g, index);
        $collectionCriteriasHolder.data('index', index + 1);
        $(place).append(newForm);
        $collectionCriteriasHolder.append("<button class='removeCriteria'>supprimer ce critère</button>");

        $(".removeCriteria").on('click', function(e) {
            $(this).prev().remove();
            $(this).remove();
        });
    }
});
