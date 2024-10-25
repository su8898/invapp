<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customers
        </h2>
    </x-slot>


    <div class="pt-6 text-left">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-left">
                <a href="{{ URL::to('customers/create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    New Customer
                </a>
            </div>
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="text-left">
                                    <th scope="col" class="px-6 py-3 text-left">
                                        <div class="py-3">Company Name</div>
                                    </th>
                                    <td scope="col" class="px-6 py-3">
                                        Contact Name
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                        City
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                        VAT #
                                    </td>
                                    <td scope="col" class="px-6 py-3">
                                        Action
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-left">
                                        {{ $customer->company_name }}                                             
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $customer->contact_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $customer->addr_city }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $customer->vat_no }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    </td>
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