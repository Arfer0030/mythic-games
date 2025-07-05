<x-app-layout>
    <div class="max-w-full mx-auto px-6 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors">
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('discovery') }}" class="ml-1 text-gray-400 hover:text-white transition-colors md:ml-2">
                            Discovery
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-white md:ml-2">{{ $game->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Main Game Info -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Left: Game Image and Screenshots -->
            <div class="lg:col-span-2">
                <!-- Main Image -->
                <div class="relative mb-6">
                    <img src="{{ $game->image_url }}" alt="{{ $game->title }}" 
                         class="w-full h-96 object-cover rounded-xl">
                    @if($game->discount_percentage)
                        <div class="absolute top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg text-lg font-bold">
                            -{{ $game->discount_percentage }}%
                        </div>
                    @endif
                    @if($game->is_featured)
                        <div class="absolute top-4 left-4 bg-blue-600 text-white px-4 py-2 rounded-lg font-bold">
                            FEATURED
                        </div>
                    @endif
                </div>

                <!-- Screenshots -->
                @if($game->screenshots && is_array($game->screenshots) && count($game->screenshots) > 0)
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-white mb-4">Screenshots</h3>
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($game->screenshots as $screenshot)
                            <img src="{{ $screenshot }}" alt="Screenshot" 
                                class="w-full h-32 object-cover rounded-lg hover:scale-105 transition-transform cursor-pointer">
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Description -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4">About This Game</h3>
                    <p class="text-gray-300 leading-relaxed">{{ $game->description }}</p>
                </div>
            </div>

            <!-- Right: Game Details and Purchase -->
            <div class="space-y-6">
                <!-- Game Title and Basic Info -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                    <h1 class="text-3xl font-bold text-white mb-4">{{ $game->title }}</h1>
                    
                    <!-- Rating -->
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= floor($game->user_rating) ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-white font-semibold">{{ $game->user_rating }}/5</span>
                        <span class="text-gray-400">(Based on user reviews)</span>
                    </div>

                    <!-- Genres -->
                    <div class="mb-4">
                        <span class="text-gray-400 text-sm">Genres:</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @if(is_array($game->genres))
                                @foreach($game->genres as $genre)
                                    <span class="bg-blue-600/20 text-blue-300 px-3 py-1 rounded-full text-sm">{{ $genre }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Short Description -->
                    <p class="text-gray-300 mb-6">{{ $game->short_description }}</p>

                    <!-- Price and Purchase -->
                    <div class="border-t border-gray-700 pt-6">
                        <div class="mb-4">
                            @if($game->hasDiscount())
                                <div class="flex items-center space-x-3 mb-2">
                                    <span class="text-3xl font-bold text-green-400">{{ $game->formatted_discount_price }}</span>
                                    <span class="text-xl line-through text-gray-400">{{ $game->formatted_price }}</span>
                                </div>
                                <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold inline-block">
                                    Save {{ $game->discount_percentage }}%
                                </div>
                            @else
                                <span class="text-3xl font-bold text-white">{{ $game->formatted_price }}</span>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <button onclick="addToCart({{ $game->id }})" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                Add to Cart
                            </button>
                        
                        </div>
                    </div>
                </div>

                <!-- Game Details -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Game Details</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Developer:</span>
                            <span class="text-white">{{ $game->developer }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Publisher:</span>
                            <span class="text-white">{{ $game->publisher }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Release Date:</span>
                            <span class="text-white">{{ $game->release_date->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Rating:</span>
                            <span class="text-white">{{ $game->rating }}</span>
                        </div>
                        @if($game->is_bestseller)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Status:</span>
                                <span class="bg-yellow-500 text-black px-2 py-1 rounded text-xs font-bold">BESTSELLER</span>
                            </div>
                        @endif
                        @if($game->is_new_release)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Status:</span>
                                <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold">NEW RELEASE</span>
                            </div>
                        @endif
                        @if($game->is_comming_soon)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Status:</span>
                                <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold">COMMING SOON</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Games -->
        @if($relatedGames->count() > 0)
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-white mb-6">More from {{ $game->developer }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
                    @foreach($relatedGames as $relatedGame)
                        <a href="{{ route('games.show', $relatedGame) }}" class="bg-gray-800/50 backdrop-blur-sm rounded-xl overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                            <img src="{{ $relatedGame->image_url }}" alt="{{ $relatedGame->title }}" class="w-full h-32 object-cover">
                            <div class="p-3">
                                <h4 class="text-white font-semibold text-sm mb-2 truncate">{{ $relatedGame->title }}</h4>
                                <div class="flex items-center justify-between">
                                    @if($relatedGame->hasDiscount())
                                        <span class="text-green-400 font-bold text-sm">{{ $relatedGame->formatted_discount_price }}</span>
                                    @else
                                        <span class="text-white font-bold text-sm">{{ $relatedGame->formatted_price }}</span>
                                    @endif
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-gray-300 text-xs">{{ $relatedGame->user_rating }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Similar Games -->
        @if($similarGames->count() > 0)
            <div>
                <h3 class="text-2xl font-bold text-white mb-6">You Might Also Like</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($similarGames as $similarGame)
                        <a href="{{ route('games.show', $similarGame) }}" class="bg-gray-800/50 backdrop-blur-sm rounded-xl overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                            <div class="relative">
                                <img src="{{ $similarGame->image_url }}" alt="{{ $similarGame->title }}" class="w-full h-48 object-cover">
                                @if($similarGame->discount_percentage)
                                    <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-sm font-bold">
                                        -{{ $similarGame->discount_percentage }}%
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h4 class="text-white font-semibold mb-2 truncate">{{ $similarGame->title }}</h4>
                                <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $similarGame->short_description }}</p>
                                <div class="flex items-center justify-between">
                                    @if($similarGame->hasDiscount())
                                        <div class="flex items-center space-x-2">
                                            <span class="text-green-400 font-bold">{{ $similarGame->formatted_discount_price }}</span>
                                            <span class="text-gray-400 line-through text-sm">{{ $similarGame->formatted_price }}</span>
                                        </div>
                                    @else
                                        <span class="text-white font-bold">{{ $similarGame->formatted_price }}</span>
                                    @endif
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-gray-300 text-sm">{{ $similarGame->user_rating }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
