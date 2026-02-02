<style>
    .cat-eyes-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        display: flex;
        gap: 15px;
        z-index: 9999;
    }

    .cat-eye {
        width: 35px;
        height: 35px;
        background: #fff;
        border-radius: 50%;
        position: relative;
        overflow: visible; /* Changed to visible for tooltip */
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
        border: 2px solid var(--accent-color);
        pointer-events: auto;
        cursor: pointer;
    }

    .cat-eye::before {
        content: attr(data-tooltip);
        position: absolute;
        top: 50%;
        right: 100%;
        transform: translateY(-50%) translateX(-15px);
        padding: 8px 12px;
        background: rgba(25, 25, 30, 0.97);
        color: #ff6b5b;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
        border-radius: 8px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 10000;
        pointer-events: none;
        border: 1px solid rgba(207, 63, 54, 0.25);
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }

    .cat-eye:hover::before {
        opacity: 1;
        visibility: visible;
        transform: translateY(-50%) translateX(-10px);
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
    <div class="cat-eye" data-tooltip="👀 I can't take my eyes off you, cutie pie! ">
        <div class="cat-pupil"></div>
    </div>
    <div class="cat-eye" data-tooltip="🫰 Here is my heart for you!">
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
