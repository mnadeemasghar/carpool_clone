<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($ride) ? __('Edit Ride Request') : __('Create Ride Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('address.create') }}" class="inline-block px-6 py-2 mb-4 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                {{ __('Add a Missing Address') }}
            </a>
            <div class="overflow-hidden sm:rounded-lg">
                <form class="space-y-4" action="{{ isset($ride) ? route('ride.update', $ride->id) : route('ride.store') }}" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 sm:p-6 lg:p-8">                    
                        @csrf
                        @if (isset($ride))
                            @method('PUT')
                        @endif

                        <div>
                            <x-label for="pick_location_id" class="block text-sm font-medium text-gray-700">{{ __('Pick Location') }}</x-label>
                            <x-select
                                name="pick_location_id"
                                id="pick_location_id"
                                :data="$addresses"
                                :selected="isset($ride) ? $ride->pick_location_id : ''"
                                class="additional-classes"
                            />
                        </div>

                        <div>
                            <x-label for="pick_time" class="block text-sm font-medium text-gray-700">{{ __('Pick Time') }}</x-label>
                            <x-input type="time" name="pick_time" id="pick_time" value="{{ isset($ride) ? $ride->pick_time : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                        </div>

                        <div>
                            <x-label for="drop_location_id" class="block text-sm font-medium text-gray-700">{{ __('Drop Location') }}</x-label>
                            <x-select
                                name="drop_location_id"
                                id="drop_location_id"
                                :data="$addresses"
                                :selected="isset($ride) ? $ride->drop_location_id : ''"
                                class="additional-classes"
                            />
                        </div>

                        <div>
                            <x-label for="return_time" class="block text-sm font-medium text-gray-700">{{ __('Return Time') }}</x-label>
                            <x-input type="time" name="return_time" id="return_time" value="{{ isset($ride) ? $ride->return_time : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                        </div>
                        
                        <div>
                            <x-label for="start_date" class="block text-sm font-medium text-gray-700">{{ __('Start Date') }}</x-label>
                            <x-input type="date" name="start_date" id="start_date" value="{{ isset($ride) ? $ride->start_date : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                        </div>
                        
                        <div>
                            <x-label for="end_date" class="block text-sm font-medium text-gray-700">{{ __('End Date') }}</x-label>
                            <x-input type="date" name="end_date" id="end_date" value="{{ isset($ride) ? $ride->end_date : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const startDateInput = document.getElementById('start_date');
                                const endDateInput = document.getElementById('end_date');

                                // Set the minimum start date to today
                                const today = new Date().toISOString().split('T')[0];
                                startDateInput.setAttribute('min', today);

                                // Update the minimum end date based on the selected start date
                                startDateInput.addEventListener('change', function() {
                                    endDateInput.setAttribute('min', startDateInput.value);
                                });

                                // Ensure the end date is not less than the start date on page load (if values are pre-filled)
                                if (startDateInput.value) {
                                    endDateInput.setAttribute('min', startDateInput.value);
                                }
                            });
                        </script>

                        <div>
                            <x-label for="gender" class="block text-sm font-medium text-gray-700">{{ __('Gender') }}</x-label>
                            <x-select
                                name="gender"
                                id="gender"
                                :data="[['id' => 'Male','title' => 'Male'],['id' => 'Female','title' => 'Female']]"
                                :selected="isset($ride) ? $ride->gender : ''"
                                class="additional-classes"
                            />
                        </div>

                        <div>
                            <x-label for="role" class="block text-sm font-medium text-gray-700">{{ __('Role') }}</x-label>
                            <x-select
                                name="role"
                                id="role"
                                :data="[['id' => 'Driver','title' => 'Driver'],['id' => 'Passenger','title' => 'Passenger']]"
                                :selected="isset($ride) ? $ride->role : ''"
                                class="additional-classes"
                            />
                        </div>

                        <div>
                            <x-label for="trip_type" class="block text-sm font-medium text-gray-700">{{ __('Trip Type') }}</x-label>
                            <x-select
                                name="trip_type"
                                id="trip_type"
                                :data="[['id' => 'One Way','title' => 'One Way'],['id' => 'Round Trip','title' => 'Round Trip']]"
                                :selected="isset($ride) ? $ride->trip_type : ''"
                                class="additional-classes"
                            />
                        </div>

                        <div>
                            <x-label for="offer" class="block text-sm font-medium text-gray-700">{{ __('Offer Price') }}</x-label>
                            <x-input type="number" min="0" name="offer" id="offer" value="{{ isset($ride) ? $ride->offer : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <x-button type="submit">{{ isset($ride) ? __('Update') : __('Submit') }}</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
