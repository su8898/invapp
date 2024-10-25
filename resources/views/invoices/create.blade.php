<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('invoices.store') }}" class="mt-6 space-y-6">
                        @csrf
                        <div class="grid grid-cols-2 grid-flow-row gap-4">
                            <div>
                                <div>Customer</div>
                                <div x-data="{ open: false }" class="">
                                    <!-- Input Group with Icon -->
                                    <div class="flex items-center border border-gray-300 rounded-md p-2 bg-white">
                                        <input type="text" class="border-0 focus:outline-none flex-1 px-2" placeholder="Select customer">
                                        <button @click="open = true" type="button" class="inline-flex items-center px-3 text-gray-500">
                                            <!-- Icon (use any icon framework like FontAwesome, Heroicons, etc.) -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a5 5 0 100-10 5 5 0 000 10zm-7 8a7 7 0 0114 0H3z" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Address Box -->
                                    <div class="mt-4 p-4 border border-gray-300 rounded-md bg-white">
                                        <p>Het Vlaams Parlement</p>
                                        <p>Leuvensweg 86</p>
                                        <p>1000 Brussel</p>
                                        <p>België</p>
                                        <p class="mt-2">BE 0931.814.563</p>
                                    </div>
                                    <!-- Modal -->
                                    <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                            <h2 class="text-lg font-bold mb-4">Modal Title</h2>
                                            <p>This is the content of the modal dialog. You can place any information here.</p>

                                            <!-- Close Button -->
                                            <div class="mt-4">
                                                <button type="button" @click="open = false" class="bg-blue-500 text-black px-4 py-2 rounded-md hover:bg-blue-600">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div>Date</div>
                                <div class="p-4">
                                    <!-- Form Group: Datum -->
                                    <div class="flex items-center mb-4">
                                        <label class="w-40 text-gray-700">Datum</label>
                                        <input type="text" class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="01/02/2019">
                                    </div>

                                    <!-- Form Group: Factuurnummer -->
                                    <div class="flex items-center mb-4">
                                        <label class="w-40 text-gray-700">Factuurnummer</label>
                                        <input type="text" class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="2019-0011">
                                    </div>

                                    <!-- Form Group: Betalingstermijn and Vervaldatum -->
                                    <div class="flex items-center mb-4">
                                        <label class="w-40 text-gray-700">Betalingstermijn</label>
                                        <div class="relative w-full">
                                            <select class="appearance-none border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option>14 dagen</option>
                                                <option>30 dagen</option>
                                                <option>60 dagen</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="ml-4 text-gray-600">Vervaldatum: 15/02/2019</span>
                                    </div>

                                    <!-- Form Group: Uw Referentie -->
                                    <div class="flex items-center mb-4">
                                        <label class="w-40 text-gray-700">Uw referentie</label>
                                        <input type="text" class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="PO/1234">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="flex items-center gap-4">

                            <x-primary-button>Save</x-primary-button>

                            @if (session('status') === 'invoice-created')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600">{{ __('Invoice created successfully.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>