<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Slip</title>
    <style>
        /* Margin settings for any paper size */
        @page {
            margin: 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 95%;
            padding: 20px;
            box-sizing: border-box;
            border: 2px solid #8F0C00;
            border-radius: 10px;
        }

        h3, h5 {
            margin: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-primary {
            color: #0d6efd;
        }

        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mb-3 { margin-bottom: 15px; }
        .mb-4 { margin-bottom: 20px; }
        .mt-3 { margin-top: 15px; }
        .mt-4 { margin-top: 20px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f8f8f8;
        }

        .note {
            font-size: 11px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center fw-bold">ORDER PAYMENT SLIP</h3>
        <p class="text-center mb-3" style="font-size: 13px;">PRESENT TO CASHIER</p>

        <div class="mb-3 d-flex justify-content-between" style="display: flex; justify-content: space-between;">
            <div>
                <strong>TRANSACTION REFERENCE NUMBER:</strong><br>
                <span class="text-primary">{{ $request->reference_number }}</span>
            </div>
            <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($request->request_date)->format('m-d-Y') }}</div>
        </div>

        <h5 class="text-center fw-bold mb-2">STUDENT INFORMATION</h5>
        <p><strong>Name:</strong> {{ $request->studentname }}</p>
        <p><strong>Student Type:</strong> {{ ucwords($request->student_type) }}</p>
        <p><strong>
                @if ($request->student_type === 'enrolled')
                        Year:
                    @elseif($request->student_type === 'alumni')
                        Batch Year:
                @endif
           </strong>
           {{ $request->student_type === 'enrolled' ? $request->year : $request->batch_year }}
        </p>
        <p><strong>Course:</strong> {{ $request->course }}</p>



        <h5 class="text-center fw-bold mt-4 mb-2">REQUESTED DOCUMENTS</h5>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($request->items as $item)
                <tr>
                    <td>{{ $item->quantity }}x {{ $item->type }}</td>
                    <td>₱{{ number_format($item->price, 2) }}</td>
                    <td>₱{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end fw-bold mt-3">
            TOTAL AMOUNT: ₱{{ number_format($request->total_amount, 2) }}
        </div>

        <div class="mt-3">
            <p><strong>PURPOSE:</strong> {{ $request->items->first()->purpose ?? 'N/A' }}</p>
            <p><strong>MESSAGE:</strong> {{ $request->items->first()->message ?? 'None' }}</p>
        </div>

        <p class="note mt-4"><strong>Note:</strong> Upload the receipt within 3 days to avoid request resubmission.</p>
    </div>
</body>
</html>
