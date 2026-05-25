<?php

namespace App\Http\Controllers;

use App\Mail\ticketCreatedMail;
use Illuminate\Http\Request;
use App\Models\ticket;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    //
    public function showTickets(){
        return  view('customer.create');
    }

    public function store(Request $request){

        $validate = $request->validate([
            'subject' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|string',
            'category' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);


        if($request->hasFile('attachment')){
            $validate['attachment'] = $request->file('attachment')
            ->store('attachment','public');
        }

        $hours=match($request->priority){
            'Critical' => 2,
            'High' => 8,
            'Medium' =>  24,
            'Low' => 72,
            default => 72,
        };

        $validate['sla_deadline'] = now()->addHours($hours);

        $validate['customer_id'] = auth()->id();

        
        $validate['status'] = 'open';

        
        $validate['assign_to'] = null;

        $ticket = ticket::create($validate);

        Mail::to(auth()->user()->email)
        ->send(new ticketCreatedMail($ticket));

        return redirect()->route('customer.create')
        ->with('success','ticket is created');
    }

    public function showindex(){
        return  view('customer.index');
    }

    public function index(){
        $data = ticket::all();
        return response()->json($data);
    }

    public function getdata(){

        $userId = auth()->id();

        $data = ticket::where('customer_id',$userId)->get();

        return response()->json($data);
    }

    public function data(){
        return  view('customer.data');
    }

    public function edit($id){

        $data = ticket::findOrFail($id);

        return view('customer.edit',compact('data'));
    }

    public function update(Request $request,$id){

       $request->validate([
            'subject'=>'required|max:255',
            'description'=>'required',
            'priority'=>'required|string',
            'category'=>'required|string',
            'attachment'=>'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = ticket::findOrFail($id);

        $data->subject = $request->subject;
        $data->description = $request->description;
        $data->priority = $request->priority;
        $data->category = $request->category;

        
        if($data->status == 'pending'){
            $data->status = 'in_progress';
        }

        if($request->hasfile('attachment')){

            if($data->attachment &&
            file_exists(storage_path('app/public/'.$data->attachment))){

                unlink(storage_path('app/public/'.$data->attachment));
            }

            $path = $request->file('attachment')
            ->store('attachment','public');

            $data->attachment = $path;
        }

        $data->save();

        return redirect()->route('customer.showindex')
        ->with('success','update data');
    }

    public function delete($id){

        $data = ticket::findOrFail($id);

        if($data->attachment &&
        file_exists(storage_path('app/public/'.$data->attachment))){

            unlink(storage_path('app/public/'.$data->attachment));
        }

        $data->delete();

        return redirect()->route('customer.showindex')
        ->with('success','delete data');
    }
}
