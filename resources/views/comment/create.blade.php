<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($ride) ? __('Edit Ride Request') : __('Create Ride Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <form class="space-y-4" action="{{ isset($ride) ? route('ride.update', $ride->id) : route('ride.store') }}" method="POST">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 sm:p-6 lg:p-8">                    
                        @csrf
                        @if (isset($ride))
                            @method('PUT')
                        @endif

                        <div>
                            <x-label for="pick_location" class="block text-sm font-medium text-gray-700">{{ __('Pick Location') }}</x-label>
                            <x-input type="text" name="pick_location" id="pick_location" oninput="fetchAddress('pick_location')" autocomplete="off" value="{{ isset($ride) ? $ride->pick_location->title : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                            <div id="pick_location_results"></div>
                        </div>
                        
                        <div>
                            <x-label for="pick_time" class="block text-sm font-medium text-gray-700">{{ __('Pick Time') }}</x-label>
                            <x-input type="time" name="pick_time" id="pick_time" value="{{ isset($ride) ? $ride->pick_time : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                        </div>
                        
                        <div>
                            <x-label for="drop_location" class="block text-sm font-medium text-gray-700">{{ __('Drop Location') }}</x-label>
                            <x-input type="text" name="drop_location" id="drop_location" oninput="fetchAddress('drop_location')" autocomplete="off" value="{{ isset($ride) ? $ride->drop_location->title : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required />
                            <div id="drop_location_results"></div>
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
                            <x-label for="vehicle_type" class="block text-sm font-medium text-gray-700">{{ __('Vehicle Type') }}</x-label>
                            <x-select
                                name="vehicle_type"
                                id="vehicle_type"
                                :data="[['id' => 'Car','title' => 'Car'],['id' => 'Van','title' => 'Van'],['id' => 'Bike','title' => 'Bike']]"
                                :selected="isset($ride) ? $ride->vehicle_type : ''"
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

                        <div>
                            <x-label for="note" class="block text-sm font-medium text-gray-700">{{ __('Extra Note') }}</x-label>
                            <x-input type="text" name="note" id="note" value="{{ isset($ride) ? $ride->note : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>
                        
                        <div class="flex flex-wrap">
                            <!-- Monday -->
                            <div class="flex items-center ml-6 mb-2 sm:mb-0 sm:mr-6">
                                <input type="checkbox" name="mon" id="mon" {{ isset($ride) && $ride->mon ? 'checked' : '' }} class="mr-1" />
                                <x-label for="mon" class="text-sm font-medium text-gray-700">{{ __('Monday') }}</x-label>
                            </div>

                            <!-- Tuesday -->
                            <div class="flex items-center ml-6 mb-2 sm:mb-0 sm:mr-6">
                                <input type="checkbox" name="tue" id="tue" {{ isset($ride) && $ride->tue ? 'checked' : '' }} class="mr-1" />
                                <x-label for="tue" class="text-sm font-medium text-gray-700">{{ __('Tuesday') }}</x-label>
                            </div>

                            <!-- Wednesday -->
                            <div class="flex items-center ml-6 mb-2 sm:mb-0 sm:mr-6">
                                <input type="checkbox" name="wed" id="wed" {{ isset($ride) && $ride->wed ? 'checked' : '' }} class="mr-1" />
                                <x-label for="wed" class="text-sm font-medium text-gray-700">{{ __('Wednesday') }}</x-label>
                            </div>

                            <!-- Thursday -->
                            <div class="flex items-center ml-6 mb-2 sm:mb-0 sm:mr-6">
                                <input type="checkbox" name="thu" id="thu" {{ isset($ride) && $ride->thu ? 'checked' : '' }} class="mr-1" />
                                <x-label for="thu" class="text-sm font-medium text-gray-700">{{ __('Thursday') }}</x-label>
                            </div>

                            <!-- Friday -->
                            <div class="flex items-center ml-6 mb-2 sm:mb-0 sm:mr-6">
                                <input type="checkbox" name="fri" id="fri" {{ isset($ride) && $ride->fri ? 'checked' : '' }} class="mr-1" />
                                <x-label for="fri" class="text-sm font-medium text-gray-700">{{ __('Friday') }}</x-label>
                            </div>

                            <!-- Saturday -->
                            <div class="flex items-center ml-6 mb-2 sm:mb-0 sm:mr-6">
                                <input type="checkbox" name="sat" id="sat" {{ isset($ride) && $ride->sat ? 'checked' : '' }} class="mr-1" />
                                <x-label for="sat" class="text-sm font-medium text-gray-700">{{ __('Saturday') }}</x-label>
                            </div>

                            <!-- Sunday -->
                            <div class="flex items-center ml-6">
                                <input type="checkbox" name="sun" id="sun" {{ isset($ride) && $ride->sun ? 'checked' : '' }} class="mr-1" />
                                <x-label for="sun" class="text-sm font-medium text-gray-700">{{ __('Sunday') }}</x-label>
                            </div>
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
