<x-layout>
  <div class="bg-gray-50">
    <div class="max-w-4xl mx-auto bg-white border-x border-gray-200">
      <div class="flex flex-col" id="screen-container">
        <div class="px-2 py-2 sm:px-6 sm:py-4 border-b border-gray-200">
          <nav class="flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-1">
              <li>
                <div>
                  <a href="/" class="text-sm font-medium text-gray-400 hover:text-gray-700">Simplechat</a>
                </div>
              </li>
              <li>
                <div class="flex items-center">
                  <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                  </svg>
                  <span class="ml-1 text-sm text-gray-500">ROOM#{{ $room['id'] }}</span>
                </div>
              </li>
            </ol>
          </nav>
        </div>
        <div class="mb-auto h-full px-2 py-4 sm:px-6 text-sm">
          <form action="/rooms/{{ $room->id }}/enter" method="POST">
            @csrf

            <!-- username -->
            <div class="max-w-lg mb-4">
              <label for="username" class="block text-sm font-medium text-gray-700">username</label>
              <div class="mt-1">
                <input type="text" name="username" value="{{ old('username') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
              </div>
              @error('username')
                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
              @enderror
            </div>

            <!-- password -->
            @if (! empty($room->password))
              <div class="max-w-lg mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">password</label>
                <div class="mt-1">
                  <input type="password" name="password" value="{{ old('password') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
                @error('password')
                  <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
                @enderror
              </div>
            @endif
            <div class="mt-8">
              <input type="submit" value="Join the room" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            </div>
          </form>
      </div>
    </div>
  </div>
</x-app-layout>
