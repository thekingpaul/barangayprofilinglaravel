<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Residents Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #f4f4f4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Selected Residents</h2>
        <button type="button" onclick="window.print()" class="print-btn">🖨️ Print</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Household No</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Alias</th>
                <th>Birthday</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Civil Status</th>
                <th>Voter Status</th>
                <th>Place of Birth</th>
                <th>Citizenship</th>
                <th>Mobile No</th>
                <th>Height</th>
                <th>Weight</th>
                <th>Email</th>
                <th>Father</th>
                <th>Mother</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($residents as $resident)
                <tr>
                    <td>{{ $resident->household_no ?? 'N/A' }}</td>
                    <td>{{ $resident->firstname }}</td>
                    <td>{{ $resident->middlename ?? '—' }}</td>
                    <td>{{ $resident->lastname }}</td>
                    <td>{{ $resident->alias ?? '—' }}</td>
                    <td>{{ $resident->birthday ?? '—' }}</td>
                    <td>{{ $resident->age ?? '—' }}</td>
                    <td>{{ $resident->gender ?? '—' }}</td>
                    <td>{{ $resident->civil_status ?? '—' }}</td>
                    <td>{{ $resident->voter_status ?? '—' }}</td>
                    <td>{{ $resident->birth_of_place ?? '—' }}</td>
                    <td>{{ $resident->citizenship ?? '—' }}</td>
                    <td>{{ $resident->mobile_no ?? '—' }}</td>
                    <td>{{ $resident->height ?? '—' }}</td>
                    <td>{{ $resident->weight ?? '—' }}</td>
                    <td>{{ $resident->email ?? '—' }}</td>
                    <td>{{ $resident->father ?? '—' }}</td>
                    <td>{{ $resident->mother ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
