$(function() {
  $(document).scroll(function() {
    var $nav = $('.navbar-fixed-top')
    var $navBrands = $('.navbar-brand')
    var $navLinks = $('.navbar-link')

    var isScrolled = $(this).scrollTop() > $nav.height()

    $nav.toggleClass('scrolled', isScrolled)
    $navBrands.toggleClass('scrolled', isScrolled)
    $navLinks.toggleClass('scrolled', isScrolled)
  })
})