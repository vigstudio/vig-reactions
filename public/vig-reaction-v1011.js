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
            var count = $('#vig-reaction-'+data.type).data('count');
            if(data.action == 'create') count = count + 1;
            if(data.action == 'delete') count = count - 1;
            if(data.action == 'update') {
                old_count = $('#vig-reaction-'+data.old_type).data('count') - 1;
                count = count + 1;
                $('#vig-reaction-'+data.old_type).html(old_count);
                $('#vig-reaction-'+data.old_type).data('count', old_count);
            }
            $('#vig-reaction-'+data.type).html(count);
            $('#vig-reaction-'+data.type).data('count', count);
        }
    })
})
