<x-guest-layout>
<div class="min-h-full flex">
  <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
    <div class="mx-auto w-full max-w-sm lg:w-96">
      <div>
        <div class="flex">
          <a href="{{ route('root') }}"><x-application-logo class="block h-10 fill-current text-gray-600" /></a>
        </div>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Recently joined rooms</h2>
      </div>

      <div class="mt-8">
        @foreach ($roomsHistory as $id => $room)
          <div class="mb-2">
            <a href="/rooms/{{ $id }}" class="text-indigo-600 hover:text-indigo-500">{{ $room['name'] }}</a>
            <span class="text-xs text-gray-400">({{ $room['joined_at'] }})</span>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="hidden lg:block relative w-0 flex-1">
    <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="">
  </div>
</div>
</x-guest-layout>
