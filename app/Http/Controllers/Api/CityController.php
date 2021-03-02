<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CityStoreRequest;
use App\Http\Requests\Api\CityUpdateRequest;
use App\Http\Resources\Api\CityCollection;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    /**
     * @OA\Get(
     *     tags={"city.index"},
     *     summary="Retorna a lista de cidades",
     *     description="Retorna a lista de cidades",
     *     path="/api/city",
     *     @OA\Response(response="200", description="Lista de cidades"),
     * )
     * 
    */
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Api\CityCollection
     */
    public function index(Request $request)
    {
        $cities = City::all();

        return new CityCollection($cities);
    }

    /**
     * @OA\Post(
     *     path="/api/city",
     *     tags={"city.store"},
     *     operationId="store",
     *     summary="Adiciona uma cidade ao banco",
     *     description="Adiciona uma cidade ao banco, é necessário informar o nome da cidade e o id do estado",
     *     @OA\Parameter(
     *         name="title",
     *         in="path",
     *         description="Informe o nome da cidade",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             maximum=200,
     *             minimum=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Informe o id do estado",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", 
     *         description="Retorna o json com a cidade adicionada"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Requisição inválida",
     *     )
     * )
     */
    /**
     * @param \App\Http\Requests\Api\CityStoreRequest $request
     * @return \App\Http\Resources\Api\CityResource
     */
    public function store(CityStoreRequest $request)
    {
        $city = City::create($request->validated());

        return new CityResource($city);
    }


    /**
     * @OA\Get(
     *     path="/api/city/{city}",
     *     summary="Mostra uma cidade pelo id",
     *     description="Retorna uma cidade pelo id",
     *     operationId="show",
     *     tags={"city.show"},
     *     @OA\Parameter(
     *         description="Id da cidade",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
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
     *         description="Cidade não encontrada"
     *     )
     * )
     *
     **/
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\City $city
     * @return \App\Http\Resources\Api\CityResource
     */
    public function show(Request $request, City $city)
    {
        return new CityResource($city);
    }

    /**
     * @OA\Put(
     *     path="/api/city",
     *     tags={"city.update"},
     *     operationId="update",
     *     @OA\Parameter(
     *         description="Id da cidade",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Parâmetros para atualizar a cidade",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     description="Atualiza o nome da cidade",
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
     *         description="cidade não encontrada"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Erro de validação"
     *     )
     * )
     */
    /**
     * @param \App\Http\Requests\Api\CityUpdateRequest $request
     * @param \App\Models\City $city
     * @return \App\Http\Resources\Api\CityResource
     */
    public function update(CityUpdateRequest $request, City $city)
    {
        $city->update($request->validated());

        return new CityResource($city);
    }


    /**
     * @OA\Delete(
     *     path="/api/city/{city}",
     *     tags={"city.destroy"},
     *     summary="Deleta a cidade pelo id",
     *     description="Recebe o id como integer e deleta a cidade no banco",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da cidade que será deletada",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Parâmetro inválido"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="cidade não encontrada"
     *     )
     * )
     */
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, City $city)
    {
        $city->delete();

        return response()->noContent();
    }
}
