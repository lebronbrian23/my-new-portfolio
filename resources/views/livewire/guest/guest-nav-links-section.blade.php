<div
    x-data="{
        activeSection: 'home',
        updateActive() {
            const sections = ['home', 'about', 'work', 'skills', 'contact'];
            const scrollPosition = window.scrollY + 100;

            for (let section of sections) {
                const element = document.getElementById(section);
                if (element) {
                    const offsetTop = element.offsetTop;
                    const offsetBottom = offsetTop + element.offsetHeight;

                    if (scrollPosition >= offsetTop && scrollPosition < offsetBottom) {
                        this.activeSection = section;
                        @this.set('activeSection', section);
                        break;
                    }
                }
            }
        }
    }"
    x-init="
        updateActive();
        window.addEventListener('scroll', () => updateActive());
    "
>

@if($location === 'header')
    {{-- Desktop Header Navigation --}}
    <div class="hidden md:flex space-x-8">
        @foreach($links as $link)
            @if($link->link_name === 'Resume')
                @php
                    $resumeBlock = \App\Models\ContentBlock::where('content_block_section', 'resume')
                        ->where('content_block_status', 'active')
                        ->first();
                    $resumeUrl = $resumeBlock && $resumeBlock->photo ? asset('storage/' . $resumeBlock->photo) : null;
                @endphp
                @if($resumeUrl)
                    <a
                        href="{{ $resumeUrl }}"
                        download
                        class="px-4 py-2 bg-primary text-cream text-sm font-medium rounded-full hover:bg-accent transition-colors"
                    >
                        {{ $link->link_name }}
                    </a>
                @else
                    <span class="px-4 py-2 bg-gray-400 text-cream text-sm font-medium rounded-full cursor-not-allowed">
                        {{ $link->link_name }}
                    </span>
                @endif
            @else
                <a
                    href="#{{ $link->link_route }}"
                    class="nav-link text-sm font-medium text-primary hover:text-accent transition-colors"
                    :class="{ 'text-red-600 font-bold': activeSection === '{{ $link->link_route }}' }"
                >
                    {{ $link->link_name }}
                </a>
            @endif
        @endforeach
    </div>

@elseif($location === 'mobile')
    {{-- Mobile Menu Navigation --}}
    <div class="flex flex-col space-y-3">
        @foreach($links as $link)
            @if($link->link_name === 'Resume')
                @php
                    $resumeBlock = \App\Models\ContentBlock::where('content_block_section', 'resume')
                        ->where('content_block_status', 'active')
                        ->first();
                    $resumeUrl = $resumeBlock && $resumeBlock->photo ? asset('storage/' . $resumeBlock->photo) : null;
                @endphp
                @if($resumeUrl)
                    <a
                        href="{{ $resumeUrl }}"
                        download
                        class="inline-block px-4 py-2 bg-primary text-cream text-sm font-medium rounded-full hover:bg-accent transition-colors text-center"
                    >
                        {{ $link->link_name }}
                    </a>
                @else
                    <span class="inline-block px-4 py-2 bg-gray-400 text-cream text-sm font-medium rounded-full text-center cursor-not-allowed">
                        {{ $link->link_name }}
                    </span>
                @endif
            @else
                <a
                    href="#{{ $link->link_route }}"
                    class="text-sm font-medium text-primary hover:text-accent transition-colors"
                    :class="{ 'text-red-600 font-bold': activeSection === '{{ $link->link_route }}' }"
                    onclick="document.getElementById('mobile-menu').classList.add('hidden')"
                >
                    {{ $link->link_name }}
                </a>
            @endif
        @endforeach
    </div>

@elseif($location === 'footer')
    {{-- Footer Navigation --}}
    <div class="flex flex-wrap justify-center gap-6">
        @foreach($links as $link)
            @if($link->link_name === 'Resume')
                @php
                    $resumeBlock = \App\Models\ContentBlock::where('content_block_section', 'resume')
                        ->where('content_block_status', 'active')
                        ->first();
                    $resumeUrl = $resumeBlock && $resumeBlock->photo ? asset('storage/' . $resumeBlock->photo) : null;
                @endphp
                @if($resumeUrl)
                    <a
                        href="{{ $resumeUrl }}"
                        download
                        class="hover:text-accent transition-colors"
                    >
                        {{ $link->link_name }}
                    </a>
                @else
                    <span class="text-gray-400 cursor-not-allowed">
                        {{ $link->link_name }}
                    </span>
                @endif
            @else
                <a
                    href="#{{ $link->link_route }}"
                    class="hover:text-accent transition-colors"
                    :class="{ 'text-red-600 font-bold': activeSection === '{{ $link->link_route }}' }"
                >
                    {{ $link->link_name }}
                </a>
            @endif
        @endforeach
    </div>

@endif

</div>
