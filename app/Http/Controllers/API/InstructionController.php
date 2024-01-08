<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instruction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Psy\VersionUpdater\Installer;

class InstructionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $userId = Auth::user()->id;

        $validator = Validator::make($input, [
            'recipe_id'=>'required',
            'instruction' => 'required|string'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $instructions = Instruction::create(array_merge($input, ['user_id' => $userId]));

        return $this->sendResponse($instructions, 201, 'Instruction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instructions = Instruction::where('recipe_id', $id)->get();

        if ($instructions->isEmpty()) {
            return $this->sendError('Instructions not found.');
        }

        return $this->sendResponse($instructions, 200, 'Instructions retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instruction $instructions)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'recipe_id' => 'required',
            'instruction' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $instructions->recipe_id = $input['recipe_id'];
        $instructions->instruction = $input['instruction'];

        $instructions->save();

        return $this->sendResponse($instructions, 200, 'Instructions updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instructions = Instruction::find($id);

        $instructions->delete();

        return $this->sendResponse($instructions, 200, 'Instructions deleted successfully.');
    }
}
