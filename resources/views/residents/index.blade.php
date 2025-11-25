<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Residents') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- 🔍 Search & Add Button -->
                    <div class="flex justify-between items-center mb-4">
                        <form method="GET" action="{{ route('residents.index') }}" class="flex space-x-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search residents..." class="px-3 py-2 border rounded-lg w-64">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Search
                            </button>
                        </form>

                        <button onclick="openModal('create')"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            ➕ Add New Resident
                        </button>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- 📋 Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 border whitespace-nowrap">Household No.</th>
                                    <th class="p-2 border whitespace-nowrap">Name</th>
                                    <th class="p-2 border whitespace-nowrap">Age</th>
                                    <th class="p-2 border whitespace-nowrap">Gender</th>
                                    <th class="p-2 border whitespace-nowrap">Civil Status</th>
                                    <th class="p-2 border whitespace-nowrap">Voter Status</th>
                                    <th class="p-2 border whitespace-nowrap">Mobile</th>
                                    <th class="p-2 border whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($residents as $resident)
                                    <tr class="text-center hover:bg-gray-50">
                                        <td class="p-2 border whitespace-nowrap">{{ $resident->household_no ?? 'N/A' }}
                                        </td>
                                        <td class="p-2 border whitespace-nowrap">{{ $resident->firstname }}
                                            {{ $resident->lastname }}</td>
                                        <td class="p-2 border whitespace-nowrap">{{ $resident->age }}</td>
                                        <td class="p-2 border whitespace-nowrap">{{ $resident->gender }}</td>
                                        <td class="p-2 border whitespace-nowrap">{{ $resident->civil_status }}</td>
                                        <td class="p-2 border whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 rounded text-xs {{ $resident->voter_status == 'Registered' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $resident->voter_status }}
                                            </span>
                                        </td>
                                        <td class="p-2 border whitespace-nowrap">{{ $resident->mobile_no ?? 'N/A' }}
                                        </td>
                                        <td class="p-2 border whitespace-nowrap">
                                            <div class="flex justify-center space-x-2">
                                                <button onclick="viewResident({{ $resident->id }})"
                                                    class="text-blue-600 hover:text-blue-900" title="View">
                                                    👁️
                                                </button>
                                                <button onclick="editResident({{ $resident->id }})"
                                                    class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                    ✏️
                                                </button>
                                                <form action="{{ route('residents.destroy', $resident) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this resident?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        title="Delete">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="p-4 text-center text-gray-500">
                                            No residents found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $residents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 📝 Modal Form -->
    <div id="residentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-5xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-2xl font-bold text-gray-900"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <form id="residentForm" method="POST" action="">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[32rem] overflow-y-auto px-2">
                    <!-- Household Information -->
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-2 text-gray-700">Household Information</h4>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Household No.</label>
                        <input type="text" name="household_no" id="household_no"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Search Household</label>
                        <select name="house_hold_id" id="house_hold_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Household</option>
                            @foreach ($households ?? [] as $household)
                                <option value="{{ $household->id }}"
                                    data-household-no="{{ $household->household_no }}">
                                    {{ $household->household_no }} - {{ $household->household_head }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Personal Information -->
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-2 mt-2 text-gray-700">Personal Information</h4>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">First Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="firstname" id="firstname" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label>
                        <input type="text" name="middlename" id="middlename"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Last Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="lastname" id="lastname" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Alias</label>
                        <input type="text" name="alias" id="alias"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Birthday <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="birthday" id="birthday" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Age <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="age" id="age" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Gender <span
                                class="text-red-500">*</span></label>
                        <select name="gender" id="gender" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Civil Status <span
                                class="text-red-500">*</span></label>
                        <select name="civil_status" id="civil_status" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Civil Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Voter Status <span
                                class="text-red-500">*</span></label>
                        <select name="voter_status" id="voter_status" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Voter Status</option>
                            <option value="Registered">Registered</option>
                            <option value="Not Registered">Not Registered</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Place of Birth</label>
                        <input type="text" name="birth_of_place" id="birth_of_place"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Citizenship</label>
                        <input type="text" name="citizenship" id="citizenship" value="Filipino"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Mobile No.</label>
                        <input type="text" name="mobile_no" id="mobile_no"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Height</label>
                        <input type="text" name="height" id="height" placeholder="e.g. 5'6&quot;"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Weight</label>
                        <input type="text" name="weight" id="weight" placeholder="e.g. 65 kg"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="email" name="email" id="email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Father's Name</label>
                        <input type="text" name="father" id="father"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Mother's Name</label>
                        <input type="text" name="mother" id="mother"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-2 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Resident
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 👁️ View Modal -->
    <div id="viewModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-900">Resident Details</h3>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <div id="viewContent" class="max-h-96 overflow-y-auto"></div>
            <div class="flex justify-end mt-4 pt-4 border-t">
                <button onclick="closeViewModal()"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function openModal(mode, id = null) {
            const modal = document.getElementById('residentModal');
            const form = document.getElementById('residentForm');
            const modalTitle = document.getElementById('modalTitle');
            const formMethod = document.getElementById('formMethod');

            form.reset();

            if (mode === 'create') {
                modalTitle.textContent = 'Add New Resident';
                form.action = "{{ route('residents.store') }}";
                formMethod.value = 'POST';
                document.getElementById('citizenship').value = 'Filipino';
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('residentModal').classList.add('hidden');
        }

        function editResident(id) {
            fetch(`/residents/${id}/edit-data`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').textContent = 'Edit Resident';
                    document.getElementById('residentForm').action = `/residents/${id}`;
                    document.getElementById('formMethod').value = 'PUT';

                    // Populate all fields
                    document.getElementById('household_no').value = data.household_no || '';
                    document.getElementById('house_hold_id').value = data.house_hold_id || '';
                    document.getElementById('firstname').value = data.firstname || '';
                    document.getElementById('middlename').value = data.middlename || '';
                    document.getElementById('lastname').value = data.lastname || '';
                    document.getElementById('alias').value = data.alias || '';
                    document.getElementById('birthday').value = data.birthday || '';
                    document.getElementById('age').value = data.age || '';
                    document.getElementById('gender').value = data.gender || '';
                    document.getElementById('civil_status').value = data.civil_status || '';
                    document.getElementById('voter_status').value = data.voter_status || '';
                    document.getElementById('birth_of_place').value = data.birth_of_place || '';
                    document.getElementById('citizenship').value = data.citizenship || 'Filipino';
                    document.getElementById('mobile_no').value = data.mobile_no || '';
                    document.getElementById('height').value = data.height || '';
                    document.getElementById('weight').value = data.weight || '';
                    document.getElementById('email').value = data.email || '';
                    document.getElementById('father').value = data.father || '';
                    document.getElementById('mother').value = data.mother || '';

                    document.getElementById('residentModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load resident data');
                });
        }

        document.getElementById('house_hold_id').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let householdNo = selectedOption.getAttribute('data-household-no');

            document.getElementById('household_no').value = householdNo || '';
        });

        function viewResident(id) {
            fetch(`/residents/${id}/view-data`)
                .then(response => response.json())
                .then(data => {
                    const content = `
                        <div class="space-y-4">
                            <div class="border-b pb-2">
                                <h4 class="font-semibold text-lg mb-2">Personal Information</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div><strong>Full Name:</strong> ${data.firstname} ${data.middlename || ''} ${data.lastname}</div>
                                    <div><strong>Alias:</strong> ${data.alias || 'N/A'}</div>
                                    <div><strong>Birthday:</strong> ${data.birthday}</div>
                                    <div><strong>Age:</strong> ${data.age} years old</div>
                                    <div><strong>Gender:</strong> ${data.gender}</div>
                                    <div><strong>Civil Status:</strong> ${data.civil_status}</div>
                                    <div><strong>Voter Status:</strong> ${data.voter_status}</div>
                                    <div><strong>Place of Birth:</strong> ${data.birth_of_place || 'N/A'}</div>
                                    <div><strong>Citizenship:</strong> ${data.citizenship}</div>
                                </div>
                            </div>
                            <div class="border-b pb-2">
                                <h4 class="font-semibold text-lg mb-2">Contact Information</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div><strong>Mobile:</strong> ${data.mobile_no || 'N/A'}</div>
                                    <div><strong>Email:</strong> ${data.email || 'N/A'}</div>
                                </div>
                            </div>
                            <div class="border-b pb-2">
                                <h4 class="font-semibold text-lg mb-2">Physical Information</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div><strong>Height:</strong> ${data.height || 'N/A'}</div>
                                    <div><strong>Weight:</strong> ${data.weight || 'N/A'}</div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-lg mb-2">Family Information</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div><strong>Father:</strong> ${data.father || 'N/A'}</div>
                                    <div><strong>Mother:</strong> ${data.mother || 'N/A'}</div>
                                </div>
                            </div>
                        </div>
                    `;
                    document.getElementById('viewContent').innerHTML = content;
                    document.getElementById('viewModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load resident data');
                });
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('residentModal');
            const viewModal = document.getElementById('viewModal');
            if (event.target == modal) {
                closeModal();
            }
            if (event.target == viewModal) {
                closeViewModal();
            }
        }
    </script>
</x-app-layout>
