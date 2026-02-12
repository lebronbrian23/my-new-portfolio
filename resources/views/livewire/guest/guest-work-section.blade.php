<div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-16">
        <p class="text-accent font-medium tracking-wide text-sm uppercase mb-2">Portfolio</p>
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-4">{{ $page_title }}</h2>
        <div class="decorative-line w-24 mx-auto mt-6"></div>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-12">
        @foreach ($work_content as $work )
            <div class="project-card bg-white rounded-2xl overflow-hidden shadow-lg border border-primary/10" key="{{ $work->id }}">
                <div class="aspect-video bg-sage/20 overflow-hidden">
                    <img src="{{ asset('storage/'.$work->image->url) }}" alt="{{ $work->title }}"
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                        onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-6xl\'>📝</div>';">
                </div>
                <div class="p-6 space-y-4">
                    <h3 class="text-2xl font-display font-bold">{{ $work->title }}</h3>
                    <p class="text-primary/70">{{ $work->description }}</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($work->skills as $skill)
                        <span key={{ $skill->id }} class="px-3 py-1 bg-accent/10 text-accent text-sm rounded-full">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                    <a href="{{ $work->url ? $work->url : '#' }}" target="_blank" class="inline-flex items-center gap-2 text-accent font-medium hover:gap-4 transition-all">
                        View Project
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach

    </div>

    <!-- APIs Section -->
    <div class="bg-sage/20 rounded-2xl p-8 border border-primary/10">
        <h3 class="text-3xl font-display font-bold mb-6">APIs I've Built</h3>
        <div class="grid md:grid-cols-3 gap-4">
            <a href="https://documenter.getpostman.com/view/11282506/2s83ziQQAf" target="_blank" class="p-4 bg-white rounded-xl hover:shadow-lg transition-shadow border border-primary/10">
                <div class="text-accent font-medium">Capstone Project API</div>
                <div class="text-sm text-primary/60 mt-1">RESTful API Documentation</div>
            </a>
            <a href="https://documenter.getpostman.com/view/11282506/UVktqDZq#overview" target="_blank" class="p-4 bg-white rounded-xl hover:shadow-lg transition-shadow border border-primary/10">
                <div class="text-accent font-medium">Patasente USSD API</div>
                <div class="text-sm text-primary/60 mt-1">Mobile Integration</div>
            </a>
            <a href="https://documenter.getpostman.com/view/11282506/SztA7UKr" target="_blank" class="p-4 bg-white rounded-xl hover:shadow-lg transition-shadow border border-primary/10">
                <div class="text-accent font-medium">Swift Gas API</div>
                <div class="text-sm text-primary/60 mt-1">Service Management</div>
            </a>
        </div>
    </div>

    <div class="text-center mt-12">
        <a href="https://github.com/lebronbrian23" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-cream font-medium rounded-full hover:bg-accent transition-all hover:shadow-lg">
            View More Projects on GitHub
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
            </svg>
        </a>
    </div>
</div>
