$("#poster").change(function(){
    if($('#poster').val().length > 0){
        $("#upload-container-label").html("File selected!")
        $(".upload-container").css('background', 'rgba(2, 95, 95, 0.7)')
        $(".upload-container").css('color', 'white')
    }else{
        $("#upload-container-label").html("Event Poster")
        $(".upload-container").css('background', 'white')
        $(".upload-container").css('color', 'rgba(2, 95, 95, 0.7)')
    }
});
$("#publish_Scheduled").change(function(){
    
    if(this.checked){
        $('#publish_at_container').fadeIn(1000)
    }
});
$("#publish_now").change(function(){
    if(this.checked){
        $('#publish_at_container').fadeOut(1000);
    }
});
////
$("#unlimited").change(function(){
    if(this.checked){
        $('#ticket_num_container').fadeOut(1000)
    }
});
$("#limited").change(function(){
    if(this.checked){
        $('#ticket_num_container').fadeIn(1000)
    }
});
$("#add_promo_code").click(function(){
    let value = Math.random().toString(15).substring(4, 8) + Math.random().toString(15).substring(4, 8);
    $('#promo_code_container').append(
        '<div class="d-flex">'+
        '<input type="text" name="code[]" class="form-control col-5" value="' + value +'" readonly>'+
        '<input type="number" id="percentage" min="1" max="100" placeholder="Percentage (%)" name="percentage[]" class="form-control container__input col-7" required>'+
        '<a class="btn btn-danger btn-sm d-flex align-items-center" onClick="$(this).parent().remove();"><i class="fas fa-trash"></i></a></div>')
});