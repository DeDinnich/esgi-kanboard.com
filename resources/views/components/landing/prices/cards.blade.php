<div class="row justify-content-center">
    @foreach ($rawPlans as $plan)
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-header fw-bold fs-4">
                    {{ $plan->name }}
                </div>
                <div class="card-body">
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
                    <button
                        class="btn btn-primary mt-4 choose-plan"
                        @if ((float) $plan->price === 0.0)
                            onclick="window.location='{{ route('register') }}'"
                        @else
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal"
                            data-plan="{{ $plan->id }}"
                        @endif
                    >
                        Choisir
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
