<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::all();
        return response()->json($notes, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $note = new Note();
        $request->validate($note->rules(), $note->feedback());

        $note->title = $request->title;
        $note->body = $request->body;
        $note->save();

        return response()->json($note, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $note = Note::find($id);

        if ($note === null) {
            return response()->json([
                'erro' => 'Register not found'
            ], 404);
        }
        return response()->json($note, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $note = Note::find($id);

        if ($note === null) {
            return response()->json([
                'error' => 'Unable to perform the update. The requested resource does not exist'
            ], 404);
        }

        if ($request->method() === 'PATCH') {

            $dinamicRules = [];
            // percorrendo todas as regras definidas no Model
            foreach ($note->rules() as $input => $rule) {
                // coletar apenas as regras aplicáveis aos parâmetros parciais de requisição PATCH
                if (array_key_exists($input, $request->all())) {
                    $dinamicRules[$input] = $rule;
                }
            }
            $request->validate($dinamicRules);

        } else {// PUT
            $request->validate($note->rules(), $note->feedback());
        }

        $note->title = $request->title ?? $note->title;
        $note->body  = $request->body  ?? $note->body;
        $note->save();

        return response()->json($note, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $note = Note::find($id);
        if ($note === null) {
            return response()->json([
                'error' => 'Impossible to perform exclusion. The requested record does not exist'
            ], 404);
        }

        $note->delete();   

        return response()->json([
            'message' => 'Record removed successfully.'
        ], 200);
    }
}
