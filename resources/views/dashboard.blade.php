<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-semibold mb-4">Welcome <span>{{ Auth::user()->name }}!</span></h1>

                    <!-- Invoice Summary Card-->
                    <div class="mt-6 bg-gray-50 p-6 rounded-lg shadow w-1/3 float-left mb-8">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Invoice Summary for This Month</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600 w-40">Total Gross Amount:</span>
                                <span class="text-gray-800">€ {{ number_format($totalGrossAmount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600 w-40">Total VAT Amount:</span>
                                <span class="text-gray-800">€ {{ number_format($totalVatAmount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600 w-40">Total Net Amount:</span>
                                <span class="text-gray-800">€ {{ number_format($totalNetAmount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- End Invoice Summary Card -->

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
