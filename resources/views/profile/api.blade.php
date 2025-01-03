<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('API Token') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg md:px-4 px-6">
                <form class=md:"w-2/3" method="post" action="{{ route('token.store') }}" >
                <h3 class="py-6 text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __("Create API Token") }}
                </h3>
                    @if(session('message'))
                    <div class="my-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                      {{ session('message') }}
                    </div>
                    @endif
                      @csrf
                      <div class="mb-5">
                        <x-input-label for="name">Key Name</x-input-label>
                        <x-text-input type="text" id="name" name="name"
                        placeholder="" value="{{ old('name') }}" class="block mt-1 w-full
                        @error('name') ring-red-400 @enderror"></x-text-input>
                        @error('name')
                        <span class="text-sm text-red-600 dark:text-red-400
                        space-y-1 my-2">{{ $message }}</span>
                        @enderror
                      </div>
                      <x-primary-button>Create</x-primary-button>
                </form>
                <div class="my-6"></div>

                    @if(count($tokens) > 0)
                    <div class="overflow-x-auto md:w-2/3">
                <h3 class="py-6 text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __("Manage API Token") }}
                </h3>
                    @if(session('key'))
                    <div class="my-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    Token successfully generated. Please save the token as it will not reappear.
                    <div class="mt-4 bg-gray-100 dark:bg-gray-900 px-4 py-2 rounded font-mono text-sm text-gray-500 break-all">
                      {{ session('key') }}
                    </div>
                    </div>
                    @endif
                    <table class="w-full text-sm text-left rtl:text-right
                    text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Key Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tokens as $token)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    {{ $token->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <form method="post" action="{{ route('token.destroy', $token->id) }}">
                                        @csrf
                                        @method('delete')
                                        <x-danger-button>Delete</x-danger-button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</x-app-layout>
