<?php

namespace App\Http\Controllers;

use App\DTOs\ApiResponseDTO;
use App\Http\Resources\FornecedorResource;
use App\Interfaces\FornecedorServiceInterface;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class FornecedorController extends Controller
{

    /**
     *
     * @var FornecedorServiceInterface
     */
    protected FornecedorServiceInterface $forecedorService;


    public function __construct(FornecedorServiceInterface $forecedorService)
    {
        $this->forecedorService = $forecedorService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return ApiResponseDTO::success(data: FornecedorResource::collection($this->forecedorService->all()))->toJson();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponseDTO::error(400, message: $th->getMessage())->toJson();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $fornecedor = $this->forecedorService->create($request->all());
            return ApiResponseDTO::success(data: FornecedorResource::collection($fornecedor->load(["enderecos", "telefones"])))->toJson();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponseDTO::error(400, message: $th->getMessage())->toJson();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fornecedor $fornecedor)
    {
        try {
            $fornecedor = $this->forecedorService->update($fornecedor->id, $request->all());
            return ApiResponseDTO::success(201, data: new FornecedorResource($fornecedor->load(["enderecos", "telefones"])))->toJson();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponseDTO::error(400, message: $th->getMessage())->toJson();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fornecedor $fornecedor)
    {
        try {
            $this->forecedorService->delete($fornecedor->id);
            return ApiResponseDTO::success()->toJson();
        } catch (\Throwable $th) {
            return ApiResponseDTO::success(400, message: $th->getMessage())->toJson();
        }
    }
}
