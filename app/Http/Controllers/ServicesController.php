<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Deceased;
use Illuminate\Http\JsonResponse;
class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return view('services');
    }
    public function get_allRecords()
    {
        $data = Services::all();
        echo json_encode($data);
    }
    public function get()
    {
        return Services::all();
    }
    public function alldata_bydatatable()
    {
        $data = $this->get();

        return datatables()->of($data)
                        ->addColumn('service_name', function($d){
                            $html = $d->service_name;
                            return $html;
                        })
                        ->addColumn('action', function($row){
                            $html = "";
                            if($row->service_name == "BURIAL")
                            {
                                $html .= '<button data-id = '.$row->id.'  type="button" class="btn btn-success btn-sm btn-flat disabled">';
                                $html .= '<i class = "fa fa-edit disabled"></i>';
                                $html .= '</button>';
                            }
                            else
                            {
                                $html .= '<button data-id = '.$row->id.' id = "btn_edit" type="button" class="btn btn-success btn-sm btn-flat">';
                                $html .= '<i class = "fa fa-edit"></i>';
                                $html .= '</button>';
                            }
                            return $html;
                        })
                        ->rawColumns(['service_name', 'action'])
                        ->make(true);


    }
    public function classified($deceased_id)
    {
        $services = Services::all();
        $data = [];
        foreach($services as $service)
        {
            $check_deceased = Deceased::where([
                'service_id'=> $service->id,
                'id' => $deceased_id,
            ])->first();

            if($check_deceased !== null)
            {
                $data[] = [
                    'id' => $service->id,
                    'service_name' => $service->service_name,
                    'status' => 1,
                ];
            }
            else
            {
                $data[] = [
                    'id' => $service->id,
                    'service_name' => $service->service_name,
                    'status' => 0,
                ];
            }
        }
        echo json_encode($data);
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
        $validate = Validator::make($request->all(), [
            'service_name' => 'required|min:5|unique:services,service_name',
        ]);

        $status = 0;
        $messages = "";
        if($validate->fails())
        {
            $status = 2;
            $messages = $validate->messages();
        }
        else
        {
            $service = new Services;
            $service->service_name = strtoupper($request->service_name);
            $service->save();

            $status = 1;
            $messages = "Service has been successfully added!";
        }
        echo json_encode(['status'=>$status, 'message'=>$messages]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = services::find($id);
        echo json_encode($service);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, services $services)
    {
        $validate = Validator::make($request->all(), [
            'service_name' => 'required|min:5|unique:services,service_name,'.$request->service_id.',id',
        ]);

        $status = 0;
        $messages = "";
        if($validate->fails())
        {
            $status = 2;
            $messages = $validate->messages();
        }
        else
        {
            $service = Services::find($request->service_id);
            $service->service_name = strtoupper($request->service_name);
            $service->update();

            $status = 1;
            $messages = "Service has been successfully updated!";
        }
        echo json_encode(['status'=>$status, 'message'=>$messages]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Services::find($id);
        $service->delete();
        echo json_encode([
            'status' => 1,
            'message' => 'Data has been successfully deleted'
        ]);
    }
}
