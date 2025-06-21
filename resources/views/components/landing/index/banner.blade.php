<section id="accueil" class="py-5 mt-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7 text-center text-md-start mb-4 mb-md-0">
                <h1 class="fw-bold mb-3 text-center text-md-start">
                    KANBOARD : Organisez, collaborez, réussissez !<br>
                </h1>
                <h2 class="fs-4 mb-4">
                    Créez des projets, organisez vos tâches et travaillez en équipe en toute simplicité.
                </h2>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    Essayer gratuitement
                </a>
            </div>

            <div class="col-md-5 text-center">
                <div class="banner-media position-relative rounded overflow-hidden shadow">
                    <video class="preview-video w-100 h-auto rounded" muted loop preload="metadata">
                        <source src="{{ asset('videos/preview.mp4') }}" type="video/mp4">
                        Votre navigateur ne supporte pas la vidéo.
                    </video>
                </div>
            </div>
        </div>
    </div>
</section>
