/*==============================================================
PROJETO SEMENTE
MAIN.JS — v1.1
==============================================================*/

const header = document.getElementById('header');
const btnMenu = document.getElementById('btn-menu');
const menu = document.getElementById('menu');
const contadores = document.querySelectorAll('.contador');

window.addEventListener('scroll', () => {
    header.classList.toggle('active', window.scrollY > 50);
});

btnMenu.addEventListener('click', () => {
    menu.classList.toggle('aberto');
    const aberto = menu.classList.contains('aberto');
    btnMenu.setAttribute('aria-expanded', aberto);
    btnMenu.innerHTML = aberto ? '<i class="bi bi-x-lg"></i>' : '<i class="bi bi-list"></i>';
    
    if (aberto) header.classList.add('active');
    else if (window.scrollY <= 50) header.classList.remove('active');
});

menu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        menu.classList.remove('aberto');
        btnMenu.setAttribute('aria-expanded', 'false');
        btnMenu.innerHTML = '<i class="bi bi-list"></i>';
    });
});

const atualizarContador = (el) => {
    const alvo = parseInt(el.dataset.target);
    let atual = 0;
    const passo = alvo / 100;
    const intervalo = setInterval(() => {
        atual += passo;
        if (atual >= alvo) {
            el.innerText = alvo;
            clearInterval(intervalo);
        } else {
            el.innerText = Math.floor(atual);
        }
    }, 20);
};

new IntersectionObserver((entradas) => {
    entradas.forEach(e => {
        if (e.isIntersecting) {
            atualizarContador(e.target);
            e.target.style.opacity = '1';
        }
    });
}, { threshold: 0.5 }).observe(document.querySelector('.numeros'));

document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const alvo = document.querySelector(link.getAttribute('href'));
        if (alvo) {
            const offset = header.offsetHeight;
            window.scrollTo({
                top: alvo.offsetTop - offset,
                behavior: 'smooth'
            });
        }
    });
});