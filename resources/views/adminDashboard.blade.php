<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Welcome Admin!
                    </div>

                    <div class="mt-6 text-gray-500">
                        You are logged in as an admin. Through here you are responsible to manage the rides and the users including conductors, drivers, and buses.
                    </div>

                    <!-- Buttons Section -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('addbus') }}" class="block text-center bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Add New Bus
                        </a>
                        <a href="{{ route('addconductor') }}" class="block text-center bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Add Conductor
                        </a>
                        <a href="{{ route('adddriver') }}" class="block text-center bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Add Driver
                        </a>
                        <form method="POST" action="{{ route('addschedule.post') }}" class="block text-center">
                            @csrf
                            <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                                Add Schedule
                            </button>
                        </form>
                        <a href="{{ route('viewbuses') }}" class="block text-center bg-teal-600 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            View Buses
                        </a>
                        <a href="{{ route('viewconductors') }}" class="block text-center bg-purple-600 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            View Conductors
                        </a>
                        <a href="{{ route('viewdrivers') }}" class="block text-center bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            View Drivers
                        </a>
                        <a href="{{ route('viewschedules') }}" class="block text-center bg-orange-600 hover:bg-orange-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            View Schedules
                        </a>
                        <a href="{{ route('viewsupportrequests') }}" class="block text-center bg-pink-600 hover:bg-pink-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Passenger Support
                        </a>
                        <a href="#" class="block text-center bg-cyan-600 hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Conductor Support
                        </a>
                        <a href="{{route('viewsafetybuttonrecords')}}" class="block text-center bg-gray-600 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            View Safety Triggers
                        </a>
                        <a href="#" class="block text-center bg-lime-600 hover:bg-lime-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            View Admins
                        </a>
                    </div>
                </div>
                <!-- Success and Error Messages Section -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-2 max-w-md mx-auto" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-2 max-w-md mx-auto" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                <br>
            </div>
        </div>
    </div>
</x-app-layout>
