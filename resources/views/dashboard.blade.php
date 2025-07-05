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
                    @foreach($newReleases->take(5) as $game)
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
            <div class="relative h-96 rounded-xl overflow-hidden">
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
                    @foreach($featuredGames->take(5) as $game)
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
                    @foreach($featuredGames->skip(5)->take(4) as $game)
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
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.758-1.378l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/>
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
