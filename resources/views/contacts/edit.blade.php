<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Edit $contact->name's details") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <form method="post" action="{{
                    route('contacts.update', $contact->username) }}"
                    enctype="multipart/form-data">
                      @csrf
                      @method('patch')
                      <div class="mb-5">
                        <x-input-label for="name">Name</x-input-label>
                        <x-text-input type="text" id="name" name="name"
                        placeholder="Galon Aqua..." value="{{ old('name',
                        $contact->name) }}" class="block mt-1 w-full
                        @error('name') ring-red-400 @enderror"></x-text-input>
                        @error('name')
                        <span class="text-sm text-red-600 dark:text-red-400
                        space-y-1 my-2">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="mb-5">
                        <x-input-label for="username">Username</x-input-label>
                        <x-text-input type="text" id="username" name="username"
                        placeholder="akugalon" value="{{ old('username',
                        $contact->username) }}" class="block mt-1 w-full
                        @error('username', $contact->username) ring-red-400 @enderror"></x-text-input>
                        @error('username')
                        <span class="text-sm text-red-600 dark:text-red-400
                        space-y-1 my-2">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="mb-5">
                        <x-input-label for="phone">Phone</x-input-label>
                        <x-text-input type="number" id="phone" name="phone"
                        placeholder="081xxxxxx" value="{{ old('phone',
                        $contact->phone) }}" class="block mt-1 w-full
                        @error('phone') ring-red-400 @enderror"></x-text-input>
                        @error('phone')
                        <span class="text-sm text-red-600 dark:text-red-400
                        space-y-1 my-2">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="mb-5">
                        <x-input-label for="email">Email</x-input-label>
                        <x-text-input type="email" id="email" name="email"
                        placeholder="blahblah@gmail.com" value="{{ old('email',
                        $contact->email) }}" class="block mt-1
                        w-full @error('email') ring-red-400
                        @enderror"></x-text-input>
                        @error('email')
                        <span class="text-sm text-red-600 dark:text-red-400
                        space-y-1 my-2">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="mb-5">
                        <label class="block mb-2 text-sm font-medium
                        text-gray-900 dark:text-white" for="file_input">Upload
                        Profile</label>
                          @if($contact->profile)
                        <div class="px-3 py-2 w-54">
                          <img width="216" id="imgPlaceholder" src="{{ asset('storage/' . $contact->profile) }}">
                        </div>
                          @endif
                        <input class="p-2 block w-full text-sm text-gray-900 border border-gray-300
                        rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none
                        dark:bg-gray-700 dark:border-gray-600
                        dark:placeholder-gray-400" name="profile" id="file_input"
                        onchange="changeImgPlaceholder(event)"
                        type="file">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                        id="file_input_help">Only PNG, JPG and JPEG are allowed.
                        <br class="my-2">
                        <span class="text-xs">
                        Upload an image to override, or tick the checkbox to delete your profile.
                        </span>
                        </p>
                        <div>
                          <input type="checkbox" @checked(old('isDeleteImage')) name="isDeleteImage"
                          id="isDeleteImage" class="w-4 h-4 text-blue-600
                          bg-gray-100 border-gray-300 rounded focus:ring-blue-500
                          dark:focus:ring-blue-600 dark:ring-offset-gray-800
                          focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
                          <label for="isDeleteImage" class="ms-2 text-sm
                          font-medium text-gray-500 dark:text-gray-300">I want
                          to delete my old profile.</label>
                        @error('profile')
                        <span class="text-sm text-red-600 dark:text-red-400
                        space-y-1 my-2">{{ $message }}</span>
                        @enderror
                        </div>
                      </div>
                      <div class="mb-5">
                        <label for="gender" class="block mb-2 text-sm
                        font-medium text-gray-900 dark:text-white">Gender</label>
                        <select id="gender" name="gender"
                        class="@error('gender') ring-red-400
                        @enderror block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                          @foreach($genders as $gender)
                            @if(old('gender', $contact->gender) == $gender)
                              <option value="{{ $gender }}" selected>{{ $gender }}</option>
                            @else
                              <option value="{{ $gender }}">{{ $gender }}</option>
                            @endif
                          @endforeach
                        </select>
                        @error('gender')
                        <span class="text-sm text-red-600 dark:text-red-400
                        space-y-1 my-2">{{ $message }}</span>
                        @enderror
                      </div>
                      <x-primary-button>Save</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
      const changeImgPlaceholder = e => {
        const imgPlaceholder = document.querySelector("#imgPlaceholder")
        imgPlaceholder.src = URL.createObjectURL(e.target.files[0])
        imgPlaceholder.onload = () => URL.revokeObjectURL(imgPlaceholder.src)
      }
    </script>
</x-app-layout>
