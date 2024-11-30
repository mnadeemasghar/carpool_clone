@props(['name', 'id' => '', 'title' => null, 'data' => [], 'selected' => null, 'class' => '', 'disabled' => false])

<select name="{{ $name }}" id="{{ $id }}" {{ $disabled ? 'disabled' : '' }} class="select2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 {{ $class }}">
    @foreach ($data as $item)
        <option value="{{ $item['id'] }}" {{ $selected == $item['id'] ? 'selected' : '' }}>
            @if ($title)
                {{ $item[$title] }}
            @else
                {{ $item['title'] }}
            @endif
        </option>
    @endforeach
</select>
