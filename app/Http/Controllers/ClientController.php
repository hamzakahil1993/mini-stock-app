<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return View
     */
    public function index(): View
    {
        $clients = Client::visible()->latest()->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientRequest $request
     * @return RedirectResponse
     */
    public function store(ClientRequest $request): RedirectResponse
    {
        Client::create($request->validated());

        return redirect()->route('clients.index')
            ->with('status', __('Client created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @return View
     */
    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientRequest $request
     * @param Client $client
     * @return RedirectResponse
     */
    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()->route('clients.index')
            ->with('status', __('Client updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->update(['status' => Client::STATUS_DELETED]);

        return redirect()->route('clients.index')
            ->with('status', __('Client deleted successfully.'));
    }
}
