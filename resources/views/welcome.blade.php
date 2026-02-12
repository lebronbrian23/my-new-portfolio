<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brian Ssekalegga - Full Stack Developer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/ca8a2a996a.js" crossorigin="anonymous"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['Crimson Pro', 'serif'],
                        'sans': ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#0A1828',
                        'accent': '#BFA181',
                        'cream': '#F4F1E8',
                        'sage': '#C5D3C8',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                    },
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #F4F1E8;
            font-family: 'DM Sans', sans-serif;
        }

        .text-display {
            font-family: 'Crimson Pro', serif;
        }

        .gradient-text {
            background: linear-gradient(135deg, #0A1828 0%, #BFA181 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #BFA181;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .project-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .project-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(10, 24, 40, 0.15);
        }

        .skill-badge {
            transition: all 0.3s ease;
        }

        .skill-badge:hover {
            transform: scale(1.1) rotate(3deg);
            box-shadow: 0 8px 16px rgba(191, 161, 129, 0.3);
        }

        .decorative-line {
            background: linear-gradient(90deg, transparent, #BFA181, transparent);
            height: 1px;
        }

        @keyframes grain {
            0%, 100% { transform: translate(0, 0); }
            10% { transform: translate(-5%, -5%); }
            20% { transform: translate(-10%, 5%); }
            30% { transform: translate(5%, -10%); }
            40% { transform: translate(-5%, 15%); }
            50% { transform: translate(-10%, 5%); }
            60% { transform: translate(15%, 0); }
            70% { transform: translate(0, 10%); }
            80% { transform: translate(-15%, 0); }
            90% { transform: translate(10%, 5%); }
        }

        .grain::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
            animation: grain 8s steps(10) infinite;
        }
    </style>
</head>
<body class="grain text-primary">

    <!-- Navigation -->
    <nav class="fixed w-full top-0 z-50 bg-cream/95 backdrop-blur-sm border-b border-primary/10">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="#home" class="text-2xl font-display font-bold text-primary hover:text-accent transition-colors">
                    <span class="flex md:hidden">BS</span>
                    <span class="hidden md:flex">Brian Ssekalegga </span>
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="nav-link text-sm font-medium text-primary hover:text-accent">Home</a>
                    <a href="#about" class="nav-link text-sm font-medium text-primary hover:text-accent">About</a>
                    <a href="#work" class="nav-link text-sm font-medium text-primary hover:text-accent">Works</a>
                    <a href="#skills" class="nav-link text-sm font-medium text-primary hover:text-accent">Skills</a>
                    <a href="#contact" class="nav-link text-sm font-medium text-primary hover:text-accent">Contact</a>
                    <a href="/pdf/Resume-Ssekalegga-Brian.pdf" target="_blank" class="px-4 py-2 bg-primary text-cream text-sm font-medium rounded-full hover:bg-accent transition-colors">Resume</a>
                </div>
                <button id="mobile-menu-btn" class="md:hidden p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pt-4 pb-2">
                <div class="flex flex-col space-y-3">
                    <a href="#home" class="text-sm font-medium text-primary hover:text-accent transition-colors">Home</a>
                    <a href="#about" class="text-sm font-medium text-primary hover:text-accent transition-colors">About</a>
                    <a href="#work" class="text-sm font-medium text-primary hover:text-accent transition-colors">Works</a>
                    <a href="#skills" class="text-sm font-medium text-primary hover:text-accent transition-colors">Skills</a>
                    <a href="#contact" class="text-sm font-medium text-primary hover:text-accent transition-colors">Contact</a>
                    <a href="/pdf/Resume-Ssekalegga-Brian.pdf" target="_blank" class="inline-block px-4 py-2 bg-primary text-cream text-sm font-medium rounded-full hover:bg-accent transition-colors text-center">Resume</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-6 py-20">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 animate-fade-in">
                    <div class="space-y-2">
                        <p class="text-accent font-medium tracking-wide text-sm uppercase">Full Stack Developer</p>
                        <h1 class="text-6xl md:text-7xl font-display font-bold leading-tight">
                            Hi, I'm <br>
                            <span class="gradient-text">Brian Ssekalegga</span>
                        </h1>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-3xl md:text-4xl font-display font-semibold text-primary/80">I build the web.</h2>
                        <p class="text-lg text-primary/70 max-w-lg leading-relaxed">
                            I'm a software developer specialized in building digital experiences. Aspiring Machine Learning developer with a passion for innovation.
                        </p>
                    </div>
                    <div class="flex gap-4 pt-4">
                        <a href="#contact" class="px-8 py-4 bg-primary text-cream font-medium rounded-full hover:bg-accent transition-all hover:shadow-lg">
                            Get In Touch
                        </a>
                        <a href="#work" class="px-8 py-4 border-2 border-primary text-primary font-medium rounded-full hover:bg-primary hover:text-cream transition-all">
                            View Work
                        </a>
                    </div>
                </div>
                <div class="hidden md:block animate-float">
                    <div class="relative">
                        <div class="absolute inset-0 bg-accent/20 rounded-full blur-3xl"></div>
                        <div class="relative bg-sage/30 rounded-3xl p-8 backdrop-blur-sm border border-primary/10">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="bg-cream p-6 rounded-2xl shadow-lg">
                                    <div class="text-4xl font-display font-bold text-accent">8+</div>
                                    <div class="text-sm text-primary/60 mt-1">Years Experience</div>
                                </div>
                                <div class="bg-cream p-6 rounded-2xl shadow-lg">
                                    <div class="text-4xl font-display font-bold text-accent">50+</div>
                                    <div class="text-sm text-primary/60 mt-1">Projects Built</div>
                                </div>
                                <div class="bg-cream p-6 rounded-2xl shadow-lg col-span-2">
                                    <div class="text-4xl font-display font-bold text-accent">$250K</div>
                                    <div class="text-sm text-primary/60 mt-1">Monthly Transaction Value</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-primary text-cream">
        <livewire:guest-about-section />
    </section>

    <!-- Work Section -->
    <section id="work" class="py-20">
        <livewire:guest-work-section />
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-20 bg-primary text-cream">
        <livewire:guest-skill-section />
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20">
        <livewire:guest-contact-section />
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-cream py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="#home" class="hover:text-accent transition-colors">Home</a>
                    <a href="#about" class="hover:text-accent transition-colors">About</a>
                    <a href="#skills" class="hover:text-accent transition-colors">Skills</a>
                    <a href="#work" class="hover:text-accent transition-colors">Works</a>
                    <a href="#contact" class="hover:text-accent transition-colors">Contact</a>
                    <a href="/pdf/Resume-Ssekalegga-Brian.pdf" target="_blank" class="hover:text-accent transition-colors">Resume</a>
                </div>
            </div>
            <div class="decorative-line my-8"></div>
            <div class="text-center text-cream/60 text-sm">
                © {{ date('Y') }} All rights reserved | Designed & developed by  Ssekalegga Brian
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking on a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        // Smooth scroll with offset for fixed nav
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 80;
                    const targetPosition = target.offsetTop - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add scroll effect to navigation
        let lastScroll = 0;
        const nav = document.querySelector('nav');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.remove('shadow-lg');
            }

            lastScroll = currentScroll;
        });
    </script>
</body>
</html>
