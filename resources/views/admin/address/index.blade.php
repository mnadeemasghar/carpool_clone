<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Addresses has rides') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="p-0">
                    <x-map />
                    <table class="table table-bordered">
                        <thead>
                            <th></th>
                            <th>Title</th>
                            <th>Lat</th>
                            <th>Lng</th>
                            <th>Rides</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if (isset($addresses) && $addresses->count() > 0 )
                                @foreach ($addresses as $address)
                                <form action="{{ route('admin.address.update',['address' => $address]) }}" method="POST">
                                    @csrf
                                    @method("PUT")
                                    <tr>
                                        <td><input name="selectThis" type="radio" value="{{$address->id}}" /></td>
                                        <td>{{$address->title}}</td>
                                        <td><input type="text" name="lat" id="lat_{{$address->id}}" class="form-control" value="{{$address->lat}}" /></td>
                                        <td><input type="text" name="lng" id="lng_{{$address->id}}" class="form-control" value="{{$address->lng}}" /></td>
                                        <td>{{$address->rides_count}}</td>
                                        <td><button type="submit" class="btn btn-success">Save</button></td>
                                    </tr>  
                                </form>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Add a click event listener to the map
        map.on('click', function(e) {
            // Get the latitude and longitude from the event object
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            var checkedRadio = document.querySelector('input[name="selectThis"]:checked');

            // Check if a radio button is selected and retrieve its value
            if (checkedRadio) {
                document.getElementById("lat_" + checkedRadio.value).value = lat;
                document.getElementById("lng_" + checkedRadio.value).value = lng;
            }

            // Set the popup content and location, then open it
            // Create a popup instance
            var popup = L.popup();
            popup.setLatLng(e.latlng).setContent("Latitude: " + lat + "<br>Longitude: " + lng).openOn(map);
        });

    </script>
</x-app-layout>