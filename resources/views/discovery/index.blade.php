<x-app-layout>
    <div class="max-w-full mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Discover Games</h1>
            <p class="text-gray-400">Find your next favorite game from our extensive collection</p>
        </div>

        <div class="flex gap-8">
            <!-- Sidebar Filters -->
            <div class="w-80 bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 h-fit sticky top-8">
                <h2 class="text-xl font-bold text-white mb-6">Filters</h2>
                
                <form method="GET" action="{{ route('discovery') }}" class="space-y-6">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search games..." 
                               class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Genre Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Genre</label>
                        <select name="genre" class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Genres</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Price Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="price_min" value="{{ request('price_min') }}" 
                                   placeholder="Min" step="0.01"
                                   class="bg-gray-700 text-white px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="number" name="price_max" value="{{ request('price_max') }}" 
                                   placeholder="Max" step="0.01"
                                   class="bg-gray-700 text-white px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Rating Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Minimum Rating</label>
                        <select name="rating" class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Any Rating</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2+ Stars</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1+ Stars</option>
                        </select>
                    </div>

                    <!-- Release Year -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Release Year</label>
                        <select name="release_year" class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Any Year</option>
                            @foreach($releaseYears as $year)
                                <option value="{{ $year }}" {{ request('release_year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Developer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Developer</label>
                        <select name="developer" class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Developers</option>
                            @foreach($developers as $developer)
                                <option value="{{ $developer }}" {{ request('developer') == $developer ? 'selected' : '' }}>
                                    {{ $developer }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- On Sale -->
                    <div>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }}
                                   class="bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500 rounded">
                            <span class="text-gray-300">On Sale Only</span>
                        </label>
                    </div>

                    <!-- Apply Filters Button -->
                    <div class="flex space-x-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Apply Filters
                        </button>
                        <a href="{{ route('discovery') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors text-center">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Sort and Results Info -->
                <div class="flex justify-between items-center mb-6">
                    <div class="text-gray-400">
                        Showing {{ $games->firstItem() ?? 0 }}-{{ $games->lastItem() ?? 0 }} of {{ $games->total() }} games
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-400">Sort by:</span>
                        <form method="GET" action="{{ route('discovery') }}" class="flex space-x-2">
                            <!-- Preserve existing filters -->
                            @foreach(request()->except(['sort', 'order']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            
                            <select name="sort" onchange="this.form.submit()" 
                                    class="bg-gray-700 text-white px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Name</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                                <option value="release_date" {{ request('sort') == 'release_date' ? 'selected' : '' }}>Release Date</option>
                            </select>
                            
                            <select name="order" onchange="this.form.submit()" 
                                    class="bg-gray-700 text-white px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Games Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($games as $game)
                    <a href="{{ route('games.show', $game) }}" class="bg-gray-800/50 backdrop-blur-sm rounded-xl overflow-hidden hover:transform hover:scale-105 transition-all duration-300 cursor-pointer">
                        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl overflow-hidden hover:transform hover:scale-105 transition-all duration-300 cursor-pointer">
                            <div class="relative">
                                <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="w-full h-48 object-cover">
                                @if($game->discount_percentage)
                                    <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded text-sm font-bold">
                                        -{{ $game->discount_percentage }}%
                                    </div>
                                @endif
                                @if($game->is_featured)
                                    <div class="absolute top-2 left-2 bg-blue-600 text-white px-2 py-1 rounded text-sm font-bold">
                                        FEATURED
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-4">
                                <h3 class="text-white font-semibold text-lg mb-2 truncate">{{ $game->title }}</h3>
                                <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $game->short_description }}</p>
                                
                                <!-- Genres -->
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @if(is_array($game->genres))
                                        @foreach(array_slice($game->genres, 0, 2) as $genre)
                                            <span class="bg-blue-600/20 text-blue-300 px-2 py-1 rounded text-xs">{{ $genre }}</span>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Developer -->
                                <p class="text-gray-500 text-sm mb-2">{{ $game->developer }}</p>

                                <!-- Rating -->
                                <div class="flex items-center space-x-2 mb-3">
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= floor($game->user_rating) ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                        <span class="text-gray-300 text-sm ml-1">{{ $game->user_rating }}</span>
                                    </div>
                                </div>

                                <!-- Price and Action -->
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($game->hasDiscount())
                                            <div class="flex items-center space-x-2">
                                                <span class="text-green-400 font-bold">{{ $game->formatted_discount_price }}</span>
                                                <span class="text-gray-400 line-through text-sm">{{ $game->formatted_price }}</span>
                                            </div>
                                        @else
                                            <span class="text-white font-bold">{{ $game->formatted_price }}</span>
                                        @endif
                                    </div>
                                    <button onclick="addToCart({{ $game->id }})" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.467-.881-6.08-2.33M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-white mb-2">No games found</h3>
                            <p class="text-gray-400">Try adjusting your filters or search terms</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($games->hasPages())
                    <div class="mt-8">
                        {{ $games->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
