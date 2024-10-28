<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Invoices
        </h2>
    </x-slot>

    <div class="pt-6 text-left">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-left">
                <a href="{{ URL::to('invoices/create') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    New Invoice
                </a>
            </div>
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="">
                                <th scope="col" class="px-6 py-3 text-left">
                                    Invoice #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Customer
                                </th>
                                <th scope="col" class="px-6 py-4 text-right">
                                    Net Amount
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                                <tr class="bg-white dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        {{ $invoice->invoice_no }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $invoice->invoice_date->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('customers.show', $invoice->customer->id) }}"
                                           class="text-indigo-600 hover:text-indigo-900">
                                            {{ $invoice->customer->company_name ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        € {{ number_format($invoice->net_amt, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('invoices.show', $invoice->id) }}"
                                           class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-4">
                        {{ $invoices->links() }} <!-- Pagination links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
