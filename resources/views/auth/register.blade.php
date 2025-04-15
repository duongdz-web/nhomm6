<x-guest-layout>
    
    <div class="min-h-screen flex items-center justify-center px-4">
        {{-- Card đăng ký ở giữa --}}
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl flex overflow-hidden mx-auto">

            {{-- Bên trái: Ảnh minh họa --}}
            <div class="w-1/2 p-10 bg-white flex flex-col justify-center">
                <img src="{{ asset('images/nen2.jpg') }}"  class="w-full max-w-sm mb-6">
                <p class="text-sm text-gray-700 text-center mt-2">Mua sắm mọi lúc mọi nơi – dễ dàng và tiện lợi!</p>
            </div>
            <div class="w-1/2 p-10 bg-white flex flex-col justify-center">
                <img src="{{ asset('images/trang.jpg') }}" width='200px'>
                
            </div>

            {{-- Bên phải: Form đăng ký --}}


            <x-auth-card>
        <x-slot name="logo">
            <a href="/">
               <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->
               <img src="{{asset('images/logo.png')}}"width='200px'>
            </a>
        </x-slot>

                    
            <div class="w-1/2 bg-orange-100 p-8 flex flex-col justify-center items-center">


                <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
        </x-auth-card>
</x-guest-layout>
