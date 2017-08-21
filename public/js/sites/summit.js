$(document).ready(function() {
    
    function apiGetter() {
        $.get('http://localhost:8080/api', function(data) {
            data = $.parseJSON(data);
            $('#messages').append($('<li>').addClass('text-info').text(data.time));            
            $('#messages').append($('<li>').text(JSON.stringify(data.data)));            
        });   
    }
    
   var interval;
           
   $('#starter').click(function(element) {
       if ($(this).data('clicked')) {
           console.log('stopped');
           $(this).removeData('clicked');
           $(this).removeClass('btn-info').addClass('btn-primary');
           console.log(interval);
           clearInterval(interval);
       } else {
           console.log('started');
           $(this).data('clicked', 'clicked');
           $(this).removeClass('btn-primary').addClass('btn-info');
           interval = setInterval(apiGetter, 5000);
       }
       
   })     
});