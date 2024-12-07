const header = document.querySelector('.custom-header');
        const menuIcon = document.querySelector('#menu-icon');
        const navbar = document.querySelector('.custom-navbar');
        let lastScrollY = 0;
        let isNavVisible = true;

        menuIcon.addEventListener('click', () => {
            menuIcon.classList.toggle('bx-x');
            navbar.classList.toggle('active');
        });

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;

            // Cambiar color del navbar
            if (currentScrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            // Ocultar/mostrar navbar
            if (currentScrollY > lastScrollY && isNavVisible) {
                header.style.transform = `translateY(-${header.offsetHeight}px)`;
                isNavVisible = false;
            } else if (currentScrollY < lastScrollY && !isNavVisible) {
                header.style.transform = 'translateY(0)';
                isNavVisible = true;
            }

            lastScrollY = currentScrollY;
        });

        // Cerrar menú al hacer clic en un enlace (para móviles)
        document.querySelectorAll('.custom-navbar a').forEach(link => {
            link.addEventListener('click', () => {
                navbar.classList.remove('active');
                menuIcon.classList.remove('bx-x');
            });
        });
        
        //script de los servicios y paquetes
            