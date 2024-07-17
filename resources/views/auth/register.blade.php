<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="conductor_admin_id" value="{{ __('ID') }}" />
                <x-input id="conductor_admin_id" class="block mt-1 w-full" type="text" name="conductor_admin_id" :value="old('conductor_admin_id')" required autofocus autocomplete="conductor_admin_id" />
            </div> <br>

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Contact Admin for Registration</title>--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">--}}
{{--    <style>--}}
{{--        @keyframes gradientBackground {--}}
{{--            0%, 100% { background-position: 0% 50%; }--}}
{{--            50% { background-position: 100% 50%; }--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body class="flex items-center justify-center min-h-screen">--}}
{{--<div class="text-center bg-black bg-opacity-70 p-10 rounded-xl shadow-2xl transform transition duration-500 hover:scale-105">--}}
{{--    <h1 class="font-sans text-5xl mb-6 text-white">Contact Admin for Registration</h1>--}}
{{--    <p class="text-xl text-white mb-6">Please reach out to the admin to complete your registration process.</p>--}}
{{--    <a href="mailto:admin@example.com" class="inline-block mt-4 py-3 px-8 bg-red-600 text-white font-semibold rounded-full shadow-lg hover:bg-red-700 transition duration-300">Email Admin</a>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}


