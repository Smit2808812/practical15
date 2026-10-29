document.addEventListener('DOMContentLoaded', () => {

const toggle = document.getElementById('menu-toggle');
const nav = document.getElementById('main-nav');

if (toggle && nav) {
toggle.addEventListener('click', () => {
nav.classList.toggle('open');
});
}

document.querySelectorAll('.faq-question').forEach(button => {

button.addEventListener('click', () => {
button.closest('.faq-item').classList.toggle('open');
});

});

document.querySelectorAll('[data-confirm]').forEach(el => {

el.addEventListener('click', e => {

if (!confirm(el.dataset.confirm || 'Are you sure?')) {
e.preventDefault();
}

});

});

});
