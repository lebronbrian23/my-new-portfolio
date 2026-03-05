<div class="max-w-7xl mx-auto px-6">
    <div class="grid md:grid-cols-2 gap-16 items-center">
        <div class="order-2 md:order-1">
            <div class="space-y-6">
                <div>
                    <p class="text-accent font-medium tracking-wide text-sm uppercase mb-2">{{ $page_title }}</p>
                    <h2 class="text-4xl md:text-5xl font-display font-bold mb-6">{{ $about_content->title ?? 'About Me' }}</h2>
                </div>

                <div class="">{!! $about_content->description ?? 'Coming soon.' !!}</div>

            </div>
        </div>

        <div class="order-1 md:order-2">
            <div class="relative">
                <div class="absolute -inset-4 bg-accent/20 rounded-3xl blur-2xl"></div>
                <img src="{{ $about_content && $about_content->photo ? asset('storage/' . $about_content->photo) : asset('images/default-profile.png') }}"
                        alt="Brian Ssekalegga"
                        class="relative rounded-3xl shadow-2xl w-full object-cover aspect-square"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <div class="relative hidden rounded-3xl bg-accent/10 backdrop-blur-sm border-2 border-accent/30 aspect-square flex items-center justify-center">
                    <span class="text-6xl">👨‍💻</span>
                </div>
            </div>
        </div>
    </div>
</div>
