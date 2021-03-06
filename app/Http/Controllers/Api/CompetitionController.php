<?php

namespace App\Http\Controllers\Api;

use Validator;

use App\Models\Discipline;

use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\competitionRequest;
use App\Http\Resources\CompetitionRessource;
use App\Models\Cyclists_category;


class CompetitionController extends Controller
{

  /*************************************************************************/
  /**** Méthode GET - Afficher la liste des competitions *****/
  /*************************************************************************/
  public function index()
  {
    $competitions = DB::table('competitions')
      ->get()
      ->toArray();


    return response()->json([
      'status' => 'Success',
      'data' => $competitions,
    ]);
  }

  public function search(Request $request)
  {

    $competitions = Competition::filter($request)
      ->join('competition_cyclists_category', 'competitions.id', '=', 'competition_cyclists_category.competition_id')
      ->select('competitions.*', 'competition_cyclists_category.cyclists_category_id')
      ->get()
      ->toArray();

    return response()->json([
      'status' => 'Success',
      'data' => $competitions,
    ]);

    // return Competition::filter($request)->get();
  }

  /*************************************************************************/
  /**** Méthode - Ajouter un competition*****/
  /*************************************************************************/

  public function store(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'name_competition' => 'required|max:100',
      'date_competition' => 'required',
      'address_competition' => 'required|max:100',
      'postal_code_competition' => 'required|max:5',
      'city_competition' => 'required|max:100',
      'lat_competition' => 'required|numeric',
      'lon_competition' => 'required|numeric',
      'organizational_details' => 'max:200',

    ]);



    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 422,
          'validate_err' => $validator->messages()
        ]
      );
    } else {
      $competition = Competition::create([
        'name_competition' => $request->name_competition,
        'date_competition' => $request->date_competition,
        'address_competition' => $request->address_competition,
        'postal_code_competition' => $request->postal_code_competition,
        'city_competition' => $request->city_competition,
        'lat_competition' => $request->lat_competition,
        'lon_competition' => $request->lon_competition,
        'organizational_details' => $request->organizational_details,
        'club_id' => $request->club_id,
        'discipline_id' => $request->discipline_id,

      ]);
      //Comment remplir une table pivot de façon bien dégueulasse

      //Je récupère mes catégories dans le formulaire
      $cyclistsCategories = $request->categories;
      //Je les mets dans un tableau
      $cyclistsCategoriesId = explode(",", $cyclistsCategories);
      //Et le boucle pour les rentrer dans la base de données
      for ($i = 0; $i < count($cyclistsCategoriesId); $i++) {
        $cyclistsCategory = Cyclists_category::find($cyclistsCategoriesId[$i]);
        $competition->cyclistsCategories()->attach($cyclistsCategory);
      }
      return response()->json([
        'status' => 'Success',
        'data' => $competition,
      ]);
    }
  }

  /*************************************************************************/
  /**** Méthode GET - Afficher la fiche d'une competition*****/
  /*************************************************************************/

  public function show(Competition $competition)
  {
    try {
      $competition =  Competition::whereId($competition->id)->firstOrFail();
      return response(['status' => 'ok', 'data' => $competition], 200);
    } catch (e) {
      return response(['status' => 'error', 'message' => 'Pas de données'], 500);
    }
  }

  /*************************************************************************/
  /**** Méthode PUT - Mettre à jour une fiche competition *****/
  /*************************************************************************/

  public function update(Request $request, Competition $competition)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'name_competition' => 'required|max:100',
      'date_competition' => 'required',
      'address_competition' => 'required|max:100',
      'postal_code_competition' => 'required|max:5',
      'city_competition' => 'required|max:100',
      'lat_competition' => 'required|numeric',
      'lon_competition' => 'required|numeric',
      'organizational_details' => 'max:200'
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    } else {

      $competition->name_competition = $input['name_competition'];
      $competition->date_competition = $input['date_competition'];
      $competition->address_competition = $input['address_competition'];
      $competition->postal_code_competition = $input['postal_code_competition'];
      $competition->city_competition = $input['city_competition'];
      $competition->lat_competition = $input['lat_competition'];
      $competition->lon_competition = $input['lon_competition'];
      $competition->organizational_details = $input['organizational_details'];
      $competition->save();

      return response()->json([
        'status' => 'Mise à jour effectuée'
      ]);
    }
  }

  /*************************************************************************/
  /**** Méthode DELETE - Supprimer une fiche competition *****/
  /*************************************************************************/
  
  public function destroy(Competition $competition)
  {
    $competition->delete();
    return response()->json([
      'status' => 'La compétition a bien été supprimée'
    ]);
  }
}
