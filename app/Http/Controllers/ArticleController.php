<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     return Article::All();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
          
        ]);
    
        try {
            DB::beginTransaction();
    
            $article = Article::create($request->all());
    
            DB::commit();
    
            return response()->json(['message' => 'Article créé avec succès', 'article' => $article], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Une erreur est survenue lors de la création de l\'article'], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article=Article::find($id);
        if(!$article){
            return response()->json(['message'=>'article non trouver'],404);
        }
        return $article;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            
        ]);
    
        
        $article = Article::findOrFail($id);
        
       $article->update($request->all());
   
        return response()->json($article, 200);
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article=Article::find($id);
        if(!$article){
            return response()->json(['message'=>'article non trouver'],404);
        } 
        $article->delete();
        return response()->json(['message'=>'supprimer avec succé']);
    }
}
