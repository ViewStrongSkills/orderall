$(function(){

	$('.infinite-scroll').each(function(){
		var container = $(this),
				containerTop = container.prop('offsetTop'),
				offset = 1000;
				loading = false;

		$(window).scroll(function(){
			onEventStop(function(){

				if ((window.pageYOffset > (container.prop('clientHeight')+containerTop-offset)) && (!loading)) {
					var nextPage = container.find('.items-wrapper:last').find('link').attr('href');
					if (nextPage) {
						load(nextPage);
						loading = true;
					}
				}

			}, 200);
		});

		function load(nextPage){
			$.ajax({
				url: nextPage,
				beforeSend: function(){
					container.append($('<div style="text-align:center;" class="loading"><div class="loader"></div><br /><h3>Loading...</h3></div>'));
				},
				error: function(response){},
				success: function(response){
					setTimeout(function(){
						container.find('.loading').remove();
						container.append(response);
						loading = false;
					}, 200);
				}

			});
		}


	})
});

var onEventStop = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();
