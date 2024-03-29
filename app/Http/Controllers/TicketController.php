<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicket;
use App\Http\Requests\UpdateTicket;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    /**
     * Creates a new ticket
     */
    public function createTicket(StoreTicket $request)
    {
        $data = $request->validated();
        
        $ticket = new Ticket();
        $ticket->title = $data['title'];
        $ticket->category_id = $data['category_id'];
        $ticket->description = $data['description'];
        $ticket->status = $data['status'];
        $ticket->user_id = auth()->id();
        $ticket->save();
        return redirect('/home')->with('success', "Your ticket has been submitted! Its ID is {$ticket->id}");
    }

    /**
     * Displays a ticket to be updated
     */
    public function editTicketIndex($id)
    {
        return view('ticket.edit')->with([
            'ticket' =>  Ticket::findOrFail($id),
            'categories' => Category::all()
        ]);
    }

    /**
     * Update a selected ticket in storage.
     */
    public function updateUserTicket(UpdateTicket $request, $id)
    {
        $data = $request->validated();

        $ticket = Ticket::findOrFail($id);
        $ticket->update($data);

        return redirect()->route('home')->with('status', 'Ticket updated successfully.');
    }


    /**
     * Display tickets filtered by category.
     */
    public function ticketsByCategories($categoryId)
    {
        $user = Auth::user();
        $categories = Category::all(); 

        $selectedCategory = null;
        $tickets = [];

        // Check if a category ID is submitted
        $selectedCategory = Category::find($categoryId);
        if($selectedCategory) {
            $tickets = Ticket::where('category_id', $categoryId)
                        ->where('user_id', $user->id)
                        ->get();
        }
        
        return view('ticket.categories', compact('tickets'))
        ->with([
            'categories' =>  Category::all(),
        ])
        ;
    }

    /**
     * Remove a user ticket from storage.
     */
    public function destroyUserTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('home')->with('status', 'Ticket deleted successfully.');
    }
    
    /**
     * Display the form for creating a new ticket.
     *
     * @return \Illuminate\Http\Response
    */
    public function createTicketView()
    {
        $categories = Category::all();
        return view('ticket.create')->with([
            'categories' => $categories
        ]);
    }


}
