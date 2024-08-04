<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Schedule') }}
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
                        View All the Schedules
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('viewschedules.post') }}">
                        @csrf
                        <div class="flex flex-col sm:flex-row items-center">
                            <x-label for="schedule_date" value="{{ __('Schedule Date') }}" />
                            <x-input id="schedule_date" class="block mt-1 w-full sm:w-auto sm:ml-4" type="date" name="schedule_date" :value="$scheduleDate ?? ''" required autofocus autocomplete="schedule_date" />
                            <x-button class="mt-4 sm:mt-0 sm:ml-4">
                                {{ __('Search') }}
                            </x-button>
                        </div>
                    </form>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if($schedules->isEmpty())
                        <p>No schedules found for the selected date.</p>
                    @else
                        <!-- Desktop View -->
                        <div class="hidden sm:block">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full min-w-full">
                                    <thead>
                                    <tr>
                                        <th class="px-4 py-2">Date</th>
                                        <th class="px-4 py-2">Route Number</th>
                                        <th class="px-4 py-2">Start Location</th>
                                        <th class="px-4 py-2">End Location</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $schedule->schedule_id }}</td>
                                            <td class="border px-4 py-2">{{ $schedule->route_number }}</td>
                                            <td class="border px-4 py-2">{{ $schedule->start_location }}</td>
                                            <td class="border px-4 py-2">{{ $schedule->end_location }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mobile View -->
                        <div class="sm:hidden">
                            @foreach($schedules as $schedule)
                                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                                    <p class="text-gray-700"><strong>Schedule ID:</strong> {{ $schedule->schedule_id }}</p>
                                    <p class="text-gray-700"><strong>Route Number:</strong> {{ $schedule->route_number }}</p>
                                    <p class="text-gray-700"><strong>Start Location:</strong> {{ $schedule->start_location }}</p>
                                    <p class="text-gray-700"><strong>End Location:</strong> {{ $schedule->end_location }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
