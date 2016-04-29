// A $( document ).ready() block.
$( document ).ready(function() {

  $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });


   $(document).on('click','#sendBtn',function(){
   		var text = $('#content').val();
      $('#content').val('');
      if(text.length === 0)
      {
        return;
      }

       $.ajax({
        url: '/push',
        type: 'POST',
        dataType: 'text',
        data: {content:text},
        success: function(data){
          console.log(data);
        },
        error: function(e){
          console.log(e);
        }
      });
   })

   $(document).on('click','.reportBtn',function(){      
       var $btn = $(this);
       var chat_id = $btn.data('id');  
       $.ajax({
        url: '/report',
        type: 'POST',
        dataType: 'text',
        data: {chat_id:chat_id},
        success: function(data){
          alert('Report successfully');
          $btn.remove();
        },
        error: function(e){
          console.log(e);
        }
      });
   })
   
   var channel = pusher.subscribe('test_channel');
   console.log(channel);

  channel.bind('my_event', function(data) {
      $('#contentList').prepend(data.message);
      $("#contentList").animate({scrollTop:0});
      var user_id = $('#contentList').data('user');

      if(data.sender_id === user_id)
      {
        $('#contentList').find('li:first').find('button').remove();
              }

	});

   channel.bind('remove_chat', function(data) {
      $('#contentList').find('li[data-id="'+data.id+'"]').remove();
  });

});