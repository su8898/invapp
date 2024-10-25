<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('customers.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="company_name" :value="__('Company Name')" />
                            <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name')" required autofocus autocomplete="company_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                        </div>

                        <div>
                            <x-input-label for="contact_name" value="Contact Name" />
                            <x-text-input id="contact_name" name="contact_name" type="text" class="mt-1 block w-full" :value="old('contact_name')" required autocomplete="none" />
                            <x-input-error class="mt-2" :messages="$errors->get('contact_name')" />
                        </div>

                        <div>
                            <x-input-label for="contact_no" value="Contact Number" />
                            <x-text-input id="contact_no" name="contact_no" type="text" class="mt-1 block w-full" :value="old('contact_no')" required autocomplete="none" />
                            <x-input-error class="mt-2" :messages="$errors->get('contact_no')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')"  autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="addr_number" :value="__('Address Number')" />
                            <x-text-input id="addr_number" name="addr_number" type="text" class="mt-1 block w-full" :value="old('addr_number')"  autocomplete="addr_number" />
                            <x-input-error class="mt-2" :messages="$errors->get('addr_number')" />
                        </div>

                        <div>
                            <x-input-label for="addr_street" :value="__('Street Address')" />
                            <x-text-input id="addr_street" name="addr_street" type="text" class="mt-1 block w-full" :value="old('addr_street')"  autocomplete="addr_street" />
                            <x-input-error class="mt-2" :messages="$errors->get('addr_street')" />
                        </div>

                        <div>
                            <x-input-label for="addr_city" :value="__('City')" />
                            <x-text-input id="addr_city" name="addr_city" type="text" class="mt-1 block w-full" :value="old('addr_city')"  autocomplete="addr_city" />
                            <x-input-error class="mt-2" :messages="$errors->get('addr_city')" />
                        </div>

                        <div>
                            <x-input-label for="addr_postcode" :value="__('Postcode')" />
                            <x-text-input id="addr_postcode" name="addr_postcode" type="text" class="mt-1 block w-full" :value="old('addr_postcode')"  autocomplete="addr_postcode" />
                            <x-input-error class="mt-2" :messages="$errors->get('addr_postcode')" />
                        </div>

                        <div>
                            <x-input-label for="vat_no" value="VAT #" />
                            <x-text-input id="vat_no" name="vat_no" type="text" class="mt-1 block w-full" :value="old('vat_no')"  autocomplete="none" />
                            <x-input-error class="mt-2" :messages="$errors->get('vat_no')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create') }}</x-primary-button>

                            @if (session('status') === 'customer-created')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Customer created successfully.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
