$(document).ready(function() {

    $collectionFormationsHolder = $('ul.formations');
    $collectionFormationsHolder.data('index', $collectionFormationsHolder.find(':input').length);

    $(".addFormation").on('click', function(e) {
        addFormationForm($collectionFormationsHolder, 'ul.formations');
    });

    $(".removeFormation").on('click', function(e) {
        $(this).prev().remove();
        $(this).remove();
    });

    function addFormationForm($collectionFormationsHolder, place) {
        var prototype = $collectionFormationsHolder.data('prototype');
        var index = $collectionFormationsHolder.data('index');
        var newForm = prototype;

        newForm = newForm.replace(/__name__/g, index);
        $collectionFormationsHolder.data('index', index + 1);
        $(place).append(newForm);
        $collectionFormationsHolder.append("<button class='removeFormation'>supprimer la formation</button>");

        $(".removeFormation").on('click', function(e) {
            $(this).prev().remove();
            $(this).remove();
        });
    }
});
