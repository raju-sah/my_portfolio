<div id="parallax-container" class="fixed inset-0 pointer-events-none z-[-1] overflow-hidden">
    <!-- Circle Top Left -->
    <svg class="parallax-layer absolute top-10 left-10 opacity-10 w-32 h-32 md:w-64 md:h-64 text-heading" data-speed="2" viewBox="0 0 100 100" fill="currentColor">
        <circle cx="50" cy="50" r="40" />
    </svg>
    
    <!-- Triangle Right -->
    <svg class="parallax-layer absolute top-1/3 right-10 opacity-5 w-24 h-24 md:w-48 md:h-48 text-heading" data-speed="-1.5" viewBox="0 0 100 100" fill="currentColor">
        <polygon points="50,15 90,85 10,85" />
    </svg>

    <!-- Square Bottom Left -->
    <svg class="parallax-layer absolute bottom-20 left-1/4 opacity-10 w-20 h-20 md:w-40 md:h-40 text-accent" data-speed="1" viewBox="0 0 100 100" fill="currentColor">
        <rect x="20" y="20" width="60" height="60" rx="4" />
    </svg>

    <!-- Blob Bottom Right -->
    <svg class="parallax-layer absolute bottom-10 right-20 opacity-10 w-40 h-40 md:w-80 md:h-80 text-heading" data-speed="-2" viewBox="0 0 200 200" fill="currentColor">
         <path d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,79.6,-46.9C87.4,-34.7,90.1,-20.4,86.9,-7.1C83.7,6.2,74.6,18.5,65.3,29.3C56,40.1,46.5,49.4,35.7,56.7C24.9,64,12.8,69.3,-0.7,70.5C-14.2,71.7,-27.1,68.8,-37.9,61.4C-48.7,54,-57.4,42.1,-65.6,29.2C-73.8,16.3,-81.5,2.4,-78.3,-9.6C-75.1,-21.6,-61,-31.7,-49.2,-40.1C-37.4,-48.5,-27.9,-55.2,-17.6,-61.8C-7.4,-68.4,3.6,-74.9,15.7,-78.9C27.8,-82.9,41,-84.4,44.7,-76.4Z" transform="translate(100 100)" />
    </svg>
    
    <!-- Code Bracket Center (faint) -->
    <svg class="parallax-layer absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-5 w-96 h-96 text-heading" data-speed="0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
       <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 18" />
    </svg>
</div>

<script>
    document.addEventListener('mousemove', (e) => {
        const layers = document.querySelectorAll('.parallax-layer');
        const x = (window.innerWidth - e.pageX * 2) / 100;
        const y = (window.innerHeight - e.pageY * 2) / 100;

        layers.forEach(layer => {
            const speed = layer.getAttribute('data-speed');
            const xPos = x * speed;
            const yPos = y * speed;
            layer.style.transform = `translateX(${xPos}px) translateY(${yPos}px)`;
        });
    });
</script>
