<?php

namespace App\Http\Controllers\Api;

use App\Models\Discipline;

use Illuminate\Http\Request;

use App\Http\Requests\disciplineRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DisciplineRessource;
// use Illuminate\Support\Facades\Validator;
use Validator;


class DisciplineController extends Controller
{

  /*************************************************************************/
  /**** Méthode GET - Afficher la liste des disciplines *****/
  /*************************************************************************/
  public function index()
  {
    $disciplines = DB::table('disciplines')
      // ->select('disciplines.name', 'disciplines.id')
      ->get()
      ->toArray();

    /* Si Jointure avec table catégorie
          $disciplines = DB::table('disciplines')
                    ->join('categories', 'disciplines.category_id', '=', 'categories.id')
                    ->select('disciplines.*', 'categories.name')
                    ->get()
                    ->toArray();
          
          */

    return response()->json([
      'status' => 'Success',
      'data' => $disciplines,
    ]);
  }

  /*************************************************************************/
  /**** Méthode POST *****/
  /*************************************************************************/

  // Méthode 3 - POST Ajouter un discipline
  public function store(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'name_discipline' => 'required',
      'image_discipline' => 'required',
      'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    $filename = "";
    if ($request->hasFile('image_discipline')) {

      // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "soccer.jpg"
      $filenameWithExt = $request->file('image_discipline')->getClientOriginalName();
      $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);

      //  On récupère l'extension du fichier, résultat $extension : ".jpg"
      $extension = $request->file('image_discipline')->getClientOriginalExtension();

      // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore : "soccer_20220422.jpg"
      $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;

      // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
      $path = $request->file('image_discipline')->storeAs('public/uploads', $filename);
    } else {
      $filename = Null;
    }

    $discipline = Discipline::create([
      'name_discipline' => $request->name_discipline,
      'image_discipline' => $filename,
    ]);

    return response()->json([
      'status' => 'Success',
      'data' => $discipline,
    ]);
  }

  /*************************************************************************/
  /**** Méthode GET - Afficher la fiche d'discipline*****/
  /*************************************************************************/

  public function show(Discipline $discipline)
  {
    try {
      $discipline =  Discipline::whereId($discipline->id)->firstOrFail();
      return response(['status' => 'ok', 'data' => $discipline], 200);
    } catch (e) {
      return response(['status' => 'error', 'message' => 'Pas de données'], 500);
    }
  }

  /*************************************************************************/
    /**** Méthode PUT - Mettre à jour une fiche discipline *****/
    /*************************************************************************/
   
    public function update(Request $request,Discipline $discipline)
    {
      $input = $request->all();
   
      $validator = Validator::make($input, [
          'name' => 'required',
      ]);

      // if($validator->fails()){
      //     return $this->sendError('Validation Error.', $validator->errors());       
      // }

      $discipline->name_discipline = $input['name_discipline'];
      $discipline->save();

      return response()->json([
        'status' => 'Mise à jour effectuée']);
    }

    /*************************************************************************/
    /**** Méthode DELETE - Supprimer une fiche discipline *****/
    /*************************************************************************/
    // Méthode 1
    public function destroy(Discipline $discipline)
    {
        $discipline->delete();
        return response()->json([
          'status' => 'La discipline a bien été supprimé']);
    }
}
