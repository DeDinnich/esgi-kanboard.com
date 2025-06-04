export default function initBannerHoverVideo() {
    const container = document.querySelector('.banner-media');
    if (!container) return;

    const img = container.querySelector('.preview-img');
    const video = container.querySelector('.preview-video');

    container.addEventListener('mouseenter', () => {
        img.style.display = 'none';
        video.style.display = 'block';
        video.currentTime = 0;
        video.play();
    });

    container.addEventListener('mouseleave', () => {
        video.pause();
        video.style.display = 'none';
        img.style.display = 'block';
    });
}
