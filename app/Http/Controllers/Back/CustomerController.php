<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(){
      $customers=Customer::orderBy('created_at','desc')->get();
      return view('back.customer',compact('customers'));
    }

    public function insert(Request $request){
      $customers = new Customer;
      $customers->name = $request->name;
      $customers->comment = ' ';
      $customers->save();
      toastr()->success('Customer name added successfully.');
      return redirect()->route('admin.customer');
    }

    public function update(Request $request){
      $id=$request->hiddenId;
      $customers = Customer::findOrFail($id);
      $customers->comment = $request->comment;
      $customers->save();
      toastr()->success('Comment successfully added.');
      return redirect()->route('admin.customer');
    }

    public function delete(Request $request){
      $id=$request->hideInput;
      Customer::find($id)->delete();
      toastr()->success('Customer successfully deleted.');
      return redirect()->route('admin.customer');
    }

    public function nameupdate(Request $request){
      $id=$request->hideNameInput;
      $customers = Customer::findOrFail($id);
      $customers->name = $request->name;
      $customers->save();
      toastr()->success('Customer name has been successfully updated.');
      return redirect()->route('admin.customer');
    }
}
