$(document).ready(function() {
  Galleria.setHeight = function() {
    $('#galleria').css('width', window.innerWidth + 'px');
    $('#galleria').css('height', window.innerHeight + 'px');
  };
  Galleria.setHeight();
  Galleria.loadTheme('//cdnjs.cloudflare.com/ajax/libs/galleria/1.4.2/themes/classic/galleria.classic.min.js');
  Galleria.run('#galleria', galleria_config);

  $(window).resize(function() {
    Galleria.setHeight();
  });
});
