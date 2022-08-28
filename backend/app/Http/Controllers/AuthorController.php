<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{   
    public function __construct(){
        $this->Author = new Author();
    }

    public function index() {
        $authors = $this->Author->getAuthors();
        return ($authors);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $response = $this->Author->createAuthor($request);
        return($response);
    }

    public function show($id) {
        $response = $this->Author->authorDetails($id);
        return ($response);
    }

    public function edit(Author $author) {
        //
    }

    public function update(Request $request, $id){
        $response = $this->Author->updateAuthor($request, $id);
        return($response);
    }

    public function destroy($id) {
        $response = $this->Author->deleteAuthor($id);
        return ($response);
    }
}
