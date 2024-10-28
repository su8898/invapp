<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invoice Details
            </h2>

            <div class="flex space-x-4 ml-auto">
                <a href="{{ route('invoices.print', $invoice->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Print
                </a>
                <a href="{{ route('invoices.edit', $invoice->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="pt-6 text-left">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Customer Information Column -->
                        <div>
                            <h3 class="text-lg font-bold mb-4 bg-gray-100 p-2 rounded">Customer Information</h3>
                            <div class="flex">
                                <p class="w-40 font-semibold">Company Name:</p>
                                <p>{{ $invoice->customer->company_name }}</p>
                            </div>
                            <div class="flex">
                                <p class="w-40 font-semibold">Contact Name:</p>
                                <p>{{ $invoice->customer->contact_name }}</p>
                            </div>
                            <div class="flex">
                                <p class="w-40 font-semibold">Contact Number:</p>
                                <p>{{ $invoice->customer->contact_no ?? 'N/A' }}</p>
                            </div>
                            <div class="flex">
                                <p class="w-40 font-semibold">Email:</p>
                                <p>{{ $invoice->customer->email ?? 'N/A' }}</p>
                            </div>
                            <div class="flex">
                                <p class="w-40 font-semibold">Address:</p>
                                <p>
                                    {{ $invoice->customer->addr_number ?? '' }}
                                    {{ $invoice->customer->addr_street ?? '' }},
                                    {{ $invoice->customer->addr_city ?? '' }}
                                    {{ $invoice->customer->addr_postcode ?? '' }}
                                </p>
                            </div>
                        </div>

                        <!-- Invoice Information Column -->
                        <div>
                            <h3 class="text-lg font-bold mb-4 bg-gray-100 p-2 rounded">Invoice Information</h3>
                            <div class="flex">
                                <p class="w-40 font-semibold">Invoice #:</p>
                                <p>{{ $invoice->invoice_no }}</p>
                            </div>
                            <div class="flex">
                                <p class="w-40 font-semibold">Date:</p>
                                <p>{{ $invoice->invoice_date->format('Y-m-d') }}</p>
                            </div>
                            <div class="flex">
                                <p class="w-40 font-semibold">Terms:</p>
                                <p>{{ $invoice->terms ?? 'N/A' }}</p>
                            </div>
                            <div class="flex">
                                <p class="w-40 font-semibold">Reference:</p>
                                <p>{{ $invoice->reference ?? 'N/A' }}</p>
                            </div>
                            <div class=" p-0 rounded">
                                <div class="flex">
                                    <p class="w-40 font-semibold">Gross Amount:</p>
                                    <p class="text-right w-24 font-semibold rounded">€ {{ number_format($invoice->gross_amt, 2) }}</p>
                                </div>
                                <div class="flex">
                                    <p class="w-40 font-semibold">VAT Amount:</p>
                                    <p class="text-right w-24 font-semibold rounded">€ {{ number_format($invoice->vat_amt, 2) }}</p>
                                </div>
                                <div class="flex">
                                    <p class="w-40 font-semibold">Net Amount:</p>
                                    <p class="text-right w-24 font-semibold rounded">€ {{ number_format($invoice->net_amt, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Invoice Items Table -->
                    <h3 class="text-lg font-bold mb-2">Invoice Items</h3>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Particulars</th>
                                    <th scope="col" class="px-6 py-3">Quantity</th>
                                    <th scope="col" class="px-6 py-3 text-right">Rate</th>
                                    <th scope="col" class="px-6 py-3 text-right">Amount</th>
                                    <th scope="col" class="px-6 py-3 text-right">VAT %</th>
                                    <th scope="col" class="px-6 py-3 text-right">VAT</th>
                                    <th scope="col" class="px-6 py-3 text-right">Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->invoiceItems as $item)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">{{ $item->particulars }}</td>
                                    <td class="px-6 py-4">{{ $item->qty }}</td>
                                    <td class="px-6 py-4 text-right">€ {{ number_format($item->rate, 2) }}</td>
                                    <td class="px-6 py-4 text-right">€ {{ number_format($item->amount, 2) }}</td>
                                    <td class="px-6 py-4 text-right">{{ $item->vat_perc }}%</td>
                                    <td class="px-6 py-4 text-right">€ {{ number_format($item->vat, 2) }}</td>
                                    <td class="px-6 py-4 text-right">€ {{ number_format($item->net, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
