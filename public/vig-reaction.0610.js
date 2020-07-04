function vigPercent(number) {
    var total = parseInt($('#vig-reaction').data('total'));
    return number/total*100;
}

function setAllPercent(reaction)
{
    var count    = parseInt($('#vig-reaction-'+reaction).attr('data-count'));
    var percent = vigPercent(count);
    $({ Counter: 0 }).animate({
        Counter: percent
    }, {
        duration: 1000,
        easing: 'swing',
        step: function() {
            $('#vig-percent-'+reaction).prop('style', 'height:'+Math.ceil(this.Counter)+'px');
        }
    });

}

function resetPercent()
{
    setAllPercent('like');
    setAllPercent('love');
    setAllPercent('haha');
    setAllPercent('wow');
    setAllPercent('sad');
    setAllPercent('angry');
}

$(document).ready(function(){
    setAllPercent('like');
    setAllPercent('love',);
    setAllPercent('haha');
    setAllPercent('wow');
    setAllPercent('sad');
    setAllPercent('angry');
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
            var count = parseInt($('#vig-reaction-'+data.type).attr('data-count'));
            if(data.action == 'create') count = count + 1;
            if(data.action == 'delete') count = count - 1;
            if(data.action == 'update') {
                old_count = parseInt($('#vig-reaction-'+data.old_type).attr('data-count')) - 1;
                count = count + 1;
                $('#vig-reaction-'+data.old_type).html(old_count);
                $('#vig-reaction-'+data.old_type).attr('data-count', old_count);
                $('#vig-reaction').attr('data-total', parseInt($('#vig-reaction').data('total')) - 1);
            }
            $('#vig-reaction-'+data.type).html(count)
            $('#vig-reaction-'+data.type).attr('data-count', count);
            $('#vig-reaction').attr('data-total', parseInt($('#vig-reaction').data('total')) - 1);
            resetPercent();
        }
    })
})
