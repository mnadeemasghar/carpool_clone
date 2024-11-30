<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($withdraw) ? __('Create Withdraw') : __('Create Topup') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <form class="space-y-4" action="{{ isset($withdraw) ? route('admin.wallet.withdraw.store') : route('admin.wallet.topup.store') }}" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 sm:p-6 lg:p-8">                    
                        @csrf

                        <div>
                            <x-label for="user_id" class="block text-sm font-medium text-gray-700">{{ __('User') }}</x-label>
                            <x-select
                                name="user_id"
                                id="user_id"
                                title="name"
                                :data="$users"
                            />
                        </div>

                        <div>
                            <x-label for="amount" class="block text-sm font-medium text-gray-700">{{ __('Amount') }}</x-label>
                            <x-input type="number" name="amount" id="amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <x-button type="submit">{{ isset($withdraw) ? __('Withdraw') : __('Topup') }}</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
