<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Passenger\'s Support Requests') }}
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
                        View All Passenger's Support Requests
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if($supportRequests->isEmpty())
                        <p>No Support Requests found.</p>
                    @else
                        <!-- Desktop View -->
                        <div class="hidden sm:block">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full min-w-full">
                                    <thead>
                                    <tr>
                                        <th class="px-4 py-2">ID</th>
                                        <th class="px-4 py-2">Name</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Phone Number</th>
                                        <th class="px-4 py-2">Request</th>
                                        <th class="px-4 py-2">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($supportRequests as $supportRequest)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $supportRequest->id }}</td>
                                            <td class="border px-4 py-2">{{ $supportRequest->name }}</td>
                                            <td class="border px-4 py-2">{{ $supportRequest->email }}</td>
                                            <td class="border px-4 py-2">{{ $supportRequest->phone }}</td>
                                            <td class="border px-4 py-2">{{ $supportRequest->issue }}</td>
                                            <td class="border px-4 py-2">
                                                @if($supportRequest->status === 'pending')
                                                    <form method="POST" action="{{ route('viewsupportrequests.post', $supportRequest->id) }}">
                                                        @csrf
                                                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                            {{ __('Issue Pending') }}
                                                        </x-button>
                                                    </form>
                                                @elseif($supportRequest->status === 'done')
                                                    <span class="text-green-600 text-lg">Issue Sorted</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mobile View -->
                        <div class="sm:hidden">
                            @foreach($supportRequests as $supportRequest)
                                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                                    <p class="text-gray-700"><strong>ID:</strong> {{ $supportRequest->id }}</p>
                                    <p class="text-gray-700"><strong>Name:</strong> {{ $supportRequest->name }}</p>
                                    <p class="text-gray-700"><strong>Email:</strong> {{ $supportRequest->email }}</p>
                                    <p class="text-gray-700"><strong>Phone Number:</strong> {{ $supportRequest->phone }}</p>
                                    <p class="text-gray-700"><strong>Request:</strong> {{ $supportRequest->issue }}</p>
                                    <p class="text-gray-700"><strong>Status:</strong>
                                        @if($supportRequest->status === 'pending')
                                            <span class="text-blue-600">Pending</span>
                                        @elseif($supportRequest->status === 'done')
                                            <span class="text-green-600">Issue Sorted</span>
                                        @endif
                                    </p>
                                    <br>
                                    @if($supportRequest->status === 'pending')
                                        <form method="POST" action="{{ route('viewsupportrequests.post', $supportRequest->id) }}">
                                            @csrf
                                            <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                {{ __('Issue Pending') }}
                                            </x-button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <center>
                <span class="p-4 text-lg">If you have completed and solved the issue, press the button <b>Issue Pending</b> and make the issue Completed.</span>
                </center>
            </div>
        </div>
    </div>
</x-app-layout>
