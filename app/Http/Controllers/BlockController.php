<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\coffinplot;
use File;
use App\Models\Deceased;
use DB;
use App\Mail\MyTestMail;
use App\Models\Services;
use App\Models\ContactPerson;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Mail;
class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('blockspage');
    }

    public function get_allBlocks()
    {
        $data = Block::all();
        return response()->json($data);
    }
    public function get()
    {
        return Block::all();
    }
    public function alldata_bydatatable()
    {
        $data = $this->get();

        return datatables()->of($data)
                        ->addColumn('image', function($row){
                            $html = "";
                            if($row->image != "" && $row->image != null)
                            {
                                $html = '<td align="center" data-id="' . $row->id . '">
    <img id="img_rip_' . $row->id . '" class="zoomed_image"
       
        src="/upload_images/' . $row->image . '"
        onclick="zoomImage(this)">
</td>';

                            }
                            else {
                                 $html = '<td align = "center" data-id = '.$row->id.'><img src= "{{ asset("dist/img/rip.jpg") }}" class = "img-responsive" style = "width: 100px; height: 100px"></td>';
                            }
                            return $html;
                        })
                        ->addColumn('block_name', function($row){
                            $html = '<td data-id = '.$row->id.'>'.$row->section_name.'</td>';
                            return $html;

                        })
                        ->addColumn('slot', function($row){
                            $html = '<td  data-id = '.$row->id.' style = "font-size: 20px; text-align: center; font-family: Times New Roman; font-weight: bold; color: red">'.$row->slot.'</td>';
                            return $html;
                        })
                        ->addColumn('cost', function($row){
                            $html = '<td  data-id = '.$row->id.' style = "font-size: 20px; text-align: center; font-family: Times New Roman; font-weight: bold; color: red">₱' . number_format($row->block_cost, 2) . '</td>';
                            return $html;

                        })
                        ->addColumn('validity', function($row){
                            $html = '<td data-id = '.$row->id.' style = "font-size: 20px; text-align: right; font-family: Times New Roman; text-align: center"> '.$row->validity.'</td>';
                            return $html;
                        })
                        ->addColumn('action', function($row){
                            $html = "";
                            $html .= '<td align = "center">';
                            $html .= '<button data-id = '.$row->id.' id = "btn_edit" type="button" class="btn btn-success btn-sm btn-flat">';
                            $html .= '<i class = "fa fa-edit"></i>';
                            $html .= '</button>';
                            $html .= '<button data-id = '.$row->id.' id = "btn_slot" type="button" class="btn btn-primary btn-sm btn-flat">';
                            $html .= '<i class = "fa fa-laptop"></i>';
                            $html .= '</button></td>';
                            $html .= '<button data-id = '.$row->id.'  id = "btn_manage" type="button" class="btn btn-danger btn-sm btn-flat">';
                            $html .= '<i class = "fa fa-user-slash"></i>';
                            $html .= '</button>';
                            return $html;
                        })
                        ->rawColumns(['image', 'block_name', 'slot', 'cost', 'validity', 'action'])
                        ->make(true);


    }
    public function get_alldeceasedsByBlock($block_id)
    {
        //get all deceaseds by block assigned.
        $deceaseds = DB::select('SELECT deceaseds.*, blocks.*, deceaseds.id as d_id
                                FROM blocks, deceaseds, coffinplots
                                WHERE blocks.id = coffinplots.block_id
                                AND deceaseds.id = coffinplots.deceased_id
                                AND coffinplots.status = 0
                                AND blocks.id = '.$block_id.'');
        return $deceaseds;
    }
    public function get_alldeceasedsByBlockInJson($block_id)
    {
        $data = [
          'deceaseds' => $this->get_alldeceasedsByBlock($block_id),
          'services' => app('App\Http\Controllers\ServicesController')->get(),
          'blockinfo' => $this->get_blockInfo($block_id),
        ];
        return response()->json($data);
    }
    //Manage deceased by block
    function checkInternet()
    {
        $connected = @fsockopen("www.google.com", 80) ? true : false;
        return $connected;
    }
    public function submitdeceased(Request $request)
    {
        $status = 0; $message = "";

        $validator = Validator::make($request->all(), [
            'deceaseds' => 'required',
            'service_id' => 'required',
            'block_id' => 'required',
        ]);

        if($validator->fails())
        {
            $status = 2;
            $message = $validator->messages();
        }
        else
        {
            $deceaseds = $request->deceaseds;
            $block_id = $request->block_id;
            $service_chosen = $request->service_id;

            for($i = 0; $i<count($deceaseds); $i++)
            {
                $deceased = Deceased::find($deceaseds[$i]);
                $deceased->service_id = $service_chosen;

                $coffinplot = coffinplot::where([
                    'deceased_id' => $deceaseds[$i],
                    'block_id' => $block_id
                ])->first();

                $service = Services::find($request->service_id);
                $service_name = $service->service_name;
                $contactpeople = ContactPerson::where('deceased_id', $deceaseds[$i])->get();

                foreach($contactpeople as $cp)
                {
                    $customer = User::find($cp->user_id);
                    $contactpeople = ContactPerson::where('deceased_id', $deceaseds[$i])->get();

                    if(!empty($customer))
                    {
                        $deceased_info = DB::select('select addresses.id as a_address_id, addresses.*, services.*,  deceaseds.*, deceaseds.id as deceased_id
                                                    from addresses, deceaseds, services
                                                    where addresses.id = deceaseds.address_id
                                                    and services.id = deceaseds.service_id
                                                    and deceaseds.id = '.$deceaseds[$i].'');

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

                $coffinplot = coffinplot::find($coffinplot->id);
                $coffinplot->status = 1;
                $coffinplot->update();
            }
            $status = 1; $message = "Deceaseds transaction has been successfull.";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
    public function get_classifiedBlocks($deceased_id)
    {
        $classifiedBlocks = [];
        $blocks = Block::all();
        $status = 0;
        foreach($blocks as $b)
        {
            $exist_coffinplot = coffinplot::where([
                'deceased_id' => $deceased_id,
                'block_id' => $b->id,
            ])->first();

            if($exist_coffinplot  !== null)
            {
                $status = 1;
                $classifiedBlocks[] = [
                    'id' => $b->id,
                    'image' => $b->image,
                    'section_name' => $b->section_name,
                    'slot' => $b->slot,
                    'block_cost' => $b->block_cost,
                    'status' => 1,
                    'coffin_id' => $exist_coffinplot->id,
                ];
            }
            else
            {
                $classifiedBlocks[] = [
                    'id' => $b->id,
                    'image' => $b->image,
                    'section_name' => $b->section_name,
                    'slot' => $b->slot,
                    'block_cost' => $b->block_cost,
                    'status' => 0,
                    'coffin_id' => null,
                ];
            }
        }
        return response()->json([
            'cb'=>$classifiedBlocks,
            'status' => $status,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = 0;
        $message = "Cannot process your request.";

        if($request->ajax())
        {
            $validation = Validator::make($request->all(), [
                'slot' => 'required|numeric|min:0|not_in:0',
                'section_name' => 'required|string|unique:blocks,section_name',
                'block_cost' => 'required|numeric|min:0|not_in:0',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|unique:blocks,image'
            ]);

            if($validation->fails())
            {
                $status = 2;
                $message = $validation->messages();
            }
            else
            {
                $image = $request->file('image');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload_images'), $new_name);

                $block = new Block;
                $block->slot = strtoupper($request->slot);
                $block->section_name = strtoupper($request->section_name);
                $block->block_cost = $request->block_cost;
                $block->validity = $request->validity;
                $block->image = $new_name;
                $block->save();

                $status = 1;
                $message = "New space area has been successfully added.";
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function get_blockInfo($id)
    {
        return Block::find($id);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json($this->get_blockInfo($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Block $block)
{
    $status = 0;
    $message = "Cannot process your request.";

    if ($request->ajax()) {
        if ($request->type == "update_slot") {
            $validation = Validator::make($request->all(), [
                '_slot' => 'required|numeric',
                '_block_id' => 'required',
            ]);

            if ($validation->fails()) {
                $status = 2;
                $message = $validation->messages();
            } else {
                $block = Block::find($request->_block_id);
                $newSlot = $block->slot + $request->_slot;

                if ($newSlot < 0) {
                    $message = "Section cannot have a negative slot.";
                } else {
                    $block->slot = $newSlot;
                    $block->update();
                    $message = "Section has been successfully updated.";
                    $status = 1;
                }
            }
        }
    }

    return response()->json([
        'status' => $status,
        'message' => $message,
    ]);
}


    public function update_withImage(Request $request)
    {
        $status = 0;
        $message = "Cannot process your request.";
        if($request->ajax())
        {
            if($request->type == "update_block")
            {
                $validation = Validator::make($request->all(),[]);
                if($request->image != null)
                {
                    $validation = Validator::make($request->all(), [
                        'slot' => 'required|numeric|min:0|not_in:0',
                        'section_name' => 'required|string|unique:blocks,section_name,'.$request->block_id.',id',
                        'block_cost' => 'required|numeric',
                        'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|unique:blocks,image,'.$request->block_id.',id',
                    ]);
                }
                if($request->image == null)
                {
                    $validation = Validator::make($request->all(), [
                        'slot' => 'required|numeric|min:0|not_in:0',
                        'section_name' => 'required|string|unique:blocks,section_name,'.$request->block_id.',id',
                        'block_cost' => 'required|numeric',
                    ]);
                }

                if($validation->fails())
                {
                    $status = 2;
                    $message = $validation->messages();
                }
                else
                {
                    $block = Block::find($request->block_id);
                    if($request->image == null)
                    {
                        $block->slot = $request->slot;
                        $block->section_name = strtoupper($request->section_name);
                        $block->block_cost = $request->block_cost;
                        $block->validity = $request->validity;
                    }
                    else
                    {
                        //Delete Previous Image to reduce memory allocation
                        File::delete(public_path("upload_images/".$block->image));

                        $image = $request->file('image');
                        $new_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('upload_images'), $new_name);

                        $block->slot = $request->slot;
                        $block->section_name = strtoupper($request->section_name);
                        $block->block_cost = $request->block_cost;
                        $block->validity = $request->validity;
                        $block->image = $new_name;

                    }
                    $block->update();
                    $status = 1;
                    $message = "Space area has been successfully updated.";
                }
            }
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $block = Block::find($id);
        $block->delete();
        return response()->json([
            'message' => "Space area has been successfully removed.",
        ]);
    }
}
