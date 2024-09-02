<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Http;
class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $contacts = Contact::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('cpf', 'like', "%{$search}%");
            })
            ->get();
    
        return view('contacts.index', ['contacts' => $contacts]);
    }    

    public function buscarEndereco(Request $request)
    {
        $uf = $request->query('uf');
        $cidade = $request->query('cidade');
        $logradouro = $request->query('logradouro');

        $response = Http::get("https://viacep.com.br/ws/{$uf}/{$cidade}/{$logradouro}/json/");
        return response()->json($response->json());
    }

    public function buscarEnderecoPorCep(Request $request)
    {
        $cep = $request->query('cep');
        $cep = preg_replace('/\D/', '', $request->cep);

        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        return response()->json($response->json());
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'cpf' => 'required|cpf|string|unique:contacts,cpf',
            'phone' => 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'cep' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'uf' => 'required|string',
            'complemento' => 'nullable|string',
        ]);

        $cpf = preg_replace('/\D/', '', $request->cpf);
        $cep = preg_replace('/\D/', '', $request->cep);
        
        $address = "{$request->logradouro}, {$request->numero}, {$request->bairro}, {$request->cidade} - {$request->uf}, {$cep}";
        $googleMapsApiKey = env('GOOGLE_MAPS_API_KEY');
        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
            'address' => $address,
            'key' => $googleMapsApiKey,
        ]);
        
        if ($response->failed()) {
            return redirect()->back()->withErrors(['address' => 'Não foi possível obter a localização.'])->withInput();
        }
        
        $location = $response->json()['results'][0]['geometry']['location'];

        try {
            Contact::create([
                'name' => $request->name,
                'cpf' => $cpf,
                'phone' => $request->phone,
                'logradouro' => $request->logradouro,
                'numero' => $request->numero,
                'cep' => $cep,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'uf' => $request->uf,
                'complemento' => $request->complemento,
                'latitude' => $location['lat'],
                'longitude' => $location['lng'],
            ]);
    
            return redirect()->route('contacts.index')->with('success', 'Contato cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'cpf' => 'required|cpf|unique:contacts,cpf,' . $id,
            'phone' => 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'cep' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'uf' => 'required|string',
            'complemento' => 'nullable|string',
        ]);

        $contact = Contact::findOrFail($id);

        $cpf = preg_replace('/\D/', '', $request->cpf);
        $cep = preg_replace('/\D/', '', $request->cep);

        $address = "{$request->logradouro}, {$request->street_number}, {$request->bairro}, {$request->cidade} - {$request->uf}, {$cep}";
        $googleMapsApiKey = env('GOOGLE_MAPS_API_KEY');
        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
            'address' => $address,
            'key' => $googleMapsApiKey,
        ]);

        if ($response->failed()) {
            return redirect()->back()->withErrors(['address' => 'Não foi possível obter a localização.'])->withInput();
        }

        $location = $response->json()['results'][0]['geometry']['location'];

        $contact->update([
            'name' => $request->name,
            'cpf' => $cpf,
            'phone' => $request->phone,
            'address' => $request->logradouro,
            'street_number' => $request->street_number,
            'cep' => $cep,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'uf' => $request->uf,
            'complement' => $request->complement,
            'latitude' => $location['lat'],
            'longitude' => $location['lng'],
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contato excluído com sucesso!');
    }
}
