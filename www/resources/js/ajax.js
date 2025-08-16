$(document).ready(function(){
    $('[data-like]').submit(function(event){
        event.preventDefault();

        var url = $(this).attr('data-action');

        $.ajax({
            url: url,
            method: 'POST',
            data: new FormData($(this)[0]),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(response)
            {
                $('#likes-' + response.id).html('<i class="fa-solid fa-heart"></i>' + response.likes + ' Like');
            },
            error: function(response) {
                console.log(response);
            }
        });

        return false;
    });

});