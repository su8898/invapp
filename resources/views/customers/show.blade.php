<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $customer->company_name }}
            </h2>
            <a href="{{ route('customers.edit', $customer->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Edit
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold pb-2 border-b mb-2">Customer Details</h3>
                    <div class="grid grid-cols-[150px_1fr] gap-1">
                        <div><strong>Contact Name:</strong></div>
                        <div>{{ $customer->contact_name }}</div>

                        <div><strong>Email:</strong></div>
                        <div>{{ $customer->email }}</div>

                        <div><strong>Contact Number:</strong></div>
                        <div>{{ $customer->contact_no }}</div>

                        <div><strong>Address:</strong></div>
                        <div>{{ $customer->addr_number }}, {{ $customer->addr_street }}, {{ $customer->addr_city }}, {{ $customer->addr_postcode }}</div>

                        <div><strong>VAT No:</strong></div>
                        <div>{{ $customer->vat_no }}</div>
                    </div>

                    <h3 class="text-xl font-semibold mt-4 mb-2">Invoices</h3>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase  dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-2">Invoice Number</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2 text-right">Gross Amount</th>
                                    <th class="px-4 py-2 text-right">VAT Amount</th>
                                    <th class="px-4 py-2 text-right">Net Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customer->invoices as $invoice)
                                <tr>
                                    <td class="px-4 py-2">{{ $invoice->invoice_no }}</td>
                                    <td class="px-4 py-2">{{ $invoice->created_at->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($invoice->gross_amt, 2) }}</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($invoice->vat_amt, 2) }}</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($invoice->net_amt, 2) }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('invoices.show', $invoice->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-2 text-center">No invoices found for this customer.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
