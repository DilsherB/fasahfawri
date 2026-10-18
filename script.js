function switchLanguage(lang) {
    const htmlElement = document.documentElement;
    if (lang === 'ar') {
        htmlElement.setAttribute('dir', 'rtl');
        htmlElement.setAttribute('lang', 'ar');
        localStorage.setItem('preferred_lang', 'ar');
        document.querySelectorAll('.lang-en').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.lang-ar').forEach(el => el.classList.remove('hidden'));
    } else {
        htmlElement.setAttribute('dir', 'ltr');
        htmlElement.setAttribute('lang', 'en');
        localStorage.setItem('preferred_lang', 'en');
        document.querySelectorAll('.lang-ar').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.lang-en').forEach(el => el.classList.remove('hidden'));
    }
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

window.addEventListener('DOMContentLoaded', () => {
    const savedLang = localStorage.getItem('preferred_lang') || 'en';
    switchLanguage(savedLang);
});