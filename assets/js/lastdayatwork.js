document.getElementById('mobile-menu').addEventListener('click', function () {
  const navCenter = document.getElementById('nav-center');
  navCenter.classList.toggle('active');

  document.querySelector('header').classList.toggle('menu-open');
});
