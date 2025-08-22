<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $contacts = Auth::user()->contacts()->paginate();

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Obtener tutor_id desde query string
        $tutorId = $request->get('tutor_id');

        // Buscar usuario y verificar que tenga rol "tutor"
        $tutor = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->find($tutorId);

        // Si no existe o no es tutor, lanzar 404
        if (!$tutor) {
            // Redirigir con mensaje de alerta
            return redirect()->route('tutors.index') // o la ruta que quieras
                ->with('error', 'Tutor no encontrado.');
        }



        // Enviar datos a la vista
        return view('contacts.create', compact('tutor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'tutor_id' => 'required',
            'message' => 'required|string|max:1000'
        ]);

        $tutor = User::findOrFail($request->tutor_id);

        if ($tutor) {

            $tutor_name = $tutor->name;

            if (Contact::where('contact_id', $tutor->id)->where('user_id', Auth::id())->first()) {
                return redirect()->route('chatroom.index');
            } else {
                $contact = Contact::create([
                    'name' => $tutor_name,
                    'user_id' => Auth::id(),
                    'contact_id' => $request->tutor_id
                ]);
            }

            $chat = Auth::user()->chats()->whereHas('users', function ($query) use ($contact) {
                $query->where('user_id', $contact->contact_id);
            })->has('users', 2)->first();
            if (!$chat) {
                $chat = Chat::create();
                $chat->users()->attach([Auth::id(), $contact->contact_id]);
            }
            $chat->messages()->create([
                'body' => $request['message'],
                'user_id' => Auth::id()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
