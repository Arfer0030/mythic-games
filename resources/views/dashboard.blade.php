<x-app-layout>
    <div class="max-w-full mx-auto px-6 py-8">
        <!-- Top Row: 3 Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Left: New Releases -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-white">New Releases</h3>
                    <a href="#" class="text-blue-400 hover:text-blue-300 text-sm font-medium">See All</a>
                </div>
                <div class="space-y-4">
                    @foreach($newReleases->take(3) as $game)
                        <div class="flex items-center space-x-4 p-3 bg-gray-700/30 rounded-lg hover:bg-gray-600/40 transition-colors cursor-pointer">
                            <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="w-16 h-16 rounded-lg object-cover">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-white font-semibold text-base mb-1 truncate">{{ $game->title }}</h4>
                                <p class="text-gray-400 text-sm mb-2">{{ $game->release_date->format('M d, Y') }}</p>
                                <div class="flex items-center justify-between">
                                    @if($game->hasDiscount())
                                        <div class="flex items-center space-x-2">
                                            <span class="text-green-400 font-bold">{{ $game->formatted_discount_price }}</span>
                                            <span class="text-gray-400 line-through text-sm">{{ $game->formatted_price }}</span>
                                        </div>
                                    @else
                                        <span class="text-white font-bold">{{ $game->formatted_price }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Center: Best Seller #1 Banner -->
            <div class="relative h-100 rounded-xl overflow-hidden">
                @if($bestsellers->count() > 0)
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent z-10"></div>
                    <img src="{{ $bestsellers->first()->image_url }}" alt="{{ $bestsellers->first()->title }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 z-20 flex flex-col justify-end p-8">
                        <div class="mb-3">
                            <span class="bg-yellow-500 text-black px-4 py-2 rounded-full text-sm font-bold">
                                🏆 #1 BESTSELLER THIS MONTH
                            </span>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-3">{{ $bestsellers->first()->title }}</h2>
                        <p class="text-gray-200 text-lg mb-4 line-clamp-2">{{ $bestsellers->first()->short_description }}</p>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= floor($bestsellers->first()->user_rating) ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                                <span class="text-white ml-2 font-semibold">{{ $bestsellers->first()->user_rating }}/5</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            @if($bestsellers->first()->hasDiscount())
                                <span class="text-2xl font-bold text-green-400">{{ $bestsellers->first()->formatted_discount_price }}</span>
                                <span class="text-lg line-through text-gray-400">{{ $bestsellers->first()->formatted_price }}</span>
                            @else
                                <span class="text-2xl font-bold text-white">{{ $bestsellers->first()->formatted_price }}</span>
                            @endif
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Coming Soon -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-white">Coming Soon</h3>
                    <a href="#" class="text-blue-400 hover:text-blue-300 text-sm font-medium">See All</a>
                </div>
                <div class="space-y-4">
                    @foreach($commingSoon->take(3) as $game)
                        <div class="flex items-center space-x-4 p-3 bg-gray-700/30 rounded-lg hover:bg-gray-600/40 transition-colors cursor-pointer">
                            <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="w-16 h-16 rounded-lg object-cover">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-white font-semibold text-base mb-1 truncate">{{ $game->title }}</h4>
                                <p class="text-blue-400 text-sm mb-2 font-medium">Coming Soon</p>
                                <div class="flex items-center justify-between">
                                    @if($game->hasDiscount())
                                        <div class="flex items-center space-x-2">
                                            <span class="text-green-400 font-bold">{{ $game->formatted_discount_price }}</span>
                                            <span class="text-gray-400 line-through text-sm">{{ $game->formatted_price }}</span>
                                        </div>
                                    @else
                                        <span class="text-white font-bold">{{ $game->formatted_price }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Bottom Row: 3 Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Featured Games -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-white">Featured Games</h3>
                    <a href="#" class="text-blue-400 hover:text-blue-300 text-sm font-medium">See All</a>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    @foreach($featuredGames->take(4) as $game)
                        <div class="bg-gray-700/30 rounded-lg p-4 hover:bg-gray-600/40 transition-colors cursor-pointer">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="w-20 h-20 rounded-lg object-cover">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-semibold text-base mb-2 truncate">{{ $game->title }}</h4>
                                    <div class="flex flex-wrap gap-1 mb-2">
                                        @if(is_array($game->genres))
                                            @foreach(array_slice($game->genres, 0, 2) as $genre)
                                                <span class="bg-blue-600/20 text-blue-300 px-2 py-1 rounded text-xs">{{ $genre }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between">
                                        @if($game->hasDiscount())
                                            <div class="flex items-center space-x-2">
                                                <span class="text-green-400 font-bold">{{ $game->formatted_discount_price }}</span>
                                                <span class="text-gray-400 line-through text-sm">{{ $game->formatted_price }}</span>
                                            </div>
                                        @else
                                            <span class="text-white font-bold">{{ $game->formatted_price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Best Sellers -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-white">Best Sellers</h3>
                    <a href="#" class="text-blue-400 hover:text-blue-300 text-sm font-medium">See All</a>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    @foreach($bestsellers->skip(1)->take(4) as $game)
                        <div class="bg-gray-700/30 rounded-lg p-4 hover:bg-gray-600/40 transition-colors cursor-pointer">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="w-20 h-20 rounded-lg object-cover">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-semibold text-base mb-2 truncate">{{ $game->title }}</h4>
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-gray-300 text-sm">{{ $game->user_rating }}</span>
                                        </div>
                                        <span class="bg-yellow-500 text-black px-2 py-1 rounded text-xs font-bold">BESTSELLER</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        @if($game->hasDiscount())
                                            <div class="flex items-center space-x-2">
                                                <span class="text-green-400 font-bold">{{ $game->formatted_discount_price }}</span>
                                                <span class="text-gray-400 line-through text-sm">{{ $game->formatted_price }}</span>
                                            </div>
                                        @else
                                            <span class="text-white font-bold">{{ $game->formatted_price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Special Offers -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-white">Special Offers</h3>
                    <a href="#" class="text-blue-400 hover:text-blue-300 text-sm font-medium">See All</a>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    @foreach($discountedGames->take(4) as $game)
                        <div class="bg-gray-700/30 rounded-lg p-4 hover:bg-gray-600/40 transition-colors cursor-pointer relative">
                            @if($game->discount_percentage)
                                <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-xs font-bold z-10">
                                    -{{ $game->discount_percentage }}%
                                </div>
                            @endif
                            <div class="flex items-center space-x-4">
                                <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="w-20 h-20 rounded-lg object-cover">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-semibold text-base mb-2 truncate">{{ $game->title }}</h4>
                                    <div class="flex items-center space-x-2 mb-2">
                                        <span class="bg-green-600/20 text-green-300 px-2 py-1 rounded text-xs">LIMITED OFFER</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-green-400 font-bold">{{ $game->formatted_discount_price }}</span>
                                        <span class="text-gray-400 line-through text-sm">{{ $game->formatted_price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800 mt-16">
        <div class="max-w-full mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-white font-semibold text-lg">Mythic Games</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">
                        Your ultimate destination for the best gaming experiences. Discover, play, and connect with millions of gamers worldwide.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                                <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"/>
                                <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Discovery</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">New Releases</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Best Sellers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Special Offers</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Community</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Bug Reports</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Feature Requests</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Cookie Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Refund Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">DMCA</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} Mythic Games. All rights reserved.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">English</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Bahasa Indonesia</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</x-app-layout>
