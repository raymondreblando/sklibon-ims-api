<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Report</title>
    <style>
        body {
            font-family: 'Courier', sans-serif;
            color: #333;
        }
        h1 {
            text-align: left;
            font-size: 16px;
            margin-bottom: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background: #f8f8f8;
            font-size: 13px;
        }
        td {
            font-size: 11px;
        }
        .header {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://ik.imagekit.io/mhkbf5beo/sklibon-ims/logo.webp" alt="sk logo" width="50">
        <img src="https://ik.imagekit.io/mhkbf5beo/sklibon-ims/libon-logo.webp" alt="sk logo" width="55">
        <div>
            <h3 style="font-size: 18px; margin-bottom: 2px;">SK Federation Management System</h3>
            <p style="font-size: 14px; margin: 0 0 24px 0;">Libon, Albay</p>
        </div>
    </div>
    @foreach ($datas as $data)
        <h1>Event: {{ $data->name }}</h1>
        <p style="margin: 0 0 16px 0; font-size: 12px;">Date: {{ $data->event_date->format('M d, Y') }}</p>

        <table style="margin-bottom: 40px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Attendee</th>
                    <th>Position</th>
                    <th>Barangay</th>
                    <th>Time In</th>
                    <th>Time Out</th>

                    @if ($withTime)
                        <th>Minute Count</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data->attendances as $index => $attendance)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $attendance->user->userInfo->firstname }} {{ $attendance->user->userInfo->lastname }}</td>
                        <td>{{ $attendance->user->userInfo->position->name }}</td>
                        <td>{{ $attendance->user->userInfo->barangay->name }}</td>
                        <td>{{ $attendance->time_in ? $attendance->time_in->format('h:i:s A') : '-' }}</td>
                        <td>{{ $attendance->time_out ? $attendance->time_out->format('h:i:s A') : '-' }}</td>

                        @if ($withTime)
                            <td>
                                @if ($attendance->time_in && $attendance->time_out)
                                    @php
                                        $diff = $attendance->time_in->diff($attendance->time_out);
                                    @endphp
                                    {{ $diff->h ? $diff->h . 'hr ' : '' }}
                                    {{ $diff->i ? $diff->i . 'mins ' : '' }}
                                    {{ (!$diff->h && !$diff->i) ? $diff->s . 'secs' : '' }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
