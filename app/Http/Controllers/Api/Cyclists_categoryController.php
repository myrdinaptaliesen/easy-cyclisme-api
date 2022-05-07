<?php

namespace App\Http\Controllers\Api;

use App\Models\Cyclists_Category;

use Illuminate\Http\Request;

use App\Http\Requests\cyclistsCategoryRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompetitionRessource;
use Validator;


class Cyclists_categoryController extends Controller
{

    /*************************************************************************/
    /**** Méthode GET - Afficher la liste des cyclistsCategorys *****/
    /*************************************************************************/
    public function index()
    {
        $cyclistsCategorys = DB::table('cyclists_categories')
            // ->select('cyclistsCategorys.name', 'cyclistsCategorys.id')
            ->get()
            ->toArray();

        /* Si Jointure avec table catégorie
          $cyclistsCategorys = DB::table('cyclistsCategorys')
                    ->join('categories', 'cyclistsCategorys.category_id', '=', 'categories.id')
                    ->select('cyclistsCategorys.*', 'categories.name')
                    ->get()
                    ->toArray();
          
          */

        return response()->json([
            'status' => 'Success',
            'data' => $cyclistsCategorys,
        ]);
    }

    /*************************************************************************/
    /**** Méthode POST *****/
    /*************************************************************************/

    // Méthode - POST Ajouter un cyclistsCategory
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name_cyclists_category' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $cyclistsCategory = Cyclists_Category::create([
            'name_cyclists_category' => $request->name_cyclists_category,
            
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $cyclistsCategory,
        ]);
    }

    /*************************************************************************/
    /**** Méthode GET - Afficher la fiche d'cyclistsCategory*****/
    /*************************************************************************/

      public function show(Cyclists_Category $cyclistsCategory)
      {
        try {
          $cyclistsCategory =  Cyclists_Category::whereId($cyclistsCategory->id)->firstOrFail();
          return response(['status' => 'ok', 'data' => $cyclistsCategory], 200);
        } catch (e) {
          return response(['status' => 'error', 'message' => 'Pas de données'], 500);
        }
      }

    /*************************************************************************/
    /**** Méthode PUT - Mettre à jour une fiche cyclistsCategory *****/
    /*************************************************************************/

    public function update(Request $request,Cyclists_Category $cyclistsCategory)
    {
      $input = $request->all();

      $validator = Validator::make($input, [
        'name_cyclists_category' => 'required',
      ]);

      if($validator->fails()){
          return $this->sendError('Validation Error.', $validator->errors());       
      }

      $cyclistsCategory->name_cyclists_category = $input['name_cyclists_category'];
      $cyclistsCategory->save();

      return response()->json([
        'status' => 'Mise à jour effectuée']);
    }

    /*************************************************************************/
    /**** Méthode DELETE - Supprimer une fiche cyclistsCategory *****/
    /*************************************************************************/
    // Méthode 1
    public function destroy(Cyclists_Category $cyclistsCategory)
    {
        $cyclistsCategory->delete();
        return response()->json([
          'status' => 'La compétition a bien été supprimé']);
    }
}