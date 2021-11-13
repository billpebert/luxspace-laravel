<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product') }} &raquo; {{ $product->name }} &raquo; Gallery
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            // AJAX Datatable
            var datatable = $('#crudTable').DataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [
                    {data: 'id', name: 'id', width: '5%'},
                    {data: 'url', name: 'url'},
                    {data: 'is_featured', name: 'is_featured'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '25%'
                    }
                ]
            })
        </script>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('dashboard.product.gallery.create', $product->id) }}"
                    class="px-4 py-2 font-semibold text-white transition duration-300 ease-out bg-green-500 rounded hover:bg-green-700">
                    Upload Photos
                </a>
            </div>

            <div class="overflow-hidden shadow sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table class="" id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Featured</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>