/* Editorial Sticky Affix */

$(function()
{
  var $stickyElement = $('.panel-affix');
  var $bottomElement = $('.module');
  if ($stickyElement.length)
  {
    $stickyElement.each(function()
    {
      var fromTop = $(this).offset().top;
      var docHeight = $(document).height();
      var outerHeight = $(this).outerHeight();
      var fromBottom = docHeight - (fromTop + outerHeight);
      var elemHeight = $(this).height();
      var elemWidth = $(this).width();
      var stopOn = docHeight - ($bottomElement.offset().top) + (outerHeight - elemHeight);
      if ((fromBottom - stopOn) > 200)
      {
        $(this).css('width', elemWidth)
               .css('top', 80)
               .css('position', '')
               .affix(
                {
                  offset:
                  {
                    top: fromTop - 80,
                    bottom: stopOn
                  }
                })
              .on('affix.bs.affix', function ()
                {
                  $(this).css('top', '80px').css('position', '');
                });
      }
      $(window).trigger('scroll');
    });
  }
});

$(function()
{
  $('body').scrollspy(
  {
      offset: 180
  });

  $('a[href*="#"]:not([href="#"])').click(function()
  {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname)
    {
      var hashName = this.hash;
      var $target = $(hashName);
      $target = $target.length ? $target : $('[name=' + hashName.slice(1) + ']');
      if ($target.length)
      {
        $('html,body').animate(
        {
          scrollTop: $target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
