jQuery(function($) {
  $(document).ready(function(){
  let $els = $('.project'), $curr ;

    $('.filter').on('click', function() {
      var $this = $(this);
      $('.active').removeClass('active');
      $this.addClass('active');
      $curr = $els.filter('.' + this.id).fadeOut();
      $curr.slice(0, 10).fadeIn();
      $els.not($curr).fadeOut();
    }).filter('.active');
  });
});