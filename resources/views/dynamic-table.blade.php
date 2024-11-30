<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$title}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($data->isNotEmpty())
                    {{ $data->links() }}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @foreach (array_keys($data->first()->toArray()) as $header)
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ ucfirst(str_replace('_', ' ', $header)) }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($data as $row)
                                    <tr>
                                        @foreach ($row->toArray() as $key => $value)
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if (isset($imageKeys) && in_array($key,$imageKeys))
                                                    <img src="{{ $value }}" />
                                                @else
                                                {{ $value }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $data->links() }}
                @else
                    <p>No data available</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
