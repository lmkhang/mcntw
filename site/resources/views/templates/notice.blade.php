<script>
    var message = '';
    @if(isset($message))
    message = '{{$message}}';
    @endif;

    if(message){
        notie.alert(4, message, 4);
    }
</script>