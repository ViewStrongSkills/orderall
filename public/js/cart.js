function removeItem(item, id, parentDiv)
{
  parentDiv.parent().parent().remove();
  calculateTotalPrice();
  var route = baseUrl+'cartitems/destroy/' + id;
  $.ajax({
    method: 'GET',
    url: route,
    success: function(response){
      var cart = $('#cart');
      if (response == 'RELOAD')
      {
        if (cart.hasClass('at-confirmation-page'))
        {
          location.reload();
        }
        else
        {
          $('#cartitems-container').slideToggle('fast', function() {
            $(this).remove();
          });
        }
      }
      else {
        parentDiv.remove();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
      console.log(JSON.stringify(jqXHR));
      console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
  });
}

$('body').on('change', '#cart .menuextra', function(e){
  calculatePrice($(this));
});

function addExtraToCart(obj, id, itemid)
{
  var route;
  calculatePrice(obj);
  if($(obj).is(":checked")){
    route = baseUrl+'cartextras/add/' + id + '/' + itemid;
  }
  else {
    route = baseUrl+'cartextras/destroy/' + id + '/' + itemid;
  }
  $.ajax({
    method: 'GET',
    url: route,
    success: function(response){
      if (response == 'orderable') {
        $('#cart-orderbutton').removeClass('disabled');
      }
      else {
        $('#cart-orderbutton').addClass('disabled');
      }
      if (!$('#cart').length) location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseJSON.message);
      $(obj).removeAttr('checked');

      console.log(JSON.stringify(jqXHR));
      console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
  });
}

function calculatePrice(obj) {
  var totalprice = 0;
  var cartitem = $(obj).parents(".cart-box")[0];
  ($(cartitem).find('.menuextra:checked')).each(function(index, element){
    totalprice += (parseInt($(element).attr("price")));
  });
  $(cartitem).find('.extras-total-price').html(totalprice.toFixed(2));
  totalprice += parseInt(($(cartitem).find('#itemprice')).attr("price"));
  $(cartitem).find('.cartitem-total').html(totalprice.toFixed(2));
  $(cartitem).find('.cartitem-total').attr("price", totalprice);
  calculateTotalPrice();
}

function calculateTotalPrice() {
  var cart_totalprice = 0;
  $('.cartitem-total').each(function(index, element){
    cart_totalprice += (parseFloat($(element).attr("price")));
  });
  $('#totalprice').html(cart_totalprice.toFixed(2));
  $('#totalprice').attr('value', '$' + cart_totalprice.toFixed(2) + ' - Finish');
}

$('body').on('click', '.show-extras', function(e){
  if (!($(e.target).hasClass('show-extras')) && !($(e.target).hasClass('extras-clickable')))
  return;
  $(this).children('.extras-div').slideToggle(200);
  $(this).children('.show-extra-arrow').toggleClass('flip');
});

$('body').on('click', '.comments-up-down', function(e){
  $(this).parents('.cart-box').find('.comments-box').slideToggle(100);
  $(this).children('.comments-arrow').toggleClass('flip');
});

function setcomment(id, box)
{

  var docId = 'comments' + id;
  var value = box.value;
  var route = baseUrl + 'cartitems/setcomments/' + id;
  var serializedData = {comments: value};

  var request = $.ajax({
    url: route,
    type: "POST",
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: serializedData
  });

  request.fail(function (jqXHR, textStatus, errorThrown){
    // Log the error to the console
    console.error(
        "The following error occurred: "+
        textStatus, errorThrown
    );
  });
}
