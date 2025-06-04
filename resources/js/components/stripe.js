import { loadStripe } from '@stripe/stripe-js';

export default async function initStripePayment() {
    const form = document.getElementById('payment-form');
    if (!form) return;

    const stripe = await loadStripe(import.meta.env.VITE_STRIPE_PUBLIC_KEY);
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const submitBtn = document.getElementById('submit-button');
    const spinner = document.getElementById('submit-spinner');
    const text = document.getElementById('submit-text');
    const cardErrors = document.getElementById('card-errors');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Activer le loading
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');
        text.textContent = 'Traitement...';
        cardErrors.textContent = '';

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: formData,
            });

            const result = await response.json();

            if (result.clientSecret) {
                const { error, paymentIntent } = await stripe.confirmCardPayment(result.clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: formData.get('prenom') + ' ' + formData.get('nom'),
                            email: formData.get('email'),
                        },
                    }
                });

                if (error) {
                    cardErrors.textContent = error.message;
                } else if (paymentIntent.status === 'succeeded') {
                    // Appel à /stripe/confirm
                    const confirmResponse = await fetch('/stripe/confirm', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                        body: JSON.stringify({
                            prenom: formData.get('prenom'),
                            nom: formData.get('nom'),
                            email: formData.get('email'),
                            plan: formData.get('plan'),
                        }),
                    });

                    const confirmResult = await confirmResponse.json();

                    if (confirmResult.success) {
                        form.innerHTML = `<div class="alert alert-success">Paiement réussi !<br>Un compte a été créé et vos identifiants vous ont été envoyés par mail.</div>`;
                    } else {
                        cardErrors.textContent = confirmResult.error || 'Erreur lors de la confirmation du compte.';
                    }
                }
            } else {
                cardErrors.textContent = result.error || 'Erreur serveur, veuillez réessayer.';
            }
        } catch (err) {
            cardErrors.textContent = 'Une erreur est survenue. Veuillez réessayer.';
            console.error(err);
        }

        // Réactiver le bouton
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        text.textContent = 'Payer';
    });
}
