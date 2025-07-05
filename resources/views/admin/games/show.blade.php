<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-white">{{ $game->title }}</h1>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.games.edit', $game) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Edit Game
                    </a>
                    <form method="POST" action="{{ route('admin.games.destroy', $game) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this game?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Delete Game
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-gray-400">Game details and information</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Game Image and Screenshots -->
            <div class="lg:col-span-2">
                <!-- Main Image -->
                <div class="relative mb-6">
                    <img src="{{ $game->image_url }}" alt="{{ $game->title }}" 
                         class="w-full h-96 object-cover rounded-xl">
                    <div class="absolute top-4 right-4 flex flex-col gap-2">
                        @if($game->discount_percentage)
                            <div class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm font-bold">
                                -{{ $game->discount_percentage }}%
                            </div>
                        @endif
                        @if($game->is_featured)
                            <div class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm font-bold">
                                FEATURED
                            </div>
                        @endif
                        @if($game->is_new_release)
                            <div class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm font-bold">
                                NEW RELEASE
                            </div>
                        @endif
                        @if($game->is_bestseller)
                            <div class="bg-yellow-500 text-black px-3 py-1 rounded-lg text-sm font-bold">
                                BESTSELLER
                            </div>
                        @endif
                    </div>
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

            <!-- Right: Game Details -->
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Game Information</h3>
                    
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

                    <!-- Price -->
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
                    </div>
                </div>

                <!-- Game Details -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Details</h3>
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
                            <span class="text-gray-400">Content Rating:</span>
                            <span class="text-white">{{ $game->rating }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Created:</span>
                            <span class="text-white">{{ $game->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Last Updated:</span>
                            <span class="text-white">{{ $game->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Featured:</span>
                            <span class="text-white">
                                @if($game->is_featured)
                                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-xs">Yes</span>
                                @else
                                    <span class="bg-gray-600 text-white px-2 py-1 rounded text-xs">No</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">New Release:</span>
                            <span class="text-white">
                                @if($game->is_new_release)
                                    <span class="bg-green-600 text-white px-2 py-1 rounded text-xs">Yes</span>
                                @else
                                    <span class="bg-gray-600 text-white px-2 py-1 rounded text-xs">No</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Bestseller:</span>
                            <span class="text-white">
                                @if($game->is_bestseller)
                                    <span class="bg-yellow-600 text-black px-2 py-1 rounded text-xs">Yes</span>
                                @else
                                    <span class="bg-gray-600 text-white px-2 py-1 rounded text-xs">No</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Comming Soon:</span>
                            <span class="text-white">
                                @if($game->is_comming_soon)
                                    <span class="bg-yellow-600 text-black px-2 py-1 rounded text-xs">Yes</span>
                                @else
                                    <span class="bg-gray-600 text-white px-2 py-1 rounded text-xs">No</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
