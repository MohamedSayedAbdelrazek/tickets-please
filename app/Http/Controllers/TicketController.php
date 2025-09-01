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

        if (!$request->user()->tokenCan('tickets.create')) {
            return $this->errorResponse('Forbidden', [], 403);
        }
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

        if ($ticket->user_id !== $request->user()->id) {
            return $this->errorResponse('You do not own this ticket', [], 403);
        }
        if (!$request->user()->tokenCan('tickets.update')) {
            return $this->errorResponse('Forbidden', [], 403);
        }
        $ticket->update($validatedData);
        return $this->ok($ticket, "Ticket Update Successfully ✅!", 200);
    }

    public function destroy(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->user_id !== $request->user()->id) {
            return $this->errorResponse('You do not own this ticket', [], 403);
        }
        if (!$request->user()->tokenCan('tickets.delete')) {
            return $this->errorResponse('Forbidden', [], 403);
        }

        $ticket->delete();
        return $this->ok([], "Ticket Deleted Successfully 🗑️!", 200);
    }
}
