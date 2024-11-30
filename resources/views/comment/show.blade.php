<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Ride Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <x-back-link href>{{ __(" <= Return Back") }}</x-back-link>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Pick Location') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->pick_location->title }}
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
                            {{ $ride->drop_location->title }}
                        </div>
                    </div>

                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Return Time') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->return_time }}
                        </div>
                    </div>

                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Start Date') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->start_date }}
                        </div>
                    </div>
                    
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('End Date') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->end_date }}
                        </div>
                    </div>
                    
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Gender') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->gender }}
                        </div>
                    </div>
                    
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Vehicle Type') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->vehicle_type }}
                        </div>
                    </div>
                    
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Role') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->role }}
                        </div>
                    </div>
                    
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Trip Type') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->trip_type }}
                        </div>
                    </div>
                    
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Offer Price') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->offer }}
                        </div>
                    </div>
                    
                    <div>
                        <x-label class="block text-sm font-medium text-gray-700">{{ __('Extra Note') }}</x-label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->note }}
                        </div>
                    </div>
                    
                    <div>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 p-2">
                            {{ $ride->mon ? "Monday, ":"" }}
                            {{ $ride->tue ? "Tuesday, ":"" }}
                            {{ $ride->wed ? "Wednesday, ":"" }}
                            {{ $ride->thu ? "Thursday, ":"" }}
                            {{ $ride->fri ? "Friday, ":"" }}
                            {{ $ride->sat ? "Saturday, ":"" }}
                            {{ $ride->sun ? "Sunday":"" }}
                        </div>
                    </div>

                    @if ($ride->user_id == auth()->user()->id)
                        <div class="col-span-1 md:col-span-2 flex justify-between">
                            <a href="{{ route('ride.edit', $ride->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                            <form action="{{ route('ride.destroy', $ride->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" class="bg-red-600 hover:bg-red-700">{{ __('Delete') }}</x-button>
                            </form>
                        </div>
                    @elseif (in_array(auth()->user()->id, $ride->interested_users->pluck('id')->toArray()))
                        <div class="col-span-1 md:col-span-2 flex justify-between">
                            <form action="{{ route('ride.interested', $ride->id) }}" method="POST">
                                @csrf
                                <x-button type="submit" class="bg-black-600 hover:bg-black-700">{{ __('Undo my interest') }}</x-button>
                            </form>
                        </div>
                    @else
                        <div class="col-span-1 md:col-span-2 flex justify-between">
                            <form action="{{ route('ride.interested', $ride->id) }}" method="POST">
                                @csrf
                                <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700">{{ __('I am interested') }}</x-button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (in_array(auth()->user()->id, $ride->interested_users->pluck('id')->toArray()) || $ride->user_id == auth()->user()->id)
        <!-- Created By -->
        <div class="py-2">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                        <h3 class="font-semibold text-lg text-gray-800 leading-tight">
                            {{ __('Created By') }}
                        </h3>
                        <div>{{ $ride->user->name }} - {{ $ride->user->phone }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Interested Users -->
        @if ($ride->interested_users->count() > 0)
            <div class="py-2">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="overflow-hidden sm:rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                            <h3 class="font-semibold text-lg text-gray-800 leading-tight">
                                {{ __('Interested Users') }}
                            </h3>
                        </div>
                        @foreach ($ride->interested_users as $user)
                            <div class="py-2">
                                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                                            <div>{{ $user->name }} - {{ $user->phone }}</div>
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
