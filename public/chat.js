$(document).ready(function(){
    $('form').submit(function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data)
            {
                $('input[name="message"]').val('');
            }
        });
    });
});

// const eventSource = new EventSource('?a=chatSentEvent');
// eventSource.addEventListener('chat', (e) => {
//     var data = JSON.parse(e.data);
//     $('textarea[name="chat"]').val($('textarea[name="chat"]').val() + data.username + '> ' + data.message + '\n');
//     //textarea.scrollTop = textarea.scrollHeight;
// });