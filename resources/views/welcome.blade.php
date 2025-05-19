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
             Masa Berlaku Habis
         </h2>
         <p class="text-gray-700 dark:text-gray-300 mb-4 transition-colors duration-300">
             Mohon maaf, link sudah kadaluarsa.
         </p>
         {{-- <div id="message" class="mt-4 text-sm text-red-500 dark:text-red-400 transition-colors duration-300"></div>
         <div id="location-status" class="hidden"></div> --}}
 
         {{-- <div id="loading-overlay" style="display: none;">
             <img src="/loading.svg" alt="" class="spinner">
         </div> --}}
 
     </div>
 </body>
 </html>
