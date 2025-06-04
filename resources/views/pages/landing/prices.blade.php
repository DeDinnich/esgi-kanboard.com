@extends('layouts.landing')

@section('title', 'Nos forfaits')
@section('description', 'Découvrez nos formules adaptées à vos besoins et à la taille de votre équipe.')
@section('keywords', 'forfaits, prix, kanboard, gratuit, pro, entreprise')
@section('author', 'Kanboard Team')

@section('content')
<section class="min-vh-100 d-flex flex-column">
    <div class="container my-5 flex-grow-1">
        <h1 class="text-center mb-5">Des forfaits adaptés à vos besoins,<br>pour tous les projets et toutes les équipes</h1>

        @include('components.landing.prices.cards')
    </div>
</section>

@include('partials.landing.modals.payment')
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const plans = @json($plans);
        const features = @json($featuresList);

        document.querySelectorAll('.choose-plan').forEach(btn => {
            btn.addEventListener('click', () => {
                const selectedId = btn.dataset.plan;
                const plan = plans.find(p => p.id === selectedId);

                if (!plan) {
                    console.warn('Plan introuvable :', selectedId);
                    return;
                }

                document.getElementById('modalPlanTitle').textContent = plan.name;
                document.getElementById('modalPlanPrice').textContent = plan.price;

                const cardHTML = `
                    <div class="card h-100 shadow-sm">
                        <div class="card-header fw-bold fs-4 text-center">${plan.name}</div>
                        <div class="card-body">
                            <h2 class="text-center mb-4">${plan.price}</h2>
                            <ul class="list-unstyled fs-6">
                                ${features.map((feature, i) => `
                                    <li class="mb-2">
                                        <i class="fas ${plan.features[i] ? 'fa-check text-success' : 'fa-times text-danger'} me-2"></i>
                                        ${feature}
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    </div>
                `;

                document.getElementById('modal-plan-card').innerHTML = cardHTML;
                document.getElementById('selectedPlan').value = plan.id;
            });
        });
    });
</script>
@endsection
