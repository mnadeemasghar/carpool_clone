<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rides') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>User</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>  
                            </thead>
                            <tbody>
                            @if (isset($data) && $data->count() > 0)
                                @foreach ($data as $ride)
                                <tr>
                                    <td>
                                        <small>{{ $ride->vehicle_type }} {{ $ride->role }} {{ $ride->trip_type }}</small>
                                        <br>
                                        {{ $ride->user->name }}
                                    </td>
                                    <td><small>{{ $ride->pick_time }} ( {{ $ride->start_date }} )</small> <br> {{ $ride->pick_location->title }}</td>
                                    <td><small>{{ $ride->return_time }} ( {{ $ride->end_date }} )</small> <br> {{ $ride->drop_location->title }}</td>
                                    <td>{{ $ride->created_at }}</td>
                                    <td>
                                        <button 
                                            class="btn btn-primary" 
                                            onclick="copyToClipboard(`Pick Location: {{ $ride->pick_location->title }}\nDrop Location: {{ $ride->drop_location->title }}\nVehicle Type: {{ $ride->vehicle_type }}\nRole: {{ $ride->role }}\nTrip Type: {{ $ride->trip_type }}\nName: {{ $ride->user->name }}\nPick Time: {{ $ride->pick_time }}\nReturn Time: {{ $ride->return_time }}\nStart Date: {{ $ride->start_date }}\nEnd Date: {{ $ride->end_date }}\n\nView Details: {{ route('ride.show', ['ride' => $ride]) }}\n\nShared via CarpoolLahore.com`)">
                                            Copy Info
                                        </button>
                                    </td>
                                </tr> 
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyToClipboard(data) {
            // Create a temporary textarea to hold the data
            const tempTextarea = document.createElement('textarea');
            tempTextarea.value = data;

            // Append it to the body (required for copying to work on some browsers)
            document.body.appendChild(tempTextarea);

            // Select the text inside the textarea
            tempTextarea.select();
            tempTextarea.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text
            document.execCommand('copy');

            // Remove the temporary textarea
            document.body.removeChild(tempTextarea);

            // Optional: Provide feedback to the user
            alert('Ride information copied to clipboard!');
        }
    </script>
</x-app-layout>