<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add a Driver') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Add a new Driver
                    </div>
                </div>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Validation Error!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form for Adding a New Ride -->
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <form method="post" action="{{route('adddriver.post')}}">
                            @csrf
                            <div>
                                <x-label for="id_number" value="{{ __('National Id') }}" />
                                <x-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number')" required autofocus autocomplete="id_number" />
                            </div>
                            <br>

                            <div>
                                <x-label for="driver_id" value="{{ __('Driver Id') }}" />
                                <x-input id="driver_id" class="block mt-1 w-full" type="text" name="driver_id" :value="old('driver_id')" required autofocus autocomplete="driver_id" />
                            </div>
                            <br>

                            <div>
                                <x-label for="first_name" value="{{ __('First Name') }}" />
                                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                            </div>
                            <br>

                            <div>
                                <x-label for="last_name" value="{{ __('Last Name') }}" />
                                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
                            </div>
                            <br>

                            <div>
                                <x-label for="password" value="{{ __('Password') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" required autofocus autocomplete="password" />
                            </div>
                            <br>

                            <div>
                                <x-label for="dob" value="{{ __('Date of Birth') }}" />
                                <x-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" required autofocus autocomplete="dob" />
                            </div>
                            <br>

                            <div>
                                <x-label for="gender" value="{{ __('Gender') }}" />
                                <x-input id="gender" class="block mt-1 w-full" type="text" name="gender" :value="old('gender')" required autofocus autocomplete="gender" />
                            </div>
                            <br>

                            <div>
                                <x-label for="phone_no" value="{{ __('Phone Number') }}" />
                                <x-input id="phone_no" class="block mt-1 w-full" type="text" name="phone_no" :value="old('phone_no')" required autofocus autocomplete="phone_no" />
                            </div>
                            <br>

                            <div>
                                <x-label for="address" value="{{ __('Address') }}" />
                                <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
                            </div>
                            <br>

                            <x-button class="ms-1">
                                {{ __('Add') }}
                            </x-button>
                        </form>
                    </div>
                    <br>
                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Display Error Message -->
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
