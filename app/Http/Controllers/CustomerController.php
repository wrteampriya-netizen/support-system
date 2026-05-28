<?php

namespace App\Http\Controllers;

use App\Jobs\TicktCreatedjob;
use App\Jobs\sendnotificationJob;
use App\Jobs\ActivityLogJob;
use App\Mail\ticketCreatedMail;
use Illuminate\Http\Request;
use App\Models\ticket;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Category;
use App\Models\notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class CustomerController extends Controller
{
    //
    public function showTickets()
    {
        // $categories = Category::all();
        $categories=Cache::remember('all_categories', 300, function () {
            return  Category::all();
            
        });

        return  view('customer.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $validate = $request->validate([
            'subject' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|string',
            'category' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);


        if ($request->hasFile('attachment')) {
            $validate['attachment'] = $request->file('attachment')
                ->store('attachment', 'public');
        }

        $hours = match ($request->priority) {
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
        Cache::forget('admin_dashbored');
        Cache::forget('ticket_report');

        ActivityLogJob::dispatch(
            auth()->id(),
            'Ticket Created',
            null,
            $ticket->subject,
            $ticket->id
        );


        // ActivityLog::create([
        //     'user_id'   => auth()->id(),
        //     'action'    => 'Ticket Created',
        //     'old_value' => null,
        //     'new_value' => $ticket->subject,
        //     'ticket_id' => $ticket->id
        // ]);

        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {

            sendnotificationJob::dispatch(

                $admin->id,
                $ticket->subject,
                $ticket->description,
                $ticket->id
            );
        }
        TicktCreatedjob::dispatch(
            $ticket,
            auth()->user()->email
        );

        return redirect()->route('customer.create')
            ->with('success', 'ticket is created');
    }

    public function showindex()
    {
        return  view('customer.index');
    }

    public function index()
    {
        $data = ticket::all();
        return response()->json($data);
    }

    public function getdata()
    {

        $userId = auth()->id();

        $data = ticket::where('customer_id', $userId)->get();

        return response()->json($data);
    }

    public function data()
    {
        return  view('customer.data');
    }

    public function edit($id)
    {
        $categories = Category::all();

        $data = ticket::findOrFail($id);

        return view('customer.edit', compact('data', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'subject' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|string',
            'category' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = ticket::findOrFail($id);
        $old = $data->subject;

        $data->subject = $request->subject;
        $data->description = $request->description;
        $data->priority = $request->priority;
        $data->category = $request->category;


        if ($data->status == 'pending') {
            $data->status = 'in_progress';
        }

        if ($request->hasfile('attachment')) {

            if (
                $data->attachment &&
                file_exists(storage_path('app/public/' . $data->attachment))
            ) {

                unlink(storage_path('app/public/' . $data->attachment));
            }

            $path = $request->file('attachment')
                ->store('attachment', 'public');

            $data->attachment = $path;
        }

        $data->save();
        Cache::forget('admin_dashbored');
        Cache::forget('ticket_report');

        ActivityLogJob::dispatch(
            auth()->id(),
            'Ticket updated',
            $old,
            $request->update,
            $data->id
        );

        return redirect()->route('customer.showindex')
            ->with('success', 'update data');
    }

    public function delete($id)
    {

        $data = ticket::findOrFail($id);


        ActivityLogJob::dispatch(
            auth()->id(),
            'Ticket deleted',
            $data->subject,
            null,
            $data->id
        );

        if (
            $data->attachment &&
            file_exists(storage_path('app/public/' . $data->attachment))
        ) {

            unlink(storage_path('app/public/' . $data->attachment));
        }

        $data->delete();
          Cache::forget('admin_dashbored');
        Cache::forget('ticket_report');



        return redirect()->route('customer.showindex')
            ->with('success', 'delete data');
    }
}
