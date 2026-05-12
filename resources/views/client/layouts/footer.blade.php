{{-- resources/views/layouts/footer.blade.php --}}

<footer class="bg-gray-50 pt-10 md:pt-16 pb-8 border-t border-gray-200">
    <div class="w-full px-4 md:px-8">

        {{-- ─── CTA Banner ─── --}}
        <div class="bg-white rounded-2xl p-6 md:p-10 mb-10 shadow-lg shadow-gray-200/50 border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-5 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-48 h-48 bg-blue-500/5 rounded-full blur-[60px] pointer-events-none"></div>
            <div class="max-w-2xl text-center md:text-left">
                <h3 class="text-lg md:text-2xl font-black text-gray-900 mb-2">
                    List Your Business to Grow Today!
                </h3>
                <p class="text-gray-500 text-sm">
                    Join thousands of businesses reaching local customers every day. Free profile setup in 5 minutes.
                </p>
            </div>
            <a
                href="{{ route('login') }}"
                class="flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white font-bold text-sm px-6 py-2.5 rounded-full shadow-lg shadow-blue-200/50 shrink-0 whitespace-nowrap transition-colors"
            >
                Create Free Account
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        {{-- ─── SEO Category Grid ─── --}}
        <div class="mb-10 bg-white rounded-2xl border border-gray-100 shadow-sm divide-y divide-gray-100 overflow-hidden">
            @php
            $seoSections = [
                [
                    'heading' => 'Popular Categories',
                    'links' => [
                        ['name' => 'Coaching & Tuitions',             'slug' => 'coaching-tuitions','type'=>'keyword'],
                        ['name' => 'Business Services',               'slug' => 'business-services','type'=>'keyword'],
                        ['name' => 'Home Construction & Renovation',  'slug' => 'home-construction','type'=>'categories'],
                        ['name' => 'Personal Finance Services',       'slug' => 'loan-service','type'=>'child'],
                        ['name' => 'Tours & Travels',                 'slug' => 'tours-travel-services','type'=>'categories'],
                        ['name' => 'Property Dealer',                 'slug' => 'property-dealer','type'=>'keyword'],
                        ['name' => 'Rent & Buy',                      'slug' => 'rent-or-buy','type'=>'child'],
                        ['name' => 'PG & Hostel',                     'slug' => 'pg-hostels','type'=>'keyword'],
                        ['name' => 'Computer Courses & Training',     'slug' => 'computer-courses','type'=>'categories'],
                        ['name' => 'Study Abroad',                    'slug' => 'study-abroad','type'=>'categories'],
                        ['name' => 'Home Services',                   'slug' => 'home-services','type'=>'keyword'],
                        ['name' => 'Parties, Special Occasions & Wedding', 'slug' => 'wedding-organisers','type'=>'keyword'],
                        ['name' => 'Electric Services',               'slug' => 'electric-services','type'=>'categories'],
                        ['name' => 'Government Exam',                 'slug' => 'entrance-exams-coaching','type'=>'categories'],
                        ['name' => 'Web Designers',                   'slug' => 'web-designers','type'=>'keyword'],
                        ['name' => 'Medical',                         'slug' => 'medical','type'=>'child'],
                        ['name' => 'Carpenters',                      'slug' => 'carpenters','type'=>'keyword'],
                        ['name' => 'Health & Wellness',               'slug' => 'health-and-wellness','type'=>'categories'],
                        ['name' => 'Yoga',                            'slug' => 'yoga-classes','type'=>'child'],
                        ['name' => 'CA & TAX Consultants',            'slug' => 'tax-consultants','type'=>'keyword'],
                    ],
                ],
                [
                    'heading' => 'Business Services',
                    'links' => [
                        ['name' => 'Patient Care Service',            'slug' => 'patient-care-services','type'=>'keyword'],
                        ['name' => 'Home Appliances Repair & Services','slug' => 'home-appliances-repair-services','type'=>'keyword'],
                        ['name' => 'Packers and Movers',              'slug' => 'packers-movers','type'=>'keyword'],
                        ['name' => 'AC Services',                     'slug' => 'ac-repair-service','type'=>'keyword'],
                        ['name' => 'Cleaning Services',               'slug' => 'cleaning-services','type'=>'keyword'],
                        ['name' => 'Security Guards',                 'slug' => 'security-guards-services','type'=>'keyword'],
                        ['name' => 'Architects',                      'slug' => 'architects','type'=>'keyword'],
                        ['name' => 'Builders & Contractors',          'slug' => 'building-consultants-contractors','type'=>'keyword'],
                        ['name' => 'Interior Designers & Decorators', 'slug' => 'interior-designers-decorators','type'=>'keyword'],
                        ['name' => 'Housekeeping Services',           'slug' => 'housekeeping-services','type'=>'keyword'],
                        ['name' => 'Painting Contractors',            'slug' => 'painting-contractors','type'=>'keyword'],
                        ['name' => 'Modular Kitchen Dealers',         'slug' => 'modular-kitchen-dealers','type'=>'keyword'],
                        ['name' => 'Waterproofing Contractors',       'slug' => 'waterproofing-contractors','type'=>'keyword'],
                    ],
                ],
                [
                    'heading' => 'Education Training',
                    'links' => [
                        ['name' => 'Schools & Colleges',              'slug' => 'coaching-tuitions','type'=>'keyword'],
                        ['name' => 'Entrance Exam Coaching',          'slug' => 'entrance-exams-coaching','type'=>'categories'],
                        ['name' => 'Competitive Exam Coaching',       'slug' => 'competitive-exam-coaching','type'=>'keyword'],
                        ['name' => 'Distance Education',              'slug' => 'distance-education','type'=>'keyword'],
                        ['name' => 'Language Training',               'slug' => 'language-training','type'=>'keyword'],
                        
                        ['name' => 'College & University Tuitions',   'slug' => 'college-tuition','type'=>'keyword'],
                        ['name' => 'Bank & Insurance Exam Coaching',  'slug' => 'bank-coaching','type'=>'keyword'],
                        ['name' => 'Placement Consultants',           'slug' => 'placement-consultants','type'=>'keyword'],
                    ],
                ],
                [
                    'heading' => 'Personal Services',
                    'links' => [
                        ['name' => 'Loans',                           'slug' => 'loan-service','type'=>'child'],
                        ['name' => 'Visa Consultants',                'slug' => 'visa-consultants','type'=>'keyword'],
                        ['name' => 'Beauty Parlour Services',         'slug' => 'beauty-parlours','type'=>'keyword'],
                        ['name' => 'Event Organisers',                'slug' => 'event-organisers','type'=>'keyword'],
                        ['name' => 'Catering Services',               'slug' => 'catering-services','type'=>'keyword'],
                        ['name' => 'Photographers & Videographers',   'slug' => 'photographers-videographers','type'=>'keyword'],
                        ['name' => 'Astrologers',                     'slug' => 'astrologers','type'=>'keyword'],
                        ['name' => 'Vehicle Rentals',                 'slug' => 'vehicle-rental','type'=>'keyword'],
                        ['name' => 'Massage Centres',                 'slug' => 'massage-centres','type'=>'keyword'],
                        ['name' => 'Advocates & Lawyers',             'slug' => 'advocates-lawyers','type'=>'keyword'],
                    ],
                ],
            ];
            @endphp

            @foreach($seoSections as $section)
                <div class="px-5 py-4">
                    <h4 class="text-xs font-black text-gray-900 uppercase tracking-wider mb-3">{{ $section['heading'] }}</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        @foreach($section['links'] as $i => $link)

                           @php
                            $slugUrl = match($link['type'] ?? '') {
                            'keyword'    => route('showCity',        $link['slug']),
                            'child'      => route('child.show',      $link['slug']),
                            'categories' => route('categories.show', $link['slug'])
                        
                            };
                            @endphp
                            <a href="{{ $slugUrl }}" class="hover:text-primary transition-colors hover:underline">{{ $link['name'] }}</a>
                            @if($i < count($section['links']) - 1)
                                <span class="mx-1.5 text-gray-300">|</span>
                            @endif
                        @endforeach
                    </p>
                </div>
            @endforeach
        </div>

        {{-- ─── Main Footer Grid ─── --}}
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-10">

            {{-- Col 1: Logo + Quick Links --}}
            <div class="col-span-1">
                <div class="mb-4">
                    <img
                        src="{{ asset('client/images/small-logo.png') }}"
                        alt="QuickDials"
                        class="h-10 w-auto object-contain"
                        onerror="this.onerror=null;this.src='{{ asset('client/images/small-logo.png') }}"
                    />
                </div>
                <ul class="space-y-2">
                    @foreach([
                        ['name' => 'Home',                      'href' => '/','route'=>route('home')],
                        ['name' => 'About Us',                  'href' => '/about-us','route'=>route('about.us')],
                        ['name' => 'Contact Us',                'href' => '/contact-us','route'=>route('contact.us')],
                        ['name' => 'Careers',                   'href' => '/careers','route'=>route('careers')],
                        ['name' => 'Blog',                      'href' => '/blog','route'=>route('blog.show')],
                        ['name' => 'Pricing',                   'href' => '/pricing','route'=>route('pricing')],
                      //  ['name' => 'Advertise on QuickDials',   'href' => '/business-owners','route'=>route('login')],
                        ['name' => 'Privacy Policy',            'href' => '/privacy-policy','route'=>route('privacy.policy')],
                        ['name' => 'Terms of Service',          'href' => '/terms-conditions','route'=>route('terms.conditions')],
                        ['name' => 'Copyright Policy',          'href' => '/copyright-policy','route'=>route('copyright.policy')],
                        ['name' => 'Refund Policy',             'href' => '/refund-policy','route'=>route('refund.policy')],
                    ] as $link)

                        <li>
                            <a href="{{ $link['route'] }}" class="text-gray-500 text-sm hover:text-primary transition-colors">{{ $link['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 2: Popular Categories --}}
            <div>
                <h4 class="font-bold text-gray-900 mb-4 uppercase tracking-wider text-xs">Popular Categories</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['name' => 'Professional Courses', 'slug' => 'professional-courses','type'=>'categories'],
                        ['name' => 'Wedding Planning',    'slug' => 'wedding-planning','type'=>'child'],
                        ['name' => 'Healthcare',          'slug' => 'health-and-wellness','type'=>'categories'],
                        ['name' => 'Real Estate',         'slug' => 'real-estate','type'=>'categories'],
                        ['name' => 'Electric Services',   'slug' => 'electric-services','type'=>'categories'],
                        ['name' => 'Security System',     'slug' => 'security-system','type'=>'categories'],
                        ['name' => 'Medical',             'slug' => 'medical','type'=>'child'],
                    ] as $link)

                        @php
                        $catUrl = match($link['type'] ?? '') {
                        'keyword'    => route('showCity',        $link['slug']),
                        'child'      => route('child.show',      $link['slug']),
                        'categories' => route('categories.show', $link['slug'])

                        };
                        @endphp
                        <li>


                            <a href="{{ $catUrl }}" class="text-gray-500 text-sm hover:text-primary transition-colors">{{ $link['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 3: Business Services --}}
            <div>
                <h4 class="font-bold text-gray-900 mb-4 uppercase tracking-wider text-xs">Business Services</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['name' => 'Patient Care Service',   'href' => 'patient-care-services','type'=>'keyword'],
                        ['name' => 'Home Appliances Repair', 'href' => 'home-appliance-repair-training','type'=>'keyword'],
                        ['name' => 'Wedding Organisers',     'href' => 'wedding-organisers','type'=>'keyword'],
                        ['name' => 'AC Services',            'href' => 'ac-repair-service','type'=>'keyword'],
                        ['name' => 'Security Guards',        'href' => 'security-guards-services','type'=>'keyword'],
                        ['name' => 'Cleaning Services',      'href' => 'cleaning-services','type'=>'keyword'],
                        ['name' => 'Repairs Services',       'href' => 'repair-services','type'=>'child'],
                        ['name' => 'SPA Beauty',             'href' => 'spa','type'=>'categories'],
                        ['name' => 'Loan',                   'href' => 'loan-service','type'=>'child'],
                        ['name' => 'Tax Consultants',        'href' => 'income-tax-consultants','type'=>'keyword'],
                    ] as $link)
                        @php
                        $footerUrl = match($link['type'] ?? '') {
                        'keyword'    => route('showCity',        $link['href']),
                        'child'      => route('child.show',      $link['href']),
                        'categories' => route('categories.show', $link['href'])

                        };
                        @endphp
                        <li>
                            <a href="{{ $footerUrl }}" class="text-gray-500 text-sm hover:text-primary transition-colors">{{ $link['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 4: For Businesses --}}
            <div>
                <h4 class="font-bold text-gray-900 mb-4 uppercase tracking-wider text-xs">For Businesses</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['name' => 'Add your Business',  'href' => 'business-owners','route'=>route('login')],
                        ['name' => 'Claim your Business','href' => 'business-owners','route'=>route('login')],
                        ['name' => 'Advertise with Us',  'href' => 'contact-us','route'=>route('contact.us')],
                        ['name' => 'Business Support',   'href' => 'contact-us','route'=>route('contact.us')],
                        ['name' => 'Pricing',            'href' => 'pricing','route'=>route('pricing')],
                    ] as $link)
                        <li>
                            <a href="{{ $link['route'] }}" class="text-gray-500 text-sm hover:text-primary transition-colors">{{ $link['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 5: Contact + Social --}}
            <div>
                <h4 class="font-bold text-gray-900 mb-4 uppercase tracking-wider text-xs">Support & Contact</h4>

                <div class="space-y-3 mb-6">
                    <p class="text-base font-bold text-gray-900">
                        QuickDials<sup class="text-[10px] font-semibold text-gray-500 ml-0.5">TM</sup> Pvt Ltd
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong class="text-gray-800 font-semibold">CIN:</strong>
                        <span class="font-mono text-xs tracking-wide">U63112KA2026PTC215594</span>
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong class="text-gray-800 font-semibold">Email:</strong>
                        <a href="mailto:support@quickdials.com" class="text-violet-600 hover:text-violet-800 hover:underline transition-colors ml-1">support@quickdials.com</a>
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong class="text-gray-800 font-semibold">Phone:</strong>
                        <a href="tel:+917559435943" class="text-violet-600 hover:text-violet-800 hover:underline transition-colors ml-1">+91-75-5943-5943</a>
                    </p>
                    <p class="text-sm text-gray-500 flex items-center gap-1.5 pt-3 border-t border-gray-100">
                        <span>🕒</span>
                        <span>Mon–Sat: 9:00 AM – 7:00 PM</span>
                    </p>
                </div>

                {{-- Social links --}}
                <div>
                    <h5 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3 pb-2 border-b border-gray-200">Follow Us</h5>
                    <div class="flex items-center gap-3 flex-wrap">
                        <a href="https://www.facebook.com/quickdialsofficial/" target="_blank" rel="noopener noreferrer" title="Facebook"
                           class="w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-700 flex items-center justify-center transition-colors text-white">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://x.com/Quickdials" target="_blank" rel="noopener noreferrer" title="Twitter / X"
                           class="w-8 h-8 rounded-full bg-gray-900 hover:bg-black flex items-center justify-center transition-colors text-white">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://www.linkedin.com/company/quickdialsoffical/" target="_blank" rel="noopener noreferrer" title="LinkedIn"
                           class="w-8 h-8 rounded-full bg-blue-700 hover:bg-blue-800 flex items-center justify-center transition-colors text-white">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/quickdialsofficial/" target="_blank" rel="noopener noreferrer" title="Instagram"
                           class="w-8 h-8 rounded-full flex items-center justify-center transition-colors text-white"
                           style="background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                        </a>
                        <a href="https://www.youtube.com/@quickdialsofficial/" target="_blank" rel="noopener noreferrer" title="youtube"
                           class="w-8 h-8 rounded-full flex items-center justify-center transition-colors text-white"
                           style="background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)">
                              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a2.997 2.997 0 0 0-2.11-2.12C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.388.566a2.997 2.997 0 0 0-2.11 2.12C0 8.07 0 12 0 12s0 3.93.502 5.814a2.997 2.997 0 0 0 2.11 2.12C4.495 20.5 12 20.5 12 20.5s7.505 0 9.388-.566a2.997 2.997 0 0 0 2.11-2.12C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.75 15.568V8.432L15.818 12 9.75 15.568z"/>
                            </svg>
                        </a>
                        <a href="https://www.pinterest.com/quickdialsofficial/" target="_blank" rel="noopener noreferrer" title="Pinterest"
                           class="w-8 h-8 rounded-full bg-red-600 hover:bg-red-700 flex items-center justify-center transition-colors text-white">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── Bottom bar ─── --}}
        <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
            <p class="text-gray-500 text-xs">
                 {{ date('Y') }} QuickDials Directory. All rights reserved.
            </p>
            <span class="text-gray-400 text-xs">Made with precision in India 🇮🇳</span>
        </div>
    </div>
</footer>
