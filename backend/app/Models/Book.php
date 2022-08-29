<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Traits\ResponseAction;

class Book extends Model {
    use HasFactory;
    use ResponseAction;

    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $fillable = [
        'editorial',
        'year_publication',
        'number_pages',
        'theme',
        'abstract',
        'category',
        'reference_code',
        'units',
        'available_units',
        'author_id',

    ];

    /* Relationships Config */
    public function getAuthor(){
        return $this->belongsTo(Author::class, 'author_id');
    }
    /* End Relationships config */

    public function validateBook($request){
        $validate = $this::where('reference_code', $request->reference_code);
        return ($validate);
    }

    public function createBook($request) {
        $validate = $this->validateBook($request);
        if ($validate->isEmpty()) {
            try {
                $book = $this::create([
                    'editorial' => $request->editorial,
                    'year_publication' => $request->year_publication,
                    'number_pages' => $request->number_pages,
                    'theme' => $request->theme,
                    'abstract' => $request->abstract,
                    'category' => $request->category,
                    'reference_code' => $request->reference_code,
                    'units' => $request->units,
                    'available_units' => $request->available_units,
                    'author_id' => $request->idAuthor,
                ]);
                
                return $this->response('success', 'Book created successfully', $book, 200);
            } catch (\Throwable $th) {
                return $this->response('error', 'An error ocurred', null, 500);
            }
        } else {
            return $this->response('error', 'The book already exists', null, 500);
        }
    }

    public function getBooks(){ 
        try {
            $books = $this::all();
            if ($books->isEmpty()) {
                return $this->response('error', 'Books not found', null, 404);
            } else {
                return $this->response('success', 'Book found', $books, 200);
            }
        } catch (\Throwable $th) {
            return $this->response('error', 'An error ocurred', null, 500);
        }
    }

    public function bookDetails($id){
        try {
            $bookDetails = $this::find($id);
            if (is_null($bookDetails)) {
                return $this->response('error', 'Book data not found', null, 404);
            } else {
                return $this->response('success', 'Book data found', $bookDetails, 200);
            }
        } catch (\Throwable $th) {
            return $this->response('error', 'An error ocurred', null, 500);
        }
    }

    public function updateBook($request, $id){
        $book = $this::find($id);
        if (is_null($book)) {
            return $this->response('error', 'Book not found', null, 404);
        } else {
            try {
                $book->update([
                    'editorial' => $request->editorial,
                    'year_publication' => $request->year_publication,
                    'number_pages' => $request->number_pages,
                    'theme' => $request->theme,
                    'abstract' => $request->abstract,
                    'category' => $request->category,
                    'reference_code' => $request->reference_code,
                    'units' => $request->units,
                    'available_units' => $request->available_units,
                    'author_id' => $request->idAuthor,
                ]);
                
                return $this->response('success', 'Book updated successfully', null, 200);
            } catch (\Throwable $th) {
                return $this->response('error', 'An error ocurred', null, 500);
            }
        }
    }

    public function deleteBook($id){
        try {
            $book = $this::find($id);
            if (is_null($book)) {
                return $this->response('error', 'Book not found', null, 404);
            } else {
                $book->delete();
                return $this->response('success', 'Book deleted successfully', null, 200);
            }
        } catch (\Throwable $th) {
            return $this->response('error', 'An error ocurred', null, 500);
        }
    }
}
