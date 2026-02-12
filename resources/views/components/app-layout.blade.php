<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Mijn App') }}</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navigatie -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">
                Mijn App
            </h1>

            <nav class="space-x-6">
                <a href="/hardware" class="text-gray-600 hover:text-blue-600 transition">
                    Home
                </a>
                <a href="/dashboard" class="text-gray-600 hover:text-blue-600 transition">
                    Dashboard
                </a>
                <a href="/contact" class="text-gray-600 hover:text-blue-600 transition">
                    Contact
                </a>
            </nav>
        </div>
    </header>

    <!-- Hoofdcontent -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-3xl">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-inner py-4 text-center text-gray-500 text-sm">
        © {{ date('Y') }} Mijn App - Alle rechten voorbehouden
    </footer>

</body>
</html>
