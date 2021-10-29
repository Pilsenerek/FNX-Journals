<h2>Chat</h2>
<div class="col-md-12 chat">
    <form action="/?a=chatAddMessage">
        <textarea name="chat" readonly class="p-2"><?php foreach ($messages as $message): ?><?php echo $message->getUsername(). " > " . $message->getMessage() . "\n" ?><?php endforeach ?></textarea>
        <input name="message" placeholder="What you want to say?"/>
    </form>
</div>

<script>
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

     const eventSource = new EventSource('?a=chatSentEvent');
     eventSource.addEventListener('chat', (e) => {
         var data = JSON.parse(e.data);
         $('textarea[name="chat"]').val($('textarea[name="chat"]').val() + data.username + '> ' + data.message + '\n');
         //textarea.scrollTop = textarea.scrollHeight;
     });
</script>

