<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ClientController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view clients', only: ['index', 'show']),
            new Middleware('permission:create clients', only: ['create', 'store']),
            new Middleware('permission:edit clients', only: ['edit', 'update']),
            new Middleware('permission:delete clients', only: ['destroy']),
        ];
    }

    public function index()
    {
        $clients = Client::orderBy('created_at', 'desc')->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')
                         ->with('success', 'Client created successfully.');
    }

    // public function show($id)
    // {
    //     $client =Client::findOrFail($id);
    //     return view('clients.show', compact('client'));
    // }

    public function edit($id)
    {
        $client =Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email,'.$id,
        ]);

        $client =Client::findOrFail($id);
        $client->update($request->all());

        return redirect()->route('clients.index')
                         ->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        $client =Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')
                         ->with('success', 'Client deleted successfully.');
    }


}
