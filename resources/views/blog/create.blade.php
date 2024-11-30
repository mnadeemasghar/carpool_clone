<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-12 md:grid-cols-12 gap-6 lg:gap-8 p-6 lg:p-8">
                    <form class="space-y-4" action="{{ route('admin.blog.store') }}" method="POST">
                        @csrf

                        <div>
                            <x-label class="block text-sm font-medium text-gray-700">{{__('Title')}}</x-label>
                            <x-input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <div>
                            <x-label class="block text-sm font-medium text-gray-700">{{__('Category')}}</x-label>
                            <x-input type="text" name="catagory" id="catagory" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <div>
                            <x-label class="block text-sm font-medium text-gray-700">{{__('content')}}</x-label>
                            <textarea id="content" name="content" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>                        </div>

                        <div class="col-span-2">
                            <x-button type="submit">{{ __('Submit') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
