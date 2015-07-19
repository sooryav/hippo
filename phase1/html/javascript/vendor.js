$(document).ready(function() {
  var track_click = 0; //track user click on "load more" button, righ now it is 0 click
  var total_pages = parseInt($("#totalVenuesCount").text());

  $('#results').load(
    "/venues",
    { 'page' :track_click },
    function() {track_click++;}); //initial data to load

  $(".load_more").click(function (e) { //user clicks on button

    $(this).hide(); //hide load more button on click
    
    if (track_click <= total_pages) //user click number is still less than total pages
    {
      $('.animation_image').show(); //show loading image

      //post page number and load returned data into result element
      $.post('/venues',{'page': track_click}, function(data) {
    
        $(".load_more").show(); //bring back load more button
        $("#results").append(data); //append data received from server

        //scroll page smoothly to button id
        $("html, body").animate({scrollTop: $("#load_more_button").offset().top}, 500);
	
        //hide loading image
        $('.animation_image').hide(); //hide loading image once data is received

        if (++track_click > total_pages) {
          $(".load_more").hide();
        }

      }).fail(function(xhr, ajaxOptions, thrownError) { 
        alert(thrownError); //alert with HTTP error
        $(".load_more").show(); //bring back load more button
        $('.animation_image').hide(); //hide loading image once data is received
      });
    }
  });
});
