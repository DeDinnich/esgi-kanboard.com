export default function initContactForm() {
    const form = document.querySelector('#contact form');
    const button = document.querySelector('#contact-submit-btn');
    const spinner = document.querySelector('#contact-spinner');

    if (!form || !button || !spinner) return;

    form.addEventListener('submit', () => {
        spinner.classList.remove('d-none');
        button.setAttribute('disabled', true);
    });
}
