$('.delete-btn').click(function () {
    $id = $(this).attr('data-news-id').substring(2);
    $url = $('#news-delete-form').attr('action') + "";
    $post_url = $url.substring(0, $url.lastIndexOf('/') + 1).concat($id);
    $('#news-delete-form').attr('action', $post_url);
});

$(function () {
    setTimeout(function () {
        $("#alert-success").hide('fadeOut', {}, 3000)
    }, 3000);
});