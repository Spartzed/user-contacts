<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('cpf')) {
            $query->where('cpf', $request->cpf);
        }

        $contacts = $query->get();

        return view('contacts.index', compact('contacts'));
    }
}
