<x-admin-layout>

    <div class="p-4 py-20 sm:ml-64">
        <div class="text-2xl">
            <p>Sales Master</p>
        </div>

        <div class="mt-4 w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-xl font-medium text-gray-900 dark:text-white">Create new sale</h5>
            <!-- Form -->
            <form class="space-y-6" action="{{ route('sale.invoice') }}" method="POST">
                @csrf
                

                <div class="mt-4 w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="text-xl font-medium text-gray-900 dark:text-white">Add Product Sale</h5>
                    <div id="productInputs">
                        <!-- Form -->
                        <div class="product-input">
                        <div class="space-y-6">
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-1">
                                    <label for="category"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product</label>
                                    <select name="product_id[]" id="category"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option disabled selected="">Select product</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-1">
                                    <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                                    <input type="number" name="quantity[]" placeholder="Type product quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                                </div>
                                <button type="button" class="w-32 text-black bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                onclick="removeProductInput(this)">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="w-32 mt-4 text-black bg-yellow-300 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800"
                        onclick="addProductInput()">
                            Add Input
                        </button>
                    </div>
                </div>
                <button type="submit"
                    class="w-full mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Create Invoice</button>
            </form>
        </div>
    </div>

</x-admin-layout>

