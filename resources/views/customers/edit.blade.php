<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $customer->company_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('customers.update', $customer->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $customer->company_name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                        </div>

                        <div>
                            <x-input-label for="contact_name" value="Contact Name" />
                            <x-text-input id="contact_name" name="contact_name" type="text" class="mt-1 block w-full" :value="old('contact_name', $customer->contact_name)" required autocomplete="none" />
                            <x-input-error class="mt-2" :messages="$errors->get('contact_name')" />
                        </div>
                        <div>
                            <x-input-label for="contact_number" value="Contact Number" />
                            <x-text-input id="contact_no" name="contact_no" type="text" class="mt-1 block w-full" :value="old('contact_no', $customer->contact_no)" required autocomplete="none" />
                            <x-input-error class="mt-2" :messages="$errors->get('contact_no')" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $customer->email)"  autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div>
                            <x-input-label for="addr_number" value="Number" />
                            <x-text-input id="addr_number" name="addr_number" type="text" class="mt-1 block w-full" :value="old('addr_number', $customer->addr_number)"  autocomplete="addr_number" />
                            <x-input-error class="mt-2" :messages="$errors->get('addr_number')" />
                        </div>
                        <div>
                            <x-input-label for="addr_street" value="Street" />
                            <x-text-input id="addr_street" name="addr_street" type="text" class="mt-1 block w-full" :value="old('addr_street', $customer->addr_street)"  autocomplete="addr_street" />
                            <x-input-error class="mt-2" :messages="$errors->get('addr_street')" />
                        </div>
                        <div>
                            <x-input-label for="addr_city" value="City" />
                            <x-text-input id="addr_city" name="addr_city" type="text" class="mt-1 block w-full" :value="old('addr_city', $customer->addr_city)"  autocomplete="addr_city" />
                            <x-input-error class="mt-2" :messages="$errors->get('addr_city')" />
                        </div>
                        <div>
                            <x-input-label for="addr_postcode" value="Post Code" />
                            <x-text-input id="addr_postcode" name="addr_postcode" type="text" class="mt-1 block w-full" :value="old('addr_postcode', $customer->addr_postcode)"  autocomplete="addr_postcode" />
                            <x-input-error class="mt-2" :messages="$errors->get('addr_postcode')" />
                        </div>
                        <div>
                            <x-input-label for="vat_no" value="VAT #" />
                            <x-text-input id="vat_no" name="vat_no" type="text" class="mt-1 block w-full" :value="old('vat_no', $customer->vat_no)"  autocomplete="none" />
                            <x-input-error class="mt-2" :messages="$errors->get('vat_no')" />
                        </div>


                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'customer-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
