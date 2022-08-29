<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller {

    public function __construct(){
        $this->Book = new Book();
    }

    public function index() {
        $response = $this->Book->getBooks();
        return ($response);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $response = $this->Book->createBook($request);
        return ($response);
    }

    public function show($id) {
        $response = $this->Book->bookDetails($id);
        return ($response);
    }

    public function edit(Book $book) {
        //
    }

    public function update(Request $request, $id) {
        $response = $this->Book->updateBook($request, $id);
        return($response);
    }

    public function destroy($id) {
        $response = $this->Book->deleteBook($id);
        return ($response);
    }
}
