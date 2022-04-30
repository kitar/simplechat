<x-layout>
  <div class="bg-gray-50">
    <div class="max-w-4xl mx-auto bg-white border-x border-gray-200">
      <div class="flex flex-col h-screen">
        <div class="px-2 py-2 sm:px-6 sm:py-4 border-b border-gray-200">
          <nav class="flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-1">
              <li>
                <div>
                  <a href="" class="text-sm font-medium text-gray-400 hover:text-gray-700">Simplechat</a>
                </div>
              </li>
            </ol>
          </nav>
        </div>
        <div class="mb-auto h-full px-2 py-4 sm:px-6 text-sm overflow-scroll">
          <div class="text-lg mb-4">Create new room</div>
          <form action="/rooms" method="POST">
            @csrf

            <!-- name -->
            <div class="max-w-lg mb-4">
              <label for="name" class="block text-sm font-medium text-gray-700">name of the room (optional)</label>
              <div class="mt-1">
                <input type="text" name="name" value="{{ old('name') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
              </div>
              @error('name')
                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
              @enderror
            </div>

            <!-- password -->
            <div class="max-w-lg mb-4">
              <label for="password" class="block text-sm font-medium text-gray-700">password of the room (optional)</label>
              <div class="mt-1">
                <input type="password" name="password" value="{{ old('password') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
              </div>
              @error('password')
                <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}</p>
              @enderror
            </div>
            <div class="mt-8">
              <input type="submit" value="Create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            </div>
          </form>

          <div class="text-lg mt-10 mb-4">Recently joined rooms</div>
          @foreach ($roomsHistory as $id => $room)
            <div class="mb-2">
              <a href="/rooms/{{ $id }}" class="text-indigo-600 hover:text-indigo-500">{{ $room['name'] }}</a>
              <span class="text-xs text-gray-400">({{ $room['joined_at'] }})</span>
            </div>
          @endforeach
      </div>
    </div>
  </div>
</x-app-layout>
