<style>
    #container-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #sandContainer {
        position: relative;
        width: 400px;
        height: 180px;
        cursor: default;
    }

    .sand-particle {
        position: absolute;
        width: 0.2px;
        height: 0.2px;
        background-color: #d2691e;
        border-radius: 50%;
    }

    @media (max-width: 600px) {
        #container-wrapper {
            position: relative;
            top: -55px;
            right: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        #sandContainer {
            width: 72.5vw;
            height: 18.5vw;
        }

        .sand-particle {
            width: 0.09px;
            height: 0.09px;
        }
    }
</style>

<div id="container-wrapper">
    <div id="sandContainer" class=""></div>
</div>

<script>
    const container = document.getElementById('sandContainer');
    const word = 'Raju Sah';
    const particlesPerLetter = 650;
    let particles = [];
    let isScattered = false;

    function createParticles() {
        container.innerHTML = '';
        particles = [];

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 430;
        canvas.height = 200;
        ctx.font = 'bold 70px Arial';
        ctx.fillStyle = 'black';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(word, canvas.width / 2, canvas.height / 2);

        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const pixels = imageData.data;

        for (let i = 0; i < pixels.length; i += 4) {
            if (pixels[i + 3] > 0) {
                const x = (i / 4) % canvas.width;
                const y = Math.floor((i / 4) / canvas.width);
                particles.push({
                    x,
                    y,
                    originalX: x,
                    originalY: y
                });
            }
        }

        particles = particles
            .sort(() => 0.5 - Math.random())
            .slice(0, word.length * particlesPerLetter);

        particles.forEach((particle) => {
            const div = document.createElement('div');
            div.classList.add('sand-particle');
            div.style.left = `${particle.x}px`;
            div.style.top = `${particle.y}px`;
            container.appendChild(div);
            particle.element = div;
        });
    }

    function scatterParticles() {
        if (!isScattered) {
            isScattered = true;
            const scatteredParticles = [];
            const scatterAmount = particlesPerLetter * 5;

            for (let i = 0; i < scatterAmount; i++) {
                const randomParticle = particles[Math.floor(Math.random() * particles.length)];
                const newParticle = {
                    x: randomParticle.x + Math.random() * 40 - 20,
                    y: randomParticle.y + Math.random() * 40 - 20,
                    originalX: randomParticle.originalX,
                    originalY: randomParticle.originalY
                };
                scatteredParticles.push(newParticle);

                const div = document.createElement('div');
                div.classList.add('sand-particle');
                div.style.left = `${newParticle.x}px`;
                div.style.top = `${newParticle.y}px`;
                container.appendChild(div);
                newParticle.element = div;
            }

            particles = particles.concat(scatteredParticles);
        }
    }

    function resetParticles() {
        if (isScattered) {
            isScattered = false;
            particles.forEach((particle, index) => {
                if (index < word.length * particlesPerLetter) {
                    particle.x = particle.originalX;
                    particle.y = particle.originalY;
                    particle.element.style.transform = 'translate(0px, 0px)';
                } else {
                    container.removeChild(particle.element);
                }
            });
            particles = particles.slice(0, word.length * particlesPerLetter);
        }
    }

    function interactWithParticles(mouseX, mouseY) {
        const interactionRadius = 70;
        const pushStrength = 40;

        particles.forEach(particle => {
            const dx = particle.x - mouseX;
            const dy = particle.y - mouseY;
            const distance = Math.sqrt(dx * dx + dy * dy);
            if (distance < interactionRadius) {
                const angle = Math.atan2(dy, dx);
                const force = (interactionRadius - distance) / interactionRadius;
                const moveX = Math.cos(angle) * force * pushStrength;
                const moveY = Math.sin(angle) * force * pushStrength;

                particle.x += moveX;
                particle.y += moveY;
                particle.element.style.transform =
                    `translate(${particle.x - particle.originalX}px, ${particle.y - particle.originalY}px)`;
            }
        });
    }

    createParticles();

    container.addEventListener('mouseenter', scatterParticles);
    container.addEventListener('mouseleave', resetParticles);
    container.addEventListener('mousemove', (e) => {
        const rect = container.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const mouseY = e.clientY - rect.top;
        interactWithParticles(mouseX, mouseY);
    });
</script>
