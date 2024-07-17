<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Delete Ride') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Delete a Ride
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    <!-- Form for Deleting a Ride -->
                    <form method="post" action="{{ route('deleteride.post') }}">
                        @csrf
                        <div>
                            <x-label for="trip_id" value="{{ __('Select Departure Time to Delete') }}" />
                            <select id="trip_id" name="trip_id" class="block mt-1 w-full" required>
                                @foreach($departureTimes as $id => $departureTime)
                                    <option value="{{ $id }}">{{ $departureTime }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <x-button class="ms-1">
                            {{ __('Delete') }}
                        </x-button>
                    </form>
                    <br>
                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
