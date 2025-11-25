<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Households Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background: #f4f4f4;
        }
    </style>
</head>

<body onload="window.print()"> <!-- ✅ auto print -->
    <h2>Selected Households</h2>
    <table>
        <thead>
            <tr>
                <th>Household No</th>
                <th>Head</th>
                <th>Purok</th>
                <th>Members</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($households as $household)
                <tr>
                    <td>{{ $household->household_no }}</td>
                    <td>{{ $household->household_head }}</td>
                    <td>{{ $household->purok }}</td>
                    <td>
                        @if ($household->residents->count())
                            <ul style="list-style: none; padding:0; margin:0;">
                                @foreach ($household->residents as $resident)
                                    <li>{{ $resident->firstname }} {{ $resident->lastname }} - ({{ $resident->age }})
                                        years old</li>
                                @endforeach
                            </ul>
                        @else
                            <em>No residents</em>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
