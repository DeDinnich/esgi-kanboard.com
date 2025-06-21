export default function initBannerAutoplay() {
    const video = document.querySelector('.preview-video');
    if (!video) return;

    const observer = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting) {
                video.play().catch(err => console.warn('Play failed:', err));
            } else {
                video.pause();
            }
        },
        {
            threshold: 0.5, // vidéo lue si au moins 50% visible
        }
    );

    observer.observe(video);
}
