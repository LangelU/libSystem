<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'first_name',
        'second_name',
        'first_lastname',
        'second_lastname',
        'city_birth',
        'country_birth',
        'date_birth',
        'death_birth',
        'biography',
    ];

    /* Relationships Config */
    public function getBook(){
        return $this->hasMany(Book::class, 'author_id');
    }

    public function getAcknowledgments(){
        return $this->hasMany(Acknowledgments::class, 'author_id');
    }
    /* End Relationships config */

    /* Scopes Config */
    public function scopeWhereFirstName($query, $value){
        if (!is_null($value)) {
            $query->where('first_name', 'like', '%'. $value .'%');
        }
    }

    public function scopeWhereSecondName($query, $value){
        if (!is_null($value)) {
            $query->where('second_name', 'like', '%'. $value .'%');
        }
    }

    public function scopeWhereFirstLastName($query, $value){
        if (!is_null($value)) {
            $query->where('first_lastname', 'like', '%'. $value .'%');
        }
    }

    public function scopeWhereSecondLastName($query, $value){
        if (!is_null($value)) {
            $query->where('second_lastname', 'like', '%'. $value .'%');
        }
    }
    /* End Scopes config */

    public function validateAuthor($request, $action = null, $id = null)
    {
        return Validator::make(
            $request->all(),
            [   'first_name' => 'required',
                'second_name' => 'nullable',
                'first_lastname' => 'required',
                'second_lastname' => 'nullable',
                'city_birth' => 'required',
                'country_birth' => 'required',
                'date_birth' => 'required',
                'death_birth' => 'required',
                'biography' => 'required',
            ]
        );
    }

    public function validateNotRepeated($request){
        $validate = Author::where('first_name', $request->first_name)
                            ->where('second_name', $request->second_name)
                            ->where('first_lastname', $request->first_lastname)
                            ->where('second_lastname', $request->second_lastname)
                            ->get();
        return ($validate);
    }
    
    public function getAuthors (){
        try {
            $authors = Author::all();
            if ($authors->isEmpty()) {
                return response()->json(['status'=>'error', 'message'=>
                'No se encontraron autores'], 404);
            } else {
                return response()->json(['status'=>'success', 'message'=>
                'Autores encontrados', 'response'=>$authors], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>'error', 'message'=>
            'Error al obtener autores'], 500);
        }
    }
    

    public function createAuthor($request){
        $validate = $this->validateNotRepeated($request);
        if ($validate->isEmpty()) {
            try {
                $author = Author::create([
                    'first_name' => $request->first_name,
                    'second_name' => $request->second_name,
                    'first_lastname' => $request->first_lastname,
                    'second_lastname' => $request->second_lastname,
                    'city_birth' => $request->city_birth,
                    'country_birth' => $request->country_birth,
                    'date_birth' => $request->date_birth,
                    'death_birth' => $request->death_birth,
                    'biography' => $request->biography,
                ]);
                
                return response()->json(['status'=>'success', 'message'=>
                'Autor creado exitosamente', 'response'=>$author], 200);
            } catch (\Throwable $th) {
                return response()->json(['status'=>'error', 'message'=>
                'Error al crear autor'], 500);
            }
    
        return ($request);

        } else {
            return response()->json(['status'=>'error', 'message'=>
            'Ya existe el autor'], 500);
        } 
    }

    public function updateAuthor($request, $id){
        $author = $this::find($id);
        if (is_null($author)) {
            return response()->json(['status'=>'error', 'message'=>
            'Autor no encontrado'], 404);
        } else {
            try {
                $author->update([
                    'first_name' => $request->first_name,
                    'second_name' => $request->second_name,
                    'first_lastname' => $request->first_lastname,
                    'second_lastname' => $request->second_lastname,
                    'city_birth' => $request->city_birth,
                    'country_birth' => $request->country_birth,
                    'date_birth' => $request->date_birth,
                    'death_birth' => $request->death_birth,
                    'biography' => $request->biography,
                ]);
                
                return response()->json(['status'=>'success', 'message'=>
                'Autor actualizado exitosamente'], 200);
            } catch (\Throwable $th) {
                return response()->json(['status'=>'error', 'message'=>
                'Error al actualizar autor'], 500);
            }
        }
    }

    public function authorDetails($id){
        try {
            $authorDetails = $this::find($id);
            if (is_null($authorDetails)) {
                return response()->json(['status'=>'error', 'message'=>
                'No se encontró al autor'], 404);
            } else {
                return response()->json(['status'=>'success', 'message'=>
                'Autor encontrado', 'response'=>$authorDetails], 200);
            }        
        } catch (\Throwable $th) {
            return response()->json(['status'=>'error', 'message'=>
            'Ocurrió un error'], 500);
        }
    }

    public function deleteAuthor($id){
        try {
            $author = $this::find($id);
            if (is_null($author)) {
                return response()->json(['status'=>'error', 'message'=>
                'No se encontró al autor'], 404);
            } else {
                $author->delete();
                return response()->json(['status'=>'success', 'message'=>
                'Autor borrado exitosamente'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>'error', 'message'=>
            'Ocurrió un error'], 500);
        }
    }
}
