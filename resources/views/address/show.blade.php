<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Ride Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Pick Location') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->pick_location }}
                        </div>
                    </div>

                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Pick Time') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->pick_time }}
                        </div>
                    </div>

                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Drop Location') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->drop_location }}
                        </div>
                    </div>

                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Return Time') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->return_time }}
                        </div>
                    </div>

                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Gender') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->gender }}
                        </div>
                    </div>
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Role') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->role }}
                        </div>
                    </div>

                    @if ($ride->user_id == auth()->user()->id)
                    <div class="col-span-2 flex justify-between">
                        <a href="{{ route('ride.edit', $ride->id) }}" >{{ __('Edit') }}</a>

                        <form action="{{ route('ride.destroy', $ride->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" class="bg-red-600 hover:bg-red-700">{{ __('Delete') }}</x-button>
                        </form>
                    </div>
                    @elseif (in_array(auth()->user()->id, $ride->interested_users->pluck('id')->toArray()))
                    <div class="col-span-2 flex justify-between">
                        <form action="{{ route('ride.interested', $ride->id) }}" method="POST">
                            @csrf
                            <x-button type="submit" class="bg-black-600 hover:bg-black-700">{{ __('Not Interested') }}</x-button>
                        </form>
                    </div>
                    @else
                    <div class="col-span-2 flex justify-between">
                        <form action="{{ route('ride.interested', $ride->id) }}" method="POST">
                            @csrf
                            <x-button type="submit" class="bg-red-600 hover:bg-red-700">{{ __('Interested') }}</x-button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (in_array(auth()->user()->id, $ride->interested_users->pluck('id')->toArray()) || $ride->user_id == auth()->user()->id )
    <!-- Created By -->
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight">
                        {{ __('Created By') }}
                    </h3>
                    {{ $ride->user->name }} - {{ $ride->user->phone }}
                </div>
            </div>
        </div>
    </div>

    <!-- Interested Users -->
    @if ($ride->interested_users->count() > 0)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                    <h3 class="font-semibold text-lg text-gray-800 leading-tight">
                        {{ __('Interested Users') }}
                    </h3>
                    </div>
                    @foreach ($ride->interested_users as $user)
                        <div class="py-2">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                                        {{ $user->name }} - {{ $user->phone }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
    @endif

    @endif
</x-app-layout>
