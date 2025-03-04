<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Facial;
use App\Models\Lecture;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Unit;
use App\Services\AttendanceServices;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
    // public $attendanceServices;
    // public function __construct(AttendanceServices $attendanceServices)
    // {
    //     $this->attendanceServices = $attendanceServices;
    // }
    /**
     * Register  a lecturer
     */
    function create(Request  $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'staffNo' => ['required', 'string', 'max:255','unique:'.Lecturer::class],
            'idNo' => ['required', 'string', 'max:255','unique:'.Lecturer::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Lecturer::class],
            'faculty' => ['required'],
            'department' => ['required'],
        ]);

        $lecturer = Lecturer::create([
            'name' => $request->name,
            'staffNo' => $request->staffNo,
            'idNo' => $request->idNo,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'email' => $request->email,
            'password' => Hash::make($request->idNo)
        ]);
        $data = [
            'name' => $lecturer->name,
            'staffNo' => $lecturer->staffNo,
            'idNo' => $lecturer->idNo,
            'faculty' => $lecturer->faculty,
            'department' => $lecturer->department,
            'email' => $lecturer->email,
        ];
        return response()->json($data);
    }

    /**
     * get lecturers
     */
    function lecturers($faculty,$department){
        logger()->info($faculty);
        logger()->info($department);

        $lecturers = Lecturer::where('faculty',$faculty)
                        ->where('department',$department)
                        ->get()
                        ->map(function($data){
                            return [
                                'id' => $data->id,
                                'department' => $data->department,
                                'faculty' => $data->faculty,
                                'email' => $data->email,
                                'name' => $data->name,
                                'staffNo' => $data->staffNo,
                                'units' => $data->units->map(function($unit){
                                    return [
                                        'id' => $unit->id,
                                        'code' => $unit->code,
                                        'name' => $unit->name,
                                        'course' => $unit->course,
                                        'count' => $unit->count,
                                    ];
                                })
                            ];
                        })
                        ;

        return response()->json([
            'lecturers' => $lecturers
        ]);
    }

    /**
     * getting lecturer data
     */
    function lecturer(Request $request){
        logger()->info($request);
        $lecturer = Lecturer::where('staffNo',$request->staffNo)
                    ->get()
                    ->map(function($data){
                        return [
                            'name' => $data->name,
                            'staffNo' => $data->staffNo,
                            'idNo' => $data->idNo,
                            'faculty' => $data->faculty,
                            'department' => $data->department,
                            'email' => $data->email,
                            'units' => $data->units == null ? []
                                        :$data->units->map(function($unit){
                                            return [
                                                'id' => $unit->id,
                                                'name' => $unit->name,
                                                'code' => $unit->code,
                                                'count' => $unit->count,
                                                'lecturer' => $unit->lecturer,
                                                'faculty' => $unit->faculty,
                                                'department' => $unit->department,
                                                'course' => $unit->course,
                                            ];
                                        })
                                
                        ];
                    });

        return response()->json([
            'lecturer' => $lecturer
        ]);
    }

    /**
     * adding a unit 
     */
    function unitAdd(Request $request){
        $request->validate([
            'unit_name' => ['required', 'string', 'max:255'],
            'unit_code' => ['required', 'string', 'max:255'],
            'lecturer' => ['required', 'max:255'],
            'faculty' => ['required',  'max:255'],
            'department' => ['required',  'max:255'],
            'course' => ['required',  'max:255'],
        ]);

        $unit = Unit::create([
            'name' => $request->unit_name,
            'code' => $request->unit_code,
            'lecturer' => $request->lecturer,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'course' => $request->course,
            'count'=>0
        ]);
        $data = [
            'staffNo' => $request->lecturer
        ];

        return response()->json([
            'lecturer' => $this->lecturer(new Request($data))->original
        ]);
    }

    /**
     * reoving unit
     */
    function unitRemove(Request $request){
        $request->validate([
            'unit' => 'required'
        ]);

        Unit::where('code',$request->unit)
                        ->where('lecturer',Auth::user()->staffNo)
                        ->delete();
        $data = [
            'staffNo' => Auth::user()->staffNo
        ];
        return response()->json([
            'lecturer' => $this->lecturer(new Request($data))->original
        ]);
    }

    /**
     * unit history
     */
    function unitHistory($code){
        
        $unit_id = Unit::where('code',$code)->get('id')[0];
        $lecture = Lecture::where('unit',$unit_id->id)
                            ->where('lecturer',Auth::user()->staffNo)
                            ->get()
                            ->map(function($data) use ($code){

                                logger()->info($code);
                                return [
                                    'id' => $data->id,
                                    'venue' => $data->venue,
                                    'time' => $data->time,
                                    'attendance' => Attendance::where('lecture',$data->id)->count(),
                                    'total' => Student::whereJsonContains('units',$code)->count(),
                                ];
                            });


        return response()->json([
            'history' => $lecture
        ]);

    }

    /**
     * unit information
     */
    function unitInfo($staffNo,$code){
        $unit_id = Unit::where('code',$code)->get()[0];
        logger()->info($unit_id);
        $students = Student::whereJsonContains('units',$code)->count();
        $unit_data = Lecture::where('unit',$unit_id->id)
                            ->get()
                            ->map(function($data) use($students){
                                
                                return [
                                    'id' => $data->id,
                                    'lecturer' => $data->lecturer,
                                    'venue' => $data->venue,
                                    'time' => $data->time,
                                    'students' => $students,
                                    'attendance' => Attendance::where('lecture',$data->id)->count(),
                                    'unit' => Unit::where('id',$data->unit)
                                                    ->get()
                                                    ->map(function($unit){
                                                        return [
                                                            'id'=> $unit->id,
                                                            'name'=> $unit->name,
                                                            'code'=> $unit->code,
                                                            'lecturer'=> $unit->lecturer,
                                                            'course'=> $unit->course,
                                                        ];
                                                    })
                                ];
                            });

        // logger()->info(sizeof($unit_data) == 0? 'true':"false");
        // $unit_students = Student::whereJsonContains('units',$code)->count();
        // $unit_attendance =  Attendance::where('lecture',$unit_data->id)->count();

        return response()->json([
            'units' =>$unit_data,
            // 'total' => $unit_students,
            // 'attendance' => $unit_attendance,
        ]);

    }

    /**
     * generate a summary of attendance in pdf format for a specific unit
     */
    public function generalSummary(){
        $unit = Unit::where('code',request('unit'))->first();
        $lecturer = Lecture::where('unit',$unit->id)->value('lecturer');
        $lecturer = Lecturer::where('staffNo',$lecturer)->get()->map(function($data){
            return [
                'name' => $data->name,
                'staffNo' => $data->staffNo,
                'idNo' => $data->idNo,
                'email' => $data->email,
            ];
        });
        $students = Student::whereJsonContains('units',request('unit'))->get()->map(function($data)use ($unit){
            return [
                'name' =>$data->name,
                'regNo' =>$data->regNo,
                // 'lectures' => Attendance::where('student',$data->regNo)->value('lecture'),
                'lectures' => Lecture::where('unit',$unit->id)->get()->map(function($unit_data) use($data){
                    return [
                        'id' => $unit_data->id,
                        'attended' => (Attendance::where('lecture',$unit_data->id)->where('student',$data->regNo)->get())->isNotEmpty() ? true : false,
                    ];
                }),
            ];
        });    
        Log::info($lecturer);
        $data = [
            'students' =>$students,
            'unit' => $unit,
            'lecturer' => $lecturer,
        ];
        $pdf = Pdf::loadView('pdf.unitReport',['data' => $data]);
        $pdf->setPaper('A4', 'landscape');
        // $pdf->setPaper('A4','portrait');
        return $pdf->stream("unit summary");
    }

    /**
     * generate a summary of attendance in  pdf for a specific lecture 
     */

    public function generatePDF()
    {
        $info = Lecture::where('id',request('data')['id'])->value('unit');
        $data = [
            'faculty' => Unit::where('id',$info)->value('faculty'),
            'department' => Unit::where('id',$info)->value('department'),
            'course' => Unit::where('id',$info)->value('course'),
            'unitCode' => Unit::where('id',$info)->value('code'),
            'lecture' => request('data')['id'],
        ];
        
        $students = Student::where('faculty',$data['faculty'])
        ->where('department',$data['department'])
        ->where('course',$data['course'])
        ->whereJsonContains('units',$data['unitCode'])
        ->get()
        ->map(function($student) use($data){
            return [
                'id'=> $student->id,
                'name'=> $student->name,
                'regNo'=> $student->regNo,
                'present'=> Attendance::where('lecture',$data['lecture'])->where('student',$student->regNo)->first() == null ? false : true,
                'clockIn'=> Attendance::where('lecture',$data['lecture'])->where('student',$student->regNo)->first() == null 
                            ?'-- --' 
                            : Attendance::where('lecture', $data['lecture'])->where('student', $student->regNo)->first()->clockIn,
            ];
        });
        $total_students = Student::whereJsonContains('units',$data['unitCode'])->count();
        $lecture = Lecture::where('id',$data['lecture'])
            ->get()
            ->map(function($u_data) use($total_students){
                return [
                    'id' => $u_data->id,
                    'lecturer_name' => Lecturer::where('staffNo',$u_data->lecturer)->value('name'),
                    'lecturer_staffNo' => Lecturer::where('staffNo',$u_data->lecturer)->value('staffNo'),
                    'venue' => $u_data->venue,
                    'time' => $u_data->time,
                    'students' => $total_students,
                    'attendance' => Attendance::where('lecture',$u_data->id)->count(),
                ];
            });
        $unit = Unit::where('code',$data['unitCode'])->get()->map(function($data){
            return [
                'name'=>$data->name,
                'code'=>$data->code,
            ];
        });
        $data = [
            'lecture' => $lecture,
            'unit' => $unit,
            'students' => $students
        ];

       
        $pdf = Pdf::loadView('pdf.document',['data' => $data]);
        $pdf->setPaper('A4','portrait');
        return $pdf->download("pdf_name");
    }

    public function download()
    {
         // Sample data (replace with your actual data)
         $data = [
            'title' => 'Welcome to PDF Generation',
            'content' => 'This is some sample content for the PDF.',
            'items' => [
                ['name' => 'Item 1', 'price' => 10.99],
                ['name' => 'Item 2', 'price' => 20.49],
                ['name' => 'Item 3', 'price' => 15.75],
            ],
        ];

        // Load the view and pass data
        $pdf = Pdf::loadView('pdf.document', $data); // 'pdf.document' is your blade view

        // Optional: Customize PDF settings
        $pdf->setPaper('A4', 'portrait'); // Example: A4 portrait

        // Return the PDF as a download
        return $pdf->download('document.pdf');
    }
}
