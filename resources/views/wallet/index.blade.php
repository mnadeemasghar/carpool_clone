<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Wallet') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('wallet.how.to.topup') }}" class="inline-block px-6 py-2 mb-4 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
            {{ __('How to Top Up or Withdraw from My Account?') }}
        </a>
            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
                @if (isset($wallets) && $wallets->count() > 0)
                    @foreach ($wallets as $wallet)
                        <x-dashboard-card title="{{$wallet['currency_symbol']}}" :count="$wallet['amount']" />
                    @endforeach
                @else
                    {{__('No wallet')}}
                @endif
            </div>
        </div>
    </div>

    @if (isset($wallet_entries) && $wallet_entries->count() > 0)
        {{ $wallet_entries->links() }}
        @foreach ($wallet_entries as $wallet_entry)
            <x-wallet-entry :entry="$wallet_entry" />
        @endforeach
        {{ $wallet_entries->links() }}
    @endif

</x-app-layout>
