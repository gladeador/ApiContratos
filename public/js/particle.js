document.addEventListener("DOMContentLoaded", function () {
    const particleContainer = document.querySelector(".particles-container");

    for (let i = 0; i < 50; i++) {
        const particle = document.createElement("div");
        particle.className = "particle";
        particleContainer.appendChild(particle);
        animateParticle(particle);
    }
});

function animateParticle(particle) {
    const animationDuration = Math.random() * (1.5 - 1) + 1; // Random duration between 1 and 1.5 seconds
    const startPosition = Math.random() * window.innerWidth;

    particle.style.animation = `particleAnimation ${animationDuration}s linear infinite`;
    particle.style.left = `${startPosition}px`;
}

