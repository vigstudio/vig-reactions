$(document).on("click", "#emoji-picker-button", function (e) {
    $('.intercom-emoji-picker-group').toggleClass('active');
});

$(document).on("click", ".intercom-emoji-picker-emoji", function () {
    callReaction($(this).attr('title'), 'press');
    $(".intercom-emoji-picker-group").removeClass("active");
});

function callReaction(type, route) {
    let reaction_id = $('#vig-reaction').data('id');
    let reaction_type = $('#vig-reaction').data('type');

    if (route == 'get') {
        var getRoute = window.VigReaction.get;
    }

    if (route == 'press') {
        var getRoute = window.VigReaction.press;
    }

    $.ajax({
        url: getRoute,
        method: 'POST',
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            reaction_id: reaction_id,
            reaction_type: reaction_type,
            type: type,
        },
        success: function (data) {
            if (!data.error) {
                $('#add-reaction-span').html('');
                $.each(data.data.reactable_summary, function (key, value) {
                    let html = `
                    <button class="c-button-unstyled c-reaction c-reaction--feature_new_reactions" type="button" delay="300">
                        <span class="emoji emoji-sizer" data-codepoints="420" style="background-image: url(&quot;vendor/core/plugins/vig-reactions/icon/` + key + `-a.gif&quot;);">:420:</span>
                        <span class="c-reaction__count">` + value + `</span>
                    </button>
                    `;


                    $('#add-reaction-span').append(html);
                });
            }
        }
    })
}

$(document).ready(function () {
    callReaction('like', 'get');
})


