<a href="{{$url ?? ''}}" style="text-decoration: none;">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 hover:bg-gray-100 cursor-pointer flex justify-between items-center">
        <div>
            <div class="text-xl font-semibold text-gray-800">{{ $title }}</div>
            <div class="mt-4 text-3xl font-bold text-gray-900">
                {{ $count ?? "" }}
            </div>
        </div>
        <div class="text-gray-800">
            &rarr;
        </div>
    </div>
</a>
