<?php

namespace App\Http\Controllers;

use App\DTOs\ApiResponseDTO;
use App\Http\Resources\FornecedorResource;
use App\Interfaces\FornecedorServiceInterface;
use Illuminate\Http\Request;

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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
