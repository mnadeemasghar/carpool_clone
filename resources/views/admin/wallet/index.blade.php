<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
                @if (isset($cards) && $cards->count() > 0)
                    @foreach ($cards as $card)
                        <x-dashboard-card title="{{$card['title']}}" :count="isset($card['count']) ? $card['count'] : false " :url="$card['url']" />
                    @endforeach
                @endif
            </div>
        </div>
        
    </div>
</x-app-layout>
