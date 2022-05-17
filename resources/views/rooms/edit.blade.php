<x-guest-layout>
<div class="min-h-full flex">
  <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
    <div class="mx-auto w-full max-w-sm lg:w-96">
      <div>
        <div class="flex items-center justify-between">
          <a href="{{ route('root') }}"><x-application-logo class="block h-10 fill-current text-gray-600" /></a>
          <div x-data="{ deleting: false }">
            <span x-show="! deleting" @click="deleting = true" class="text-sm font-medium text-red-600 hover:text-red-500 cursor-pointer">Delete</span>
            <div x-show="deleting" class="text-sm">
              <form action="{{ route('rooms.destroy', $room->id) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="font-medium text-red-600 hover:text-red-500">Yes, Delete it</button>
                /
                <span @click="deleting = false" class="text-sm font-medium text-gray-600 hover:text-gray-500 cursor-pointer">Nevermind</span>
              </form>
            </div>
          </div>
        </div>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Edit the room</h2>
        <p class="mt-2 text-sm text-gray-600">
          ROOM#{{ $room->id }}
        </p>
      </div>

      <div class="mt-8">
        <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="space-y-6">
          @method('put')
          @csrf
          <div>
            <x-label>Room name</x-label>
            <x-input name="name" type="text" value="{{ old('name', $room->name) }}" class="mt-1" />
          </div>

          <x-button>Update</x-button>
        </form>
      </div>
    </div>
  </div>
  <div class="hidden lg:block relative w-0 flex-1">
    <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="">
  </div>
</div>
</x-guest-layout>
