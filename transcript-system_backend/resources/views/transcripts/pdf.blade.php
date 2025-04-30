<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transcript</title>
    <style>
        @page {
            margin: 150px 40px 60px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: -130px;
            left: 0;
            right: 0;
            height: 120px;
        }

        .header-table {
            width: 100%;
            font-size: 11px;
            border: none;
        }

        .header-table td {
            padding: 2px 6px;
            vertical-align: top;
        }

        main {
            margin-top: 10px;
        }

        .semester-header {
            background: #f0f0f0;
            font-weight: bold;
            padding: 4px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
        }

        .status-passed { color: green; }
        .status-failed { color: red; }
    </style>
</head>
<body>

<header>
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <strong>Name:</strong> {{ $student->name ?? '-' }}<br>
                <strong>Last Name:</strong> {{ $student->surname ?? '-' }}<br>
                <strong>Student No:</strong> {{ $student->student_number }}<br>
                <strong>Department - Program:</strong> {{ $student->department_id }}
            </td>
            <td style="width: 50%;">
                <strong>Date of Birth:</strong> {{ $student->birth_date ?? '-' }}<br>
                <strong>Date of Registration:</strong> {{ $student->registration_date ?? '-' }}<br>
                <strong>Date of Graduation:</strong> {{ $student->graduation_date ?? '-' }}<br>
                <strong>Date of Issue:</strong> {{ now()->format('Y-m-d') }}
            </td>
        </tr>
    </table>
</header>

<main>
    @php
        $grandCredits = 0;
    @endphp

    @foreach($transcripts as $semester => $data)
        <div class="semester-header">{{ $semester }}</div>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Course Title</th>
                    <th>Grade</th>
                    <th>Credits</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['courses'] as $course)
                    <tr>
                        <td>{{ $course['code'] }}</td>
                        <td>{{ $course['title'] }}</td>
                        <td>{{ $course['grade'] }}</td>
                        <td>{{ $course['credits'] }}</td>
                        <td class="{{ $course['status'] === 'Passed' ? 'status-passed' : 'status-failed' }}">
                            {{ $course['status'] }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>TOTALS</strong></td>
                    <td><strong>{{ $data['total_credits'] }}</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3"><strong>GPA</strong></td>
                    <td colspan="2"><strong>{{ number_format($data['gpa'], 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        @php $grandCredits += $data['total_credits']; @endphp
    @endforeach

    <table style="margin-top: 20px;">
        <tr>
            <td colspan="3"><strong>GRAND TOTALS</strong></td>
            <td><strong>{{ $grandCredits }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"><strong>CUMULATIVE GPA</strong></td>
            <td colspan="2"><strong>{{ number_format($cumulativeGPA, 2) }}</strong></td>
        </tr>
    </table>
</main>

<div class="footer">
    This transcript is system-generated. No signature required.
</div>

</body>
</html>
