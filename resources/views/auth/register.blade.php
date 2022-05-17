<x-guest-layout>
<div class="min-h-full flex">
  <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
    <div class="mx-auto w-full max-w-sm lg:w-96">
      <div>
        <div class="flex">
          <a href="{{ route('root') }}"><x-application-logo class="block h-10 fill-current text-gray-600" /></a>
        </div>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Register</h2>
        <p class="mt-2 text-sm text-gray-600">
          Or
          <x-link href="{{ route('root') }}"> Create a chat room</x-link>
          without registration.
        </p>
      </div>

      <div class="mt-8">
        <form action="{{ route('register') }}" method="POST" class="space-y-6">
          @csrf
          <div>
            <x-label>Name</x-label>
            <x-input name="name" type="text" value="{{ old('name') }}" class="mt-1" />
          </div>

          <div>
            <x-label>Email</x-label>
            <x-input name="email" type="text" value="{{ old('email') }}" class="mt-1" />
          </div>

          <div class="space-y-1">
            <x-label>Password</x-label>
            <x-input name="password" type="password" class="mt-1" />
          </div>

          <div class="space-y-1">
            <x-label>Confirm Password</x-label>
            <x-input name="password_confirmation" type="password" class="mt-1" />
          </div>

          <x-button>Create an account</x-button>
        </form>
      </div>
    </div>
  </div>
  <div class="hidden lg:block relative w-0 flex-1">
    <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1505904267569-f02eaeb45a4c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80" alt="">
  </div>
</div>
</x-guest-layout>
