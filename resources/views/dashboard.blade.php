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
                        <a href="{{ route('viewtrips') }}" class="block text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            View Trips
                        </a>
                        <a href="{{ route('addride') }}" class="block text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Add New Trip Day
                        </a>
                        <a href="" class="block text-center bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Tickets
                        </a>
                        <a href="{{ route('deleteride') }}" class="block text-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                            Cancel Rides
                        </a>
                    </div>
                </div>

                <!-- Add form for bus license plate number -->
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200" id="bus-form">
                    <form id="bus-license-form">
                        @csrf
                        <label for="bus_license">Enter Bus License Plate Number:</label>
                        <input type="text" id="bus_license" name="bus_license" required class="block mt-1 w-full">
                        <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
            document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('bus-form');
            const busLicenseForm = document.getElementById('bus-license-form');

            // Check if the form has been submitted before and start location updates
            if (localStorage.getItem('formSubmitted')) {
            form.style.display = 'none';
            const busLicense = localStorage.getItem('busLicense');
            startLocationUpdates(busLicense);
        }

            busLicenseForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const busLicense = document.getElementById('bus_license').value;

            if (!busLicense) {
            alert('Please enter the bus license plate number.');
            return;
        }

            form.style.display = 'none';
            localStorage.setItem('formSubmitted', 'true');
            localStorage.setItem('busLicense', busLicense);

            startLocationUpdates(busLicense);
        });

            function startLocationUpdates(busLicense) {
            function getLocation() {
            if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(sendLocation);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
        }

            function sendLocation(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            fetch('{{ route('updatelocation.post') }}', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
            body: JSON.stringify({
            latitude: lat,
            longitude: lng,
            bus_license: busLicense
        })
        })
            .then(response => {
            if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
        }
            return response.json();
        })
            .then(data => {
            console.log('Location updated:', data);
        })
            .catch(error => {
            console.error('Error updating location:', error);
        });
        }

            // Update location every 10 seconds
            setInterval(getLocation, 10000);

            // Get initial location
            getLocation();
        }
        });

    </script>
</x-app-layout>
