<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("$contact->name details") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @if(session('message'))
                    <div class="my-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                      {{ session('message') }}
                    </div>
                    @endif
                    <div class="my-4 flex gap-2">
                      <x-button-link href="{{ route('contacts.edit',
                      $contact->username) }}">Edit contact</x-button-link>
                      <form id="delete-confirm" action="{{ route('contacts.destroy',
                    $contact->username) }}" method="post">
                      @csrf
                      @method('delete')
                      <x-danger-button>Delete</x-danger-button>
                    </form>
                    </div>
                    <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right
                    text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    &
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    Name
                                </td>
                                <td class="px-6 py-4">
                                  {{ $contact->name }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    Username
                                </td>
                                <td class="px-6 py-4">
                                  {{ $contact->username }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    Phone Number
                                </td>
                                <td class="px-6 py-4">
                                  {{ $contact->phone }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    Email Address
                                </td>
                                <td class="px-6 py-4">
                                  {{ $contact->email ?? "-" }}
                                </td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">
                                    Gender
                                </td>
                                <td class="px-6 py-4">
                                  {{ $contact->gender }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if($contact->profile)
                    <div class="px-6 py-4">
                      <img src="/storage/{{ $contact->profile }}"
                      alt="{{ $contact->name }}">
                    </div>
                    @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
