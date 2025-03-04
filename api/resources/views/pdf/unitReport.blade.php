<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$data['unit']['name']}} Attendance Report</title>
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
    <h1>{{$data['unit']['name']}}</h1>
    <h3>Class Attendance Report</h3>
    @if(count($data['lecturer']) > 0)
        <h4>Lecturer Information</h4>
        <table>
            <thead>
                <tr>
                    <th>Lecturer Name</th>
                    <th>Lecturer Staff No</th>
                    <th>Lecturer ID No</th>
                    <th>Lecturer Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['lecturer'] as $lecturer)
                    <tr>
                        <td>{{ $lecturer['name'] }}</td>
                        <td>{{ $lecturer['staffNo'] }}</td>
                        <td>{{ $lecturer['idNo'] }}</td>
                        <td>{{ $lecturer['email'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>   
    @endif
    @if(count($data['students'])>0)
        <h4>Students Information</h4>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    @if(count($data['students']) > 0 && count($data['students'][0]['lectures']) > 0)
                        @foreach($data['students'][0]['lectures'] as $lecture)
                            <th>Lecture</th>
                        @endforeach
                    @endif
                    <th>Rate</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($data['students'] as $student)
                    <tr>
                        <td>{{ $student['name'] }}</td>
                        @php
                            $totalLectures = count($student['lectures']);
                            $attendedLectures = 0;
                        @endphp
                        @foreach($student['lectures'] as $lecture)
                            <td>
                                @if($lecture['attended'])
                                    Present
                                    @php $attendedLectures++; @endphp
                                @else
                                    Absent
                                @endif
                            </td>
                        @endforeach
                        <td>
                            @if($totalLectures > 0)
                                {{ number_format(($attendedLectures / $totalLectures) * 100, 2) }}%
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
