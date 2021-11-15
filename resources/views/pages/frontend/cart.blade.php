@extends('layouts.frontend')

@section('content')
<!-- START: BREADCRUMB -->
<section class="px-4 py-8 bg-gray-100">
    <div class="container mx-auto">
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('index') }}">Home</a>
            </li>
            <li>
                <a href="#" aria-label="current-page">Shopping Cart</a>
            </li>
        </ul>
    </div>
</section>
<!-- END: BREADCRUMB -->

<!-- START: COMPLETE YOUR ROOM -->
<section class="md:py-16">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap -mx-4">
            <div class="w-full px-4 mb-4 md:w-8/12 md:mb-0" id="shopping-cart">
                <div class="flex pb-3 mt-8 mb-4 border-b border-gray-200 flex-start md:border-b-0">
                    <h3 class="text-2xl">Shopping Cart</h3>
                </div>

                <div class="hidden mb-4 border-b border-gray-200 md:block">
                    <div class="flex items-center pb-2 -mx-4 flex-start">
                        <div class="flex-none px-4">
                            <div class="" style="width: 90px">
                                <h6>Photo</h6>
                            </div>
                        </div>
                        <div class="w-5/12 px-4">
                            <div class="">
                                <h6>Product</h6>
                            </div>
                        </div>
                        <div class="w-5/12 px-4">
                            <div class="">
                                <h6>Price</h6>
                            </div>
                        </div>
                        <div class="w-2/12 px-4">
                            <div class="text-center">
                                <h6>Action</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- START: ROW 1 -->
                @forelse ($carts as $cart)
                <div class="flex flex-wrap items-center mb-4 -mx-4 flex-start" data-row="1">
                    <div class="flex-none px-4">
                        <div class="" style="width: 90px; height: 90px">
                            <img src="{{ $cart->product->galleries()->exists() ? Storage::url($cart->product->galleries->first()->url) : 'data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==' }}"
                                alt="chair-1" class="object-cover w-full h-full rounded-xl" />
                        </div>
                    </div>
                    <div class="flex-1 w-auto px-4 md:w-5/12">
                        <div class="">
                            <h6 class="text-lg font-semibold leading-8 md:text-xl">
                                {{ $cart->product->name }}
                            </h6>
                            <span class="text-sm md:text-lg">Office Room</span>
                            <h6 class="block text-base font-semibold md:text-lg md:hidden">
                                IDR {{ number_format($cart->product->price) }}
                            </h6>
                        </div>
                    </div>
                    <div class="flex-none hidden w-auto px-4 md:flex-1 md:w-5/12 md:block">
                        <div class="">
                            <h6 class="text-lg font-semibold">IDR {{ number_format($cart->product->price) }}</h6>
                        </div>
                    </div>
                    <div class="w-2/12 px-4">
                        <div class="text-center">
                            <form action="{{ route('deleteCart', $cart->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 text-red-600 border-none focus:outline-none">
                                    X
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p id="cart-empty" class="py-8 text-center">
                    Ooops... Cart is empty
                    <a href="{{ route('index') }}" class="underline">Shop Now</a>
                </p>
                @endforelse

                <!-- END: ROW 1 -->
            </div>
            <div class="w-full md:px-4 md:w-4/12" id="shipping-detail">
                <div class="px-4 py-6 bg-gray-100 md:p-8 md:rounded-3xl">
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <div class="flex mb-6 flex-start">
                            <h3 class="text-2xl">Shipping Details</h3>
                        </div>

                        <div class="flex flex-col mb-4">
                            <label for="complete-name" class="mb-2 text-sm">Complete Name</label>
                            <input data-input type="text" name="name" id="complete-name"
                                class="px-4 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-200 focus:outline-none"
                                placeholder="Input your name" />
                        </div>

                        <div class="flex flex-col mb-4">
                            <label for="email" class="mb-2 text-sm">Email Address</label>
                            <input data-input type="email" name="email" id="email"
                                class="px-4 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-200 focus:outline-none"
                                placeholder="Input your email address" />
                        </div>

                        <div class="flex flex-col mb-4">
                            <label for="address" class="mb-2 text-sm">Address</label>
                            <input data-input type="text" name="address" id="address"
                                class="px-4 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-200 focus:outline-none"
                                placeholder="Input your address" />
                        </div>

                        <div class="flex flex-col mb-4">
                            <label for="phone-number" class="mb-2 text-sm">Phone Number</label>
                            <input data-input type="tel" name="phone" id="phone-number"
                                class="px-4 py-2 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-200 focus:outline-none"
                                placeholder="Input your phone number" />
                        </div>

                        <div class="flex flex-col mb-4">
                            <label for="complete-name" class="mb-2 text-sm">Choose Courier</label>
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-6/12 h-24 px-2 mb-4">
                                    <button type="button" data-value="fedex" data-name="courier"
                                        class="flex items-center justify-center w-full h-full bg-white border border-gray-200 focus:border-red-200 rounded-xl focus:outline-none">
                                        <img src="{{ url('/frontend/images/content/logo-fedex.svg') }}" alt="Logo Fedex"
                                            class="object-contain max-h-full" />
                                    </button>
                                </div>
                                <div class="w-6/12 h-24 px-2 mb-4">
                                    <button type="button" data-value="dhl" data-name="courier"
                                        class="flex items-center justify-center w-full h-full bg-white border border-gray-200 focus:border-red-200 rounded-xl focus:outline-none">
                                        <img src="{{ url('/frontend/images/content/logo-dhl.svg') }}" alt="Logo dhl"
                                            class="object-contain max-h-full" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col mb-4">
                            <label for="complete-name" class="mb-2 text-sm">Choose Payment</label>
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-6/12 h-24 px-2 mb-4">
                                    <button type="button" data-value="midtrans" data-name="payment"
                                        class="flex items-center justify-center w-full h-full bg-white border border-gray-200 focus:border-red-200 rounded-xl focus:outline-none">
                                        <img src="{{ url('/frontend/images/content/logo-midtrans.png') }}"
                                            alt="Logo midtrans" class="object-contain max-h-full" />
                                    </button>
                                </div>
                                <div class="w-6/12 h-24 px-2 mb-4">
                                    <button type="button" data-value="mastercard" data-name="payment"
                                        class="flex items-center justify-center w-full h-full bg-white border border-gray-200 focus:border-red-200 rounded-xl focus:outline-none">
                                        <img src="{{ url('/frontend/images/content/logo-mastercard.svg') }}"
                                            alt="Logo mastercard" />
                                    </button>
                                </div>
                                <div class="w-6/12 h-24 px-2 mb-4">
                                    <button type="button" data-value="bitcoin" data-name="payment"
                                        class="flex items-center justify-center w-full h-full bg-white border border-gray-200 focus:border-red-200 rounded-xl focus:outline-none">
                                        <img src="{{ url('/frontend/images/content/logo-bitcoin.svg') }}"
                                            alt="Logo bitcoin" class="object-contain max-h-full" />
                                    </button>
                                </div>
                                <div class="w-6/12 h-24 px-2 mb-4">
                                    <button type="button" data-value="american-express" data-name="payment"
                                        class="flex items-center justify-center w-full h-full bg-white border border-gray-200 focus:border-red-200 rounded-xl focus:outline-none">
                                        <img src="{{ url('/frontend/images/content/logo-american-express') }}.svg"
                                            alt="Logo american-logo-american-express" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" disabled
                                class="w-full px-6 py-3 text-lg text-black transition-all duration-200 bg-pink-400 rounded-full hover:bg-black hover:text-pink-400 focus:outline-none focus:text-black">
                                Checkout Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END: COMPLETE YOUR ROOM -->
@endsection