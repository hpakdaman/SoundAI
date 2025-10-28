<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(251, 191, 36, 0.5); }
            50% { box-shadow: 0 0 40px rgba(251, 191, 36, 0.8); }
        }

        @keyframes wave {
            0% { transform: rotate(0deg); }
            10% { transform: rotate(14deg); }
            20% { transform: rotate(-8deg); }
            30% { transform: rotate(14deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(10deg); }
            60% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .wave-animation {
            animation: wave 2s ease-in-out;
            transform-origin: 70% 70%;
            display: inline-block;
        }

        .gradient-text {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .music-note {
            position: absolute;
            font-size: 2rem;
            opacity: 0.1;
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen flex items-center justify-center overflow-hidden relative">

    <!-- Floating Music Notes Background -->
    <div class="music-note" style="top: 10%; left: 10%; animation-delay: 0s;">🎵</div>
    <div class="music-note" style="top: 20%; right: 15%; animation-delay: 1s;">🎶</div>
    <div class="music-note" style="bottom: 20%; left: 20%; animation-delay: 2s;">🎼</div>
    <div class="music-note" style="bottom: 10%; right: 10%; animation-delay: 1.5s;">🎹</div>
    <div class="music-note" style="top: 50%; left: 5%; animation-delay: 0.5s;">🎸</div>
    <div class="music-note" style="top: 60%; right: 5%; animation-delay: 2.5s;">🎤</div>

    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">

        <!-- 404 Number with Animation -->
        <div class="float-animation mb-8">
            <h1 class="text-9xl md:text-[12rem] font-bold gradient-text mb-4 leading-none">
                404
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-8">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">
                Oops! This Page Hit a Wrong Note
            </h2>
            <p class="text-xl md:text-2xl text-gray-400 mb-2">
                The page you're looking for seems to have gone off-key...
            </p>
            <p class="text-lg text-gray-500">
                Don't worry, even the best composers make mistakes!
            </p>
        </div>

        <!-- Musical Divider -->
        <div class="flex items-center justify-center gap-4 my-8">
            <div class="h-px bg-gradient-to-r from-transparent via-amber-500 to-transparent w-32"></div>
            <span class="text-4xl">🎵</span>
            <div class="h-px bg-gradient-to-r from-transparent via-amber-500 to-transparent w-32"></div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8">
            <a href="{{ url('/') }}"
               class="group relative inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-full font-semibold text-lg transition-all duration-300 hover:scale-105 pulse-glow hover:shadow-2xl">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>

            <button onclick="history.back()"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-gray-800 text-gray-300 rounded-full font-semibold text-lg transition-all duration-300 hover:bg-gray-700 hover:text-white hover:scale-105 border border-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"/>
                </svg>
                Go Back
            </button>
        </div>

        <!-- Quick Links -->
        <div class="mt-12 p-6 bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-gray-700">
            <p class="text-gray-400 mb-4 font-semibold">Quick Links:</p>
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="{{ url('/') }}" class="px-4 py-2 bg-gray-700/50 text-gray-300 rounded-lg hover:bg-amber-600 hover:text-white transition-colors duration-300">
                    Home
                </a>
                <a href="{{ url('/blog') }}" class="px-4 py-2 bg-gray-700/50 text-gray-300 rounded-lg hover:bg-amber-600 hover:text-white transition-colors duration-300">
                    Blog
                </a>
                <a href="{{ url('/contact') }}" class="px-4 py-2 bg-gray-700/50 text-gray-300 rounded-lg hover:bg-amber-600 hover:text-white transition-colors duration-300">
                    Contact Us
                </a>
            </div>
        </div>

        <!-- Fun Message with Waving Hand -->
        <div class="mt-8 text-gray-500">
            <p class="text-sm">
                Need help? <a href="{{ url('/contact') }}" class="text-amber-500 hover:text-amber-400 underline">Get in touch</a>
            </p>
            <p class="mt-2 text-xs">
                Error Code: 404 | Keep composing your masterpiece! <span class="wave-animation">👋</span>
            </p>
        </div>

    </div>

    <!-- Interactive Particles Effect -->
    <canvas id="particlesCanvas" class="absolute inset-0 pointer-events-none"></canvas>

    <script>
        // Particle animation
        const canvas = document.getElementById('particlesCanvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        const particleCount = 50;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.radius = Math.random() * 2 + 1;
                this.opacity = Math.random() * 0.5 + 0.2;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(251, 191, 36, ${this.opacity})`;
                ctx.fill();
            }
        }

        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            // Draw connections
            particles.forEach((p1, i) => {
                particles.slice(i + 1).forEach(p2 => {
                    const dx = p1.x - p2.x;
                    const dy = p1.y - p2.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < 150) {
                        ctx.beginPath();
                        ctx.strokeStyle = `rgba(251, 191, 36, ${0.1 * (1 - distance / 150)})`;
                        ctx.lineWidth = 1;
                        ctx.moveTo(p1.x, p1.y);
                        ctx.lineTo(p2.x, p2.y);
                        ctx.stroke();
                    }
                });
            });

            requestAnimationFrame(animate);
        }

        animate();

        // Resize handler
        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        // Add wave animation on load
        window.addEventListener('load', () => {
            const wave = document.querySelector('.wave-animation');
            if (wave) {
                setInterval(() => {
                    wave.style.animation = 'none';
                    setTimeout(() => {
                        wave.style.animation = 'wave 2s ease-in-out';
                    }, 10);
                }, 5000);
            }
        });
    </script>

</body>
</html>
