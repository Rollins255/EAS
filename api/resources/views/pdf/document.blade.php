<!DOCTYPE html>
<html>
<head>
    <title>{{$data['unit'][0]['name'] }} - {{$data['unit'][0]['code']}}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #7CB9E8;
        }
    </style>
</head>
<body>
    <h1>{{$data['unit'][0]['name']}}</h1>
    <h3>Lecture Summary</h3>
    @if(count($data['lecture']) > 0)
        <table>
            <thead>
                <tr>
                    <th>Lecturer Name</th>
                    <th>Lecturer Staff No</th>
                    <th>Venue</th>
                    <th>Time</th>
                    <th>Attendance</th>
                    <th>Total Students</th>
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['lecture'] as $unit)
                    <tr>
                        <td>{{ $unit['lecturer_name'] }}</td>
                        <td>{{ $unit['lecturer_staffNo'] }}</td>
                        <td>{{ $unit['venue'] }}</td>
                        <td>{{ $unit['time'] }}</td>
                        <td>{{ $unit['attendance'] }}</td>
                        <td>{{ $unit['students'] }}</td>
                        <td>
                            @if($unit['students'] > 0)
                                {{ number_format(($unit['attendance'] / $unit['students']) * 100, 2) }}%
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>   
    @else
        <p>No lecture information</p>
    @endif
    <h3>Student Information</h1>
    @if(count($data['students']) > 0)
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Reg No</th>
                    <th>Present</th>
                    <th>Clock In</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['students'] as $student)
                    <tr>
                        <td>{{ $student['name'] }}</td>
                        <td>{{ $student['regNo'] }}</td>
                        <td>{{ $student['present'] ? 'Yes' : 'No' }}</td>
                        <td>{{ $student['clockIn'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No student data available.</p>
    @endif

    

</body>
</html>