tippy('.vigreaction', {
    placement: 'top',
    animation: 'scale',
    animateFill: false,
    duration: 100,
    flip: false,
    arrow: false
});

$('.vigreaction').on('click', function(){
    var type = $(this).data('type');
    var reaction_id = $('#reaction_id').val();
    var reaction_type = $('#reaction_type').val();
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
            if(data.type == 'like') {
                var count = $('#vig-reaction-like').data('count');
                count = count + 1;
                $('#vig-reaction-like').html(count);
                $('#vig-reaction-like').data('count', count);
            }

            if(data.type == 'love') {
                var count = $('#vig-reaction-love').data('count');
                count = count + 1;
                $('#vig-reaction-love').html(count);
                $('#vig-reaction-love').data('count', count);
            }

            if(data.type == 'haha') {
                var count = $('#vig-reaction-haha').data('count');
                count = count + 1;
                $('#vig-reaction-haha').html(count);
                $('#vig-reaction-haha').data('count', count);
            }

            if(data.type == 'wow') {
                var count = $('#vig-reaction-wow').data('count');
                count = count + 1;
                $('#vig-reaction-wow').html(count);
                $('#vig-reaction-wow').data('count', count);
            }

            if(data.type == 'sad') {
                var count = $('#vig-reaction-sad').data('count');
                count = count + 1;
                $('#vig-reaction-sad').html(count);
                $('#vig-reaction-sad').data('count', count);
            }

            if(data.type == 'angry') {
                var count = $('#vig-reaction-angry').data('count');
                count = count + 1;
                $('#vig-reaction-angry').html(count);
                $('#vig-reaction-angry').data('count', count);
            }
        }
    })
})
