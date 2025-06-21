<section id="solution" class="py-5">
    <div class="container">
        {{-- Bloc 1 : Image gauche + texte droite --}}
        <div class="row align-items-center mb-5">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img src="{{ asset('images/temp.png') }}" alt="Créer un projet" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-8">
                <h3 class="mb-3">Créez et gérez vos projets en toute simplicité</h3>
                <ul class="list-unstyled fs-5">
                    <li><i class="fas fa-check-circle text-success me-2"></i>Démarrez un projet en quelques clics</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Définissez vos objectifs et ajoutez des tâches</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Suivez l’avancement de vos projets en un seul endroit</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Glissez-déposez simplement vos tâches d’une colonne à l’autre</li>
                </ul>
            </div>
        </div>

        {{-- Bloc 2 : Texte gauche + image droite --}}
        <div class="row align-items-center mb-5 flex-md-row-reverse">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img src="{{ asset('images/temp.png') }}" alt="Collaboration équipe" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-8">
                <h3 class="mb-3">Collaborez facilement avec votre équipe</h3>
                <ul class="list-unstyled fs-5">
                    <li><i class="fas fa-check-circle text-success me-2"></i>Invitez facilement vos collègues à rejoindre un projet</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Assignez des tâches à chaque membre de l’équipe</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Suivez les progrès en temps réel</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i>Échangez des commentaires et partagez des fichiers</li>
                </ul>
            </div>
        </div>

        {{-- Bloc 3 : Centré --}}
        <div class="text-center mb-4">
            <h3>Adaptez la vue à votre façon de travailler</h3>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img src="{{ asset('images/temp.png') }}" alt="Changer de vue" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6 fs-5">
                <p>
                    Passez facilement entre les vues Kanban, Liste et Calendrier pour gérer vos tâches de la manière qui vous convient le mieux et visualiser votre projet sous différents angles.
                </p>
            </div>
        </div>
    </div>
</section>
