<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div x-data="editInvoice({{ json_encode($invoice) }})" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('invoices.update', $invoice->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Customer Selection and Address Box -->
                        <div class="grid grid-cols-2 grid-flow-row gap-4">
                            <div>
                                <div>Customer</div>
                                <div>
                                    <div class="flex items-center border border-gray-300 rounded-md p-2 bg-white" :class="{'border-red-500 bg-red-100': errors.customer_id}">
                                        <input type="text" x-model="selectedCustomer" class="border-0 focus:outline-none flex-1 px-2 bg-transparent" placeholder="Select customer" readonly>
                                        <button @click="open = true" type="button" class="inline-flex items-center px-3 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a5 5 0 100-10 5 5 0 000 10zm-7 8a7 7 0 0114 0H3z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="hidden" name="customer_id" :value="selectedCustomerId">

                                    <!-- Address Box -->
                                    <div id="addressBox" class="mt-4 p-4 border border-gray-300 rounded-md bg-white">
                                        <p>{{ $invoice->customer->addr_number }} {{ $invoice->customer->addr_street }}</p>
                                        <p>{{ $invoice->customer->addr_city }}</p>
                                        <p>{{ $invoice->customer->addr_postcode }}</p>
                                        <p class="mt-2">{{ $invoice->customer->vat_no }}</p>
                                    </div>

                                    <!-- Customer Modal -->
                                    <div x-cloak x-show="open" class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                            <h2 class="text-lg font-bold mb-4">Select Customer</h2>
                                            <select x-ref="customerSelect" class="appearance-none border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                @foreach ($customersList as $customer)
                                                <option value="{{ $customer->id }}"> {{ $customer->company_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="mt-4 flex justify-end space-x-4">
                                                <button type="button" @click="open = false" class="bg-gray-200 text-black px-4 py-2 rounded-md hover:bg-gray-300">Close</button>
                                                <button type="button" @click="selectedCustomer = $refs.customerSelect.options[$refs.customerSelect.selectedIndex].text; selectedCustomerId = $refs.customerSelect.value; fetchCustomerAddress($refs.customerSelect.value); open = false" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Select</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Invoice Fields -->
                            <div class="p-4">
                                <div class="flex items-center mb-4">
                                    <label class="w-40 text-gray-700">Date</label>
                                    <input type="date" x-model="invoice_date" class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" :class="{'border-red-500 bg-red-100': errors.invoice_date}">
                                </div>
                                <div class="flex items-center mb-4">
                                    <label class="w-40 text-gray-700">Terms</label>
                                    <select x-model="terms" class="appearance-none border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option values="14 days">14 days</option>
                                        <option values="30 days">30 days</option>
                                        <option values="60 days">60 days</option>
                                    </select>
                                </div>
                                <div class="flex items-center mb-4">
                                    <label class="w-40 text-gray-700">Your Reference</label>
                                    <input type="text" class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" x-model="reference" placeholder="PO/1234">
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Items -->
                        <button @@click="addItem" type="button" class="bg-gray-200 text-black px-4 py-2 rounded-md hover:bg-gray-300">Add Item</button>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="grid grid-cols-[40px_1fr_60px_80px_100px_80px_30px] items-center gap-4">
                                <div class="text-left">#</div>
                                <div class="text-left">Particulars</div>
                                <div class="text-right">Qty</div>
                                <div class="text-right">Rate</div>
                                <div class="text-right">Amount</div>
                                <div class="text-right">VAT %</div>
                                <div></div>
                            </div>
                            <template x-for="item in items.filter(i => i.markedToDelete == false)" :key="item.seqNo">
                                <div class="grid grid-cols-[40px_1fr_60px_80px_100px_80px_30px] items-center gap-x-4">
                                    <div x-text="item.seqNo"></div>
                                    <input x-model="item.particulars" class="min-w-0 flex-grow border border-gray-200 rounded-md" placeholder="Enter particulars" />
                                    <input x-model.number="item.qty" @input="calcAmount(item)" class="text-right border border-gray-200 rounded-md" placeholder="Qty" />
                                    <input x-model.number="item.rate" @input="calcAmount(item)" class="text-right border border-gray-200 rounded-md" placeholder="Rate" />
                                    <input x-model="item.amount" readonly class="text-right border border-gray-200 rounded-md" placeholder="Amount" />
                                    {{-- <input type="checkbox" x-model="item.vatApplicable" class="ml-2" /> --}}
                                    <input x-model.number="item.vat_perc"  class="text-right border border-gray-200 rounded-md" placeholder="VAT %" />
                                    <button @click="deleteItem(item)" type="button" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M6.225 4.811a.75.75 0 011.06 0L12 9.525l4.715-4.714a.75.75 0 111.06 1.06L13.06 10.585l4.715 4.715a.75.75 0 11-1.06 1.06L12 11.645l-4.715 4.715a.75.75 0 11-1.06-1.06l4.714-4.715-4.714-4.715a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-md grid grid-cols-[auto_180px] justify-items-end gap-x-2 gap-y-2">
                            <div class="text-right font-semibold">Gross Amount:</div>
                            <div x-text="grossAmount" class="text-right"></div>

                            <div class="text-right font-semibold">VAT Amount:</div>
                            <div x-text="vatAmount" class="text-right"></div>

                            <div class="text-right font-semibold">Net Amount:</div>
                            <div x-text="netAmount" class="text-right"></div>
                        </div>
                        <!-- Save Button -->
                        <div class="flex items-right gap-4">
                            <x-primary-button type="button" @click="updateInvoice">Update</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function fetchCustomerAddress(customerId) {
        fetch(`/customer/${customerId}/address`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    document.getElementById('addressBox').innerHTML = `
                        <p>${data.addr_number} ${data.addr_street}</p>
                        <p>${data.addr_city}</p>
                        <p>${data.addr_postcode}</p>
                        <p>${data.vat_no}</p>
                    `;
                }
            })
            .catch(error => console.error('Error:', error));
    }

</script>
