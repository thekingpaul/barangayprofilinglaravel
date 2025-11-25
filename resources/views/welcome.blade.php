<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Profiling System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- 🌐 Header / Navbar -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">🏘 Barangay Profiling</h1>
        </div>
    </header>

    <!-- 🎉 Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-green-500 text-white py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold mb-4">Sayon Profiling System</h2>
            <p class="text-lg mb-6">Efficiently manage residents, households, and staff records in one system.</p>
        </div>
    </section>

    <!-- 🔐 Login Options -->
    <section id="login" class="py-16 flex justify-center">
        <div class="bg-white shadow-lg rounded-xl p-10 text-center w-full max-w-lg">
            <h3 class="text-2xl font-bold mb-6 text-gray-800">Login as</h3>
            <div class="space-y-4">
                <!-- Admin Login -->
                <a href="/staff/login"
                    class="block w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    👩‍💻 Staff Login
                </a>

                <!-- Staff Login -->
                <a href="{{ route('login') }}?role=captain"
                    class="block w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    👨‍💼 Admin Login
                </a>
            </div>
        </div>
    </section>

    <!-- 📖 Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6 mt-12">
        <div class="max-w-7xl mx-auto text-center text-sm">
            © {{ date('Y') }} Barangay Profiling System. All rights reserved.
        </div>
    </footer>

</body>

</html>
