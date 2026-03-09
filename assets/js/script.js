// Мобильное меню
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // Анимация гамбургера
            const spans = this.querySelectorAll('span');
            spans.forEach(span => span.classList.toggle('active'));
        });
    }
    
    // Слайд-шоу
    let slideIndex = 1;
    let slideTimer;
    
    function showSlides(n) {
        const slides = document.getElementsByClassName("slide");
        const dots = document.getElementsByClassName("dot");
        
        if (slides.length === 0) return;
        
        if (n > slides.length) slideIndex = 1;
        if (n < 1) slideIndex = slides.length;
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
            slides[i].style.opacity = "0";
        }
        
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        
        slides[slideIndex-1].style.display = "block";
        setTimeout(() => {
            slides[slideIndex-1].style.opacity = "1";
        }, 50);
        dots[slideIndex-1].className += " active";
        
        // Автоматическое переключение
        clearTimeout(slideTimer);
        slideTimer = setTimeout(() => {
            changeSlide(1);
        }, 5000);
    }
    
    window.changeSlide = function(n) {
        showSlides(slideIndex += n);
    }
    
    window.currentSlide = function(n) {
        showSlides(slideIndex = n);
        clearTimeout(slideTimer);
        slideTimer = setTimeout(() => {
            changeSlide(1);
        }, 5000);
    }
    
    // Запуск слайд-шоу
    showSlides(slideIndex);
    
    // Переключение вида товаров
    const viewBtns = document.querySelectorAll('.view-btn');
    const gridView = document.getElementById('grid-view');
    const tableView = document.getElementById('table-view');
    
    if (viewBtns.length > 0 && gridView && tableView) {
        const savedView = localStorage.getItem('shopView') || 'grid';
        
        if (savedView === 'grid') {
            gridView.classList.add('active');
            tableView.classList.remove('active');
            viewBtns[0].classList.add('active');
            viewBtns[1].classList.remove('active');
        } else {
            gridView.classList.remove('active');
            tableView.classList.add('active');
            viewBtns[0].classList.remove('active');
            viewBtns[1].classList.add('active');
        }
        
        viewBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const view = this.dataset.view;
                
                viewBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                if (view === 'grid') {
                    gridView.classList.add('active');
                    tableView.classList.remove('active');
                    localStorage.setItem('shopView', 'grid');
                } else {
                    gridView.classList.remove('active');
                    tableView.classList.add('active');
                    localStorage.setItem('shopView', 'table');
                }
            });
        });
    }
    
    // Добавление в корзину
    const addToCartButtons = document.querySelectorAll('.add-to-cart, .add-to-cart-large');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            let quantity = 1;
            
            const quantityInput = this.closest('.product-actions')?.querySelector('.quantity-input') || 
                                  this.closest('.product-footer')?.querySelector('.quantity-input');
            
            if (quantityInput) {
                quantity = quantityInput.value;
            }
            
            addToCart(productId, quantity, this);
        });
    });
    
    function addToCart(productId, quantity, button) {
        const originalText = button ? button.textContent : '';
        if (button) {
            button.textContent = '...';
            button.disabled = true;
        }
        
        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=add&product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.text())
        .then(() => {
            updateCartCount();
            showNotification('✓ Товар добавлен в корзину', 'success');
            
            // Анимация корзины
            const cartIcon = document.querySelector('.cart-link');
            if (cartIcon) {
                cartIcon.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    cartIcon.style.transform = 'scale(1)';
                }, 200);
            }
        })
        .catch(error => {
            showNotification('✗ Ошибка при добавлении', 'error');
        })
        .finally(() => {
            if (button) {
                button.textContent = originalText;
                button.disabled = false;
            }
        });
    }
    
    // Обновление счетчика корзины
    function updateCartCount() {
        fetch('get_cart_count.php')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.count;
                
                cartCount.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    cartCount.style.transform = 'scale(1)';
                }, 200);
            }
        });
    }
    
    // Уведомления
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        
        if (type === 'error') {
            notification.style.background = '#c62828';
        }
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Обработка количества
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    
    quantityBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input, .cart-quantity-input');
            if (!input) return;
            
            let value = parseInt(input.value);
            const max = parseInt(input.max) || 99;
            
            if (this.classList.contains('minus') && value > 1) {
                input.value = value - 1;
            } else if (this.classList.contains('plus') && value < max) {
                input.value = value + 1;
            }
            
            const cartId = this.dataset.cartId;
            if (cartId) {
                updateCartQuantity(cartId, input.value);
            }
        });
    });
    
    function updateCartQuantity(cartId, quantity) {
        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=update&cart_id=${cartId}&quantity=${quantity}`
        })
        .then(() => {
            location.reload();
        });
    }
    
    // Форма обратной связи
    const feedbackForm = document.getElementById('feedbackForm');
    
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Отправка...';
            submitBtn.disabled = true;
            
            const formData = new FormData(this);
            
            fetch('send_feedback.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('✓ Сообщение отправлено!', 'success');
                    this.reset();
                } else {
                    showNotification('✗ Ошибка отправки', 'error');
                }
            })
            .catch(() => {
                showNotification('✗ Ошибка отправки', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
    
    // Анимация при скролле
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.feature-card, .category-card, .product-card, .team-member, .value-card');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight - 100;
            
            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Устанавливаем начальные стили для анимации
    const animatedElements = document.querySelectorAll('.feature-card, .category-card, .product-card, .team-member, .value-card');
    animatedElements.forEach(element => {
        if (!element.classList.contains('no-animate')) {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        }
    });
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll();
    
    // Плавная прокрутка для якорных ссылок
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Валидация форм
    const authForms = document.querySelectorAll('.auth-form');
    authForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const password = this.querySelector('input[type="password"]');
            const confirmPassword = this.querySelector('input[name="confirm_password"]');
            
            if (password && confirmPassword) {
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    showNotification('✗ Пароли не совпадают', 'error');
                }
            }
        });
    });
    
    // Обновление счетчика при загрузке
    updateCartCount();
});