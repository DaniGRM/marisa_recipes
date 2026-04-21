<div id="screensaver" style="display: none">
    <video id="bmoVideo" class="w-100" muted loop playsinline preload="auto">
        <source src="bmo-loop.mp4" type="video/mp4">
    </video>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const video = document.getElementById('bmoVideo');

        // Precargar aunque esté oculto
        video.load();

        const screensaver = document.getElementById('screensaver');
        const observer = new MutationObserver(() => {
            if (screensaver.style.display !== 'none') {
                video.play().catch(() => {
                    document.addEventListener('click', () => video.play(), { once: true });
                });
            }
        });

        observer.observe(screensaver, { attributes: true, attributeFilter: ['style'] });
    });
</script>