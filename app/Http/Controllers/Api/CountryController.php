<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CountryStoreRequest;
use App\Http\Requests\Api\CountryUpdateRequest;
use App\Http\Resources\Api\CountryCollection;
use App\Http\Resources\Api\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"country.index"},
     *     summary="Retorna a lista de países",
     *     description="Retorna a lista de países",
     *     path="/api/country",
     *     @OA\Response(response="200", description="Lista de países"),
     * )
     * 
    */
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Api\CountryCollection
     */
    public function index(Request $request)
    {
        $countries = Country::all();

        return new CountryCollection($countries);
    }


    /**
     * @OA\Post(
     *     path="/api/country",
     *     tags={"country.store"},
     *     operationId="store",
     *     summary="Adiciona um país",
     *     description="Adiciona um país ao banco, é necessário informar o nome do país",
     *     @OA\RequestBody(
     *         description="Parâmetros para adicionar o país",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     description="Adiciona o país",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", 
     *         description="Retorna o json com o país adicionado"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Requisição inválida",
     *     )
     * )
     */
    /**
     * @param \App\Http\Requests\Api\CountryStoreRequest $request
     * @return \App\Http\Resources\Api\CountryResource
     */
    public function store(CountryStoreRequest $request)
    {
        $country = Country::create($request->validated());

        return new CountryResource($country);
    }

    /**
     * @OA\Get(
     *     path="/api/country/{country}",
     *     summary="Mostra um país pelo id",
     *     description="Retorna um país pelo id",
     *     operationId="show",
     *     tags={"country.show"},
     *     @OA\Parameter(
     *         description="Id do país",
     *         in="path",
     *         name="country",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="ID inválido fornecido"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="País não encontrado"
     *     )
     * )
     */
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Country $country
     * @return \App\Http\Resources\Api\CountryResource
     */
    public function show(Request $request, Country $country)
    {
        return new CountryResource($country);
    }


    /**
     * @OA\Put(
     *     path="/api/country/{country}",
     *     tags={"country.update"},
     *     operationId="update",
     *     @OA\Parameter(
     *         description="Id do país",
     *         in="path",
     *         name="country",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Parâmetros para atualizar o país",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     description="Atualiza o nome do país",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Parâmetro inválido"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="País não encontrado"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Erro de validação"
     *     )
     * )
     */
    /**
     * @param \App\Http\Requests\Api\CountryUpdateRequest $request
     * @param \App\Models\Country $country
     * @return \App\Http\Resources\Api\CountryResource
     */
    public function update(CountryUpdateRequest $request, Country $country)
    {
        $country->update($request->validated());

        return new CountryResource($country);
    }

    /**
     * @OA\Delete(
     *     path="/api/country/{country}",
     *     tags={"country.destroy"},
     *     summary="Deleta o país pelo id",
     *     description="Recebe o id como integer e deleta o país no banco",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         name="country",
     *         in="path",
     *         required=true,
     *         description="ID do país que será deletado",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             minimum=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Parâmetro inválido"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="País não encontrado"
     *     )
     * ),
     */
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country)
    {
        $country->delete();

        return response()->noContent();
    }
}
