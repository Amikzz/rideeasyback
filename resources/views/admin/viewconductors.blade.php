<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Conductors') }}
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
                        View All the Conductors
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('viewconductors.post') }}">
                        @csrf
                        <div class="flex flex-col sm:flex-row items-center">
                            <x-label for="conductor_id" value="{{ __('Conductor ID') }}" />
                            <x-input id="conductor_id" class="block mt-1 w-full sm:w-auto sm:ml-4" type="text" name="conductor_id" :value="$conductorID ?? ''" required autofocus autocomplete="conductor_id" />
                            <x-button class="mt-4 sm:mt-0 sm:ml-4">
                                {{ __('Search') }}
                            </x-button>
                        </div>
                    </form>
                </div>

                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    @if($conductors->isEmpty())
                        <p>No conductors found.</p>
                    @else
                        <div class="hidden sm:block">
                            <table class="table-auto w-full min-w-full">
                                <thead>
                                <tr class="text-left">
                                    <th class="px-4 py-2">Conductor ID</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($conductors as $conductor)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $conductor->conductor_admin_id }}</td>
                                        <td class="border px-4 py-2">{{ $conductor->name }}</td>
                                        <td class="border px-4 py-2">{{ $conductor->email }}</td>
                                        <td class="border px-4 py-2">
                                            <form method="POST" action="{{route('deleteconductor.post', $conductor->conductor_admin_id)}}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <x-button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                    {{ __('Delete Conductor') }}
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
                            @foreach($conductors as $conductor)
                                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                                    <p class="text-gray-700"><strong>Conductor ID:</strong> {{ $conductor->conductor_admin_id }}</p>
                                    <p class="text-gray-700"><strong>Name:</strong> {{ $conductor->name }}</p>
                                    <p class="text-gray-700"><strong>Email:</strong> {{ $conductor->email }}</p>
                                    <br>
                                    <form method="POST" action="{{route('deleteconductor.post', $conductor->conductor_admin_id)}}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <x-button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            {{ __('Delete Conductor') }}
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
