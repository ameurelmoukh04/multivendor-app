<x-app-layout title="{{ $product->name }} | SpeedRapid">

@push('styles')
<style>
    .product-show-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .product-main {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 4rem;
    }

    @media (max-width: 968px) {
        .product-main {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }

    /* Image Slider */
    .image-slider-container {
        position: relative;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .dark .image-slider-container {
        background: #1f2937;
    }

    .image-slider {
        position: relative;
        width: 100%;
        aspect-ratio: 1;
        overflow: hidden;
    }

    .slider-wrapper {
        display: flex;
        transition: transform 0.4s ease-in-out;
        height: 100%;
    }

    .slider-image {
        min-width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #333;
        transition: all 0.3s;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }
    .dark .slider-nav {
        background: rgba(31, 41, 55, 0.9);
        color: #f9fafb;
    }

    .slider-nav:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-50%) scale(1.1);
    }
    .dark .slider-nav:hover {
        background: rgba(31, 41, 55, 1);
    }

    .slider-nav.prev {
        left: 15px;
    }

    .slider-nav.next {
        right: 15px;
    }

    .slider-nav:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .slider-indicators {
        display: flex;
        justify-content: center;
        gap: 8px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.95);
    }
    .dark .slider-indicators {
        background: rgba(31, 41, 55, 0.95);
    }

    .indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #cbd5e1;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        padding: 0;
    }
    .dark .indicator {
        background: #4b5563;
    }

    .indicator.active {
        background: #3b82f6;
        width: 30px;
        border-radius: 5px;
    }
    .dark .indicator.active {
        background: #60a5fa;
    }

    /* Product Info */
    .product-info {
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        line-height: 1.2;
    }
    .dark .product-title {
        color: #f9fafb;
    }

    .product-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2rem;
        color: #6b7280;
        font-size: 0.95rem;
    }
    .dark .product-meta {
        color: #9ca3af;
    }

    .product-meta strong {
        color: #374151;
        font-weight: 600;
    }
    .dark .product-meta strong {
        color: #e5e7eb;
    }

    .product-price-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #e5e7eb;
    }
    .dark .product-price-section {
        border-bottom-color: #4b5563;
    }

    .product-price {
        font-size: 3rem;
        font-weight: 700;
        color: #10b981;
        margin-bottom: 1rem;
        line-height: 1;
    }
    .dark .product-price {
        color: #34d399;
    }

    .stock-badge {
        display: inline-block;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stock-badge.in-stock {
        background: #d1fae5;
        color: #065f46;
    }
    .dark .stock-badge.in-stock {
        background: #064e3b;
        color: #d1fae5;
    }

    .stock-badge.out-of-stock {
        background: #fee2e2;
        color: #991b1b;
    }
    .dark .stock-badge.out-of-stock {
        background: #7f1d1d;
        color: #fee2e2;
    }

    .product-description {
        margin-bottom: 2rem;
    }

    .product-description h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.75rem;
    }
    .dark .product-description h3 {
        color: #f9fafb;
    }

    .product-description p {
        color: #4b5563;
        line-height: 1.7;
        font-size: 1rem;
    }
    .dark .product-description p {
        color: #d1d5db;
    }

    .product-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-add-cart {
        flex: 1;
        padding: 1rem 2rem;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-add-cart:hover:not(:disabled) {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-add-cart:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .btn-back {
        padding: 1rem 2rem;
        background: #6b7280;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #4b5563;
        transform: translateY(-2px);
    }

    /* Reviews Section */
    .reviews-section {
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 2px solid #e5e7eb;
    }
    .dark .reviews-section {
        border-top-color: #4b5563;
    }

    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .reviews-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }
    .dark .reviews-title {
        color: #f9fafb;
    }

    .reviews-stats {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .average-rating {
        font-size: 2.5rem;
        font-weight: 700;
        color: #f59e0b;
    }

    .total-reviews {
        color: #6b7280;
        font-size: 0.95rem;
    }
    .dark .total-reviews {
        color: #9ca3af;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .review-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }
    .dark .review-card {
        background: #1f2937;
        border-color: #4b5563;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .reviewer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .reviewer-details h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 0.25rem 0;
    }
    .dark .reviewer-details h4 {
        color: #f9fafb;
    }

    .reviewer-details .review-date {
        font-size: 0.875rem;
        color: #6b7280;
    }
    .dark .reviewer-details .review-date {
        color: #9ca3af;
    }

    .star-rating {
        display: flex;
        gap: 2px;
    }

    .star {
        font-size: 1.25rem;
        color: #fbbf24;
    }

    .star.empty {
        color: #d1d5db;
    }
    .dark .star.empty {
        color: #4b5563;
    }

    .review-content {
        color: #4b5563;
        line-height: 1.7;
        font-size: 1rem;
    }
    .dark .review-content {
        color: #d1d5db;
    }

    .no-reviews {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }
    .dark .no-reviews {
        color: #9ca3af;
    }

    .no-reviews-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 640px) {
        .product-title {
            font-size: 2rem;
        }

        .product-price {
            font-size: 2.5rem;
        }

        .reviews-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .product-actions {
            flex-direction: column;
        }
    }
</style>
@endpush

<div class="product-show-container">
    <div class="product-main">
        <!-- Image Slider -->
        <div class="image-slider-container">
            @if($product->images->count() > 0)
                <div class="image-slider" id="imageSlider">
                    <div class="slider-wrapper" id="sliderWrapper">
                        @foreach($product->images as $image)
                            <img 
                                src="{{ asset('storage/' . $image->image_path) }}" 
                                alt="{{ $product->name }}" 
                                class="slider-image"
                            >
                        @endforeach
                    </div>
                    @if($product->images->count() > 1)
                        <button class="slider-nav prev" id="prevBtn" onclick="changeSlide(-1)">‹</button>
                        <button class="slider-nav next" id="nextBtn" onclick="changeSlide(1)">›</button>
                        <div class="slider-indicators" id="indicators">
                            @foreach($product->images as $index => $image)
                                <button 
                                    class="indicator {{ $index === 0 ? 'active' : '' }}" 
                                    onclick="goToSlide({{ $index }})"
                                    aria-label="Go to slide {{ $index + 1 }}"
                                ></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="image-slider">
                    <img 
                        src="https://via.placeholder.com/600?text=No+Image" 
                        alt="{{ $product->name }}" 
                        class="slider-image"
                    >
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <h1 class="product-title">{{ $product->name }}</h1>
            
            <div class="product-meta">
                <div>
                    Sold by: <strong>{{ $product->vendor->store_name }}</strong>
                </div>
                <div>
                    Category: <strong>{{ $product->category->name }}</strong>
                </div>
            </div>

            <div class="product-price-section">
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                <span class="stock-badge {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                    {{ $product->stock > 0 ? 'In Stock (' . $product->stock . ' available)' : 'Out of Stock' }}
                </span>
            </div>

            <div class="product-description">
                <h3>Description</h3>
                <p>{{ $product->description ?? 'No description available.' }}</p>
            </div>

            <div class="product-actions">
                @if($product->stock > 0)
                    <button 
                        class="btn-add-cart" 
                        onclick="addToCart({{ $product->id }})"
                        id="addToCartBtn"
                    >
                        <span>Ajouter au Panier</span>
                    </button>
                @else
                    <button class="btn-add-cart" disabled>
                        Out of Stock
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <div class="reviews-header">
            <h2 class="reviews-title">Customer Reviews</h2>
            @if($product->reviews->count() > 0)
                <div class="reviews-stats">
                    <div class="average-rating">
                        {{ number_format($product->reviews->avg('rating'), 1) }}
                    </div>
                    <div>
                        <div class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $product->reviews->avg('rating') ? '' : 'empty' }}">
                                    {{ $i <= $product->reviews->avg('rating') ? '★' : '☆' }}
                                </span>
                            @endfor
                        </div>
                        <div class="total-reviews">
                            Based on {{ $product->reviews->count() }} {{ Str::plural('review', $product->reviews->count()) }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if($product->reviews->count() > 0)
            <div class="reviews-list">
                @foreach($product->reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    {{ strtoupper(substr($review->client->name, 0, 1)) }}
                                </div>
                                <div class="reviewer-details">
                                    <h4>{{ $review->client->name }}</h4>
                                    <div class="review-date">{{ $review->created_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">
                                        {{ $i <= $review->rating ? '★' : '☆' }}
                                    </span>
                                @endfor
                            </div>
                        </div>
                        <div class="review-content">
                            {{ $review->comment }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-reviews">
                <div class="no-reviews-icon">💬</div>
                <p style="font-size: 1.1rem; margin-bottom: 0.5rem;">No reviews yet</p>
                <p>Be the first to review this product!</p>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <div style="margin-top: 3rem;">
        <a href="{{ route('products.index') }}" class="btn-back">
            <span>←</span>
            <span>Back to Products</span>
        </a>
    </div>
</div>

@push('scripts')
<script>
    // Image Slider Functionality
    let currentSlide = 0;
    const totalSlides = {{ $product->images->count() }};
    const sliderWrapper = document.getElementById('sliderWrapper');
    const indicators = document.querySelectorAll('.indicator');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    function updateSlider() {
        if (sliderWrapper) {
            sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
        
        // Update indicators
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentSlide);
        });

        // Update navigation buttons
        if (prevBtn) prevBtn.disabled = currentSlide === 0;
        if (nextBtn) nextBtn.disabled = currentSlide === totalSlides - 1;
    }

    function changeSlide(direction) {
        const newSlide = currentSlide + direction;
        if (newSlide >= 0 && newSlide < totalSlides) {
            currentSlide = newSlide;
            updateSlider();
        }
    }

    function goToSlide(index) {
        if (index >= 0 && index < totalSlides) {
            currentSlide = index;
            updateSlider();
        }
    }

    // Auto-play slider (optional)
    let autoPlayInterval;
    function startAutoPlay() {
        if (totalSlides > 1) {
            autoPlayInterval = setInterval(() => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }, 5000);
        }
    }

    function stopAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
        }
    }

    // Initialize slider
    if (totalSlides > 0) {
        updateSlider();
        startAutoPlay();
        
        // Pause on hover
        const slider = document.getElementById('imageSlider');
        if (slider) {
            slider.addEventListener('mouseenter', stopAutoPlay);
            slider.addEventListener('mouseleave', startAutoPlay);
        }
    }

    // Add to Cart Functionality
    function addToCart(productId) {
        // Get product data
        const user = @json(Auth::user());
        @auth
        const isUser = @json(Auth::user()->isUser()? true : false);
        @endauth
        if(!user){
            window.location.href = '{{ route("login") }}';
            return;
        }
        if(!isUser){
            alert('you have not permission to add to cart');
            return;
        }
        const product = {
            id: {{ $product->id }},
            name: "{{ $product->name }}",
            price: {{ $product->price }},
            img: @if($product->images->count() > 0) "{{ asset('storage/' . $product->images->first()->image_path) }}" @else "https://via.placeholder.com/400?text=No+Image" @endif,
            stock: {{ $product->stock }},
            slug: "{{ $product->slug }}",
            description: "{{ addslashes($product->description ?? '') }}"
        };

        // Get existing cart
        let cart = JSON.parse(localStorage.getItem('speedRapidCart')) || [];

        // Check if product is already in cart
        const existingIndex = cart.findIndex(item => item.id === productId);
        
        if (existingIndex > -1) {
            // Product already in cart
            if (confirm('This product is already in your cart. Would you like to view your cart?')) {
                // Open cart sidebar if it exists
                if (typeof toggleCart === 'function') {
                    toggleCart();
                } else {
                    window.location.href = '{{ route("products.index") }}';
                }
            }
            return;
        }

        // Add to cart
        cart.push(product);
        localStorage.setItem('speedRapidCart', JSON.stringify(cart));

        // Show success message
        const btn = document.getElementById('addToCartBtn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span>✓</span><span>Added to Cart!</span>';
        btn.style.background = '#10b981';
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.style.background = '';
        }, 2000);

        // Update cart UI if function exists
        if (typeof updateCartUI === 'function') {
            updateCartUI();
        }
    }
</script>
@endpush

</x-app-layout>
