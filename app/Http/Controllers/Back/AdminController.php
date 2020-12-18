<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Datapanel;
use App\Models\Customer;
use App\Models\User;
use App\Models\Iplist;
use DataTables;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class AdminController extends Controller
{
    public function login(){
      return view('login');
    }

    public function logout(){
      Auth::logout();
      return redirect()->route('admin.login');
    }

    public function loginPost(Request $request){
      if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->route('admin.dashboard');
      } else {
        return redirect()->route('admin.login')->withErrors('Email addres or password not correct!');
      }
    }


    public function index(){
      $chart_options = [
            'chart_title'           => 'Earnings chart',
            'chart_type'            => 'bar',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Datapanel',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'month',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'prix',
            'filter_field'          => 'created_at',
            'filter_days'           => '1825',
            'group_by_field_format' => 'm/d/Y',
            'column_class'          => 'col-md-4',
            'entries_number'        => '12',
        ];
      $chart1 = new LaravelChart($chart_options);
      $totalPrix=Datapanel::where('deleted_at', '=', null)->where('status', '=', 1)->sum('prix');
      $totalName=Customer::count('name');
      return view('back.dashboard', compact('chart1','totalPrix','totalName'));

    }

    public function calculator(){
      return view('back.calculator');
    }

    public function insert(Request $request){
      $customer= new Datapanel;
      $customer->name=$request->name;
      $customer->email=$request->email;
      $customer->ip=$request->ip;
      $customer->prix=$request->prix;
      $customer->created_at=$request->created_at;
      $customer->save();
      return response()->json($customer);
    }

    public function update(Request $request){
      $id=$request->id;
      $customer = Datapanel::findOrFail($id);
      $customer->name=$request->name;
      $customer->email=$request->email;
      $customer->ip=$request->ip;
      $customer->prix=$request->prix;
      $customer->created_at=$request->created_at;
      $customer->save();
      return response()->json($customer);
    }

    public function delete(Request $request){
      Datapanel::find($request->id)->delete();
      $iplists = new Iplist;
      $iplists->ip = $request->ip;
      $iplists->status = 0;
      $iplists->save();
    }

    public function cancelPanel(){
      $cancellists=Datapanel::orderBy('deleted_at','desc')->get();
      return view('back.cancelpanel',compact('cancellists'));
    }

    public function trash(){
        return DataTables::of(Datapanel::onlyTrashed())->addColumn('status', function($data) {
              if($data->status == '1'){
                  return '<h5><span class="badge badge-success">Paid</span></h5>';
              } else {
                return '<h5><span class="badge badge-danger">Unpaid</span></h5>';
              }
          })
          ->addColumn('created_at', function($data) {
                   return '<span>'.($data->created_at)->diffForHumans().'</span>';
                })
          ->addColumn('action', function($data){
          $button = '<button style="margin-top:4px;" type="button" class="btn btn-primary btn-sm recoverBtn" id="'.$data->id.'" name="button"><i class="fas fa-recycle"></i></button>';
          $button .= '&nbsp;&nbsp;';
          $button .= '<button style="margin-top:4px;" type="button" class="btn btn-danger btn-sm destroyBtn" id="'.$data->id.'" name="button">Delete</button>';
          return $button;
        })->rawColumns(['action','status','created_at'])->make(true);
    }

    public function recover(Request $request){
      Datapanel::onlyTrashed()->find($request->id)->restore();
    }

    public function destroy(Request $request){
      Datapanel::onlyTrashed()->find($request->id)->forceDelete();
    }

    public function dataPanel(){
      $datalists=Datapanel::orderBy('created_at','asc')->get();
      $customers=Customer::orderBy('created_at','desc')->get();
      return view('back.datapanel',compact('datalists','customers'));
    }

    public function switch(Request $request){
      $datapanel=Datapanel::findOrFail($request->id);
      $datapanel->status=$request->statu=="true" ? 1 : 0;
      $datapanel->save();
    }

    public function fetch(){
      return DataTables::of(Datapanel::query())->addColumn('created_at', function($data) {
                $timestamp = time()-strtotime($data->created_at);
                $diffMonth = 2592000-$timestamp;
                $passedDay = ceil(substr($diffMonth/86400,0,5));
                $futureDay = ceil(substr($diffMonth/86400,0,5));
                $total = substr($diffMonth/86400,0,2);
                $date = $total*100/30;
                $progress = substr($date,0,4);

                if($total<0){
                  return '<div class="progress" style="height: 30px;margin-top:5px;">
                            <input style="display:none;" class="form-control" type="date" data="'.$data->created_at.'" val="'.$data->created_at.'">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width:100%;" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100">'.$passedDay.' Day Expired</div>
                          </div>
                          ';
                } elseif ($total<15) {
                  return '<div class="progress" style="height: 30px;margin-top:5px;">
                            <input style="display:none;" class="form-control" type="date" data="'.$data->created_at.'" val="'.$data->created_at.'">
                            <div class="progress-bar bg-warning text-dark" role="progressbar" style="width: '.$progress.'%;" aria-valuenow="'.$progress.'"
                            aria-valuemin="0" aria-valuemax="100">'.$total.' Day Left</div>
                          </div>
                          ';
                } elseif ($total>30) {
                  return '<div class="progress" style="height: 30px;margin-top:5px;">
                            <input style="display:none;" class="form-control" type="date" data="'.$data->created_at.'" val="'.$data->created_at.'">
                            <div class="progress-bar bg-purple text-white" role="progressbar" style="width: 100%;" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100">'.$futureDay.' Day Left</div>
                          </div>
                          ';
                } else {
                  return '<div class="progress" style="height: 30px;margin-top:5px;">
                            <input style="display:none;" class="form-control" type="date" data="'.$data->created_at.'" val="'.$data->created_at.'">
                            <div class="progress-bar" role="progressbar" style="width: '.$progress.'%;" aria-valuenow="'.$progress.'"
                            aria-valuemin="0" aria-valuemax="100">'.$total.' Day Left</div>
                          </div>
                          ';
                }

            })
            ->addColumn('status', function($data) {
                if($data->status == '1'){
                    return '<input class="switch" type="checkbox" checked data-toggle="toggle"
                    data-on="Paid" data-off="Unpaid" data="'.$data->id.'" data-onstyle="success" data-offstyle="danger">';
                } else {
                  return '<input class="switch" type="checkbox" data-toggle="toggle"
                  data-on="Paid" data-off="Unpaid" data="'.$data->id.'" data-onstyle="success" data-offstyle="danger">';
                }
            })
        ->addColumn('action', function($data){
        $button = '<button style="margin-top:4px;" type="button" class="btn btn-info btn-sm editBtn" id="'.$data->id.'" name="button">Edit</button>';
        $button .= '&nbsp;&nbsp;';
        $button .= '<button style="margin-top:4px;" type="button" class="btn btn-danger btn-sm deleteBtn" data="'.$data->ip.'" id="'.$data->id.'" name="button">Cancel</button>';
        return $button;
      })->rawColumns(['action','status','created_at'])->make(true);
    }

}
