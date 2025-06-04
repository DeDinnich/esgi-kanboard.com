<section id="accueil" class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                <h1 class="fw-bold mb-3">
                    KANBOARD :<br>
                    <span class="text-primary">Organisez, collaborez, réussissez !</span>
                </h1>
                <h2 class="fs-4 mb-4">
                    Créez des projets, organisez vos tâches et travaillez en équipe en toute simplicité.
                </h2>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    Essayer gratuitement
                </a>
            </div>

            <div class="col-md-6 text-center">
                <div class="banner-media position-relative">
                    <img src="{{ asset('images/preview.jpg') }}" alt="Aperçu Kanboard" class="img-fluid rounded shadow preview-img">
                    <video class="preview-video position-absolute top-0 start-0 w-100 h-100 rounded shadow" muted loop preload="none" style="display: none;">
                        <source src="{{ asset('videos/preview.mp4') }}" type="video/mp4">
                        Votre navigateur ne supporte pas la vidéo.
                    </video>
                </div>
            </div>
        </div>
    </div>
</section>
