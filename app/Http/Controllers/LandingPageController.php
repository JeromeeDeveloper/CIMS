<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Block;
use App\Models\Services;
use App\Models\Deceased;
use App\Models\coffinplot;

class LandingPageController extends Controller
{
    public function index()
    {
        $blocks = DB::select('select * from blocks');
        $services = Services::all();

        $deceaseds = DB::select('select deceaseds.id as deceased_id, deceaseds.*, addresses.*
                            from addresses, deceaseds
                            where addresses.id = deceaseds.address_id
                            and deceaseds.approvalStatus = 1');
        $data = [
            'data' => $deceaseds,
            'blocks' => $blocks
        ];
        return view('landingpage.main', compact('data'));
    }
    public function search(Request $request)
    {
        $data = "";
        if($request->fname !== null)
        {
            $data = DB::select('select deceaseds.*, addresses.*
                    from addresses, deceaseds
                    where addresses.id = deceaseds.address_id
                    and deceaseds.firstname like "'.$request->fname.'%"
                    and deceaseds.lastname like "'.$request->mname.'%"');
        }

        return redirect('/')->with('data', $data);
    }
    public function deceasedinfo(Request $request, $deceased_id)
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

        return redirect('/')->with('info', $data);
    }
}
