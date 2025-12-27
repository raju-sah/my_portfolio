<style>
    #container-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #sandCanvas {
        display: block;
    }

    @media (max-width: 600px) {
        #container-wrapper {
            margin: 20px 0;
            top: -55px;
            right: 70px;
        }
    }
</style>

<div id="container-wrapper">
    <canvas id="sandCanvas"></canvas>
</div>

<script>
    (function() {
        const canvas = document.getElementById('sandCanvas');
        const ctx = canvas.getContext('2d');
        let particlesArray = [];
        const word = 'Raju Sah';
        
        let mouse = {
            x: null,
            y: null,
            radius: 50
        };

        function setCanvasDimensions() {
            // Set canvas size matching the original design intent
            // Desktop: ~400x180, Mobile logic handled by JS resizing or fixed ratio
            if (window.innerWidth < 600) {
                 // Mobile dimensions from original CSS: 72.5vw x 18.5vw approximately
                 canvas.width = window.innerWidth * 0.725;
                 canvas.height = window.innerWidth * 0.185;
            } else {
                canvas.width = 700;
                canvas.height = 185;
            }
        }
        
        setCanvasDimensions();

        window.addEventListener('mousemove', function(event) {
            const rect = canvas.getBoundingClientRect();
            mouse.x = event.x - rect.left;
            mouse.y = event.y - rect.top;
        });
        
        // Handle touch events for mobile
        window.addEventListener('touchmove', function(event) {
            const rect = canvas.getBoundingClientRect();
            mouse.x = event.touches[0].clientX - rect.left;
            mouse.y = event.touches[0].clientY - rect.top;
        }, {passive: true});

        window.addEventListener('resize', function() {
            setCanvasDimensions();
            init();
        });

        window.addEventListener('mouseout', function() {
            mouse.x = null;
            mouse.y = null;
        });

        class Particle {
            constructor(x, y) {
                // Start from random position for initial animation
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = 1;
                this.baseX = x; // Final target position
                this.baseY = y;
                this.density = (Math.random() * 1000) + 1;
                this.color = '#d2691e';
                this.isForming = true; // Flag to track if still animating into position
            }

            draw() {
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.closePath();
                ctx.fill();
            }

            update() {
                // Initial formation animation
                if (this.isForming) {
                    let dx = this.baseX - this.x;
                    let dy = this.baseY - this.y;
                    this.x += dx * 0.05; // Animation speed (5% each frame)
                    this.y += dy * 0.05;
                    
                    // Check if close enough to target position
                    if (Math.abs(dx) < 0.5 && Math.abs(dy) < 0.5) {
                        this.x = this.baseX;
                        this.y = this.baseY;
                        this.isForming = false;
                    }
                    return; // Skip mouse interaction during formation
                }

                // Mouse interaction (only after formation complete)
                let dx = mouse.x - this.x;
                let dy = mouse.y - this.y;
                let distance = Math.sqrt(dx * dx + dy * dy);
                let forceDirectionX = dx / distance;
                let forceDirectionY = dy / distance;
                let maxDistance = mouse.radius;
                let force = (maxDistance - distance) / maxDistance;
                let directionX = forceDirectionX * force * this.density;
                let directionY = forceDirectionY * force * this.density;

                if (distance < mouse.radius) {
                    this.x -= directionX * 3; // Push strength
                    this.y -= directionY * 3;
                } else {
                    if (this.x !== this.baseX) {
                        let dx = this.x - this.baseX;
                        this.x -= dx / 10; // Return speed (easing)
                    }
                    if (this.y !== this.baseY) {
                        let dy = this.y - this.baseY;
                        this.y -= dy / 10;
                    }
                }
            }
        }

        function init() {
            particlesArray = [];
            // Draw text to canvas to get data
            ctx.clearRect(0,0, canvas.width, canvas.height); // clear for resize
            
            let fontSize = 70;
            if(window.innerWidth < 600) fontSize = 40; // Smaller font for mobile
            
            ctx.font = 'bold ' + fontSize + 'px Arial';
            ctx.fillStyle = 'white'; // Color doesn't matter for scanning, just needs to be non-transparent
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(word, canvas.width / 2, canvas.height / 2);

            const textCoordinates = ctx.getImageData(0, 0, canvas.width, canvas.height);
            
            // Scan pixel data
            // step logic to reduce density if needed, or scan every pixel
            // For performance, scanning every 2nd or 3rd pixel is often enough
            const step = 2; 

            for (let y = 0, y2 = textCoordinates.height; y < y2; y += step) {
                for (let x = 0, x2 = textCoordinates.width; x < x2; x += step) {
                    // Check alpha value (4th byte)
                    if (textCoordinates.data[(y * 4 * textCoordinates.width) + (x * 4) + 3] > 128) {
                        let positionX = x;
                        let positionY = y;
                        particlesArray.push(new Particle(positionX, positionY));
                    }
                }
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (let i = 0; i < particlesArray.length; i++) {
                particlesArray[i].draw();
                particlesArray[i].update();
            }
            requestAnimationFrame(animate);
        }

        init();
        animate();
    })();
</script>
