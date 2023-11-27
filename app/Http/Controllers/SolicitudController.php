<?php

namespace App\Http\Controllers;

use App\Models\Solicitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function addSoli(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No access baby'], 401);
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'ruta_archivo' => 'required|mimes:jpeg,png,pdf,doc,docx|max:2048',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $fileRoute = $request->file('ruta_archivo')->store('public/filedata');

        $solicutud = Solicitude::create([
            'ruta_archivo' => $fileRoute,
            'nue' => $user->id
        ]);
        return response()->json(['solicitud' => $solicutud], 201);
    }


    public function getAllSolisByUser()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No access'], 401);
        }

        $user = Auth::user();


        //It gets all tasks from the user who logged in 
        $solicitudes = Solicitude::where('nue', $user->id)->get();

        if (!$solicitudes) {
            return response()->json(['error' => 'No solicitudes'], 404);
        }

        return response()->json(['solicitudes' => $solicitudes], 200);
    }


    public function deleteSoliById($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No access'], 401);
        }

        $user = Auth::user();

        $solicitud = Solicitude::find($id);

        if (!$solicitud) {
            return response()->json(['error' => 'Solicitud not found in DB'], 404);
        }

        if ($solicitud->nue !== $user->id) {
            return response()->json(['error' => 'Unauthorized! This solicitud does not belong you.'], 403);
        }
        Storage::delete($solicitud->ruta_archivo);
        $solicitud->delete();

        return response()->json(['message' => 'Solicitud deleted successfully...'], 200);
    }



    public function getSolis()
    {
        $solicitudes = Solicitude::with('user')->get();

        foreach ($solicitudes as $soli) {
            $soli->ruta_archivo = asset(Storage::url($soli->ruta_archivo));
        }
        return response()->json($solicitudes, 200);
    }


    public function getSolisByFecha(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Solicitude::with('user');

        $query->whereBetween('created_at', [$startDate, $endDate]);

        $solicitudes = $query->get();

        foreach ($solicitudes as $soli) {
            $soli->ruta_archivo = asset(Storage::url($soli->ruta_archivo));
        }

        return response()->json($solicitudes, 200);
    }



    public function downloadFile($id)
    {
        $solicitud = Solicitude::find($id);

        if (!$solicitud) {
            return response()->json(['error' => 'Solicitud not found'], 404);
        }

        $rutaArchivo = storage_path('app/' . $solicitud->ruta_archivo);

        if (!file_exists($rutaArchivo)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->download($rutaArchivo);
    }
}
