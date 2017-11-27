var working = false;
$('#login').on('submit',function() {
  e.preventDefault();
  if (working) return;
  working = true;
  var $this = $(this),
    $state = $this.find('button > .state');
  $this.addClass('loading');
  $state.html('Authenticating');

  setTimeout(function() {
    setTimeout(function() {
      $state.html('Log in');
      $this.removeClass('loading');
      working = false;
    }, 4000);
  }, 3000);

});
