<div class="row justify-content-center">
    @foreach ($plans as $plan)
        @php
            $isActive = $plan->id === $activePlanId;
        @endphp
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm {{ $isActive ? 'border-primary border-2' : '' }}">
                <div class="card-header text-center fw-bold fs-4 {{ $isActive ? 'bg-primary text-white' : '' }}">
                    {{ $plan->name }}
                    @if ($isActive)
                        <span class="badge bg-success ms-2">Plan actuel</span>
                    @endif
                </div>
                <div class="card-body text-center">
                    <h2 class="mb-4">{{ number_format($plan->price, 2) }}€</h2>
                    <ul class="list-unstyled text-start">
                        @foreach ($featuresList as $i => $feature)
                            @php $option = 'option' . ($i + 1); @endphp
                            <li class="mb-2">
                                <i class="fas {{ $plan->$option ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    @if ($isActive)
                        <button class="btn btn-outline-success mt-4 w-100" disabled>Actif</button>
                    @else
                        <div class="d-grid gap-2">
                            <button
                                class="btn btn-primary w-100 choose-plan"
                                data-plan-id="{{ $plan->id }}"
                            >
                                Choisir
                            </button>
                            <div class="alert alert-info mt-3 d-none" id="alert-{{ $plan->id }}">
                                Ce n'est pas dans les consignes donc je ne m'y attarde pas, mais la fonctionnalité de paiement fonctionnel a été faite dans la landing page.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
