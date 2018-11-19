if (sessionStorage.xcoord) {
  setLocation(sessionStorage.xcoord, sessionStorage.ycoord);
  if (sessionStorage.format_add) {
    $('#search').attr("placeholder", "Search for restaurants near " + sessionStorage.format_add);
  }
}
else {
  addressMethod();
}

function autoGeoMethod() {
  if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function(position) {
      if (position.coords.accuracy < 1000) {
        $('#search-form-container .alert').remove();
        sessionStorage.xcoord = position.coords.latitude;
        sessionStorage.ycoord = position.coords.longitude;
        setLocation(position.coords.latitude, position.coords.longitude);
      }
      else {
        locationError('We couldn\'t accurately get your location');
        addressMethod();
      }
    },
    function (error) {
      if (error.code == error.PERMISSION_DENIED)
        locationError('Permission to get your location has been denied');
        addressMethod();
  });

  }
  else {
    addressMethod();
    console.log('Error: geolocation not supported');
  }
}

function locationError(error) {
  $("#address").removeAttr("disabled");
  var template = $('<div class="alert alert-danger" style="display:none;" role="alert"><img src="' + baseUrl + '/images/blocked.svg' +'"><ul></ul></div>');
     template.find('ul').append($('<li>' + error + '</li>'));
     $("#search-form-container").find('.alert-danger').remove().end().prepend(template);
     $('.alert-danger').slideDown(100);
     $('#address').attr("placeholder", "Enter your address");
}

function addressMethod()
{
  sessionStorage.clear();
  $('.search-location').show();
  $('.remove-search').hide();
  $('#searchform').attr("id", "addressform");
  $('#addressform').attr("method", "POST");
  $('#addressform').attr("action", baseUrl + "getaddresscoords");
  $("#search").removeAttr("disabled");
  $('#search').attr("placeholder", "Enter your address");
  $('#search').attr("name", "address");
  $('#search').attr("id", "address");
  bindsearch();
}

function bindsearch()
{
  $("#addressform").submit(function(e) {
    e.preventDefault();
    var url = baseUrl+'getaddresscoords';
    var formData = {
        "_token": $('#token').val(),
        "address": $('#address').val()
    };
    $('#address').val("");
    $('#address').attr("placeholder", "Loading...");
    $("#address").attr("disabled", "disabled");
    $.post(url, formData).done(function (data) {
      try {
        var result = JSON.parse(data);
      }
      catch (e) {
        console.log('Error parsing result.');
      }
      if (result.status == false || result.format_add == 'Australia') {
        locationError('Error: we couldn\'t find that address');
        $("#address").removeAttr("disabled");
      }
      else {
        $('#search-form-container .alert').remove();
        sessionStorage.xcoord = result.lat;
        sessionStorage.ycoord = result.lng;
        sessionStorage.format_add = result.format_add;
        setLocation(result.lat, result.lng);
        $('#search').attr("placeholder", "Search for restaurants near " + result.format_add);
      }
    });
  });
}

function setLocation(lat, long) {
  $('.search-location').hide();
  $('.remove-search').show();
  $('#addressform').unbind();
  $('#address').attr("name", "search");
  $("#address").removeAttr("disabled");
  $("#search").removeAttr("disabled");
  $('#addressform').attr("id", "searchform");
  $('#address').attr("id", "search");
  $('#searchform').attr("action", baseUrl + "search");
  $('#searchform').attr("method", "GET");
  $('#search').attr("placeholder", "Search for restaurants near you");
  $('#search').attr("id", "search");
  $('#xcoord').val(lat);
  $('#ycoord').val(long);
}
