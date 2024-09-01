<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Safety Button Records') }}
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
                        View All the Safety Button Records
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if($safetyButtonRecords->isEmpty())
                        <p>No Safety Button Triggers found.</p>
                    @else
                        <!-- Desktop View -->
                        <div class="hidden sm:block">
                            <table class="table-auto w-full">
                                <thead>
                                <tr>
                                    <th class="px-4 py-2">ID Number</th>
                                    <th class="px-4 py-2">First Name</th>
                                    <th class="px-4 py-2">Last Name</th>
                                    <th class="px-4 py-2">Issue Type</th>
                                    <th class="px-4 py-2">Latitude</th>
                                    <th class="px-4 py-2">Longitude</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($safetyButtonRecords as $record)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $record->id_number }}</td>
                                        <td class="border px-4 py-2">{{ $record->first_name }}</td>
                                        <td class="border px-4 py-2">{{ $record->last_name }}</td>
                                        <td class="border px-4 py-2">{{ $record->issue_type }}</td>
                                        <td class="border px-4 py-2">{{ $record->latitude }}</td>
                                        <td class="border px-4 py-2">{{ $record->longitude }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile View -->
                        <div class="sm:hidden">
                            @foreach($safetyButtonRecords as $record)
                                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                                    <p class="text-gray-700"><strong>ID Number:</strong> {{ $record->id_number }}</p>
                                    <p class="text-gray-700"><strong>First Name:</strong> {{ $record->first_name }}</p>
                                    <p class="text-gray-700"><strong>Last Name:</strong> {{ $record->last_name }}</p>
                                    <p class="text-gray-700"><strong>Issue Type:</strong> {{ $record->issue_type }}</p>
                                    <p class="text-gray-700"><strong>Latitude:</strong> {{ $record->latitude }}</p>
                                    <p class="text-gray-700"><strong>Longitude:</strong> {{ $record->longitude }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
