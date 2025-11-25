<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('House Holds') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- 🔍 Search & Add Button -->
                    <div class="flex justify-between items-center mb-4">
                        <form method="GET" action="{{ route('households.index') }}" class="flex space-x-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search households..." class="px-3 py-2 border rounded-lg w-64">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Search
                            </button>
                        </form>

                        <button onclick="openModal('create')"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            ➕ Add New Household
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

                    <!-- 🗂 Bulk Action Toolbar -->
                    <div id="bulk-toolbar" class="hidden mb-4">
                        <form method="POST" action="{{ route('households.bulkPrint') }}" target="_blank"
                            id="bulkForm">
                            @csrf
                            <div id="bulk-ids-container"></div>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                                onclick="return confirm('Print selected households?')">
                                🖨️ Bulk Print
                            </button>
                        </form>
                    </div>

                    <!-- 📋 Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 border">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th class="p-2 border whitespace-nowrap">Household Number</th>
                                    <th class="p-2 border whitespace-nowrap">Head</th>
                                    <th class="p-2 border whitespace-nowrap">Purok</th>
                                    <th class="p-2 border whitespace-nowrap">Address</th>
                                    <th class="p-2 border whitespace-nowrap">Ownership</th>
                                    <th class="p-2 border whitespace-nowrap">House Type</th>
                                    <th class="p-2 border whitespace-nowrap">Electricity</th>
                                    <th class="p-2 border whitespace-nowrap">Monthly Income</th>
                                    <th class="p-2 border whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($households as $household)
                                    <tr class="text-center hover:bg-gray-50">
                                        <td class="p-2 border">
                                            <input type="checkbox" class="row-checkbox" value="{{ $household->id }}">
                                        </td>
                                        <td class="p-2 border whitespace-nowrap">{{ $household->household_no }}</td>
                                        <td class="p-2 border whitespace-nowrap">{{ $household->household_head }}</td>
                                        <td class="p-2 border whitespace-nowrap">{{ $household->purok }}</td>
                                        <td class="p-2 border whitespace-nowrap">
                                            {{ Str::limit($household->address, 30) }}</td>
                                        <td class="p-2 border whitespace-nowrap">{{ $household->house_ownership }}</td>
                                        <td class="p-2 border whitespace-nowrap">{{ $household->house_type }}</td>
                                        <td class="p-2 border whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 rounded text-xs {{ $household->electricity ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $household->electricity ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="p-2 border whitespace-nowrap">
                                            ₱{{ number_format($household->monthly_income ?? 0, 2) }}</td>
                                        <td class="p-2 border whitespace-nowrap">
                                            <div class="flex justify-center space-x-2">
                                                <button onclick="viewHousehold({{ $household->id }})"
                                                    class="text-blue-600 hover:text-blue-900" title="View">
                                                    👁️
                                                </button>
                                                <button onclick="editHousehold({{ $household->id }})"
                                                    class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                    ✏️
                                                </button>
                                                <form action="{{ route('households.destroy', $household) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this household?');">
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
                                        <td colspan="10" class="p-4 text-center text-gray-500">
                                            No households found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $households->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 📝 Modal Form -->
    <div id="householdModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-2xl font-bold text-gray-900"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>

            <form id="householdForm" method="POST" action="">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto px-2">
                    <!-- Basic Information -->
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-2 text-gray-700">Basic Information</h4>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Household No. <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="household_no" id="household_no" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Household Head</label>
                        <input type="text" name="household_head" id="household_head"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Purok <span class="text-red-500">*</span>
                        </label>
                        <select name="purok" id="purok" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Purok/Zone</option>
                            <option value="1a">1a</option>
                            <option value="1b">1b</option>
                            <option value="2a">2a</option>
                            <option value="2b">2b</option>
                            <option value="3a">3a</option>
                            <option value="3b">3b</option>
                            <option value="4a">4a</option>
                            <option value="4b">4b</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Full Address <span
                                class="text-red-500">*</span></label>
                        <textarea name="address" id="address" rows="2" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>

                    <!-- House Information -->
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-2 mt-4 text-gray-700">House Information</h4>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">House Ownership <span
                                class="text-red-500">*</span></label>
                        <select name="house_ownership" id="house_ownership" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Ownership</option>
                            <option value="Owned">Owned</option>
                            <option value="Rented">Rented</option>
                            <option value="Shared">Shared</option>
                            <option value="Informal Settler">Informal Settler</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">House Type <span
                                class="text-red-500">*</span></label>
                        <select name="house_type" id="house_type" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Type</option>
                            <option value="Concrete">Concrete</option>
                            <option value="Semi-Concrete">Semi-Concrete</option>
                            <option value="Light Materials">Light Materials</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Electricity <span
                                class="text-red-500">*</span></label>
                        <select name="electricity" id="electricity" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <!-- Economic Information -->
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-2 mt-4 text-gray-700">Economic Information</h4>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Monthly Income (₱)</label>
                        <input type="number" step="0.01" name="monthly_income" id="monthly_income"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Primary Livelihood</label>
                        <input type="text" name="livelihood" id="livelihood"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Benefits & Risk -->
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-2 mt-4 text-gray-700">Benefits & Risk Assessment</h4>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Government Beneficiaries</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="beneficiaries[]" value="4Ps" class="mr-2"> 4Ps
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="beneficiaries[]" value="PhilHealth" class="mr-2">
                                PhilHealth
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="beneficiaries[]" value="SSS" class="mr-2"> SSS
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="beneficiaries[]" value="GSIS" class="mr-2"> GSIS
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="beneficiaries[]" value="Senior Citizen" class="mr-2">
                                Senior Citizen
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="beneficiaries[]" value="PWD" class="mr-2"> PWD
                            </label>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Disaster Risk Areas</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="disaster_risk[]" value="Flood-prone" class="mr-2">
                                Flood-prone
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="disaster_risk[]" value="Coastal Area" class="mr-2">
                                Coastal Area
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="disaster_risk[]" value="Landslide-prone"
                                    class="mr-2"> Landslide-prone
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="disaster_risk[]" value="Earthquake Zone"
                                    class="mr-2"> Earthquake Zone
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="disaster_risk[]" value="Fire Hazard" class="mr-2">
                                Fire Hazard
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-2 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Household
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 👁️ View Modal -->
    <div id="viewModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-3xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-900">Household Details</h3>
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
        // Bulk selection functionality
        const selectAll = document.getElementById('select-all');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const bulkToolbar = document.getElementById('bulk-toolbar');

        selectAll.addEventListener('click', (e) => {
            rowCheckboxes.forEach(cb => cb.checked = e.target.checked);
            toggleBulkToolbar();
        });

        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', toggleBulkToolbar);
        });

        function toggleBulkToolbar() {
            const selected = Array.from(rowCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            const container = document.getElementById('bulk-ids-container');
            container.innerHTML = '';

            if (selected.length > 0) {
                bulkToolbar.classList.remove('hidden');
                selected.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    container.appendChild(input);
                });
            } else {
                bulkToolbar.classList.add('hidden');
            }
        }

        // Modal functions
        function openModal(mode, id = null) {
            const modal = document.getElementById('householdModal');
            const form = document.getElementById('householdForm');
            const modalTitle = document.getElementById('modalTitle');
            const formMethod = document.getElementById('formMethod');

            // Reset form
            form.reset();
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);

            if (mode === 'create') {
                modalTitle.textContent = 'Add New Household';
                form.action = "{{ route('households.store') }}";
                formMethod.value = 'POST';
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('householdModal').classList.add('hidden');
        }

        function editHousehold(id) {
            fetch(`/households/${id}/edit-data`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').textContent = 'Edit Household';
                    document.getElementById('householdForm').action = `/households/${id}`;
                    document.getElementById('formMethod').value = 'PUT';

                    // Populate form fields
                    document.getElementById('household_no').value = data.household_no || '';
                    document.getElementById('household_head').value = data.household_head || '';
                    document.getElementById('purok').value = data.purok || '';
                    document.getElementById('address').value = data.address || '';
                    document.getElementById('house_ownership').value = data.house_ownership || '';
                    document.getElementById('house_type').value = data.house_type || '';
                    document.getElementById('electricity').value = data.electricity ? '1' : '0';
                    document.getElementById('monthly_income').value = data.monthly_income || '';
                    document.getElementById('livelihood').value = data.livelihood || '';

                    // Handle beneficiaries checkboxes
                    document.querySelectorAll('input[name="beneficiaries[]"]').forEach(cb => {
                        cb.checked = data.beneficiaries && data.beneficiaries.includes(cb.value);
                    });

                    // Handle disaster risk checkboxes
                    document.querySelectorAll('input[name="disaster_risk[]"]').forEach(cb => {
                        cb.checked = data.disaster_risk && data.disaster_risk.includes(cb.value);
                    });

                    document.getElementById('householdModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load household data');
                });
        }

        function viewHousehold(id) {
            fetch(`/households/${id}/view-data`)
                .then(response => response.json())
                .then(data => {
                    const content = `
                        <div class="grid grid-cols-2 gap-4">
                            <div><strong>Household No:</strong> ${data.household_no}</div>
                            <div><strong>Household Head:</strong> ${data.household_head || 'N/A'}</div>
                            <div><strong>Purok:</strong> ${data.purok}</div>
                            <div><strong>House Ownership:</strong> ${data.house_ownership}</div>
                            <div><strong>House Type:</strong> ${data.house_type}</div>
                            <div><strong>Electricity:</strong> ${data.electricity ? 'Yes' : 'No'}</div>
                            <div><strong>Monthly Income:</strong> ₱${parseFloat(data.monthly_income || 0).toFixed(2)}</div>
                            <div><strong>Livelihood:</strong> ${data.livelihood || 'N/A'}</div>
                            <div class="col-span-2"><strong>Address:</strong> ${data.address}</div>
                            <div class="col-span-2"><strong>Beneficiaries:</strong> ${data.beneficiaries ? data.beneficiaries.join(', ') : 'None'}</div>
                            <div class="col-span-2"><strong>Disaster Risk:</strong> ${data.disaster_risk ? data.disaster_risk.join(', ') : 'None'}</div>
                        </div>
                    `;
                    document.getElementById('viewContent').innerHTML = content;
                    document.getElementById('viewModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load household data');
                });
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('householdModal');
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
