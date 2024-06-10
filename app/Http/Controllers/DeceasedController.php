<?php

namespace App\Http\Controllers;

use App\Models\Deceased;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;
use App\Models\User;
use App\Models\ContactPerson;
use App\Models\coffinplot;
use App\Models\Block;
use App\Models\Services;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Carbon\Carbon;
use DateTime;
use Date;
use Illuminate\Support\Facades\Notification;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Mail;

class DeceasedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('deceasedpage');
    }
    public function get_allDataByJSon()
    {
        $data = DB::select('select addresses.*, services.*, deceaseds.*, deceaseds.id as deceased_id
                            from addresses, deceaseds, services
                            where addresses.id = deceaseds.address_id
                            and services.id = deceaseds.service_id
                            order by deceaseds.lastname desc');
        return response()->json($data);
    }
    public function deceasedForApproval()
    {
        return view('deceasedForApproval');
    }
    public function printpage($deceased_id)
    {
        $deceased_info = DB::select('select addresses.id as a_address_id, addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
        from addresses, deceaseds, services
        where addresses.id = deceaseds.address_id
        and services.id = deceaseds.service_id
        and deceaseds.id = '.$deceased_id.'');

        //Block Area
        //E check niya block kung aha gi pili para sa deceased .Para pag abot sa view dali ra e check ang checkbox kinsa ang selected nga blocks
        $blocks = Block::all();
        $block_data = [];
        foreach($blocks as $b)
        {
            $isPlotted = coffinplot::where([
                'deceased_id' => $deceased_id,
                'block_id' => $b->id,
            ])->exists();

            if($isPlotted)
            {
                $block_data[] = [
                    'id' => $b->id,
                    'section_name' => $b->section_name,
                    'block_cost' => $b->block_cost,
                    'isPlotted' => 1,
                ];
            }
            else
            {
                $block_data[] = [
                    'id' => $b->id,
                    'section_name' => $b->section_name,
                    'block_cost' => $b->block_cost,
                    'isPlotted' => 0,
                ];
            }
        }

        //Service Area
        //E check niya block kung aha gi pili para sa deceased. Para pag abot sa view dali ra e check ang checkbox kinsa ang selected nga services
        $services = Services::all();
        $service_data = [];
        foreach($services as $s)
        {
            $is_selected = Deceased::where([
                'id' => $deceased_id,
                'service_id' => $s->id,
            ])->exists();

            if($is_selected)
            {
                $service_data[] = [
                    'id' => $s->id,
                    'service_name' => $s->service_name,
                    'is_selected' => 1,
                ];
            }
            else
            {
                $service_data[] = [
                    'id' => $s->id,
                    'service_name' => $s->service_name,
                    'is_selected' => 0,
                ];
            }
        }

        $contactpeople = DB::select('select users.*, addresses.* from users, addresses, deceaseds, contactpeople where users.id = contactpeople.user_id and deceaseds.id = contactpeople.deceased_id and users.address_id = addresses.id  and users.role = 3 and deceaseds.id = '.$deceased_id.'');
        $data = [
            'deceased_info' => $deceased_info,
            'blocks' => $block_data,
            'services' => $service_data,
            'contactpeople' => $contactpeople,
        ];
        return view('printpage', compact('data'));
    }
    public function approve($deceased_id)
    {
        $deceased = Deceased::find($deceased_id);
        $deceased->approvalStatus = 1;
        $deceased->update();
        $status = 1;
        $message = "Deceased has been successfully approved";

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
    public function disapprove($deceased_id)
    {
        $deceased = Deceased::find($deceased_id);
        $deceased->approvalStatus = 0;
        $deceased->update();
        return response()->json([
            'status' => 1,
            'message' => 'Deceased has been successfully denied',
        ]);
        // $deceased = Deceased::find($deceased_id);

        // $status = 0; $message = "";
        // $contactpeople = ContactPerson::where('deceased_id', $deceased_id)->get();
        // if(!empty($contactpeople))
        // {
        //     foreach($contactpeople as $cp)
        //     {
        //         $customer = User::find($cp->user_id);

        //         if(!empty($customer))
        //         {
        //             $deceased_info = DB::select('select addresses.id as a_address_id, addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
        //                                         from addresses, deceaseds, services
        //                                         where addresses.id = deceaseds.address_id
        //                                         and services.id = deceaseds.service_id
        //                                         and deceaseds.id = '.$deceased_id.'');

        //             $deceased_details = [
        //                 'customer' => $customer,
        //                 'deceased' => $deceased_info,
        //                 'user_name' => Auth::user()->name,
        //                 'user_position' => Auth::user()->role == 1 ? "LCIMS Admin" : "LCIMS Staff",
        //             ];
        //             $testMailData = [
        //                 'title' => 'Deceased Approval Information',
        //                 'body' => $deceased_details,
        //                 'status' => 'disapproved',
        //                 'data'=> 'This is to inform you that the deceased name '.$deceased_info[0]->firstname.' '.$deceased_info[0]->middlename.' '.$deceased_info[0]->lastname.' '.$deceased_info[0]->suffix.' has been succesfully disappoved.',
        //             ];

        //             Mail::to($customer->email)->send(new MyTestMail($testMailData));

        //             $deceased->approvalStatus = 0;
        //             $deceased->update();
        //             $status = 1;
        //             $message = "Deceased has been successfully disapproved and successfully sent to email.";
        //         }
        //         else
        //         {
        //             $message = "Deceased details has not sent to email might be the customer has invalid/no email address found.";
        //         }
        //     }
        // }
        // else
        // {
        //     $message = "Cannot find a contact person";
        // }
    }
    public function get_deceasedLessThanValidity()
    {
        $data = DB::select('select deceaseds.*
                            from deceaseds, blocks, coffinplots
                            where blocks.id =  coffinplots.block_id
                            and deceaseds.id = coffinplots.deceased_id
                            and year(curdate()) - year(deceaseds.dateof_burial) < blocks.validity');
        return response()->json($data);
    }
    public function get_allMaturity()
    {
        $data = DB::select('select deceaseds.*, blocks.*, deceaseds.id as deceased_id, coffinplots.status as cp_status
                            from deceaseds, blocks, coffinplots
                            where blocks.id =  coffinplots.block_id
                            and deceaseds.id = coffinplots.deceased_id');
        return $data;
    }
    public function calculateTwoDates($fdate, $tdate)
    {
        $date1 = Carbon::parse($fdate);
        $date2 = Carbon::parse($tdate);
        $interval = $date1->diffInYears($date2);
        return $interval;
    }
    public function get_allMaturityByDatatable()
    {
        $data = $this->get_allMaturity();

        return datatables()->of($data)
                            ->addColumn('fullname', function($row){
                                return $row->firstname." ".$row->middlename." ".$row->lastname;
                            })
                            ->addColumn('burialdate', function($row){
                                return $row->dateof_burial;
                            })
                            ->addColumn('block', function($row){
                                return $row->section_name;
                            })
                            ->addColumn('validity', function($row){
                                $burialdate = $row->dateof_burial;
                                $today = Carbon::today();
                                $count = $this->calculateTwoDates($burialdate, $today);

                                if($count > $row->validity)
                                {
                                    $html = "<span class = 'badge badge-danger'>".($count - $row->validity)." Exceeding Years</span>";
                                }
                                else if ($count == $row->validity)
                                {
                                    $html = "<span class = 'badge badge-danger'> Validity Due </span>";
                                }
                                else
                                {
                                    $html = "<span class = 'badge badge-primary'>".($row->validity - $count)." Remaining Years</span>";
                                }
                                return $html;
                            })
                            ->addColumn('status', function($row){
                                $html = "<span class = 'badge badge-warning'>Pending</span>";
                                if($row->cp_status == 1)
                                {
                                    $html = "<span class = 'badge badge-danger'>Mapped Out</span>";
                                }
                                return $html;
                            })
                            ->addColumn('action', function($row){
                                $html = '<button data-id = '.$row->deceased_id.' id = "btn_assignment" type="button" class="btn btn-primary btn-sm btn-flat">';
                                $html .= '<i class = "fas fa fa-route"></i>';
                                $html .= '</button>';
                                return $html;
                            })
                            ->rawColumns(['fullname', 'burialdate', 'block','validity', 'status', 'action'])
                            ->make(true);

    }
    public function nearingmaturity()
    {
        return view('nearingmaturity');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->ajax())
        {
            $validations = [];
            if($request->addcontactperson == 1)
            {
                if($request->sameaddress == 1 AND $request->sameaddress1 == 1)
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'email' => 'required|email:',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'email1' => 'required|email|unique:users,email',
                    ];
                }
                else if($request->sameaddress == 0 AND $request->sameaddress1 == 1)
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'region1' => 'required',
                        'province1' => 'required',
                        'city1' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'email' => 'required|email|unique:users,email',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'email1' => 'required|email|unique:users,email',
                    ];
                }
                //if other contact person has sameaddresss
                else if($request->sameaddress == 1 AND $request->sameaddress1 == 0)
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'region2' => 'required',
                        'province2' => 'required',
                        'city2' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'email' => 'required|email|unique:users,email',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'email1' => 'required|email|unique:users,email',
                    ];
                }
                else
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'region1' => 'required',
                        'province1' => 'required',
                        'city1' => 'required',
                        'region2' => 'required',
                        'province2' => 'required',
                        'city2' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'email' => 'required|email|unique:users,email',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'email1' => 'required|email|unique:users,email',
                        'sameaddress' => 'required',
                    ];
                }
            }
            else
            {
                if($request->sameaddress == 1)
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'email' => 'required|email|unique:users,email',
                        'sameaddress' => 'required',
                    ];
                }
                else
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'region1' => 'required',
                        'province1' => 'required',
                        'city1' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'email' => 'required|email|unique:users,email',
                        'sameaddress' => 'required',
                    ];
                }
            }
            $validator = Validator::make($request->all(), $validations);

            $status = 0;
            $message = "";
            if($validator->fails())
            {
                $status = 2;
                $message = $validator->messages();
            }
            else
            {
                //Address
                $address = DB::table('addresses')->select('id')->where([
                    'region_no' => $request->region,
                    'province_no' => $request->province,
                    'city_no' => $request->city,
                    'barangay_no' => $request->barangay,
                ])->first();

                if($address !== null)
                {
                    $address = $address->id;
                }
                else
                {
                    $address = new Address;
                    $address->region_no = $request->region;
                    $address->region = strtoupper($request->region_text);
                    $address->province_no = $request->province;
                    $address->province =  strtoupper($request->province_text);
                    $address->city_no = $request->city;
                    $address->city = strtoupper($request->city_text);
                    $address->barangay_no = $request->barangay;
                    $address->barangay = strtoupper($request->barangay_text);
                    $address->save();
                    $address = $address->id;
                }

                $conperson_add;
                if($request->sameaddress == 1)
                {
                    $conperson_add = $address;
                }
                else
                {
                    $conperson_add = Address::where([
                        'region_no' => $request->region1,
                        'province_no' => $request->province1,
                        'city_no' => $request->city1,
                        'barangay_no' => $request->barangay1,
                    ])->first();

                    if($conperson_add !== null)
                    {
                        $conperson_add = $conperson_add->id;
                    }
                    else
                    {
                        $conperson_add = new Address;
                        $conperson_add->region_no = $request->region1;
                        $conperson_add->region = strtoupper($request->region_text1);
                        $conperson_add->province_no = $request->province1;
                        $conperson_add->province =  strtoupper($request->province_text1);
                        $conperson_add->city_no = $request->city1;
                        $conperson_add->city = strtoupper($request->city_text1);
                        $conperson_add->barangay_no = $request->barangay1;
                        $conperson_add->barangay = strtoupper($request->barangay_text1);
                        $conperson_add->save();
                        $conperson_add = $conperson_add->id;
                    }

                }

                $contactperson = User::where([
                    'role' => 3,
                    'name' => strtoupper($request->contactperson),
                ])->first();

                if($contactperson !== null)
                {
                    $contactperson = $contactperson->id;
                }
                else
                {
                    $contactperson = new User();
                    $contactperson->role = 3;
                    $contactperson->name = strtoupper($request->contactperson);
                    $contactperson->contactnumber = "63".$request->contactnumber;
                    $contactperson->email = $request->email;
                    $contactperson->relationshipthdeceased = $request->relationship;
                    $contactperson->address_id = $conperson_add;
                    $contactperson->save();
                    $contactperson = $contactperson->id;
                }

                //other contact person
                $contactperson1 = null;
                $conperson_add1 = null;
                if($request->addcontactperson == 1)
                {
                    if($request->sameaddress1 == 1)
                    {
                        $conperson_add1 = $address;
                    }
                    else
                    {
                        $conperson_add1 = Address::where([
                            'region_no' => $request->region2,
                            'province_no' => $request->province2,
                            'city_no' => $request->city2,
                            'barangay_no' => $request->barangay2,
                        ])->first();

                        if($conperson_add1 !== null)
                        {
                            $conperson_add1 = $conperson_add1->id;
                        }
                        else
                        {
                            $conperson_add1 = new Address;
                            $conperson_add1->region_no = $request->region2;
                            $conperson_add1->region = strtoupper($request->region_text2);
                            $conperson_add1->province_no = $request->province2;
                            $conperson_add1->province =  strtoupper($request->province_text2);
                            $conperson_add1->city_no = $request->city2;
                            $conperson_add1->city = strtoupper($request->city_text2);
                            $conperson_add1->barangay_no = $request->barangay2;
                            $conperson_add1->barangay = strtoupper($request->barangay_text2);
                            $conperson_add1->save();
                            $conperson_add1 = $conperson_add1->id;
                        }

                    }
                    $contactperson1 = User::where([
                        'role' => 3,
                        'name' => strtoupper($request->contactperson1),
                    ])->first();

                    if($contactperson1 !== null)
                    {
                        $contactperson1 = $contactperson->id;
                    }
                    else
                    {
                        $contactperson1 = new User();
                        $contactperson1->role = 3;
                        $contactperson1->name = strtoupper($request->contactperson1);
                        $contactperson1->contactnumber = "63".$request->contactnumber1;
                        $contactperson1->email = $request->email1;
                        $contactperson1->relationshipthdeceased = $request->relationship1;
                        $contactperson1->address_id = $conperson_add1;
                        $contactperson1->save();
                        $contactperson1 = $contactperson1->id;
                    }
                }
                //Add Deceased
                $deceased = Deceased::where([
                    'service_id' => 1,
                    'address_id' => $address,
                    // 'contactperson_id' => $contactperson,
                    'causeofdeath' => $request->causeofdeath,
                    'lastname' => strtoupper($request->lastname),
                    'middlename' => strtoupper($request->middlename),
                    'firstname' => strtoupper($request->firstname),
                    'suffix' => strtoupper($request->suffix),
                    'civilstatus' => $request->civilstatus,
                    'sex' => $request->sex,
                    'dateof_death' => $request->dateof_death,
                    'dateof_burial' => $request->dateof_burial,
                    'burial_time' => $request->burial_time,
                    'dateofbirth' => $request->dateofbirth,
                ])->first();

                if($deceased !== null)
                {
                    $status = 0;
                    $message = "Deceased already exists.";
                }
                else
                {
                    $deceased = new Deceased;
                    $deceased->service_id = 1;
                    $deceased->address_id = $address;
                    // $deceased->contactperson_id = $contactperson;
                    $deceased->causeofdeath = $request->causeofdeath;
                    $deceased->lastname = strtoupper($request->lastname);
                    $deceased->middlename = strtoupper($request->middlename);
                    $deceased->firstname = strtoupper($request->firstname);
                    $deceased->suffix = strtoupper($request->suffix);
                    $deceased->civilstatus = $request->civilstatus;
                    $deceased->sex = $request->sex;
                    $deceased->dateof_death = $request->dateof_death;
                    $deceased->dateof_burial = $request->dateof_burial;
                    $deceased->burial_time = $request->burial_time;
                    $deceased->dateofbirth = $request->dateofbirth;
                    $deceased->lastaction_by = Auth::user()->name;
                    $deceased->save();

                    $dbcontactperson = new ContactPerson;
                    $dbcontactperson->user_id = $contactperson;
                    $dbcontactperson->deceased_id = $deceased->id;
                    $dbcontactperson->save();

                    if($contactperson1 !== null)
                    {
                        $dbcontactperson1 = new ContactPerson;
                        $dbcontactperson1->user_id = $contactperson1;
                        $dbcontactperson1->deceased_id = $deceased->id;
                        $dbcontactperson1->save();
                    }
                    $status = 1;
                    $message = "Deceased has been successfully registered.";
                }
            }
            $json = [
                'status' => $status,
                'message' => $message,
            ];
            return response()->json($json);
        }
    }

    public function get_allData()
    {
        $data = DB::select('select addresses.*, services.*, deceaseds.*, deceaseds.id as deceased_id
                            from addresses, deceaseds, services
                            where addresses.id = deceaseds.address_id
                            and services.id = deceaseds.service_id
                            order by date(deceaseds.dateof_burial) desc');

        return datatables()->of($data)
                            ->addColumn('fullname', function($row){
                                $html = $row->lastname.", ".$row->middlename.", ".$row->firstname;
                                return $html;
                            })
                            ->addColumn('address', function($row){
                                $html = $row->barangay.", ".$row->city;
                                return $html;
                            })
                            ->addColumn('dateofburial', function($row){
                                $html = $row->dateof_burial;
                                return $html;
                            })
                            ->addColumn('sex', function($row){
                                $html = $row->sex;
                                return $html;
                            })
                            ->addColumn('status', function($row){
                                $html = '<span class = "badge badge-warning right">PENDING APPROVAL</span>';
                                if($row->burriedStatus == 1)
                                {
                                    $html = '<span class = "badge badge-danger right">DESIGNATED</span>';
                                }
                                if($row->burriedStatus == 2)
                                {
                                    $html = '<span class = "badge badge-danger right">MAPPED OUT</span>';
                                }
                                if($row->approvalStatus == 1 && $row->burriedStatus == 0)
                                {
                                    $html = '<span class = "badge badge-primary right">TO PLOT</span>';
                                }

                                return $html;
                            })
                            ->addColumn('lastaction', function($row){
                                return $row->lastaction_by;
                            })
                            ->addColumn('action', function($row){
                                $html = "";
                                if($row->approvalStatus == 1)
                                {
                                    $html .= '<button data-id = '.$row->deceased_id.' id = "btn_assign" type="button" class="btn btn-primary btn-sm btn-flat">';
                                    $html .= '<i class = "fa fas fa-map-marked-alt"></i>';
                                    $html .= '</button>';
                                    $html .= '<button data-id = '.$row->deceased_id.' id = "btn_edit" type="button" class="btn btn-success btn-sm btn-flat">';
                                    $html .= '<i class = "fa fa-edit"></i>';
                                    $html .= '</button>';
                                    $html .= '<button data-id = '.$row->deceased_id.' id = "btn_info" type="button" class="btn btn-primary btn-sm btn-flat">';
                                    $html .= '<i class = "fa fa-info"></i>';
                                    $html .= '</button>';
                                    // $html .= '<button data-id = '.$row->deceased_id.' id = "btn_assignment" type="button" class="btn btn-primary btn-sm btn-flat">';
                                    // $html .= '<i class = "fas fa fa-route"></i>';
                                    // $html .= '</button>';
                                    $html .= '<a  href="/deceased/printpage/'.$row->deceased_id.'" type="button" class="btn btn-success btn-sm btn-flat">';
                                    $html .= '<i class = "fas fa fa-print"></i>';
                                    $html .= '</a>';
                                }
                                else
                                {
                                    $deceased_id = $row->deceased_id;
                                    $html .= '<button disabled data-id = '.$row->deceased_id.' id = "btn_assign" type="button" class="btn btn-primary btn-sm btn-flat">';
                                    $html .= '<i class = "fa fas fa-map-marked-alt"></i>';
                                    $html .= '</button>';
                                    $html .= '<button  data-id = '.$row->deceased_id.' id = "btn_edit" type="button" class="btn btn-success btn-sm btn-flat">';
                                    $html .= '<i class = "fa fa-edit"></i>';
                                    $html .= '</button>';
                                    $html .= '<button data-id = '.$row->deceased_id.' id = "btn_info" type="button" class="btn btn-primary btn-sm btn-flat">';
                                    $html .= '<i class = "fa fa-info"></i>';
                                    $html .= '</button>';
                                    // $html .= '<button disabled data-id = '.$row->deceased_id.' id = "btn_assignment" type="button" class="btn btn-primary btn-sm btn-flat">';
                                    // $html .= '<i class = "fas fa fa-route"></i>';
                                    // $html .= '</button>';
                                    $html .= '<a href="/deceased/printpage/'.$row->deceased_id.'"  type="button" class="btn btn-success btn-sm btn-flat disabled">';
                                    $html .= '<i class = "fas fa fa-print"></i>';
                                    $html .= '</a>';
                                }
                                return $html;
                            })
                            ->rawColumns(['fullname', 'address', 'dateofburial', 'sex', 'status', 'action'])
                            ->make(true);
    }
    public function show($deceased_id)
    {
        $deceased_info = DB::select('select addresses.id as a_address_id, addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
        from addresses, deceaseds, services
        where addresses.id = deceaseds.address_id
        and services.id = deceaseds.service_id
        and deceaseds.id = '.$deceased_id.'');

        $contactperson =  DB::select('SELECT users.*, users.id as contactperson_id, deceaseds.id as deceased_id, addresses.id as address_id, addresses.*
                                    FROM users, deceaseds, addresses, contactpeople
                                    where addresses.id = users.address_id
                                    and users.id = contactpeople.user_id
                                    and deceaseds.id = contactpeople.deceased_id
                                    and deceaseds.id = '.$deceased_id.'
                                    order by users.id asc');

       $deceased_asssigment = DB::select('SELECT blocks.*, services.*
                                      FROM deceaseds, blocks, services, coffinplots
                                      WHERE blocks.id = coffinplots.block_id
                                      AND deceaseds.id = coffinplots.deceased_id
                                      AND services.id = deceaseds.service_id
                                      AND deceaseds.id = '.$deceased_id.'');

        $data = [ $deceased_info, $deceased_asssigment, $contactperson];
        return response()->json($data);
    }
    public function notificationCount()
    {
        $data = DB::select('select addresses.*, services.*, deceaseds.*, deceaseds.id as deceased_id
                            from addresses, deceaseds, services
                            where addresses.id = deceaseds.address_id
                            and services.id = deceaseds.service_id
                            order by deceaseds.dateof_burial desc');
        return response()->json($data);
    }
    function checkInternet()
    {
        $connected = @fsockopen("www.google.com", 80) ? true : false;
        return $connected;
    }
    public function notificationCount_NearingMaturity()
    {
        $blocks = Block::all();
        $notification = [];
        $count  = 0;
        foreach($blocks as $b)
        {
            $data = DB::select('select DATE_FORMAT(FROM_DAYS(DATEDIFF(now(), deceaseds.dateof_burial)), "%Y")+0 AS age, deceaseds.*, blocks.*, deceaseds.id as deceased_id
                                from deceaseds, blocks, coffinplots
                                where blocks.id =  coffinplots.block_id
                                and deceaseds.id = coffinplots.deceased_id
                                and deceaseds.hasSentEmail = 0
                                and coffinplots.status = 0
                                and blocks.id = '.$b->id.'');
            if(!empty($data))
            {
                if($this->checkInternet())
                {
                    if($data[0]->age >= $b->validity)
                    {
                        $contactpeople = ContactPerson::where('deceased_id', $data[0]->deceased_id)->get();
                        if(!empty($contactpeople))
                        {
                            foreach($contactpeople as $cp)
                            {
                                $customer = User::find($cp->user_id);

                                if(!empty($customer))
                                {
                                    $deceased_info = DB::select('select addresses.id as a_address_id, addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
                                                                from addresses, deceaseds, services
                                                                where addresses.id = deceaseds.address_id
                                                                and services.id = deceaseds.service_id
                                                                and deceaseds.id = '.$data[0]->deceased_id.'');

                                    $deceased_details = [
                                        'customer' => $customer,
                                        'deceased' => $deceased_info,
                                        'user_name' => Auth::user()->name,
                                        'user_position' => Auth::user()->role == 1 ? "LCIMS Admin" : "LCIMS Staff",
                                    ];
                                    $testMailData = [
                                        'title' => 'Deceased Nearing Maturity Information',
                                        'body' => $deceased_details,
                                        'status' => 'matures',
                                        'years' => $data[0]->age,
                                        'data'=> 'This communication serves to notify you that the status of the deceased individual, namely ' .$deceased_info[0]->firstname.' '.$deceased_info[0]->middlename.' '.$deceased_info[0]->lastname.' '.$deceased_info[0]->suffix.' has surpassed the parameters outlined within the lot contract. Kindly refer to the details provided below for further information.',
                                    ];

                                    Mail::to($customer->email)->send(new MyTestMail($testMailData));

                                    //Update deceased to avoid repeated email notification
                                    $deceased = Deceased::find($data[0]->deceased_id);
                                    $deceased->hasSentEmail = 1;
                                    $deceased->update();
                                }
                            }
                        }
                    }
                }
                $count = $count+1;
            }

        }
        return response()->json($count);
    }
    public function forApproval()
    {
        $data = DB::select('select addresses.*, services.*, deceaseds.*, deceaseds.id as deceased_id
                            from addresses, deceaseds, services
                            where addresses.id = deceaseds.address_id
                            and services.id = deceaseds.service_id
                            order by deceaseds.dateof_burial desc');

        return datatables()->of($data)
                            ->addColumn('fullname', function($row){
                                $html = $row->lastname.", ".$row->middlename.", ".$row->firstname;
                                return $html;
                            })
                            ->addColumn('address', function($row){
                                $html = $row->barangay.", ".$row->city;
                                return $html;
                            })
                            ->addColumn('dateofburial', function($row){
                                $html = $row->dateof_burial;
                                return $html;
                            })
                            ->addColumn('sex', function($row){
                                $html = $row->sex;
                                return $html;
                            })
                            ->addColumn('action', function($row){
                                $html = "";
                                if($row->burriedStatus == 1)
                                {
                                    $html = '<span class = "badge badge-danger right">DESIGNATED</span>';
                                }
                                else
                                {
                                    if($row->approvalStatus == 1)
                                    {

                                        $html .= '<button data-id = '.$row->deceased_id.' id = "btn_disapprove" type="button" class="btn btn-danger btn-sm btn-flat">';
                                        $html .= '<i class = "fa fas fa-times"></i>&nbsp;&nbsp;CANCEL';
                                        $html .= '</button>';
                                    }
                                    else
                                    {
                                        $html .= '<button data-id = '.$row->deceased_id.' id = "btn_approve" type="button" class="btn btn-primary btn-sm btn-flat">';
                                        $html .= '<i class = "fa fas fa-check"></i>&nbsp;&nbsp;APPROVE';
                                        $html .= '</button>';
                                    }
                                }
                                return $html;
                            })
                            ->rawColumns(['fullname', 'address', 'dateofburial', 'sex',  'action'])
                            ->make(true);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(deceased $deceased)
    {
        //
    }
    public function updatenotification()
    {
        $new_notif_exists = Deceased::where([
            'new_notif' => 0
        ])->exists();
        if($new_notif_exists)
        {
            DB::table('deceaseds')->update(['new_notif'=> 1])->where('new_notif', 0);
        }
        return response()->json([
            'status' => 1,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update_deceased(Request $request, deceased $deceased)
    {
        if($request->ajax())
        {
            $validations = [];
            if($request->addcontactperson == 1)
            {
                if($request->sameaddress == 1 AND $request->sameaddress1 == 1)
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'email1' => 'required|email',
                        'email' => 'required|email',
                    ];
                }
                else if($request->sameaddress == 0 AND $request->sameaddress1 == 1)
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'region1' => 'required',
                        'province1' => 'required',
                        'city1' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'email1' => 'required|email',
                        'email' => 'required|email',
                    ];
                }
                //if other contact person has sameaddresss
                else if($request->sameaddress == 1 AND $request->sameaddress1 == 0)
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'region2' => 'required',
                        'province2' => 'required',
                        'city2' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'email1' => 'required|email',
                        'email' => 'required|email',
                    ];
                }
                else
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'region1' => 'required',
                        'province1' => 'required',
                        'city1' => 'required',
                        'region2' => 'required',
                        'province2' => 'required',
                        'city2' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'contactperson1' => 'required',
                        'relationship1' => 'required',
                        'contactnumber1' => 'required|min:10|max:10',
                        'sameaddress' => 'required',
                        'email1' => 'required|email',
                        'email' => 'required|email',
                    ];
                }
            }
            else
            {
                if($request->sameaddress == 1)
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'sameaddress' => 'required',
                        'email' => 'required|email',
                    ];
                }
                else
                {
                    $validations = [
                        'lastname' => 'required',
                        'middlename' => 'required',
                        'firstname' => 'required',
                        'suffix' => 'required',
                        'dateof_death' => 'required',
                        'dateofbirth' => 'required',
                        'dateof_burial' => 'required',
                        'burial_time' => 'required',
                        'civilstatus' => 'required|in:S,M,W,D',
                        'sex' => 'required|in:M,F',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'region1' => 'required',
                        'province1' => 'required',
                        'city1' => 'required',
                        'causeofdeath' => 'required',
                        'contactperson' => 'required',
                        'relationship' => 'required',
                        'contactnumber' => 'required|min:10|max:10',
                        'sameaddress' => 'required',
                        'email' => 'required|email',
                    ];
                }
            }
            $validator = Validator::make($request->all(), $validations);

            $status = 0;
            $message = "";
            if($validator->fails())
            {
                $status = 2;
                $message = $validator->messages();
            }
            else
            {
                //Address

                $address = DB::table('addresses')->select('id')->where([
                    'region_no' => $request->region,
                    'province_no' => $request->province,
                    'city_no' => $request->city,
                    'barangay_no' => $request->barangay,
                ])->first();

                if($address !== null)
                {
                    $address = $address->id;
                }
                else
                {
                    $address = new Address;
                    $address->region_no = $request->region;
                    $address->region = strtoupper($request->region_text);
                    $address->province_no = $request->province;
                    $address->province =  strtoupper($request->province_text);
                    $address->city_no = $request->city;
                    $address->city = strtoupper($request->city_text);
                    if($request->barangay != null)
                    {
                        $address->barangay_no = $request->barangay;
                        $address->barangay = strtoupper($request->barangay_text);
                    }
                    $address->save();
                    $address = $address->id;
                }

                $conperson_add;
                if($request->sameaddress == 1)
                {
                    $conperson_add = $address;

                }
                else
                {
                    $conperson_add = Address::where([
                        'region_no' => $request->region1,
                        'province_no' => $request->province1,
                        'city_no' => $request->city1,
                        'barangay_no' => $request->barangay1,
                    ])->first();

                    if($conperson_add !== null)
                    {
                        $conperson_add = $conperson_add->id;
                    }
                    else
                    {
                        $conperson_add = new Address;
                        $conperson_add->region_no = $request->region1;
                        $conperson_add->region = strtoupper($request->region_text1);
                        $conperson_add->province_no = $request->province1;
                        $conperson_add->province =  strtoupper($request->province_text1);
                        $conperson_add->city_no = $request->city1;
                        $conperson_add->city = strtoupper($request->city_text1);
                        if($request->barangay1 != null)
                        {
                            $conperson_add->barangay_no = $request->barangay1;
                            $conperson_add->barangay = strtoupper($request->barangay_text1);
                        }
                        $conperson_add->save();
                        $conperson_add = $conperson_add->id;
                    }

                }

                if($request->contactperson_id !== null)
                {
                    $contactperson = User::find($request->contactperson_id);
                    $contactperson->role = 3;
                    $contactperson->name = strtoupper($request->contactperson);
                    $contactperson->contactnumber = "63".$request->contactnumber;
                    $contactperson->email = $request->email;
                    $contactperson->relationshipthdeceased = $request->relationship;
                    $contactperson->address_id = $conperson_add;
                    $contactperson->update();
                    $contactperson = $request->contactperson_id;
                }

                $contactperson1 = null;
                $conperson_add1;

                if($request->addcontactperson == 1)
                {
                    if($request->sameaddress1 == 1)
                    {
                        $conperson_add1 = $address;
                    }
                    else
                    {
                        $conperson_add1 = Address::where([
                            'region_no' => $request->region2,
                            'province_no' => $request->province2,
                            'city_no' => $request->city2,
                            'barangay_no' => $request->barangay2,
                        ])->first();

                        if($conperson_add1 !== null)
                        {
                            $conperson_add1 = $conperson_add1->id;
                        }
                        else
                        {
                            $conperson_add1 = new Address;
                            $conperson_add1->region_no = $request->region2;
                            $conperson_add1->region = strtoupper($request->region_text2);
                            $conperson_add1->province_no = $request->province2;
                            $conperson_add1->province =  strtoupper($request->province_text2);
                            $conperson_add1->city_no = $request->city2;
                            $conperson_add1->city = strtoupper($request->city_text2);
                            if($request->barangay2 !== null)
                            {
                                $conperson_add1->barangay_no = $request->barangay2;
                                $conperson_add1->barangay = strtoupper($request->barangay_text2);
                            }
                            $conperson_add1->save();
                            $conperson_add1 = $conperson_add1->id;
                        }

                    }

                    if($request->contactperson_id1 !== null)
                    {
                        $contactperson1 = User::find($request->contactperson_id1);
                        $contactperson1->role = 3;
                        $contactperson1->name = strtoupper($request->contactperson1);
                        $contactperson1->contactnumber = "63".$request->contactnumber1;
                        $contactperson1->email = $request->email1;
                        $contactperson1->relationshipthdeceased = $request->relationship1;
                        $contactperson1->address_id = $conperson_add1;
                        $contactperson1->update();
                        $contactperson1 = $request->contactperson_id1;
                    }
                    else
                    {
                        $exist_contactpeople = ContactPerson::where([
                            'deceased_id' => $request->deceased_id,
                            'user_id' => $request->contactperson_id1
                        ])->exists();
                        if(!$exist_contactpeople)
                        {
                            $contactperson1 = new User;
                            $contactperson1->role = 3;
                            $contactperson1->name = strtoupper($request->contactperson1);
                            $contactperson1->contactnumber = "63".$request->contactnumber1;
                            $contactperson1->relationshipthdeceased = $request->relationship1;
                            $contactperson1->address_id = $conperson_add1;
                            $contactperson1->save();
                            $contactperson1 = $contactperson1->id;
                        }
                    }
                }

                $deceased = Deceased::find($request->cem_id);
                $deceased->service_id = 1;
                $deceased->address_id = $address;
                $deceased->causeofdeath = $request->causeofdeath;
                $deceased->lastname = strtoupper($request->lastname);
                $deceased->middlename = strtoupper($request->middlename);
                $deceased->firstname = strtoupper($request->firstname);
                $deceased->suffix = strtoupper($request->suffix);
                $deceased->civilstatus = $request->civilstatus;
                $deceased->sex = $request->sex;
                $deceased->dateof_death = $request->dateof_death;
                $deceased->dateof_burial = $request->dateof_burial;
                $deceased->burial_time = $request->burial_time;
                $deceased->dateofbirth = $request->dateofbirth;
                $deceased->lastaction_by = Auth::user()->name;
                $deceased->update();

                $verify_contact = ContactPerson::where([
                    'deceased_id' => $request->cem_id,
                    'user_id' => $request->contactperson_id,
                ])->first();

                //Check if no changes.
                if($verify_contact === null)
                {
                    $dbcontactperson = new ContactPerson;
                    $dbcontactperson->user_id = $contactperson;
                    $dbcontactperson->deceased_id = $deceased->id;
                    $dbcontactperson->save();
                }

                $verify_contact1 = ContactPerson::where([
                    'deceased_id' => $request->cem_id,
                    'user_id' => $request->contactperson_id1,
                ])->first();

                if($verify_contact1 === null)
                {
                    if($contactperson1 !== null)
                    {
                        $dbcontactperson1 = new ContactPerson;
                        $dbcontactperson1->user_id = $contactperson1;
                        $dbcontactperson1->deceased_id = $deceased->id;
                        $dbcontactperson1->save();
                    }
                }
                $status = 1;
                $message = "Deceased has been successfully updated.";

            }
            $json = [
                'status' => $status,
                'message' => $message,
            ];
            return response()->json($json);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    //THIS IS THE MAIN PROBLEM SOLVING OF THE SYSTEM.
    public function assign_block(Request $request, $deceased_id, $space_id)
    {
        $status = 0;
        $message = "";
        $_block_name = "";
        $_block_cost = "";
        $_block_payment = "";

        $deceased = Deceased::find($deceased_id);
        if($request->status == "assign")
        {

            $space_area = Block::find($space_id);
            if($request->payment > $space_area->block_cost)
            {
                $status = 2;
                $message = "Payment must below the block cost";
            }
            else
            {
                //Diri mag transact sa payment kung naa bay balance bayran ang client;
                $remainingBalance = 0;
                if($request->payment < $space_area->block_cost)
                {
                    $remainingBalance = $space_area->block_cost - $request->payment;
                }
                //E update dayon niya ang burried status to 1 meaning nalubong na gyud ang patay
                $deceased->remaining_balance = $remainingBalance;
                $deceased->burriedStatus = 1;
                $deceased->lastaction_by = Auth::user()->name;
                $deceased->update();

                $coffinplot = new coffinplot();
                $coffinplot->deceased_id = $deceased_id;
                $coffinplot->block_id = $space_id;
                $coffinplot->status = 0;
                $coffinplot->plot_number = 0001;
                $coffinplot->save();

                //Decrement blocks once coffinplot is occupied.
                $block = Block::find($space_id);
                $block->slot = $block->slot-1;
                $block->update();

                $_block_name = $block->section_name;
                $_block_payment = $remainingBalance;
                $_block_cost = $space_area->block_cost;

                $status = 1;
                $message = 'The deceased has been plotted successfully.';
            }
        }
        if($request->status == "move")
        {
            if(Hash::check($request->password, Auth::user()->password))
            {
                $space_area = Block::find($space_id);
                if($request->payment > $space_area->block_cost)
                {
                    $status = 2;
                    $message = "Payment must below the block cost";
                }
                else
                {
                    //Diri mag transact sa payment kung naa bay balance bayran ang client;
                    $remainingBalance = 0;
                    if($request->payment < $space_area->block_cost)
                    {
                        $remainingBalance = $space_area->block_cost - $request->payment;
                    }

                    $deceased->remaining_balance = $remainingBalance;
                    $deceased->lastaction_by = Auth::user()->name;
                    $deceased->update();
                    //Return info
                    $coffinplot = coffinplot::find($request->coffin_id);
                    $block_id = $coffinplot->block_id;
                    //Increment blocks once coffinplot is occupied.
                    $block = Block::find($block_id);
                    $block->slot = $block->slot+1;
                    $block->update();

                    //update new
                    $coffinplot = coffinplot::find($request->coffin_id);
                    $coffinplot->deceased_id = $deceased_id;
                    $coffinplot->block_id = $space_id;
                    $coffinplot->plot_number = 0001;
                    $coffinplot->update();

                    //Decrement blocks once coffinplot is occupied.
                    $block = Block::find($space_id);
                    $block->slot = $block->slot-1;
                    $block->update();

                    $_block_name = $block->section_name;
                    $_block_payment = $remainingBalance;
                    $_block_cost = $space_area->block_cost;

                    $status = 1;
                    $message = 'The deceased has been plotted successfully.';
                }
            }
            else{
                $status = 0;
                $message = "Invalid Password!";
            }
        }
        $sentemail = 0;

        if($status == 1)
        {
            //Send Email To Receipients
            $contactpeople = ContactPerson::where('deceased_id', $deceased_id)->get();
            foreach($contactpeople as $cp)
            {
                $customer = User::find($cp->user_id);

                if(!empty($customer))
                {
                    $deceased_info = DB::select('select addresses.id as a_address_id, addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
                                                from addresses, deceaseds, services
                                                where addresses.id = deceaseds.address_id
                                                and services.id = deceaseds.service_id
                                                and deceaseds.id = '.$deceased_id.'');

                    $deceased_details = [
                        'customer' => $customer,
                        'deceased' => $deceased_info,
                        'user_name' => Auth::user()->name,
                        'user_position' => Auth::user()->role == 1 ? "LCIMS Admin" : "LCIMS Staff",
                    ];
                    $testMailData = [
                        'title' => 'Deceased Plot Information',
                        'body' => $deceased_details,
                        'status' => 'plotted',
                        'block_cost' => $_block_cost,
                        'block_name' => $_block_name,
                        'block_payment' => $_block_payment,
                        'data'=> 'This is to inform you that the deceased name '.$deceased_info[0]->firstname.' '.$deceased_info[0]->middlename.' '.$deceased_info[0]->lastname.' '.$deceased_info[0]->suffix.' has been successfully burried and plotted in '.$_block_name.'',
                    ];

                    Mail::to($customer->email)->send(new MyTestMail($testMailData));

                    $sentemail += 1;
                }
            }
        }
        return response()->json([
            'status' => $status,
            'email' => $sentemail,
            'message' => $message,
        ]);
    }
    public function destroy(deceased $deceased)
    {
        //
    }

    public function designation(Request $request, $deceased_id, $service_id)
    {
        $status = 0;
        $msg = "";
        if($request->ajax())
        {
            if(Hash::check($request->password, Auth::user()->password))
            {
                if($request->status == "designation")
                {
                    $deceased = Deceased::find($deceased_id);
                    $deceased->service_id = $service_id;
                    $deceased->burriedStatus = 2;
                    $deceased->lastaction_by = Auth::user()->name;
                    $deceased->update();
                    $status = 1;
                    $msg = "Deceased has been successfully processed!";

                    $service = Services::find($service_id);
                    $service_name = $service->service_name;
                    $contactpeople = ContactPerson::where('deceased_id', $deceased_id)->get();
                    foreach($contactpeople as $cp)
                    {
                        $customer = User::find($cp->user_id);
                        $contactpeople = ContactPerson::where('deceased_id', $deceased_id)->get();

                        if(!empty($customer))
                        {
                            $deceased_info = DB::select('select addresses.id as a_address_id, addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
                                                        from addresses, deceaseds, services
                                                        where addresses.id = deceaseds.address_id
                                                        and services.id = deceaseds.service_id
                                                        and deceaseds.id = '.$deceased_id.'');

                            $deceased_details = [
                                'customer' => $customer,
                                'deceased' => $deceased_info,
                                'user_name' => Auth::user()->name,
                                'user_position' => Auth::user()->role == 1 ? "LCIMS Admin" : "LCIMS Staff",
                            ];
                            $testMailData = [
                                'title' => 'Deceased Nearing Maturity Information',
                                'body' => $deceased_details,
                                'status' => 'mappedout',
                                'data'=> 'This is to inform you that the deceased name '.$deceased_info[0]->firstname.' '.$deceased_info[0]->middlename.' '.$deceased_info[0]->lastname.' '.$deceased_info[0]->suffix.' has been successfully mapped out and assigned in :'.$service_name.'',
                            ];

                            Mail::to($customer->email)->send(new MyTestMail($testMailData));
                        }
                    }

                    $coffinplot = coffinplot::where('deceased_id', $deceased_id)->get();
                    $coffinplot = coffinplot::find($coffinplot[0]->id);
                    $coffinplot->status = 1;
                    $coffinplot->update();
                }
            }
            else
            {
                $status = 0;
                $msg = "Cannot proceed. Invalid Password";
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $msg
        ]);
    }

}
