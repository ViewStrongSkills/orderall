$(document).ready(function(){
  $('body').on('click', '.logreg', function(e){
    e.preventDefault();
    title_url = baseUrl + this.id;
    newtitle = this.id.charAt(0).toUpperCase() + this.id.slice(1) + ' | Orderall';
    $.ajax({
      url: baseUrl + 'logreg/' + this.id,
      error: function(response){
        if(response.status == 401){
          handlePermissionErrors(response);
        }
      },
      success: function(response){
        $(".right").replaceWith(response);
        document.title = newtitle
      }
    });
    history.pushState(baseUrl + 'logreg/' + this.id, null, baseUrl + 'logreg/' + this.id);
  }),
  window.addEventListener('popstate', function(e){
    if (e.state != null) {
      $.ajax({
        url: e.state,
        error: function(response){
          if(response.status == 401){
            handlePermissionErrors(response);
          }
        },
        success: function(response){
          $(".right").replaceWith(response);
          document.title = newtitle
        }
      });
    }
})
});
