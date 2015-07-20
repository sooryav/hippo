$(document).ready(function() {
  var currentPage = 0; 
  var totalPages = parseInt($("#totalVenuesCount").text());

  $('#results').load(
    "/venues",
    { 'page' : currentPage },
    function() {
    ++currentPage;
  }); 

  $("#load_button").click(function (e) { // User clicks on button.
    $(this).hide(); // Hide load more button on click.
    
    if (currentPage <= totalPages) {
      $.post('/venues', { 'page' : currentPage }, function(data) {
        $("#load_button").show(); 
        $("#venuesContainer").append(data); 

        // Scroll page smoothly to button.
        $("html, body").animate({scrollTop: $("#load_button").offset().top}, 500);
	
        if (++currentPage > totalPages) {
          $("#load_button").hide();
        }

      }).fail(function(xhr, ajaxOptions, thrownError) { 
        alert(thrownError);
        $("#load_button").show();
      });
    }
  });
});
