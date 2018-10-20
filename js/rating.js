$(function() {
    // rating form hide/show
    $( "#rateProduct" ).click(function() {
        $("#ratingDetails").hide();
        $("#ratingSection").show();
    });
    $( "#cancelReview" ).click(function() {
        $("#ratingSection").hide();
        $("#ratingDetails").show();
    });
    // implement start rating select/deselect
    $( ".rateButton" ).click(function() {
        if($(this).hasClass('btn-grey')) {
            $(this).removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
            $(this).prevAll('.rateButton').removeClass('btn-grey btn-default').addClass('btn-warning star-selected');
            $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
        } else {
            $(this).nextAll('.rateButton').removeClass('btn-warning star-selected').addClass('btn-grey btn-default');
        }
        $("#rating").val($('.star-selected').length);
    });
    // save review using Ajax
    $('#ratingForm').submit( function(event){
        event.preventDefault();
        var formData = $(this).serialize();
        //alert(formData);
        $.ajax({
            type : 'POST',
            url : 'includes/saveRating.php',
            data : formData,
            success : function (response) {
                console.log(response);
                //alert(response);
                $("#ratingForm")[0].reset();
                window.setTimeout(function(){window.location.reload()},1000)
            }
        });
    });
});