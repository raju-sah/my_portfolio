<style>
    .cat-eyes-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: flex;
        gap: 15px;
        z-index: 9999;
        pointer-events: none; /* Let clicks pass through */
    }

    .cat-eye {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 50%;
        position: relative;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
        border: 2px solid var(--accent-color);
    }

    .cat-pupil {
        width: 12px;
        height: 12px;
        background: #000;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Dark mode adjustments if needed */
    [data-theme="dark"] .cat-eye {
        background: #e0e0e0;
    }
</style>

<div class="cat-eyes-container">
    <div class="cat-eye">
        <div class="cat-pupil"></div>
    </div>
    <div class="cat-eye">
        <div class="cat-pupil"></div>
    </div>
</div>

<script>
    document.addEventListener('mousemove', (e) => {
        const eyes = document.querySelectorAll('.cat-eye');
        
        eyes.forEach(eye => {
            const pupil = eye.querySelector('.cat-pupil');
            const eyeRect = eye.getBoundingClientRect();
            const eyeCenterX = eyeRect.left + eyeRect.width / 2;
            const eyeCenterY = eyeRect.top + eyeRect.height / 2;

            const angle = Math.atan2(e.clientY - eyeCenterY, e.clientX - eyeCenterX);
            const distance = Math.min(eyeRect.width / 4, Math.hypot(e.clientX - eyeCenterX, e.clientY - eyeCenterY));

            const pupilX = Math.cos(angle) * distance;
            const pupilY = Math.sin(angle) * distance;

            pupil.style.transform = `translate(calc(-50% + ${pupilX}px), calc(-50% + ${pupilY}px))`;
        });
    });
</script>
