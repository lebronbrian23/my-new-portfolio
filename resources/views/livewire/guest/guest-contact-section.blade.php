<div class="max-w-4xl mx-auto px-6">
    <div class="text-center mb-12">
        <p class="text-accent font-medium tracking-wide text-sm uppercase mb-2">Let's Connect</p>
        <h2 class="text-4xl md:text-5xl font-display font-bold mb-4">{{ $page_title }}</h2>
        <p class="text-primary/70 text-lg">I'm always open to new opportunities and challenges. My inbox is always open.</p>
        <div class="decorative-line w-24 mx-auto mt-6"></div>
    </div>

    <div class="bg-sage/20 rounded-3xl p-12 border border-primary/10 text-center">
        <div class="space-y-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-accent rounded-full">
                <svg class="w-8 h-8 text-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            @foreach ( $contact_content as $contact )
                @if ( $contact->type === 'email' )
                    <div>
                        <h3 class="text-2xl font-display font-bold mb-2">Email Me</h3>
                        <a href="mailto:{{ $contact->link }}" class="text-xl text-accent hover:underline">{{ $contact->link }} </a>
                    </div>
                    <a href="mailto:{{ $contact->link }}" class="inline-block px-8 py-4 bg-primary text-cream font-medium rounded-full hover:bg-accent transition-all hover:shadow-lg mt-4">
                        Send a Message
                    </a>
                @endif

            @endforeach
        </div>

        <div class="mt-12 text-sm text-primary/60">
            <p>Alternatively, you can also find me on:</p>
            <div class="flex justify-center gap-6 mt-4">
                @foreach ( $contact_content as $contact )
                    @if ( $contact->type !== 'email' )
                        <a key="{{ $contact->id }}" href="{{ $contact->type === 'email' ? 'mailto:'.$contact->link : ( $contact->type === 'phone' ? 'tel:'.$contact->link : $contact->link ) }}" target="_blank" class="text-primary hover:text-accent transition-colors">
                                                        <i class="{{ $contact->icon }} fa-2x"></i>
                    </a>
                    @endif

                @endforeach
        </div>
    </div>
</div>
