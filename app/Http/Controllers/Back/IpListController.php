<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Iplist;

class IpListController extends Controller
{
    public function index(){
      $iplists=Iplist::orderBy('created_at','desc')->get();
      return view('back.iplist',compact('iplists'));
    }

    public function insert(Request $request){
      $iplists = new Iplist;
      $iplists->ip = $request->ip;
      $iplists->save();
      toastr()->success('Ip successfully added.');
      return redirect()->route('admin.iplist');
    }

    public function update(Request $request){
      $id=$request->hideInput;
      $iplists = Iplist::findOrFail($id);
      $iplists->ip = $request->ip;
      $iplists->save();
      toastr()->success('Ip has been successfully updated.');
      return redirect()->route('admin.iplist');
    }

    public function delete(Request $request){
      $id=$request->hideInput;
      Iplist::find($id)->delete();
      toastr()->success('Ip successfully deleted.');
      return redirect()->route('admin.iplist');
    }

    public function switch(Request $request){
      $iplists=Iplist::findOrFail($request->id);
      $iplists->status=$request->statu=="true" ? 0 : 1;
      $iplists->save();
    }

}
