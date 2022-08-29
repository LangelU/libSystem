<?php

namespace App\Http\Controllers;

use App\Models\Acknowledgments;
use Illuminate\Http\Request;

class AcknowledgmentsController extends Controller {
    public function __construct(){
        $this->Author = new Acknowledgments();
    }

    public function index() {
        $response = $this->Author->getAcknowledgments();
        return ($response);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $response = $this->Author->createAcknowledgments($request);
        return($response);
    }


    public function edit() {
        //
    }

    public function update(Request $request, $id){
        $response = $this->Author->updateAcknowledgment($request, $id);
        return($response);
    }

    public function destroy($id) {
        $response = $this->Author->deleteAcknowledgment($id);
        return ($response);
    }
}
