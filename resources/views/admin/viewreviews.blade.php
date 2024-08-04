<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Passenger\'s Reviews') }}
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
                        View All Passenger's Reviews
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if($userReviews->isEmpty())
                        <p>No Reviews found.</p>
                    @else
                        <!-- Desktop View -->
                        <div class="hidden sm:block">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full min-w-full">
                                    <thead>
                                    <tr>
                                        <th class="px-4 py-2">ID</th>
                                        <th class="px-4 py-2">Passenger_id</th>
                                        <th class="px-4 py-2">Bus License Plate Number</th>
                                        <th class="px-4 py-2">Review</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($userReviews as $review)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $review->id }}</td>
                                            <td class="border px-4 py-2">{{ $review->user_id }}</td>
                                            <td class="border px-4 py-2">{{ $review->bus_license_plate_no }}</td>
                                            <td class="border px-4 py-2">{{ $review->review }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
