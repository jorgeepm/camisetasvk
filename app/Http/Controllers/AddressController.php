<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddressController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('profile.addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'street' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
        ]);

        auth()->user()->addresses()->create($request->all());

        return back()->with('success', 'Dirección añadida correctamente');
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();

        return back()->with('success', 'Dirección eliminada');
    }
}
