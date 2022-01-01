$(".cat-check").on('change', function(){

    if($(this).attr('name') == 'all-categories'){
        $("input[name=categories]").prop('checked', false)
        //show all events
        $('.event-container').fadeIn();
    }else{
        $('#all-categories').prop('checked', false)
        var catArr = categoriesSelected();

        $(".event-container").each(function(){
            var category = ($(this).data('category'));  
            if(catArr.indexOf(category) != -1){
                //console.log(category);
                $(this).fadeIn();
            }else{
                $(this).fadeOut();
            }
        })
    }
    
})

function categoriesSelected(){
    var arr = []
    $(".cat-check").each(function(){
        if($(this).is(':checked')){
            arr.push(parseInt($(this).val()));
        }
    })
    return arr;
}