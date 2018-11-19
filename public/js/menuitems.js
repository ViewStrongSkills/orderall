$(document).ready(function(){

$('body').on('change', '#modal-business-menu-item .menuextra', function(e){
  var totalprice = 0;
  totalprice += (parseInt($('#modal-business-menu-item #itemprice').attr("price")));
  $('#modal-business-menu-item .menuextra:checked').each(function(index, element){
    totalprice += (parseInt($(element).attr("price")));
  });
  $("#menuitem-totalprice").html(totalprice.toFixed(2));
});

// MENUITEMS

//Ajax Show/Add to cart
$('body').on('click', '.business-menu-item', function(e){
  e.preventDefault();
  $('#modal-business-menu-item').remove();
  $.ajax({
    url: $(this).attr('href'),
    error: function(response){
      if(response.status == 401){
        handlePermissionErrors(response);
      }
    },
    success: function(response){
      $('body').append(response);
      $('#modal-business-menu-item').modal().show();
    }
  });

});

$('body').on('submit', '.business-menu-item-form', function(e){
  e.preventDefault();
  
  //make rule for menu items not being able to have extras below the price of the item
  var totalprice = 0;
  totalprice += (parseInt($('#modal-business-menu-item #itemprice').attr("price")));
  $('#modal-business-menu-item .menuextra:checked').each(function(index, element){
    totalprice += (parseInt($(element).attr("price")));
  });  
  if (totalprice < parseInt($('#modal-business-menu-item #itemprice').attr("price"))) {
    alert("You are not able to have extras below the price of the item.");
    return false;
  }

  var form = $(this);
  menuextras = [];
  $('form.business-menu-item-form .menuextra:checked').each(function(index, element){
    menuextras.push(parseInt($(element).attr("data")));
  });
  form_data = $('.business-menu-item-form:not(.menuextra) > :input').serializeArray();
  data = {
    token: form_data[0].value,
    menuitem: form_data[1].value,
    comments: form_data[2].value,
    menuextras: menuextras
  };
  data = JSON.stringify(data);
  $.ajax({
    processData: false,
    contentType: 'raw',
    url: form.attr('action'),
    type: form.attr('method'),
    data: data,
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function(){},
    error: function(response){
      if(response.status == 422){
        handleFormErrors(form, response.responseJSON.errors);
      } else if(response.status == 401){
        handlePermissionErrors(response);
      }
    },
    success:function(response){
      if ($("#cartitems-container").length == 0) {        
        $('#cart').html(response);
        $('#cart').hide();
        $('#cart').slideUp(100);
      }
      else {                   
        response = JSON.parse(response);        
        $('#cart-cartitems').html(response.view);
        $('#totalprice').html(response.total.toFixed(2));
        if (response.orderable) {
          $('#cart-orderbutton').removeClass('disabled');
        }
        else {
          $('#cart-orderbutton').addClass('disabled');
        }
      }
      $('#cart').slideDown(100);
      $('#modal-business-menu-item').modal('hide');
      //calculateTotalPrice();
    }
  });
});

});
