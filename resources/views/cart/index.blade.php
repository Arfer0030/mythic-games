<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Shopping Cart</h1>
            <p class="text-gray-400">Review your selected games before checkout</p>
        </div>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 cart-item" data-cart-id="{{ $item->id }}">
                            <div class="flex items-center space-x-6">
                                <!-- Game Image -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $item->game->image_url }}" alt="{{ $item->game->title }}" 
                                         class="w-24 h-24 object-cover rounded-lg">
                                </div>

                                <!-- Game Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $item->game->title }}</h3>
                                    <p class="text-gray-400 text-sm mb-2">{{ $item->game->developer }}</p>
                                    
                                    <!-- Genres -->
                                    <div class="flex flex-wrap gap-1 mb-3">
                                        @if(is_array($item->game->genres))
                                            @foreach(array_slice($item->game->genres, 0, 3) as $genre)
                                                <span class="bg-blue-600/20 text-blue-300 px-2 py-1 rounded text-xs">{{ $genre }}</span>
                                            @endforeach
                                        @endif
                                    </div>

                                    <!-- Price -->
                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if($item->hasDiscount())
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-2xl font-bold text-green-400">{{ $item->formatted_discount_price }}</span>
                                                    <span class="text-lg line-through text-gray-400">{{ $item->formatted_price }}</span>
                                                </div>
                                            @else
                                                <span class="text-2xl font-bold text-white">{{ $item->formatted_price }}</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Remove Button -->
                                        <button onclick="removeFromCart({{ $item->id }})" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 sticky top-8">
                        <h3 class="text-xl font-bold text-white mb-6">Order Summary</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-300">
                                <span>Subtotal ({{ $cartItems->count() }} items)</span>
                                <span id="subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-300">
                                <span>Tax</span>
                                <span>Rp 0</span>
                            </div>
                            <div class="border-t border-gray-700 pt-3">
                                <div class="flex justify-between text-xl font-bold text-white">
                                    <span>Total</span>
                                    <span id="total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <button onclick="checkout()" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors mb-4">
                            Proceed to Checkout
                        </button>

                        <div class="text-center">
                            <a href="{{ route('discovery') }}" class="text-blue-400 hover:text-blue-300 text-sm">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
                <h3 class="text-2xl font-bold text-white mb-4">Your cart is empty</h3>
                <p class="text-gray-400 mb-8">Looks like you haven't added any games to your cart yet.</p>
                <a href="{{ route('discovery') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    Browse Games
                </a>
            </div>
        @endif
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-gray-800 rounded-xl p-8 max-w-md mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">Payment Successful!</h3>
                <p class="text-gray-400 mb-4" id="successMessage">Your games have been added to your library.</p>
                <p class="text-green-400 font-bold mb-6" id="successTotal"></p>
                <button onclick="closeSuccessModal()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                    Continue
                </button>
            </div>
        </div>
    </div>

    <script>
        // Add CSRF token to all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function removeFromCart(cartId) {
            if (!confirm('Are you sure you want to remove this game from your cart?')) {
                return;
            }

            $.ajax({
                url: `/cart/remove/${cartId}`,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        // Remove the cart item from DOM
                        $(`.cart-item[data-cart-id="${cartId}"]`).fadeOut(300, function() {
                            $(this).remove();
                            
                            // Update cart count
                            $('#cart-count').text(response.cart_count);
                            
                            // Reload page if cart is empty
                            if (response.cart_count === 0) {
                                location.reload();
                            } else {
                                // Recalculate total (you might want to implement this)
                                location.reload();
                            }
                        });
                        
                        // Show success message
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Failed to remove item from cart!');
                }
            });
        }

        function checkout() {
            $.ajax({
                url: '{{ route("cart.checkout") }}',
                type: 'POST',
                success: function(response) {
                    if (response.success) {
                        // Update cart count
                        $('#cart-count').text(response.cart_count);
                        
                        // Show success modal
                        $('#successMessage').text(response.message);
                        $('#successTotal').text(`Total: ${response.total}`);
                        $('#successModal').removeClass('hidden').addClass('flex');
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Payment failed! Please try again.');
                }
            });
        }

        function closeSuccessModal() {
            $('#successModal').removeClass('flex').addClass('hidden');
            // Redirect to dashboard or reload page
            window.location.href = '{{ route("dashboard") }}';
        }
    </script>
</x-app-layout>
