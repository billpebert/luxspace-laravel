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
                <a href="#" aria-label="current-page">Success Checkout</a>
            </li>
        </ul>
    </div>
</section>
<!-- END: BREADCRUMB -->

<!-- START: CONGRATS -->
<section class="">
    <div class="container min-h-screen mx-auto">
        <div class="flex flex-col items-center justify-center">
            <div class="w-full text-center md:w-4/12">
                <img src="{{ url('/frontend/images/content/illustration-success.png') }}" alt="congrats illustration" />
                <h2 class="mb-6 text-3xl font-semibold">Ah yes it’s success!</h2>
                <p class="mb-12 text-lg">
                    Furniture yang anda beli akan kami kirimkan saat ini juga so now
                    please sit tight and be ready for it
                </p>
                <a href="{{ route('index') }}"
                    class="w-full px-8 py-3 text-lg text-gray-900 transition-all duration-200 bg-red-200 rounded-full cursor-pointer focus:outline-none focus:text-black">
                    Back to Shop
                </a>
            </div>
        </div>
    </div>
</section>
<!-- END: CONGRATS -->
@endsection