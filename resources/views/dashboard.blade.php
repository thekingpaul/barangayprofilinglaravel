<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <!-- Households -->
                <div class="p-6 bg-blue-50 border border-blue-200 rounded-lg shadow flex items-center gap-4">
                    <div class="bg-blue-200 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-800" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-800">Households</h3>
                        <p class="text-2xl font-bold text-blue-900">{{ $householdsCount }}</p>
                    </div>
                </div>

                <!-- Residents -->
                <div class="p-6 bg-green-50 border border-green-200 rounded-lg shadow flex items-center gap-4">
                    <div class="bg-green-200 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-800" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-800">Residents</h3>
                        <p class="text-2xl font-bold text-green-900">{{ $residentsCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Search + Create -->
                <div class="flex justify-between items-center mb-4">
                    <form method="GET" action="{{ route('dashboard') }}" class="flex space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search users..." class="px-3 py-2 border rounded-lg w-64">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                            </svg>
                            Search
                        </button>
                    </form>

                    <!-- Add User -->
                    <button onclick="document.getElementById('createModal').showModal()"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add User
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border text-left">Name</th>
                                <th class="p-2 border text-left">Email</th>
                                <th class="p-2 border text-left">Role</th>
                                <th class="p-2 border text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-2 border">{{ $user->name }}</td>
                                    <td class="p-2 border">{{ $user->email }}</td>
                                    <td class="p-2 border">{{ $user->role }}</td>
                                    <td class="p-2 border text-center space-x-2">

                                        <!-- Edit -->
                                        <button
                                            onclick="document.getElementById('editModal-{{ $user->id }}').showModal()"
                                            class="inline-flex items-center text-blue-600 hover:underline gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5h2M12 7v6m0 0h6m-6 0H6" />
                                            </svg>
                                            Edit
                                        </button>

                                        <!-- Delete -->
                                        <form method="POST" action="{{ route('users.destroy', $user) }}"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete this user?')"
                                                class="inline-flex items-center text-red-600 hover:underline gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <dialog id="editModal-{{ $user->id }}" class="p-4 rounded-lg shadow-lg">
                                    <form method="POST" action="{{ route('users.update', $user) }}">
                                        @csrf
                                        @method('PUT')
                                        <h2 class="text-lg font-semibold mb-2">Edit User</h2>
                                        <input type="text" name="name" value="{{ $user->name }}"
                                            class="block w-full mb-2 border rounded p-2" required>
                                        <input type="email" name="email" value="{{ $user->email }}"
                                            class="block w-full mb-2 border rounded p-2" required>
                                        <input type="password" name="password" placeholder="New Password (optional)"
                                            class="block w-full mb-2 border rounded p-2">
                                        <input type="password" name="password_confirmation"
                                            placeholder="Confirm Password"
                                            class="block w-full mb-2 border rounded p-2">
                                        <div class="flex justify-end space-x-2">
                                            <button type="button" onclick="this.closest('dialog').close()"
                                                class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                                        </div>
                                    </form>
                                </dialog>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $users->links() }}
                </div>

                <!-- Create Modal -->
                <dialog id="createModal" class="p-4 rounded-lg shadow-lg max-w-7xl">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <h2 class="text-lg font-semibold mb-2">Add User</h2>

                        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
                            class="block w-full mb-2 border rounded p-2" required>

                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                            class="block w-full mb-2 border rounded p-2" required>

                        <label for="">Role</label>
                        <select name="role" class="block w-full mb-2 border rounded p-2" required>
                            <option value="">Choose</option>
                            <option value="staff" selected>Staff</option>
                            <option value="captain">Admin/Captain</option>
                        </select>

                        <input type="password" name="password" placeholder="Password"
                            class="block w-full mb-2 border rounded p-2" required>

                        <input type="password" name="password_confirmation" placeholder="Confirm Password"
                            class="block w-full mb-2 border rounded p-2" required>

                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="this.closest('dialog').close()"
                                class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
                        </div>
                    </form>
                </dialog>
            </div>
        </div>
    </div>
</x-app-layout>
