<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="paymentModalLabel">
                    Paiement de la formule <span id="modalPlanTitle" class="text-uppercase text-primary"></span> d'une valeur de <span id="modalPlanPrice" class="text-success"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Colonne carte -->
                    <div class="col-md-5" id="modal-plan-card">
                        {{-- Carte remplie dynamiquement --}}
                    </div>

                    <!-- Colonne formulaire -->
                    <div class="col-md-7">
                        <form action="{{ route('stripe.pay') }}" method="POST" id="payment-form">
                            @csrf
                            <input type="hidden" name="plan" id="selectedPlan">

                            <div class="mb-3">
                                <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div id="card-element" class="mb-3"></div>
                            <div id="card-errors" class="text-danger"></div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success w-100 mb-3 d-flex justify-content-center align-items-center" id="submit-button">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="submit-spinner" aria-hidden="true"></span>
                                    <span id="submit-text">Payer</span>
                                </button>
                            </div>

                            <div class="alert alert-light small text-muted">
                                <strong>Paiement 100% sécurisé</strong> via Stripe. <br>
                                Nous nous engageons à ne jamais utiliser vos données personnelles à d'autres fins. <br>
                                Vous recevrez immédiatement un <strong>email de confirmation</strong> contenant un lien sécurisé pour accéder à votre espace client.
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
