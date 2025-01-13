<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
            margin: 20px auto;
            max-width: 1200px;
        }

        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
        }

        th,
        td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #464646;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a.btn {
            text-decoration: none;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            margin: 0 2px;
            display: inline-block;
        }

        .btn-primary {
            background-color: #ff8802;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .pagination a {
            color: #ff8802;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 4px;
        }

        .pagination a.active {
            background-color: #ff8802;
            color: white;
            border: 1px solid #ff8802;
        }

        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>

    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="bg-white shadow-lg rounded-lg p-4">
            <h2 class="text-center font-bold text-dark mb-4">Visitor Records</h2>

            <!-- Visitor Records Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Business Details</th>
                            <th>Phone Number</th>
                            <th>Branch</th>
                            <th>Assigned To</th>
                            <th>Appointment Date</th>
                            <th>Comments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($visits as $visit)
                        <tr>
                            <td>{{ $visit->name }}</td>
                            <td>
                                <a href="mailto:{{ $visit->email }}" class="text-primary">
                                    {{ $visit->email }}
                                </a>
                            </td>
                            <td>{{ $visit->businessDetails }}</td>
                            <td>{{ $visit->phonenumber }}</td>
                            <td>{{ $visit->branch->branch_name ?? 'N/A' }}</td>
                            <td>{{ $visit->assignedTo ?? 'N/A' }}</td>
                            <td>{{ $visit->appointment_date }}</td>
                            <td>{{ $visit->Comments ?? 'N/A' }}</td>
                            <td class="d-flex flex-row ">
                                <a href="{{ route('visitors.edit', $visit->id) }}" class="btn btn-primary"> <i class='fa-solid fa-pen-to-square'></i></a>
                                <form action="{{ route('visitors.destroy', $visit->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary"><i class='fa-solid fa-trash'></i></button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">No visitors found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $visits->links() }}
            </div>
        </div>
    </div>
    @endsection

</body>

</html>