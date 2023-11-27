<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agremiado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function addAgremiado(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'a_paterno' => 'required|string|max:40',
            'a_materno' => 'required|string|max:40',
            'nombre' => 'required|string|max:50',
            'genero' => 'required',
            'nup' => 'required|string|max:10',
            'nue' => 'required|unique:agremiados,nue', // Verificar unicidad en la tabla 'agremiados'
            'rfc' => 'required|string|max:13|unique:agremiados,rfc',
            'nss' => 'required|string|max:11|unique:agremiados,nss',
            'f_nacimiento' => 'required|date|before:now -18 years',
            'telefono' => 'required|max:10|unique:agremiados,telefono',
            'cuota' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('id', $request->nue)->first(); //Checo si hay un id para el registro
        $agremiado = Agremiado::create(array_merge(
            $validator->validate(),
            ['id' => $user->id] //Lo agrego a la validacion
        ));
        return response()->json([
            'message' => '¡Agremiado created successfully!',
            'user' => $agremiado
        ], 201);
    }


    public function editAgremiado(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'a_paterno' => 'required|string|max:40',
            'a_materno' => 'required|string|max:40',
            'nombre' => 'required|string|max:50',
            'genero' => 'required',
            'nup' => 'required|string|max:10',
            'rfc' => 'required|string|max:13',
            'nss' => 'required|string|max:11',
            'f_nacimiento' => 'required|date|before:now -18 years',
            'telefono' => 'required|max:10',
            'cuota' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $agremiado = Agremiado::find($id);

        if (!$agremiado) {
            return response()->json(['message' => 'Agremiado no encontrado'], 404);
        }

        $agremiado->update($validator->validate());

        return response()->json([
            'message' => '¡Agremiado updated successfully!',
            'agremiado' => $agremiado
        ], 200);
    }



    public function getAgremiados()
    {
        $agremiados = Agremiado::with(['cuota', 'genero', 'user']) // Carga la relación "cuota"
            ->get();

        return response()->json([
            'agremiados' => $agremiados
        ], 200);
    }


    public function deleteAgremiado($id)
    {
        $agremiado = Agremiado::find($id);
        if (!$agremiado) {
            return response()->json(['message' => 'Agr no encontrado'], 404);
        }
        $agremiado->delete();
        return response()->json(['message' => '¡Agr eliminado con éxito!'], 200);
    }

    public function getAgremiadoById($id)
    {
        $ag = Agremiado::find($id);

        if (!$ag) {
            return response()->json(['message' => 'Agremiado no encontrado'], 404);
        }

        return response()->json($ag, 200);
    }
}
