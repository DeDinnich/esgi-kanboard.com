<section id="contact" class="py-5 bg-light">
    <div class="container">
        <h3 class="text-center mb-4">Contactez-nous</h3>

        @include('components.alerts')

        <form method="POST" action="{{ route('contact.send') }}" class="mx-auto" style="max-width: 700px;">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" placeholder="Nom" value="{{ old('nom') }}" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" placeholder="Prénom" value="{{ old('prenom') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <input type="text" name="objet" class="form-control @error('objet') is-invalid @enderror" placeholder="Objet" value="{{ old('objet') }}" required>
            </div>

            <div class="mb-3">
                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="Votre message..." required>{{ old('message') }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">Envoyer</button>
            </div>
        </form>
    </div>
</section>
