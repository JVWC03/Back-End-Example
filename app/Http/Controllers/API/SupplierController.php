<?php 

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;

use Validator;

class SupplierController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $suppliers = Supplier::all();

        return $this->sendResponse(
            SupplierResource::collection($suppliers),
            'Suppliers retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:suppliers,email',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $supplier = Supplier::create($input);

        return $this->sendResponse(new SupplierResource($supplier), 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): JsonResponse
    {
        $supplier = Supplier::find($id);

        if (is_null($supplier)) {
            return $this->sendError('Supplier not found.');
        }

        return $this->sendResponse(new SupplierResource($supplier), 'Supplier retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $supplier->name = $input['name'];
        $supplier->address = $input['address'];
        $supplier->phone = $input['phone'];
        $supplier->email = $input['email'];
        $supplier->save();

        return $this->sendResponse(new SupplierResource($supplier), 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier): JsonResponse
    {
        $supplier->delete();

        return $this->sendResponse([], 'Supplier deleted successfully.');
    }
}