<x-app-layout>
    <div class="max-w-full mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Admin Dashboard</h1>
            <p class="text-gray-400">Manage games and monitor system statistics</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Games</p>
                        <p class="text-2xl font-bold text-white">{{ $totalGames }}</p>
                    </div>
                    <div class="bg-blue-600 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Featured Games</p>
                        <p class="text-2xl font-bold text-white">{{ $featuredGames }}</p>
                    </div>
                    <div class="bg-yellow-600 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">New Releases</p>
                        <p class="text-2xl font-bold text-white">{{ $newReleases }}</p>
                    </div>
                    <div class="bg-green-600 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Bestsellers</p>
                        <p class="text-2xl font-bold text-white">{{ $bestsellers }}</p>
                    </div>
                    <div class="bg-purple-600 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Comming Soon</p>
                        <p class="text-2xl font-bold text-white">{{ $commingSoon }}</p>
                    </div>
                    <div class="bg-gray-600 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Games Management -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-white">Games Management</h2>
                <a href="{{ route('admin.games.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Add New Game
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Games Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-gray-300 font-semibold py-3 px-4">Image</th>
                            <th class="text-gray-300 font-semibold py-3 px-4">Title</th>
                            <th class="text-gray-300 font-semibold py-3 px-4">Developer</th>
                            <th class="text-gray-300 font-semibold py-3 px-4">Price</th>
                            <th class="text-gray-300 font-semibold py-3 px-4">Status</th>
                            <th class="text-gray-300 font-semibold py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($games as $game)
                            <tr class="border-b border-gray-700/50 hover:bg-gray-700/30">
                                <td class="py-4 px-4">
                                    <img src="{{ $game->image_url }}" alt="{{ $game->title }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                </td>
                                <td class="py-4 px-4">
                                    <div>
                                        <p class="text-white font-semibold">{{ $game->title }}</p>
                                        <p class="text-gray-400 text-sm">{{ Str::limit($game->short_description, 50) }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-gray-300">{{ $game->developer }}</td>
                                <td class="py-4 px-4">
                                    @if($game->hasDiscount())
                                        <div>
                                            <span class="text-green-400 font-bold">{{ $game->formatted_discount_price }}</span>
                                            <span class="text-gray-400 line-through text-sm block">{{ $game->formatted_price }}</span>
                                        </div>
                                    @else
                                        <span class="text-white font-bold">{{ $game->formatted_price }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if($game->is_featured)
                                            <span class="bg-blue-600 text-white px-2 py-1 rounded text-xs">Featured</span>
                                        @endif
                                        @if($game->is_new_release)
                                            <span class="bg-green-600 text-white px-2 py-1 rounded text-xs">New</span>
                                        @endif
                                        @if($game->is_bestseller)
                                            <span class="bg-yellow-600 text-black px-2 py-1 rounded text-xs">Bestseller</span>
                                        @endif
                                        @if($game->is_comming_soon)
                                            <span class="bg-purple-600 text-white px-2 py-1 rounded text-xs">Comming Soon</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.games.show', $game) }}" 
                                           class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('admin.games.edit', $game) }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.games.destroy', $game) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete this game?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-400">
                                    No games found. <a href="{{ route('admin.games.create') }}" class="text-blue-400 hover:text-blue-300">Create your first game</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($games->hasPages())
                <div class="mt-6">
                    {{ $games->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
