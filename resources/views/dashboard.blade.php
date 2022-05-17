<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div>
          <h1 class="text-xl font-semibold text-gray-900">Rooms</h1>
          <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Password protected</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                          <span class="sr-only">Manage</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      @if ($rooms->isEmpty())
                        <tr>
                          <td colspan="3" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            You haven't created a room yet.
                          </td>
                        </tr>
                      @endif
                      @foreach ($rooms as $room)
                      <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                          <x-link href="{{ route('rooms.show', $room->id) }}">{{ $room->name }}</x-link>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          @if (empty($room->password))
                          <span class="inline-flex rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800">No</span>
                          @else
                          <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Yes</span>
                          @endif
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                          <x-link href="{{ route('rooms.edit', $room->id) }}">Manage</x-link>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <h1 class="text-xl font-semibold text-gray-900">Create new room</h1>
          <div class="mt-8 bg-white pt-2 pb-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form action="{{ route('rooms.store') }}" method="POST" class="space-y-6">
              @csrf
              <div>
                <x-label>Room name</x-label>
                <x-input name="name" type="text" value="{{ old('name') }}" class="mt-1" />
              </div>

              <div>
                <x-label>Room password (optional)</x-label>
                <x-input name="password" type="password" class="mt-1" />
              </div>

              <x-button>Create a chat room</x-button>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
