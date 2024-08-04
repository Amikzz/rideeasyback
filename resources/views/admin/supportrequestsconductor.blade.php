<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Conductor\'s Support Requests') }}
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
                        View All the Conductor's Support Requests
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if($supportRequestsConductor->isEmpty())
                        <p>No Support Requests found.</p>
                    @else
                        <div class="hidden sm:block">
                            <table class="table-auto w-full">
                                <thead>
                                <tr>
                                    <th class="px-4 py-2">Record Number</th>
                                    <th class="px-4 py-2">Conductor Name</th>
                                    <th class="px-4 py-2">Conductor ID</th>
                                    <th class="px-4 py-2">Request</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($supportRequestsConductor as $supportRequestConductor)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $supportRequestConductor->id }}</td>
                                        <td class="border px-4 py-2">{{ $supportRequestConductor->conductor_name }}</td>
                                        <td class="border px-4 py-2">{{ $supportRequestConductor->conductor_id }}</td>
                                        <td class="border px-4 py-2">{{ $supportRequestConductor->request }}</td>
                                        <td class="border px-4 py-2">
                                            @if($supportRequestConductor->status === 'Pending')
                                                <form method="POST" action="{{route('viewsupportrequestsconductor.post', $supportRequestConductor->id)}}">
                                                    @csrf
                                                    <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                        {{ __('Issue Attended') }}
                                                    </x-button>
                                                </form>
                                            @elseif($supportRequestConductor->status === 'Done')
                                                <span class="text-green-600 text-lg"> Issue Sorted </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
