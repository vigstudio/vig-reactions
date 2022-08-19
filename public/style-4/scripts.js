var array_reation = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];

$(document).on("click", "#emoji-picker",function(e){
     $('.intercom-emoji-picker-group').toggleClass("active");
    //  var rect = document.querySelector('#emoji-picker').getBoundingClientRect();
    // console.log(rect.top, rect.right, rect.bottom, rect.left);
    // console.log(e.pageX, e.pageY);
    $('.intercom-emoji-picker-group').css({
        right: 'calc(95% - '+e.pageX+'px)',
        bottom: 'calc(100% - '+(e.pageY - 100)+'px)',
    });
 });

$(document).on("click",".intercom-emoji-picker-emoji",function(e){
    callReaction($(this).attr('title'), 'press');
    $(".intercom-composer-emoji-popover").removeClass("active");
});

function callReaction(type, route){
    var reaction_id = $('#vig-reaction').data('id');
    var reaction_type = $('#vig-reaction').data('type');

    $.ajax({
        url: "reaction/"+route+"-reaction",
        method: 'POST',
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            reaction_id: reaction_id,
            reaction_type: reaction_type,
            type: type,
        },
        success: function(data){
            $('#add-reaction-span').html('');
            $.each( data.data.reactable_summary, function( key, value ) {
                var html =  `
                <button class="c-button-unstyled c-reaction c-reaction--feature_new_reactions" type="button" delay="300">
                    <span class="emoji emoji-sizer" data-codepoints="420" style="background-image: url(&quot;vendor/core/plugins/vig-reactions/icon/`+key+`-a.gif&quot;);">:420:</span>
                    <span class="c-reaction__count">`+value+`</span>
                </button>
                `;


                $('#add-reaction-span').append(html);
            });
        }
    })
}
$(document).ready(function(){
    callReaction('like', 'get');
})


