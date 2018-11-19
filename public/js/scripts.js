$(document).ready(function(){

  $('body').on('change', '.operatinghours-toggler', function(e){
    $(this).next().toggleClass('d-none');
    if(!$(this).is(':checked')){
      $(this).next().find('input').attr({'disabled':'disabled'}).val('');
    } else {
      $(this).next().find('input').removeAttr('disabled');
    }
  });

  $('body').on('click', '.close', function(e)
  {
    e.preventDefault();
    $(this).parent().hide(); // hide link
  });

  $('.select-tags').each(function(){
    $(this).select2({
      tags: true,
      placeholder: 'Pick a tag or add your own...'
    });
  });

  $('body').on('click', '.clear', function(e) {
    if (e.target == this)
    {
      $('#cart-cartitems').slideToggle(100);
    }
  });

  // MENUS
  // Ajax Create/Edit
  $('body').on('click', '.menus-create, .menus-edit, .menus-show', function(e){
    e.preventDefault();
    $('#modal-menu').remove();
    $.ajax({
      url: $(this).attr('href'),
      error: function(response){
        if(response.status == 401){
          handlePermissionErrors(response);
        }
      },
      success: function(response){
        $('body').append(response);
        $('#modal-menu').modal().show();
      }
    });

  });

  $('body').on('submit', '.menus-ajax-form', function(e){
    e.preventDefault();
    var form = $(this);

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(),
      beforeSend: function(){},
      error: function(response){
        if(response.status == 422){
          handleFormErrors(form, response.responseJSON.errors);
        } else if(response.status == 401){
          handlePermissionErrors(response);
        }
      },
      success:function(response){
        $('#business-menu').replaceWith(response);
        $('#modal-menu').modal('hide');
      }
    });
  });

  // Ajax Create/Edit
  $('body').on('click', '.menuitems-create, .menuitems-edit', function(e){
    e.preventDefault();
    $('#modal-menuitem').remove();
    $('#modal-business-menu-item').remove();
    $('.modal-backdrop').remove();
    $.ajax({
      url: $(this).attr('href'),
      error: function(response){
        if(response.status == 401){
          handlePermissionErrors(response);
        }
      },
      success: function(response){
        $('body').append(response);
        $('#modal-menuitem').modal().show();
        $('.select-menus').select2({
          placeholder: 'Select menu...'
        });
      }
    });

  });

  $('body').on('submit', '.menuitems-ajax-form', function(e){
    e.preventDefault();
    var form = $(this),
        data = new FormData(form[0]);

    $.ajax({
      processData: false,
      contentType: false,
      url: form.attr('action'),
      type: form.attr('method'),
      data: data,
      beforeSend: function(){},
      error: function(response){
        if(response.status == 422){
          handleFormErrors(form, response.responseJSON.errors);
        } else if(response.status == 401){
          handlePermissionErrors(response);
        }
      },
      success:function(response){
        $('#business-menu').replaceWith(response);
        $('#modal-menuitem').modal('hide');
        location.reload();
      }
    });
  });

  //REVIEWS
  $('body').on('click', '.reviews-show', function(e){
    e.preventDefault();
    $('#modal-business-menu-item').remove();
    $('.modal-backdrop').remove();
    $.ajax({
      url: $(this).attr('href'),
      error: function(response){
        if(response.status == 401){
          handlePermissionErrors(response);
        }
      },
      success: function(response){
        $('body').append(response);
        $('#modal-review').modal().show();
      }
    });
  });

  $('body').on('click', '.reviews-create', function(e){
    e.preventDefault();
    $('#modal-business-menu-item').remove();
    $('.modal-backdrop').remove();
    $.ajax({
      url: $(this).attr('href'),
      error: function(response){
        if(response.status == 401){
          handlePermissionErrors(response);
        }
      },
      success: function(response){
        $('body').append(response);
        $('#modal-review-create').modal().show();
      }
    });
  });

  // MENUEXTRAS
  // Ajax Create/Edit
  $('body').on('click', '.menuextras-create, .menuextras-edit', function(e){
    e.preventDefault();
    $('#modal-menuextra').remove();
    $.ajax({
      url: $(this).attr('href'),
      error: function(response){
        if(response.status == 401){
          handlePermissionErrors(response);
        }
      },
      success: function(response){
        $('body').append(response);
        $('#modal-menuextra').modal().show();
        // $('.select-menuextra-category').select2({
        //   placeholder: 'Select category',
        //   tags: true,
        //   maximumSelectionLength: 1
        // });

      }
    });

  });

  $('body').on('submit', '.menuextras-ajax-form', function(e){
    e.preventDefault();
    var form = $(this),
        data = new FormData(form[0]);

    $.ajax({
      processData: false,
      contentType: false,
      url: form.attr('action'),
      type: form.attr('method'),
      data: data,
      beforeSend: function(){},
      error: function(response){
        if(response.status == 422){
          handleFormErrors(form, response.responseJSON.errors);
        } else if(response.status == 401){
          handlePermissionErrors(response);
        }
      },
      success:function(response){
        $('#modal-menuextra').modal('hide');
        var exists = $('#'+$(response).attr('id'));
        // update
        if(exists.length){
          exists.replaceWith(response);
        // create
        } else {
          $('#menuextras').prepend(response);
        }
      }
    });
  });


    // MENUEXTRACATEGORIES
    // Ajax Create/Edit
    $('body').on('click', '.menuextracategories-edit', function(e){
      e.preventDefault();
      $('#modal-menuitem').remove();
      $.ajax({
        url: $(this).attr('href'),
        error: function(response){
          if(response.status == 401){
            handlePermissionErrors(response);
          }
        },
        success: function(response){
          $('body').append(response);
          $('#modal-menuextracategory').modal().show();
        }
      });
    });

    $('body').on('submit', '.menuextracategories-ajax-form', function(e){
      e.preventDefault();
      var form = $(this),
          data = new FormData(form[0]);

      $.ajax({
        processData: false,
        contentType: false,
        url: form.attr('action'),
        type: form.attr('method'),
        data: data,
        beforeSend: function(){},
        error: function(response){
          if(response.status == 422){
            handleFormErrors(form, response.responseJSON.errors);
          } else if(response.status == 401){
            handlePermissionErrors(response);
          }
        },
        success:function(response){
          $('#modal-menuextracategory').modal('hide');
          var exists = $('#'+$(response).attr('id'));
          // update
          if(exists.length){
            exists.replaceWith(response);
          // create
          } else {
            $('#menuextracategories').prepend(response);
          }
        }
      });
    });
});

$(window).on('load', function(){
  $(".progressive-image").each(function(key, value) {
    var newSrc = value.dataset.fullsize,
    image = new Image();

    image.onload = function() {
        $(value).attr("src", newSrc).show();
    }
    image.src = newSrc;
  });

  $(".progressive-bg").each(function(key, value) {
    var newSrc = value.dataset.fullsize,
    image = new Image();
    image.onload = function() {
      $(value).css('background-image', 'url(' + newSrc + ')');
    }
    image.src = newSrc;
  });
});



function handlePermissionErrors(response){
  // for now it's just log
  console.log('Error 403: Not authorized');
}

function handleFormErrors(form, errors){
  var template = $('<div class="alert alert-danger" role="alert"><h3>Error</h3><ul></ul></div>');
  for(var field in errors){
    template.find('ul').append($('<li>'+errors[field]+'</li>'));
  }
  form.find('.alert-danger').remove().end().prepend(template);
}
