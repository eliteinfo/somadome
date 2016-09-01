$(window).load(function() {

$( ".search" ).click(function() {
  $(this).addClass('active');	

});


$(document).mouseup(function (e)
{
    var container = $(".search");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
       $(container).removeClass('active');	
       $('.search input').val('');		   
    }
});


});
