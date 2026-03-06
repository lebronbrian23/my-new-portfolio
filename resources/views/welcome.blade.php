<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('PORTFOLIO_OWNER_NAME', 'My Portfolio') }} - {{ env('PORTFOLIO_OWNER_TITLE', 'Software Developer') }}</title>
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
                    <span class="flex md:hidden">{{ env('PORTFOLIO_OWNER_NAME_INITIALS') }}</span>
                    <span class="hidden md:flex">{{ env('PORTFOLIO_OWNER_NAME') }} </span>
                </a>
                <div class="hidden md:flex space-x-8">
                     @livewire('guest-nav-links-section' , ['location' => 'header'])
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
                     @livewire('guest-nav-links-section' , ['location' => 'mobile'])
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center pt-20">
        <livewire:guest-home-section />
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-primary text-cream">
        <livewire:guest-about-section />
    </section>

    <!-- Work Section -->
    <section id="works" class="py-20">
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
                    @livewire('guest-nav-links-section' , ['location' => 'footer'])
                </div>
            </div>
            <div class="decorative-line my-8"></div>
            <div class="text-center text-cream/60 text-sm">
                © {{ date('Y') }} All rights reserved | Designed & developed by {{ env('APP_DEVELOPER_NAME') }}
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
