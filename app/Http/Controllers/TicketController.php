<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // ✅ لازم تضيفه هنا

class TicketController extends Controller
{
    //
    use ApiResponses,AuthorizesRequests;
    public function index()
    {
        $tickets = Ticket::with('user')->paginate(10);
        return $this->paginatedResponse($tickets, "Tickets Returned Successfully!");
    }

    public function store(StoreTicketRequest $request)
    {

        if (!$request->user()->tokenCan('tickets.create')) {
            return $this->errorResponse('Forbidden', [], 403);
        }

        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;

        $ticket = Ticket::create($validatedData);
        return $this->ok($ticket, "Ticket Stored Successfully 🚀!", 201);
    }

    public function show($id)
    {
        $ticket = Ticket::with('user')->findOrFail($id);

        $this->authorize('view', $ticket);
        return $this->ok($ticket, "Ticket Retured Successfully!", 200);
    }

    public function update(UpdateTicketRequest $request, $id)
    {
        if (!$request->user()->tokenCan('tickets.update')) {
            return $this->errorResponse('Forbidden', [], 403);
        }

        $ticket = Ticket::findOrFail($id);

        $this->authorize('update', $ticket);

        $validatedData = $request->validated();

        $ticket->update($validatedData);
        return $this->ok($ticket, "Ticket Update Successfully ✅!", 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->user()->tokenCan('tickets.delete')) {
            return $this->errorResponse('Forbidden', [], 403);
        }

        $ticket = Ticket::findOrFail($id);

        $this->authorize('delete', $ticket);

        $ticket->delete();
        return $this->ok([], "Ticket Deleted Successfully 🗑️!", 200);
    }
}
