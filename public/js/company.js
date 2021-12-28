$("#create-company-btn").click(() => {
    $("#create-company-form").fadeIn();
})
$("#cancel-company-btn").click(() => {
    $("#create-company-form").fadeOut();
})
$("#logo").change(function(){
    if($('#logo').val().length > 0){
        $("#upload-logo-label").html("Logo selected!")
        $(".upload-container").css('background', 'rgba(2, 95, 95, 0.7)')
        $(".upload-container").css('color', 'white')
    }else{
        $("#upload-logo-label").html("Company logo")
        $(".upload-container").css('background', 'white')
        $(".upload-container").css('color', 'rgba(2, 95, 95, 0.7)')
    }
});
