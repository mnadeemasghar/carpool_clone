<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($data->isNotEmpty())
                {{ $data->appends(request()->query())->links() }}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="overflow-x-auto">
                        <table class="table table-responsive table-hover table-bordered">
                            <thead>
                                <tr>
                                    @foreach (array_keys($data->first()->toArray()) as $header)
                                        @php
                                            $currentSorts = request('sort', []);
                                            $currentOrder = $currentSorts[$header] ?? null;
                                            $nextOrder = $currentOrder === 'asc' ? 'desc' : ($currentOrder === 'desc' ? null : 'asc');
                                            
                                            $sortIcon = $currentOrder === 'asc'
                                                ? 'bi bi-sort-down'
                                                : ($currentOrder === 'desc' ? 'bi bi-sort-up' : 'bi bi-arrow-down-up');
                                            
                                            // Construct updated sorting query for multi-column sorting
                                            $newSorts = $currentSorts;
                                            if ($nextOrder) {
                                                $newSorts[$header] = $nextOrder;
                                            } else {
                                                unset($newSorts[$header]);
                                            }
                                        @endphp
                                        <th class="uppercase">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => $newSorts]) }}">
                                                <i class="{{ $sortIcon }}"></i> {{ ucfirst(str_replace('_', ' ', $header)) }}
                                            </a>
                                        </th>
                                        @endforeach
                                        <th>
                                            Actions
                                        </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        @foreach ($row->toArray() as $key => $value)
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if (isset($imageKeys) && in_array($key, $imageKeys))
                                                    <img src="{{ $value }}" alt="{{ ucfirst($key) }} image" />
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                            @endforeach
                                            <td>
                                                <a href="{{ url(request()->path().'/'.$row->id) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                                                <a href="{{ url(request()->path().'/'.$row->id.'/edit') }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                                <a href="{{ url(request()->path().'/'.$row->id.'/delete') }}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $data->appends(request()->query())->links() }}
            @else
                <p>No data available</p>
            @endif
        </div>
    </div>
</x-app-layout>
