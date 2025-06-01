    document.addEventListener('DOMContentLoaded', function () {
      const menuToggle = document.getElementById('mobile-menu');
      const navCenter = document.getElementById('nav-center');
      const icon = menuToggle.querySelector('i');

      menuToggle.addEventListener('click', function () {
        const isOpen = navCenter.classList.contains('active');
        navCenter.classList.toggle('active');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
      });
    });
