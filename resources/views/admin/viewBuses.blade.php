<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Buses') }}
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
                        View All the Buses
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('viewbuses.post') }}">
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
                    @if($buses->isEmpty())
                        <p>No buses found.</p>
                    @else
                        <div class="hidden sm:block">
                            <table class="table-auto w-full">
                                <thead>
                                <tr>
                                    <th class="px-4 py-2">Bus License Plate Number</th>
                                    <th class="px-4 py-2">Capacity</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($buses as $bus)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $bus->bus_license_plate_no }}</td>
                                        <td class="border px-4 py-2">{{ $bus->capacity }}</td>
                                        <td class="border px-4 py-2">
                                            @if($bus->status === 'Active')
                                                <span class="text-green-500">{{ $bus->status }}</span>
                                            @elseif($bus->status === 'Inactive')
                                                <span class="text-red-500">{{ $bus->status }}</span>
                                            @else
                                                <span class="text-yellow-500">{{ $bus->status }}</span>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">
                                            @if($bus->status === 'Active')
                                                <form method="POST" action="{{ route('inactivatebus.post', $bus->bus_license_plate_no) }}">
                                                    @csrf
                                                    <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                        {{ __('Inactivate bus') }}
                                                    </x-button>
                                                </form>
                                            @elseif($bus->status === 'Inactive')
                                                <form method="POST" action="{{ route('activatebus.post', $bus->bus_license_plate_no) }}">
                                                    @csrf
                                                    <x-button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                        {{ __('Activate bus') }}
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
                            @foreach($buses as $bus)
                                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                                    <p class="text-gray-700"><strong>Bus License Plate Number:</strong> {{ $bus->bus_license_plate_no }}</p>
                                    <p class="text-gray-700"><strong>Capacity:</strong> {{ $bus->capacity }}</p>
                                    <p class="text-gray-700"><strong>Status:</strong>
                                        @if($bus->status === 'Active')
                                            <span class="text-green-500">{{ $bus->status }}</span>
                                        @elseif($bus->status === 'Inactive')
                                            <span class="text-red-500">{{ $bus->status }}</span>
                                        @else
                                            <span class="text-yellow-500">{{ $bus->status }}</span>
                                        @endif
                                    </p>
                                    <br>
                                    @if ($bus->status === 'Active')
                                        <form method="POST" action="{{ route('inactivatebus.post', $bus->bus_license_plate_no) }}">
                                            @csrf
                                            <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                {{ __('Inactivate bus') }}
                                            </x-button>
                                        </form>
                                    @elseif($bus->status === 'Inactive')
                                        <form method="POST" action="{{ route('activatebus.post', $bus->bus_license_plate_no) }}">
                                            @csrf
                                            <x-button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                {{ __('Activate bus') }}
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
