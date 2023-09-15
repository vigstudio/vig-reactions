let array_reaction = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];

$(document).ready(function () {
    let type = 'like';
    let reaction_id = $('#vig-reaction').data('id');
    let reaction_type = $('#vig-reaction').data('type');

    $.ajax({
        url: window.VigReaction.get,
        method: 'POST',
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            reaction_id: reaction_id,
            reaction_type: reaction_type,
            type: type,
        },
        success: function (data) {
            if (!data.error) {
                $.each(array_reaction, function (index, value) {
                    $('#vig-reaction-' + value).attr('data-count', 0);
                    $('#vig-reaction-' + value).text(0);
                });

                $.each(data.data.reactable_summary, function (key, value) {
                    $('#vig-reaction-' + key).attr('data-count', value);
                    $('#vig-reaction-' + key).html(value);
                });

                $('#vig-reaction').attr('data-total', data.data.reactable_total);
            }
        }
    })
})

$('#vig-reaction').on('click', '.vigreaction', function () {
    let type = $(this).data('type');
    let reaction_id = $('#vig-reaction').data('id');
    let reaction_type = $('#vig-reaction').data('type');
    $.ajax({
        url: window.VigReaction.press,
        method: 'POST',
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            reaction_id: reaction_id,
            reaction_type: reaction_type,
            type: type,
        },
        success: function (data) {
            // let count = parseInt($('#vig-reaction-'+data.type).attr('data-count'));
            // console.log(data.reactable_summary);

            $.each(array_reaction, function (index, value) {
                $('#vig-reaction-' + value).attr('data-count', 0);
                $('#vig-reaction-' + value).text(0);
            });

            $.each(data.data.reactable_summary, function (key, value) {
                $('#vig-reaction-' + key).attr('data-count', value);
                $('#vig-reaction-' + key).html(value);
            });

            $('#vig-reaction').attr('data-total', data.data.reactable_total);
        }
    })
})

