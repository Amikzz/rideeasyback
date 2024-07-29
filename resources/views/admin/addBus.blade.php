<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add a Bus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Add a new Bus
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
                        <form method="post" action="{{route('addbus.post')}}">
                            @csrf
                            <div>
                                <x-label for="bus_license_plate_no" value="{{ __('Bus License Plate Number') }}" />
                                <x-input id="bus_license_plate_no" class="block mt-1 w-full" type="text" name="bus_license_plate_no" :value="old('bus_license_plate_no')" required autofocus autocomplete="bus_license_plate_no" />
                            </div>
                            <br>

                            <div>
                                <x-label for="capacity" value="{{ __('Capacity') }}" />
                                <x-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity')" required autofocus autocomplete="capacity" />
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
