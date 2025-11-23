<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Transaction History</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px; /* slightly smaller to fit content */
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px; /* smaller padding to fit content */
            text-align: center;
            vertical-align: top; /* top align for long content */
            word-wrap: break-word;
        }

        th {
            background: #f2f2f2;
            font-size: 9px;
        }

        td {
            font-size: 9px;
        }

        /* Prevent breaking table rows across pages */
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        /* Header logos */
        .header-table td {
            border: none !important;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- Header Table -->
    <table class="header-table" style="width: 900px; margin: 20px auto 10px auto;">
        <tr>
            <td style="width: 70px; vertical-align: middle;">
                <img src="{{ public_path('registrar/assets/img/sorsu-logo.png') }}" alt="Left Logo" class="logo">
            </td>
            <td style="text-align: center; font-size: 12px; line-height: 1.2; vertical-align: middle;">
                <div>Republic of the Philippines</div>
                <div><strong>Sorsogon State University</strong></div>
                <div><strong>OFFICE OF THE REGISTRAR</strong></div>
                <div><strong>Bulan Campus</strong></div>
                <div><em>Zone 8, Bulan, Sorsogon</em></div>
                <div>Tel. No.: (056) 311-98-00; Email Address: registrar.bc@sorsu.edu.ph</div>
            </td>
            <td style="width: 70px; vertical-align: middle;">
                <img src="{{ public_path('registrar/assets/img/sorsu_logo_2.png') }}" alt="Right Logo" class="logo">
            </td>
        </tr>
    </table>

    <h2>Transaction History Report</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Student ID</th>
                <th>Student Type</th>
                <th>Course</th>
                <th>Year</th>
                <th>Batch Year</th>
                <th>Reference Number</th>
                <th>Request Date</th>
                <th>Requested Documents</th>
                <th>Purpose</th>
                <th>Request Status</th>
                <th>Payment Status</th>
                <th>Total Amount</th>
                <th>Claimed Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction_history as $i => $data)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $data->studentname }}</td>
                    <td>{{ $data->student_id }}</td>
                    <td>{{ ucwords($data->student_type) }}</td>
                    <td>{{ $data->course }}</td>
                    <td>{{ $data->year ?? 'N/A' }}</td>
                    <td>{{ $data->batch_year ?? 'N/A' }}</td>
                    <td>{{ $data->reference_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->request_date)->format('F j, Y') }}</td>
                    <td style="text-align: left;">
                        @foreach ($data->items as $item)
                            • {{ $item->type }}@if($item->quantity) ({{ $item->quantity }}x)@endif<br>
                        @endforeach
                    </td>
                    <td>{{ collect($data->items)->pluck('purpose')->unique()->implode(', ') }}</td>
                    <td>{{ $data->status }}</td>
                    <td>{{ $data->payment->status ?? 'Unpaid' }}</td>
                    <td>{{ number_format($data->total_amount, 2) }}</td>
                    <td>{{ $data->claimed_date ? \Carbon\Carbon::parse($data->claimed_date)->format('F j, Y') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
