<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Traits\ResponseAction;
use Illuminate\Support\Facades\Validator;

class Acknowledgments extends Model{
    use HasFactory;
    use ResponseAction;

    protected $table = 'acknowledgments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'year_of_obtaining',
        'name',
        'author_id'
    ];

    /* Relationships Config */
    public function getAuthor(){
        return $this->belongsTo(Author::class, 'author_id');
    }
    /* End Relationships config */

    /* Scopes Config */
    
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
        $validate = Acknowledgments::where('name', $request->name)
                                    ->where('author_id', $request->author_id)
                            ->get();
        return ($validate);
    }
    
    public function createAcknowledgment($request){
        $validate = $this->validateNotRepeated($request);
        if ($validate->isEmpty()) {
            try {
                $acknowledgment = Acknowledgments::create([
                    'name' => $request->name,
                    'year_of_obtaining' => $request->year_of_obtaining,
                    'author_id' => $request->author_id,
                ]);
                
                return $this->response('success', 'Acknowledgment created successfully', null, 200);
            } catch (\Throwable $th) {
                return $this->response('error', 'An error ocurred', null, 500);
            }
        } else {
            return $this->response('error', 'The Acknowledgment already exists', null, 501);
        } 
    }

    public function getAcknowledgments (){
        try {
            $authors = Acknowledgments::all();
            if ($authors->isEmpty()) {
                return $this->response('error', 'Acknowledgments not found', null, 404);
            } else {
                return $this->response('success', 'Acknowledgments found', $authors, 200);
            }
        } catch (\Throwable $th) {
            return $this->response('error', 'An error ocurred', null, 500);
        }
    }

    
    public function updateAcknowledgment($request, $id){
        $acknowledgment = $this::find($id);
        if (is_null($acknowledgment)) {
            return $this->response('error', 'Author not found', null, 404);
        } else {
            try {
                $acknowledgment->update([
                    'name' => $request->name,
                    'year_of_obtaining' => $request->year_of_obtaining,
                    'author_id' => $request->author_id,
                ]);
                
                return $this->response('success', 'Acknowledgment updated successfully', null, 200);
            } catch (\Throwable $th) {
                return $this->response('error', 'An error ocurred', null, 500);
            }
        }
    }

    public function deleteAcknowledgment($id){
        try {
            $acknowledgment = $this::find($id);
            if (is_null($acknowledgment)) {
                return $this->response('error', 'Acknowledgment not found', null, 404);
            } else {
                $acknowledgment->delete();
                return $this->response('success', 'Acknowledgment deleted successfully', null, 200);
            }
        } catch (\Throwable $th) {
            return $this->response('error', 'An error ocurred', null, 500);
        }
    }
}
