<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Drivers') }}
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
                        View All the Drivers
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('viewdrivers.post') }}">
                        @csrf
                        <div class="flex flex-col sm:flex-row items-center">
                            <x-label for="driver_id" value="{{ __('Driver ID') }}" />
                            <x-input id="driver_id" class="block mt-1 w-full sm:w-auto sm:ml-4" type="text" name="driver_id" :value="$driverID ?? ''" required autofocus autocomplete="driver_id" />
                            <x-button class="mt-4 sm:mt-0 sm:ml-4">
                                {{ __('Search') }}
                            </x-button>
                        </div>
                    </form>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if($drivers->isEmpty())
                        <p>No drivers found.</p>
                    @else
                        <div class="hidden sm:block">
                            <table class="table-auto w-full min-w-full">
                                <thead>
                                <tr>
                                    <th class="px-4 py-2">Driver ID</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">National ID</th>
                                    <th class="px-4 py-2">Phone Number</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($drivers as $driver)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $driver->driver_id }}</td>
                                        <td class="border px-4 py-2">{{ $driver->first_name }}</td>
                                        <td class="border px-4 py-2">{{ $driver->id_number }}</td>
                                        <td class="border px-4 py-2">{{ $driver->phone_no }}</td>
                                        <td class="border px-4 py-2">
                                            <form method="POST" action="{{ route('deletedriver.post', $driver->driver_id) }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    {{ __('Delete Driver') }}
                                                </x-button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile View -->
                        <div class="sm:hidden">
                            @foreach($drivers as $driver)
                                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                                    <p class="text-gray-700"><strong>Driver ID:</strong> {{ $driver->driver_id }}</p>
                                    <p class="text-gray-700"><strong>Name:</strong> {{ $driver->first_name }}</p>
                                    <p class="text-gray-700"><strong>National ID:</strong> {{ $driver->id_number }}</p>
                                    <p class="text-gray-700"><strong>Phone Number:</strong> {{ $driver->phone_no }}</p>
                                    <br>
                                    <form method="POST" action="{{ route('deletedriver.post', $driver->driver_id) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            {{ __('Delete Driver') }}
                                        </x-button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
