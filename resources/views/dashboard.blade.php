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
                        Welcome to your RideEasy Portal!
                    </div>

                    <div class="mt-6 text-gray-500">
                        You're logged in! You can now view your rides, add new rides, and view your profile.
                    </div>
                </div>
                <!-- Add the buttons here -->
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{route('viewtrips')}}" class="block text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            View Trips
                        </a>
                        <a href="{{route('addride')}}" class="block text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Add New Trip Day
                        </a>
                        <a href="" class="block text-center bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Tickets
                        </a>
                        <a href="{{route('deleteride')}}" class="block text-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Cancel Rides
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
