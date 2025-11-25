<nav class="flex-1 px-4 py-6 space-y-2">

    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
        {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-700 border-r-2 border-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">

        <!-- Square dashboard icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
            <path d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
        </svg>

        Dashboard
    </a>

    <!-- Households -->
    <a href="{{ route('households.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
            {{ request()->routeIs('households.*') ? 'bg-indigo-100 text-indigo-700 border-r-2 border-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 12l9.75-9 9.75 9M4.5 9v11.25A1.5 1.5 0 006 21.75h12a1.5 1.5 0 001.5-1.5V9" />
        </svg>

        House Holds
    </a>

    <!-- Residents -->
    <a href="{{ route('residents.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors
            {{ request()->routeIs('residents.*') ? 'bg-indigo-100 text-indigo-700 border-r-2 border-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
        </svg>

        Residents
    </a>

</nav>
