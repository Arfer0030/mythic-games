<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-white">Edit Game: {{ $game->title }}</h1>
            </div>
            <p class="text-gray-400">Update game information and details</p>
        </div>

        <!-- Form -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-8">
            <form method="POST" action="{{ route('admin.games.update', $game) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Game Title *</label>
                        <input type="text" name="title" value="{{ old('title', $game->title) }}" required
                               class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Developer *</label>
                        <input type="text" name="developer" value="{{ old('developer', $game->developer) }}" required
                               class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('developer') border-red-500 @enderror">
                        @error('developer')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Publisher *</label>
                        <input type="text" name="publisher" value="{{ old('publisher', $game->publisher) }}" required
                               class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('publisher') border-red-500 @enderror">
                        @error('publisher')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Release Date *</label>
                        <input type="date" name="release_date" value="{{ old('release_date', $game->release_date->format('Y-m-d')) }}" required
                               class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('release_date') border-red-500 @enderror">
                        @error('release_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Descriptions -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Short Description *</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $game->short_description) }}" required
                           class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('short_description') border-red-500 @enderror"
                           placeholder="Brief description for cards and listings">
                    @error('short_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Full Description *</label>
                    <textarea name="description" rows="6" required
                              class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                              placeholder="Detailed description of the game">{{ old('description', $game->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pricing -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Price (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $game->price) }}" step="0.01" min="0" required
                               class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Discount Price (Rp)</label>
                        <input type="number" name="discount_price" value="{{ old('discount_price', $game->discount_price) }}" step="0.01" min="0"
                               class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('discount_price') border-red-500 @enderror">
                        @error('discount_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">User Rating (1-5) *</label>
                        <input type="number" name="user_rating" value="{{ old('user_rating', $game->user_rating) }}" step="0.1" min="0" max="5" required
                               class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_rating') border-red-500 @enderror">
                        @error('user_rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Media -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Main Image URL *</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $game->image_url) }}" required
                           class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image_url') border-red-500 @enderror"
                           placeholder="https://example.com/image.jpg">
                    @error('image_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Screenshots -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Screenshots URLs</label>
                    <div id="screenshots-container">
                        @if(old('screenshots') || $game->screenshots)
                            @foreach(old('screenshots', $game->screenshots ?? []) as $index => $screenshot)
                                <div class="flex gap-2 mb-2">
                                    <input type="url" name="screenshots[]" value="{{ $screenshot }}"
                                           class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="https://example.com/screenshot.jpg">
                                    <button type="button" onclick="removeScreenshot(this)" class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg">Remove</button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex gap-2 mb-2">
                                <input type="url" name="screenshots[]"
                                       class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="https://example.com/screenshot.jpg">
                                <button type="button" onclick="removeScreenshot(this)" class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg">Remove</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addScreenshot()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                        Add Screenshot
                    </button>
                </div>

                <!-- Genres -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Genres *</label>
                    <div id="genres-container">
                        @if(old('genres') || $game->genres)
                            @foreach(old('genres', $game->genres ?? []) as $index => $genre)
                                <div class="flex gap-2 mb-2">
                                    <select name="genres[]" required class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Genre</option>
                                        <option value="Action" {{ $genre == 'Action' ? 'selected' : '' }}>Action</option>
                                        <option value="Adventure" {{ $genre == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                                        <option value="RPG" {{ $genre == 'RPG' ? 'selected' : '' }}>RPG</option>
                                        <option value="Strategy" {{ $genre == 'Strategy' ? 'selected' : '' }}>Strategy</option>
                                        <option value="Simulation" {{ $genre == 'Simulation' ? 'selected' : '' }}>Simulation</option>
                                        <option value="Sports" {{ $genre == 'Sports' ? 'selected' : '' }}>Sports</option>
                                        <option value="Racing" {{ $genre == 'Racing' ? 'selected' : '' }}>Racing</option>
                                        <option value="Puzzle" {{ $genre == 'Puzzle' ? 'selected' : '' }}>Puzzle</option>
                                        <option value="Horror" {{ $genre == 'Horror' ? 'selected' : '' }}>Horror</option>
                                        <option value="Indie" {{ $genre == 'Indie' ? 'selected' : '' }}>Indie</option>
                                    </select>
                                    <button type="button" onclick="removeGenre(this)" class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg">Remove</button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex gap-2 mb-2">
                                <select name="genres[]" required class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Genre</option>
                                    <option value="Action">Action</option>
                                    <option value="Adventure">Adventure</option>
                                    <option value="RPG">RPG</option>
                                    <option value="Strategy">Strategy</option>
                                    <option value="Simulation">Simulation</option>
                                    <option value="Sports">Sports</option>
                                    <option value="Racing">Racing</option>
                                    <option value="Puzzle">Puzzle</option>
                                    <option value="Horror">Horror</option>
                                    <option value="Indie">Indie</option>
                                </select>
                                <button type="button" onclick="removeGenre(this)" class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg">Remove</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addGenre()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                        Add Genre
                    </button>
                    @error('genres')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Content Rating *</label>
                    <select name="rating" required class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rating') border-red-500 @enderror">
                        <option value="">Select Rating</option>
                        <option value="E" {{ old('rating', $game->rating) == 'E' ? 'selected' : '' }}>E - Everyone</option>
                        <option value="T" {{ old('rating', $game->rating) == 'T' ? 'selected' : '' }}>T - Teen</option>
                        <option value="M" {{ old('rating', $game->rating) == 'M' ? 'selected' : '' }}>M - Mature</option>
                        <option value="AO" {{ old('rating', $game->rating) == 'AO' ? 'selected' : '' }}>AO - Adults Only</option>
                    </select>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Flags -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $game->is_featured) ? 'checked' : '' }}
                               class="bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500 rounded mr-3">
                        <label class="text-gray-300">Featured Game</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_new_release" value="1" {{ old('is_new_release', $game->is_new_release) ? 'checked' : '' }}
                               class="bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500 rounded mr-3">
                        <label class="text-gray-300">New Release</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $game->is_bestseller) ? 'checked' : '' }}
                               class="bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500 rounded mr-3">
                        <label class="text-gray-300">Bestseller</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_comming_soon" value="1" {{ old('is_comming_soon', $game->is_comming_soon) ? 'checked' : '' }}
                               class="bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500 rounded mr-3">
                        <label class="text-gray-300">Comming Soon</label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex space-x-4 pt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors" id="updateBtn">
                        <span id="updateText">Update Game</span>
                        <span id="updateLoader" class="hidden">Updating...</span>
                    </button>
                    <a href="{{ route('admin.games.show', $game) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addScreenshot() {
            const container = document.getElementById('screenshots-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = `
                <input type="url" name="screenshots[]" 
                       class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://example.com/screenshot.jpg">
                <button type="button" onclick="removeScreenshot(this)" class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg">Remove</button>
            `;
            container.appendChild(div);
        }

        function removeScreenshot(button) {
            button.parentElement.remove();
        }

        function addGenre() {
            const container = document.getElementById('genres-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2';
            div.innerHTML = `
                <select name="genres[]" class="flex-1 bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Genre</option>
                    <option value="Action">Action</option>
                    <option value="Adventure">Adventure</option>
                    <option value="RPG">RPG</option>
                    <option value="Strategy">Strategy</option>
                    <option value="Simulation">Simulation</option>
                    <option value="Sports">Sports</option>
                    <option value="Racing">Racing</option>
                    <option value="Puzzle">Puzzle</option>
                    <option value="Horror">Horror</option>
                    <option value="Indie">Indie</option>
                </select>
                <button type="button" onclick="removeGenre(this)" class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg">Remove</button>
            `;
            container.appendChild(div);
        }

        function removeGenre(button) {
            const container = document.getElementById('genres-container');
            if (container.children.length > 1) {
                button.parentElement.remove();
            }
        }
    </script>
</x-app-layout>
