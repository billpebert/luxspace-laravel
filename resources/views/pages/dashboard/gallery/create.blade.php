<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Product &raquo; {{ $product->name }} &raquo; Upload Photos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div>
                @if ($errors->any())
                <div class="mb-5" role="alert">
                    <div class="px-4 py-2 text-white bg-red-500 rounded-t">
                        Something went wrong!
                    </div>
                    <div class="px-4 py-3 text-red-700 bg-red-100 border border-t-0 border-red-400 rounded-b">
                        <p>
                        <ul>
                            @foreach ($errors as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </p>
                    </div>
                </div>
                @endif

                <form action="{{ route('dashboard.product.gallery.store', $product->id) }}" class="w-full" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap gap-5 mb-5 -mx-3">
                        <div class="w-full px-3">
                            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase">
                                Browse Photos
                            </label>
                            <input type="file" multiple accept="image/*" name="files[]"
                                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-green-200"
                                placeholder="Product Photos" />
                        </div>
                    </div>
                    <div class="flex flex-row justify-end">
                        <button type="submit"
                            class="px-4 py-2 font-semibold text-white transition duration-300 ease-out bg-green-500 rounded hover:bg-green-700">
                            Upload Photos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
</x-app-layout>