<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    //
    use ApiResponses;
    public function index()
    {
        $tickets = Ticket::with('user')->paginate(10);
        return $this->paginatedResponse($tickets, "Tickets Returned Successfully!");
    }

    public function store(StoreTicketRequest $request)
    {

        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;

        $ticket = Ticket::create($validatedData);
        return $this->ok($ticket, "Ticket Stored Successfully 🚀!", 201);
    }

    public function show($id)
    {
        $ticket = Ticket::with('user')->findOrFail($id);
        return $this->ok($ticket, "Ticket Retured Successfully!", 200);
    }

    public function update(UpdateTicketRequest $request, $id)
    {
        $validatedData = $request->validated();
        $ticket = Ticket::findOrFail($id);
        $ticket->update($validatedData);
        return $this->ok($ticket, "Ticket Update Successfully ✅!", 200);
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return $this->ok([], "Ticket Deleted Successfully 🗑️!", 200);
    }
}
