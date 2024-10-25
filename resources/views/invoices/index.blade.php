<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Invoices
        </h2>
    </x-slot>


    <div class="pt-6 text-left">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-left">
                <a href="{{ URL::to('invoices/create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    New Invoice
                </a>
            </div>
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="text-left">
                                    <th scope="col" class="px-6 py-3 text-left">
                                        <div class="py-3">Invoice #</div>
                                    </th>
                                    <td scope="col" class="px-6 py-3">
                                        Date
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                        Customer
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                        Net Amount
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                        Action
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>