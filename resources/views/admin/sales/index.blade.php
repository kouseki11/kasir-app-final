<x-admin-layout>

    <div class="p-4 py-20 sm:ml-64">
        <div class="text-2xl">
            <p>Products Master</p>
        </div>

        <div class="mt-10">
            <p class="text-xl">List Products</p>
        </div>
        <div class="flex justify-between mt-4">
            <a href="{{ route('sale.export.excel') }}"
                class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                </svg>
                Export Sales
            </a>
            @if(Auth::user()->hasRole('staff'))
            <a href="{{ route('sale.create') }}"
                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Add Sale
            </a>
            @endif
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Customer Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sale Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price Total
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created By
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $sale['customer']['name'] }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $sale['sale_date'] }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                Rp. {{ number_format($sale['price_total'], 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $sale['user']['name'] }}
                            </td>
                            <td class="flex px-6 py-4 md:py-14  text-right gap-2">
                                <button data-modal-target="detail{{ $sale->id }}"
                                    data-modal-toggle="detail{{ $sale->id }}" type="button"
                                    class="text-white focus:ring-4 bg-yellow-300 hover:bg-yellow-800 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">Detail</button>
                                <a href="{{ route('sale.export', $sale->id) }}"
                                    class="text-white focus:ring-4 bg-blue-300 hover:bg-blue-800 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Download
                                    Proof</a>
                                @if(Auth::user()->hasRole('admin'))
                                <a href="{{ route('sale.destroy', $sale->id) }}" 
                                    class="text-white focus:ring-4 bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    Delete</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end mt-2">
            {{ $sales->links() }}
        </div>
    </div>


    @foreach ($sales as $sale)
        <!-- Main modal Stock -->
        <div id="detail{{ $sale->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-lg max-h-full">
                <!-- Modal content -->
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Sale Detail
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="detail{{ $sale->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="text-center">
                        <h2 class="text-2xl font-bold">Indo Agus</h2>
                    </div>

                    <div class="mt-4">
                        <div class="info">
                            <p class="mb-2">Customer Name : {{ $sale['customer']['name'] }}</p>
                            <p class="mb-2">Customer Address : {{ $sale['customer']['address'] }}</p>
                            <p class="mb-2">Custumer Phone Number : {{ $sale['customer']['phone_number'] }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div id="table">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                                        <th class="py-2 px-3 text-left">Product Name</th>
                                        <th class="py-2 px-3 text-left">Qty</th>
                                        <th class="py-2 px-3 text-left">Price</th>
                                        <th class="py-2 px-3 text-left">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale['saleDetail'] as $item)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-2 px-3">{{ $item['product']['name'] }}</td>
                                            <td class="py-2 px-3">{{ $item['quantity'] }}</td>
                                            <td class="py-2 px-3">Rp.
                                                {{ number_format($item['product']['price'], '0', ',', '.') }}</td>
                                            <td class="py-2 px-3">Rp.
                                                {{ number_format($item['subtotal'], '0', ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-gray-200">
                                        <td class="py-2 px-3"></td>
                                        <td class="py-2 px-3"></td>
                                        <td class="py-2 px-3 font-bold">Price Total</td>
                                        <td class="py-2 px-3 font-bold">Rp.
                                            {{ number_format($sale['price_total'], '0', ',', '.') }}</td>
                                    </tr>
                                    <tr class="bg-gray-200">
                                        <td class="py-2 px-3 font-bold">Cash</td>
                                        <td class="py-2 px-3"></td>
                                        <td class="py-2 px-3 font-bold"></td>
                                        <td class="py-2 px-3 font-bold">Rp.
                                            {{ number_format($sale['customer']['cash'], '0', ',', '.') }}</td>
                                    </tr>
                                    <tr class="bg-gray-200">
                                        <td class="py-2 px-3 font-bold">Change</td>
                                        <td class="py-2 px-3"></td>
                                        <td class="py-2 px-3 font-bold"></td>
                                        <td class="py-2 px-3 font-bold">Rp.
                                            {{ number_format($sale['customer']['change'], '0', ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="text-sm">{{ $sale['created_at'] }} | {{ $sale['user']['name'] }}</p>
                            <p class="legal text-gray-600"><strong>Thank you for your purchase!</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</x-admin-layout>
