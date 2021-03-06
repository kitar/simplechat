<x-guest-layout>
<div class="min-h-full flex">
  <div class="flex-1 flex flex-col justify-center lg:flex-none xl:w-1/2">
    <div class="mx-auto w-full">
      <div class="flex flex-col" id="screen-container">
          <div class="px-2 py-2 sm:px-6 sm:py-4 border-b border-gray-200">
            <nav class="flex justify-between" aria-label="Breadcrumb">
              <ol role="list" class="flex items-center space-x-1">
                <li>
                  <div class="flex items-center">
                    <a href="/" class="text-sm font-medium text-gray-400 hover:text-gray-700">Simplechat</a>
                  </div>
                </li>
                <li>
                  <div class="flex items-center">
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                      <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                    </svg>
                    <span class="ml-1 text-sm text-gray-500">{{ $room['name'] }}</span>
                  </div>
                </li>
              </ol>
              <div>
                <form action="/rooms/{{ $room->id }}/leave" method="POST">
                  @csrf
                  <span class="text-xs text-gray-500">{{ $username }}</span>
                  <input type="submit" value="Leave room" class="ml-2 inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                </form>
              </div>
            </nav>
          </div>
          <div x-data="messages('{{ Auth::user()->uuid ?? null }}', '{{ session()->getId() }}', '{{ $room->id }}')" class="mb-auto h-full overflow-scroll flex flex-col-reverse text-sm py-4">
            <div id="bottom" x-intersect:enter="atBottom = true" x-intersect:leave="atBottom = false" class="h-2 mb-2"></div>
            <template x-for="message in messages">
              <div class="px-2 sm:px-6 py-2 hover:bg-gray-50 flex flex-row justify-between items-center">
                <div>
                  <div class="flex items-baseline">
                    <div class="font-bold" x-text="message.username"></div>
                    <div class="ml-2 text-xs text-gray-400" x-text="message.created_at"></div>
                  </div>
                  <div x-html="message.message" class="message pr-4"></div>
                </div>
                <div x-show="canDeleteMessage(message) && deletingMessage != message.id">
                  <svg x-on:click="deleteMessage(message.id, false)" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer text-gray-300 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </div>
                <div x-show="deletingMessage == message.id" class="flex flex-col space-y-1 w-44 text-center">
                  <span class="text-sm">Are you sure?</span>
                  <span x-on:click="deletingMessage = null" class="px-2 py-1 border border-gray-300 shadow-sm text-xs text-center font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">Cancel</span>
                  <span x-on:click="deleteMessage(message.id, true)" class="text-sm text-red-400 hover:text-red-500 cursor-pointer">Yes, delete it</span>
                </div>
              </div>
            </template>
            <div id="top" x-intersect:enter="getMoreMessages" class="h-2"></div>
          </div>
          <div class="px-4 pb-4">
            <div x-data="messageInput('{{ $room->id }}')" @trix-file-accept.prevent>
              <trix-editor x-ref="trix" class="prose message"></trix-editor>
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="hidden lg:block relative w-0 flex-1">
    <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="">
    <div x-data="presence('{{ $room->id }}')" class="absolute inset-4">
      <div class="w-auto px-2 pb-2 bg-white bg-opacity-60 flex flex-col space-y-2">
        <template x-for="user in users">
          <div class="flex items-center space-x-2">
            <span class="h-4 w-4 bg-green-100 rounded-full flex items-center justify-center" aria-hidden="true">
              <span class="h-2 w-2 bg-green-400 rounded-full"></span>
            </span>
            <span class="text-sm font-medium text-gray-700" x-text="user"></span>
          </div>
        </template>
      </div>
    </div>
  </div>
</div>
</x-guest-layout>
