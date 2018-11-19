<script type="text/javascript">
$(document).ready(function(){
  $.ajax({
    url: baseUrl + 'api/unsupported-country-notice',
    error: function(response){
      if(response.status == 401){
        handlePermissionErrors(response);
      }
    },
    success: function(response){
      $('body').append(response);
      $('#modal-country-warning').modal().show();
    }
  });
});
</script>
