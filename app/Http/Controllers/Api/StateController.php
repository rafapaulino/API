<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StateStoreRequest;
use App\Http\Requests\Api\StateUpdateRequest;
use App\Http\Resources\Api\StateCollection;
use App\Http\Resources\Api\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"state.index"},
     *     summary="Retorna a lista de estados",
     *     description="Retorna a lista de estados",
     *     path="/api/state",
     *     @OA\Response(response="200", description="Lista de estados"),
     * )
     * 
    */
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Api\StateCollection
     */
    public function index(Request $request)
    {
        $states = State::all();

        return new StateCollection($states);
    }

    
    /**
     * @OA\Post(
     *     path="/api/state",
     *     tags={"state.store"},
     *     operationId="store",
     *     summary="Adiciona um estado",
     *     description="Adiciona um estado ao banco, é necessário informar o nome do estado e o id do país",
     *     @OA\RequestBody(
     *         description="Parâmetros para adicionar o estado",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     description="Nome do estado",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="country_id",
     *                     description="Id do país",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200", 
     *         description="Retorna o json com o estado adicionado"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Requisição inválida",
     *     )
     * )
     */
    /**
     * @param \App\Http\Requests\Api\StateStoreRequest $request
     * @return \App\Http\Resources\Api\StateResource
     */
    public function store(StateStoreRequest $request)
    {
        $state = State::create($request->validated());

        return new StateResource($state);
    }

    /**
     * @OA\Get(
     *     path="/api/state/{state}",
     *     summary="Mostra um estado pelo id",
     *     description="Retorna um estado pelo id",
     *     operationId="show",
     *     tags={"state.show"},
     *     @OA\Parameter(
     *         description="Id do estado",
     *         in="path",
     *         name="state",
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
     *         description="Estado não encontrado"
     *     )
     * )
     *
     **/
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \App\Http\Resources\Api\StateResource
     */
    public function show(Request $request, State $state)
    {
        return new StateResource($state);
    }

    /**
     * @OA\Put(
     *     path="/api/state/{state}",
     *     tags={"state.update"},
     *     operationId="update",
     *     @OA\Parameter(
     *         description="Id do estado",
     *         in="path",
     *         name="state",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Parâmetros para atualizar o estado",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     description="Atualiza o nome do estado",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="country_id",
     *                     description="Atualiza o país ao qual o estado pertence",
     *                     type="integer",
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
     *         description="estado não encontrado"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Erro de validação"
     *     )
     * )
     */
    /**
     * @param \App\Http\Requests\Api\StateUpdateRequest $request
     * @param \App\Models\State $state
     * @return \App\Http\Resources\Api\StateResource
     */
    public function update(StateUpdateRequest $request, State $state)
    {
        $state->update($request->validated());

        return new StateResource($state);
    }

    /**
     * @OA\Delete(
     *     path="/api/state/{state}",
     *     tags={"state.destroy"},
     *     summary="Deleta o estado pelo id",
     *     description="Recebe o id como integer e deleta o estado no banco",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         name="state",
     *         in="path",
     *         required=true,
     *         description="ID do estado que será deletado",
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
     *         description="estado não encontrado"
     *     )
     * )
     */
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, State $state)
    {
        $state->delete();

        return response()->noContent();
    }
}
