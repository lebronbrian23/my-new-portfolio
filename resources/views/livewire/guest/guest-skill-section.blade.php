<div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-16">
        <p class="text-accent font-medium tracking-wide text-sm uppercase mb-2">Technologies</p>
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-4">{{ $page_title }}</h2>
        <p class="text-cream/70 max-w-2xl mx-auto">The skills, tools and technologies I use to build your products</p>
        <div class="decorative-line w-24 mx-auto mt-6"></div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-12">
        @foreach ( $skill_content as $skill )
            <div key="{{ $skill->id }}" class="skill-badge bg-cream/10 backdrop-blur-sm p-6 rounded-2xl text-center border border-cream/20">
                <div class="text-4xl mb-3">
                    @if ( $skill->icon )
                        <i class="{{ $skill->icon }} fa-3x" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-code fa-3x" aria-hidden="true"></i>
                    @endif
                </div>
                <div class="font-medium">{{ $skill->name }}</div>
            </div>
        @endforeach
    </div>

    <div class="bg-accent/10 backdrop-blur-sm rounded-2xl p-8 border border-accent/30 text-center">
        <p class="text-lg">
            <span class="font-semibold text-accent">Currently improving my skills in:</span>
            <span class="text-cream/90">Machine Learning & Data Science</span>
        </p>
    </div>
</div>
