<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="overflow-x-auto lg:max-w-lg md:max-w-md max-w-sm mx-auto">

              <form class="flex gap-2 p-6 -mb-6">
                <x-text-input type="search" name="search" placeholder="Search..."
                autocomplete="off" value="{{ request('search') ?? null }}" required
                class="w-full" />
                <x-primary-button>Search</x-primary-button>
              </form>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('message'))
                    <div class="my-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                      {{ session('message') }}
                    </div>
                    @endif
                    <div class="my-4 flex gap-2">
                      <x-button-link href="{{ route('contacts.create') }}">Add new contact</x-button-link>
                    </div>
                    <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right
                    text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Profile
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Phone
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    @if($contact->profile)
                                    <img width="64px" alt="{{ $contact->name }}" src="/storage/{{ $contact->profile }}" />
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a class="underline text-sm text-gray-600
                                    dark:text-gray-400 hover:text-gray-900
                                    dark:hover:text-gray-100 rounded-md
                                    focus:outline-none focus:ring-2
                                    focus:ring-offset-2 focus:ring-indigo-500
                                    dark:focus:ring-offset-gray-800" href="{{
                                    route('contacts.show', $contact->username)
                                    }}">
                                      {{ $contact->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $contact->phone }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="p-2">
                      {{ $contacts->links() }}
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
