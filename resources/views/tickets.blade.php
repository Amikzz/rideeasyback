<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Passenger Ticket Controlling
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

                <!-- Ticket Validation Form -->
                <div class="p-6 sm:px-20">
                    <form method="POST" action="{{ route('validateticket.post') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="id" class="block text-gray-700 text-sm font-bold mb-2">
                                Ticket ID
                            </label>
                            <input type="text" id="id" name="id" value="{{ old('id') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('id') border-red-500 @enderror" placeholder="Enter Ticket ID">
                            @error('id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Validate Ticket
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Display Ticket Details -->
                @if (session('ticket'))
                    @php $ticket = session('ticket'); @endphp
                    <div class="p-6 sm:px-20">
                        <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                            <h3 class="text-lg font-semibold mb-2">Ticket Details</h3>
                            <p><strong>ID:</strong> {{ $ticket->id }}</p>
                            <p><strong>Ticket ID:</strong> {{ $ticket->ticket_id }}</p>
                            <p><strong>Bus License Plate Number:</strong> {{ $ticket->bus_license_plate_no }}</p>
                            <p><strong>Passenger ID:</strong> {{ $ticket->passenger_id }}</p>
                            <p><strong>Start Location:</strong> {{ $ticket->start_location }}</p>
                            <p><strong>End Location:</strong> {{ $ticket->end_location }}</p>
                            <p><strong>Date:</strong> {{ $ticket->date }}</p>
                            <p><strong>Time:</strong> {{ $ticket->departure_time }}</p>
                            <p><strong>Status:</strong> {{ $ticket->status }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
