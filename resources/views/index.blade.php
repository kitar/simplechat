<x-guest-layout>
<div class="min-h-full flex">
  <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
    <div class="mx-auto w-full max-w-sm lg:w-96">
      <div>
        <div class="flex">
          <a href="{{ route('root') }}"><x-application-logo class="block h-10 fill-current text-gray-600" /></a>
        </div>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Create a chat room</h2>
        <p class="mt-2 text-sm text-gray-600">
          Or
          <x-link href="{{ route('register') }}"> Register </x-link>
          /
          <x-link href="{{ route('login') }}"> Sign in </x-link>
          to manage your rooms.
        </p>
      </div>

      <div class="mt-8">
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
      <div class="mt-6 relative">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
          <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
          <span class="px-2 bg-white text-gray-500"> Or continue with </span>
        </div>
      </div>
      <div class="mt-6">
        <a href="{{ route('rooms.index') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Recently joined rooms</a>
      </div>
    </div>
  </div>
  <div class="hidden lg:block relative w-0 flex-1">
    <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="">
  </div>
</div>
</x-guest-layout>
