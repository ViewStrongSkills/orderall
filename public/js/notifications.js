//check for updates
    setInterval(function() {
        $.ajax({
            type: "GET",
            url: baseUrl + "checknotifications",
            success: function(response) {
                if (response) {
                  $('body').prepend(response);
                  $( "#order-notify" ).slideDown( "slow", function() {
                  });
            }
        }});
}, 10000); //Wait 10s
