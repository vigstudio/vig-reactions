var array_reation = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];

function vigPercent(number) {
    var total = parseInt($('#vig-reaction').attr('data-total'));
    return number/total*100;
}

function setAllPercent(reaction)
{
    var count       = parseInt($('#vig-reaction-'+reaction).attr('data-count'));
    var percent     = vigPercent(count) ? vigPercent(count) : 0;
    $({ Counter: 0 }).animate({
        Counter: percent
    }, {
        duration: 1000,
        easing: 'swing',
        step: function() {
            $('#vig-percent-'+reaction).prop('style', 'height:'+Math.ceil(this.Counter)+'px; position: relative; top: '+ (100-Math.ceil(this.Counter))+'px;' );
        }
    });

}

function resetPercent()
{
    $.each(array_reation, function(index, reaction) {
        setAllPercent(reaction);
    });
}

$(document).ready(function(){
    $.each(array_reation, function(index, reaction) {
        setAllPercent(reaction);
    });

    var type = 'like';
    var reaction_id = $('#vig-reaction').data('id');
    var reaction_type = $('#vig-reaction').data('type');

    $.ajax({
        url: "reaction/get-reaction",
        method: 'POST',
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            reaction_id: reaction_id,
            reaction_type: reaction_type,
            type: type,
        },
        success: function(data){
            $.each(array_reation, function(index, value){
                $('#vig-reaction-'+value).attr('data-count',0);
                $('#vig-reaction-'+value).text(0);
            });

            $.each( data.data.reactable_summary, function( key, value ) {
                $('#vig-reaction-'+key).attr('data-count', value);
                $('#vig-reaction-'+key).html(value);
            });

            $('#vig-reaction').attr('data-total', data.data.reactable_total);

            resetPercent();
        }
    })
})

$('#vig-reaction').on('click', '.vigreaction', function(){
    var type = $(this).data('type');
    var reaction_id = $('#vig-reaction').data('id');
    var reaction_type = $('#vig-reaction').data('type');
    $.ajax({
        url: "reaction/press-reaction",
        method: 'POST',
        data: {
            _token: $("meta[name='csrf-token']").attr("content"),
            reaction_id: reaction_id,
            reaction_type: reaction_type,
            type: type,
        },
        success: function(data){
            // var count = parseInt($('#vig-reaction-'+data.type).attr('data-count'));
            // console.log(data.reactable_summary);

            $.each(array_reation, function(index, value){
                $('#vig-reaction-'+value).attr('data-count',0);
                $('#vig-reaction-'+value).text(0);
            });

            $.each( data.data.reactable_summary, function( key, value ) {
                $('#vig-reaction-'+key).attr('data-count', value);
                $('#vig-reaction-'+key).html(value);
            });

            $('#vig-reaction').attr('data-total', data.data.reactable_total);

            resetPercent();
        }
    })
})

