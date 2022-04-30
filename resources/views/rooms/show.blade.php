<x-layout>
  <div class="bg-gray-50">
    <div class="max-w-4xl mx-auto bg-white border-x border-gray-200">
      <div class="flex flex-col h-screen">
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
        <div x-data="messages('{{ $room->id }}')" class="mb-auto h-full overflow-scroll text-sm py-4">
          <template x-for="message in messages">
            <div class="px-2 sm:px-6 py-2 hover:bg-gray-50">
              <div class="flex items-baseline">
                <div class="font-bold" x-text="message.username"></div>
                <div class="ml-2 text-xs text-gray-400" x-text="message.created_at"></div>
              </div>
              <div x-html="message.message"></div>
            </div>
          </template>
          <div id="bottom" x-intersect:enter="atBottom = true" x-intersect:leave="atBottom = false" class="h-2 mb-2"></div>
        </div>
        <div class="px-4 pb-4">
          <div x-data="messageInput('{{ $room->id }}')" @trix-file-accept.prevent>
            <trix-editor x-ref="trix" class="prose"></trix-editor>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
