<?php

namespace App\Http\Controllers\Api;

use App\Models\Club;

use Illuminate\Http\Request;

use App\Http\Requests\clubRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClubRessource;
// use Illuminate\Support\Facades\Validator;
use Validator;


class ClubController extends Controller
{

  /*************************************************************************/
  /**** Méthode GET - Afficher la liste des clubs *****/
  /*************************************************************************/
  public function index()
  {
    $clubs = DB::table('clubs')
      // ->select('clubs.name', 'clubs.id')
      ->get()
      ->toArray();

    /* Si Jointure avec table catégorie
          $clubs = DB::table('clubs')
                    ->join('categories', 'clubs.category_id', '=', 'categories.id')
                    ->select('clubs.*', 'categories.name')
                    ->get()
                    ->toArray();
          
          */

    return response()->json([
      'status' => 'Success',
      'data' => $clubs,
    ]);
  }

  /*************************************************************************/
  /**** Méthode POST *****/
  /*************************************************************************/

  // Méthode 3 - POST Ajouter un club
  public function store(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'name_club' => 'required',
      'logo_club' => 'required',
      'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    $filename = "";
    if ($request->hasFile('logo_club')) {

      // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "soccer.jpg"
      $filenameWithExt = $request->file('logo_club')->getClientOriginalName();
      $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);

      //  On récupère l'extension du fichier, résultat $extension : ".jpg"
      $extension = $request->file('logo_club')->getClientOriginalExtension();

      // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore : "soccer_20220422.jpg"
      $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;

      // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
      $path = $request->file('logo_club')->storeAs('public/uploads', $filename);
    } else {
      $filename = Null;
    }

    $club = Club::create([
      'name_club' => $request->name_club,
      'logo_club' => $filename,
    ]);

    return response()->json([
      'status' => 'Success',
      'data' => $club,
    ]);
  }

  /*************************************************************************/
  /**** Méthode GET - Afficher la fiche d'club*****/
  /*************************************************************************/

  public function show(Club $club)
  {
    try {
      $club =  Club::whereId($club->id)->firstOrFail();
      return response(['status' => 'ok', 'data' => $club], 200);
    } catch (e) {
      return response(['status' => 'error', 'message' => 'Pas de données'], 500);
    }
  }

  /*************************************************************************/
    /**** Méthode PUT - Mettre à jour une fiche club *****/
    /*************************************************************************/
   
    public function update(Request $request,Club $club)
    {
      $input = $request->all();
   
      $validator = Validator::make($input, [
          'name' => 'required',
      ]);

      // if($validator->fails()){
      //     return $this->sendError('Validation Error.', $validator->errors());       
      // }

      $club->name_club = $input['name_club'];
      $club->save();

      return response()->json([
        'status' => 'Mise à jour effectuée']);
    }

    /*************************************************************************/
    /**** Méthode DELETE - Supprimer une fiche club *****/
    /*************************************************************************/
    // Méthode 1
    public function destroy(Club $club)
    {
        $club->delete();
        return response()->json([
          'status' => 'Le club a bien été supprimé']);
    }
}
