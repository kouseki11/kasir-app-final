<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="bg-gray-100 dark:bg-gray-900">
        @include('components.sidebar')
        @include('sweetalert::alert')


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <script>
        function addProductInput() {
            let productInputs = document.getElementById('productInputs');
            let newProductInput = productInputs.children[0].cloneNode(true);
            productInputs.appendChild(newProductInput);
            newProductInput.querySelectorAll('input').forEach(function(input) {
                input.value = '';
            });
        }

        function removeProductInput(button) {
            let productInput = button.closest('.product-input');
            productInput.remove();
        }
    </script>
</body>

</html>
