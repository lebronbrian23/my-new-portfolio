<div class="max-w-7xl mx-auto px-6 py-20">
    <div class="grid md:grid-cols-2 gap-12 items-center">
        <div class="space-y-6 animate-fade-in">
            <div class="space-y-2">
                <p class="text-accent font-medium tracking-wide text-sm uppercase">{{ $page_title}}</p>
                <h1 class="text-6xl md:text-7xl font-display font-bold leading-tight">
                    Hi, I'm <br>
                    <span class="gradient-text">{{ env('PORTFOLIO_OWNER_NAME')}}</span>
                </h1>
            </div>

            <div class="space-y-4">
                <p class="text-lg text-primary/70 max-w-lg leading-relaxed">
                {!! $home_content->description !!}
                </p>
            </div>
            <div class="flex gap-4 pt-4">
                <a href="#contact" class="px-8 py-4 bg-primary text-cream font-medium rounded-full hover:bg-accent transition-all hover:shadow-lg">
                    Get In Touch
                </a>
                <a href="#works" class="px-8 py-4 border-2 border-primary text-primary font-medium rounded-full hover:bg-primary hover:text-cream transition-all">
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
                            <div class="text-4xl font-display font-bold text-accent">{{ $home_content->years_of_experience }}+</div>
                            <div class="text-sm text-primary/60 mt-1">Years Experience</div>
                        </div>
                        <div class="bg-cream p-6 rounded-2xl shadow-lg">
                            <div class="text-4xl font-display font-bold text-accent">{{ $home_content->projects_completed }}+</div>
                            <div class="text-sm text-primary/60 mt-1">Projects Built</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
