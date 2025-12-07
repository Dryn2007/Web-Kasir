<x-app-layout>
    <div class="py-16 bg-[#0b0c15] min-h-screen relative overflow-hidden">

        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-600/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">

                <div class="relative group">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-1000">
                    </div>
                    <div
                        class="relative rounded-2xl overflow-hidden border border-gray-700 bg-gray-900 aspect-video lg:aspect-square shadow-2xl">
                        @if($about && $about->image)
                            <img src="{{ asset('storage/' . $about->image) }}" alt="About Us"
                                class="w-full h-full object-cover transform transition duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-[#15161c] text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mb-4 opacity-50" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="font-bold tracking-widest text-sm">OUR HQ</span>
                            </div>
                        @endif

                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-6">
                            <p class="text-white font-bold text-lg brand-font">EST. 2025</p>
                            <p class="text-indigo-400 text-xs font-mono">Premium Digital Library</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2
                        class="text-xs font-bold text-indigo-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <span class="w-8 h-[2px] bg-indigo-500"></span> WHO WE ARE
                    </h2>

                    <h1 class="text-4xl md:text-5xl font-black text-white brand-font mb-6 leading-tight">
                        {{ $about->title ?? 'Welcome to Our Store' }}
                    </h1>

                    <div class="space-y-6 text-gray-400 text-lg leading-relaxed font-light">
                        {!! nl2br(e($about->content ?? 'We provide the best games for you.')) !!}
                    </div>

                    <div class="mt-10 flex flex-wrap gap-4">
                        <div class="bg-[#1a1b26] border border-gray-700 p-4 rounded-lg flex items-center gap-3">
                            <div class="p-2 bg-indigo-900/30 rounded text-indigo-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-white font-bold">24/7</div>
                                <div class="text-xs text-gray-500">Instant Delivery</div>
                            </div>
                        </div>

                        <div class="bg-[#1a1b26] border border-gray-700 p-4 rounded-lg flex items-center gap-3">
                            <div class="p-2 bg-green-900/30 rounded text-green-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-white font-bold">100%</div>
                                <div class="text-xs text-gray-500">Official Keys</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-16 mb-16">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-white brand-font mb-2">
                            FRESH <span class="text-indigo-500">DROPS</span>
                        </h2>
                        <p class="text-gray-400 text-sm">Newest additions to our library.</p>
                    </div>
                    <a href="{{ route('home', ['sort' => 'latest']) }}"
                        class="hidden md:flex items-center gap-2 text-indigo-400 hover:text-white transition font-bold text-sm">
                        VIEW ALL NEW <span class="text-lg">&rarr;</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($latestProducts as $product)
                        <a href="{{ route('product.show', $product->id) }}"
                            class="group relative flex flex-col bg-[#1a1b26] rounded-2xl overflow-hidden border border-gray-800 hover:border-indigo-500/50 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_-10px_rgba(79,70,229,0.3)]">

                            <div class="relative h-56 w-full overflow-hidden bg-gray-900">
                                @php
                                    $imageSrc = ($product->image && str_starts_with($product->image, 'http')) ? $product->image : asset('storage/' . $product->image);
                                @endphp
                                @if($product->image)
                                    <img src="{{ $imageSrc }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                        onerror="this.onerror=null; this.src='https://placehold.co/600x800/1a1b26/FFF?text=No+Image';">
                                @else
                                    <div
                                        class="w-full h-full flex flex-col items-center justify-center text-gray-600 bg-[#15161c]">
                                        <span class="text-xs font-bold">NO PREVIEW</span></div>
                                @endif

                                <div class="absolute top-3 left-3">
                                    <span
                                        class="bg-indigo-600 text-white text-[10px] font-black px-2 py-1 rounded shadow-lg border border-indigo-400/50">
                                        NEW ARRIVAL
                                    </span>
                                </div>

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-[#1a1b26] via-transparent to-transparent opacity-90">
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-grow relative -mt-8 z-10">
                                <h3 class="text-lg font-bold text-white mb-1 leading-snug group-hover:text-indigo-400 transition-colors line-clamp-1"
                                    title="{{ $product->name }}">{{ $product->name }}</h3>
                                <div class="flex-grow"></div>
                                <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-800">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] text-gray-500 uppercase tracking-wider font-bold">Price</span>
                                        <span
                                            class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-300">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div
                                        class="w-10 h-10 rounded-xl bg-[#252630] text-indigo-400 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg></div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-gray-800 pt-16">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-white brand-font mb-2">
                            POPULAR <span class="text-yellow-500">NOW</span>
                        </h2>
                        <p class="text-gray-400 text-sm">Most downloaded games this month.</p>
                    </div>
                    <a href="{{ route('home', ['sort' => 'popular']) }}"
                        class="hidden md:flex items-center gap-2 text-yellow-500 hover:text-white transition font-bold text-sm">
                        VIEW BEST SELLERS <span class="text-lg">&rarr;</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($bestSellingProducts as $product)
                        <a href="{{ route('product.show', $product->id) }}"
                            class="group relative flex flex-col bg-[#1a1b26] rounded-2xl overflow-hidden border border-gray-800 hover:border-yellow-500/50 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_-10px_rgba(234,179,8,0.3)]">

                            <div class="relative h-56 w-full overflow-hidden bg-gray-900">
                                @php
                                    $imageSrc = ($product->image && str_starts_with($product->image, 'http')) ? $product->image : asset('storage/' . $product->image);
                                @endphp
                                @if($product->image)
                                    <img src="{{ $imageSrc }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                        onerror="this.onerror=null; this.src='https://placehold.co/600x800/1a1b26/FFF?text=No+Image';">
                                @else
                                    <div
                                        class="w-full h-full flex flex-col items-center justify-center text-gray-600 bg-[#15161c]">
                                        <span class="text-xs font-bold">NO PREVIEW</span></div>
                                @endif

                                <div class="absolute top-3 left-3">
                                    <span
                                        class="bg-red-600 text-white text-[10px] font-black px-2 py-1 rounded shadow-lg flex items-center gap-1 border border-red-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-300"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.298-2.26A1 1 0 005.097 6.09c-.709 2.331-1.123 5.061-.517 7.373C5.395 16.596 8.324 19 12 19c2.836 0 5.235-1.29 6.577-3.155.137-.19.236-.39.297-.593a1 1 0 00-.813-1.264c-.37-.058-.727-.123-1.07-.197-.893-.193-1.579-.472-1.958-.876-.412-.44-.572-1.013-.673-1.587-.1-.565-.116-1.17-.03-1.637.072-.393.18-.756.288-1.096.108-.34.22-.66.295-.972.073-.306.082-.559.043-.76a1 1 0 00-.756-.79zM9.05 12a1 1 0 011.89 0l.478 2.872a1 1 0 11-1.972.328L9.05 12z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        HOT ITEM
                                    </span>
                                </div>

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-[#1a1b26] via-transparent to-transparent opacity-90">
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-grow relative -mt-8 z-10">
                                <h3 class="text-lg font-bold text-white mb-1 leading-snug group-hover:text-yellow-400 transition-colors line-clamp-1"
                                    title="{{ $product->name }}">{{ $product->name }}</h3>
                                <div class="flex-grow"></div>
                                <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-800">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] text-gray-500 uppercase tracking-wider font-bold">Price</span>
                                        <span
                                            class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div
                                        class="w-10 h-10 rounded-xl bg-[#252630] text-yellow-500 group-hover:bg-yellow-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg></div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>