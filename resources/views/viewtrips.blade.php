<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Trips') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <!-- Success and Error Messages -->
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        View your Trips
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('viewtrips.post') }}">
                        @csrf
                        <div class="flex flex-col sm:flex-row items-center">
                            <x-label for="bus_license_plate_no" value="{{ __('Bus License Plate Number') }}" />
                            <x-input id="bus_license_plate_no" class="block mt-1 w-full sm:w-auto sm:ml-4" type="text" name="bus_license_plate_no" :value="$busLicensePlateNo ?? ''" required autofocus autocomplete="bus_license_plate_no" />
                            <x-button class="mt-4 sm:mt-0 sm:ml-4">
                                {{ __('Search') }}
                            </x-button>
                        </div>
                    </form>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if($trips->isEmpty())
                        <p>No trips found.</p>
                    @else
                        <div class="hidden sm:block">
                            <table class="table-auto w-full">
                                <thead>
                                <tr>
                                    <th class="px-4 py-2">Bus License Plate Number</th>
{{--                                    <th class="px-4 py-2">Trip ID</th>--}}
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Departure Time</th>
                                    <th class="px-4 py-2">Arrival Time</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Process</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($trips as $trip)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $trip->bus_license_plate_no }}</td>
{{--                                        <td class="border px-4 py-2">{{ $trip->trip_id }}</td>--}}
                                        <td class="border px-4 py-2">{{ $trip->date }}</td>
                                        <td class="border px-4 py-2">{{ $trip->departure_time }}</td>
                                        <td class="border px-4 py-2">{{ $trip->arrival_time }}</td>
                                        <td class="border px-4 py-2">
                                            @if($trip->status === 'Up')
                                                <span class="text-red-500">{{ $trip->status }}</span>
                                            @elseif($trip->status === 'Down')
                                                <span class="text-green-500">{{ $trip->status }}</span>
                                            @else
                                                <span class="text-yellow-500">{{ $trip->status }}</span>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">
                                            @if($trip->process === 'Pending')
                                                <span class="text-blue-500">{{ $trip->process }}</span>
                                            @elseif($trip->process === 'In Progress')
                                                <span class="text-green-500">{{ $trip->process }}</span>
                                            @elseif($trip->process === 'Done')
                                                <span class="text-red-500">{{ $trip->process }}</span>
                                            @else
                                                <span>{{ $trip->process }}</span>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">
                                            @if($trip->process === 'Pending')
                                                <div class="flex space-x-2">
                                                    <form method="POST" action="{{ route('starttrip.post', $trip->trip_id) }}">
                                                        @csrf
                                                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                            {{ __('Start') }}
                                                        </x-button>
                                                    </form>
                                                    <form method="POST" action="{{ route('deleteride.post', $trip->trip_id) }}">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <x-button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                            {{ __('Delete') }}
                                                        </x-button>
                                                    </form>
                                                </div>
                                            @elseif($trip->process === 'In Progress')
                                                <form method="POST" action="{{ route('endtrip.post', $trip->trip_id) }}">
                                                    @csrf
                                                    <x-button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                        {{ __('End') }}
                                                    </x-button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="sm:hidden">
                            @foreach($trips as $trip)
                                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                                    <p class="text-gray-700"><strong>Bus License Plate Number:</strong> {{ $trip->bus_license_plate_no }}</p>
                                    <p class="text-gray-700"><strong>Trip ID:</strong> {{ $trip->trip_id }}</p>
                                    <p class="text-gray-700"><strong>Departure Time:</strong> {{ $trip->departure_time }}</p>
                                    <p class="text-gray-700"><strong>Arrival Time:</strong> {{ $trip->arrival_time }}</p>
                                    <p class="text-gray-700"><strong>Status:</strong>
                                        @if($trip->status === 'Up')
                                            <span class="text-red-500">{{ $trip->status }}</span>
                                        @elseif($trip->status === 'Down')
                                            <span class="text-green-500">{{ $trip->status }}</span>
                                        @else
                                            <span>{{ $trip->status }}</span>
                                        @endif
                                    </p>
                                    <p class="text-gray-700"><strong>Process:</strong>
                                        @if($trip->process === 'Pending')
                                            <span class="text-blue-500">{{ $trip->process }}</span>
                                        @elseif($trip->process === 'In Progress')
                                            <span class="text-green-500">{{ $trip->process }}</span>
                                        @elseif($trip->process === 'Done')
                                            <span class="text-red-500">{{ $trip->process }}</span>
                                        @else
                                            <span>{{ $trip->process }}</span>
                                        @endif
                                    </p>
                                    <br>
                                    @if ($trip->process === 'Pending')
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('starttrip.post', $trip->trip_id) }}">
                                                @csrf
                                                <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    {{ __('Start') }}
                                                </x-button>
                                            </form>
                                            <form method="POST" action="{{ route('deleteride.post', $trip->trip_id) }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <x-button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    {{ __('Delete') }}
                                                </x-button>
                                            </form>
                                        </div>
                                    @elseif($trip->process === 'In Progress')
                                        <form method="POST" action="{{ route('endtrip.post', $trip->trip_id) }}">
                                            @csrf
                                            <x-button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                {{ __('End') }}
                                            </x-button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
