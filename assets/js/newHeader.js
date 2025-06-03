document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.getElementById('mobile-menu');
  const navCenter = document.getElementById('nav-center');
  const header = document.querySelector('header');
  const icon = menuToggle.querySelector('i');

  menuToggle.addEventListener('click', function() {
    const isOpen = navCenter.classList.contains('active');
    navCenter.classList.toggle('active');
    header.classList.toggle('menu-active');
    icon.classList.toggle('fa-bars');
    icon.classList.toggle('fa-times');
  });
});