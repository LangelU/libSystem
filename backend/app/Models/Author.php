<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\ResponseAction;

class Author extends Model
{
    use HasFactory;
    use ResponseAction;

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
                
                return $this->response('success', 'Author created successfully', null, 200);
            } catch (\Throwable $th) {
                return $this->response('error', 'An error ocurred', null, 500);
            }
        } else {
            return $this->response('error', 'The author already exists', null, 501);
        } 
    }

    public function getAuthors (){
        try {
            $authors = Author::all();
            if ($authors->isEmpty()) {
                return $this->response('error', 'Authors not found', null, 404);
            } else {
                return $this->response('success', 'Authors found', $authors, 200);
            }
        } catch (\Throwable $th) {
            return $this->response('error', 'An error ocurred', null, 500);
        }
    }

    public function authorDetails($id){
        try {
            $authorDetails = $this::find($id);
            if (is_null($authorDetails)) {
                return $this->response('error', 'Author not found', null, 404);
            } else {
                return $this->response('success', 'Author found', $authorDetails, 200);
            }        
        } catch (\Throwable $th) {
            return $this->response('error', 'An error ocurred', null, 500);
        }
    }
    
    public function updateAuthor($request, $id){
        $author = $this::find($id);
        if (is_null($author)) {
            return $this->response('error', 'Author not found', null, 404);
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
                
                return $this->response('success', 'Author updated successfully', null, 200);
            } catch (\Throwable $th) {
                return $this->response('error', 'An error ocurred', null, 500);
            }
        }
    }

    public function deleteAuthor($id){
        try {
            $author = $this::find($id);
            if (is_null($author)) {
                return $this->response('error', 'Author not found', null, 404);
            } else {
                $author->delete();
                return $this->response('success', 'Author deleted successfully', null, 200);
            }
        } catch (\Throwable $th) {
            return $this->response('error', 'An error ocurred', null, 500);
        }
    }
}
