
    console.log("Custom JS loaded");
    function goLink(url) {

            const clickEffect = document.createElement('div');
            clickEffect.className = 'fixed inset-0 bg-primary/10 backdrop-blur-sm z-50 flex items-center justify-center pointer-events-none';
            clickEffect.innerHTML = '<div class="w-12 h-12 bg-primary rounded-full animate-ping"></div>';
            document.body.appendChild(clickEffect);

            setTimeout(() => {
                window.location.href = url;
            }, 250);

            setTimeout(() => {
                document.body.removeChild(clickEffect);
            }, 500);
        }


        document.addEventListener('mousemove', (e) => {
            const shapes = document.querySelectorAll('.shape');
            shapes.forEach((shape, index) => {
                const speed = (index + 1) * 0.01;
                const x = (e.clientX * speed);
                const y = (e.clientY * speed);
                shape.style.transform = `translate(${x}px, ${y}px)`;
            });
        });


        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.glass-card');
            cards.forEach((card, index) => {
                if (index > 0) {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    setTimeout(() => {
                        card.style.transition = 'all 0.6s ease-out';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 150 + 200);
                }
            });
        });


        document.querySelectorAll('.glass-card').forEach(card => {
            card.addEventListener('mouseenter', function(e) {
                const ripple = document.createElement('div');
                ripple.className = 'absolute inset-0 bg-primary/5 rounded-2xl opacity-0 pointer-events-none';
                ripple.style.animation = 'ripple 0.6s ease-out';
                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });


        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                0% { opacity: 0; transform: scale(0.8); }
                50% { opacity: 1; transform: scale(1.02); }
                100% { opacity: 0; transform: scale(1.05); }
            }
        `;
        document.head.appendChild(style);
