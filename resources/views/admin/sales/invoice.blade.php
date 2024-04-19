<x-admin-layout>

    <div class="p-4 py-20 sm:ml-64">
        <div class="text-2xl">
            <p>Sales Master</p>
        </div>

        <div
            class="mt-4 w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between">
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Create new invoice</h5>
                <a href="{{ route('sale.index') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back</a>
            </div>
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-1">
                        <div class="bg-white shadow-md rounded-md p-4">
                            <input type="hidden" name="_token" value="UEZyFSU0K9Fzk81Dcg79XewXYIkkWtDJiwPP098T"
                                autocomplete="off">
                            <input type="hidden" name="_method" value="POST">
                            <h2 class="text-lg font-semibold mb-4">Selected Product</h2>
                            <table class="w-full mb-4">
                                <thead></thead>
                                @php
                                    $price_total = 0;
                                @endphp
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->name }} <br> <small>
                                                    @foreach ($products as $p)
                                                        @if ($p['product_id'] == $item->id)
                                                            @php
                                                                $price = $p['quantity'] * $item->price;
                                                                $price_total += $price;
                                                            @endphp
                                                            Rp. {{ number_format($item->price, 2, ',', '.') }} x
                                                            {{ $p['quantity'] }}
                                                        @endif
                                                    @endforeach
                                                </small></td>
                                            <td><b>(Rp. {{ number_format($price, 2, ',', '.') }})</b></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="pt-5 text-lg"><b>Total</b></td>
                                        <td class="text-right pt-5 text-lg"><b>Rp.
                                                {{ number_format($price_total, 2, ',', '.') }}</b></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="text" name="total" value="75000" hidden>
                        </div>
                    </div>
                    <form action="{{ route('sale.invoice-data') }}" method="POST">
                        @csrf
                        <div class="col-span-1">
                            <div class="bg-white shadow-md rounded-md p-4">
                                <div class="mb-4">
                                    <label class="block font-semibold mb-1">Data Customer <span
                                            class="text-red-500">*</span></label>
                                    <div class="col-span-1">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer
                                            Name</label>
                                        <input type="text" name="name" id="name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="Type customer name" required />
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="col-span-1">
                                        <label for="phone_number"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone
                                            Number</label>
                                        <input type="text" name="phone_number" id="phone_number"
                                            placeholder="Type customer phone number"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            required />
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="col-span-1">
                                        <label for="cash"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cash</label>
                                        <input type="text" name="cash" id="cash"
                                            placeholder="Type customer cash"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            required />
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="col-span-2">
                                        <label for="address"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                        <textarea type="text" name="address" id="address" placeholder="Type customer address"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="mt-4">
                    <button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        type="submit">Confirm Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
