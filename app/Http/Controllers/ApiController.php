<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Estado;

class ApiController extends Controller
{
    public function getAllClientes() {
        $tableCliente = Cliente::get();
        return response(['data'=>$tableCliente], 200);
    }

    public function createCliente(ClienteRequest $request) {
        try {
            $tableCliente = new Cliente;
            $dataNascimento = explode("/", $request->xdataNascimento);
            if (checkdate($dataNascimento[1], $dataNascimento[0], $dataNascimento[2])) {
                $dataNascimento = new \DateTime($dataNascimento[2].'-'.$dataNascimento[1].'-'.$dataNascimento[0]);
            } 
            $dataCreate = [
                'numeroCPF'=>$request->xnumeroCPF,
                'nomeCliente'=>$request->xnomeCliente,
                'dataNascimento'=>$dataNascimento->format('Y-m-d'),
                'sexoCliente'=>$request->xsexoCliente,
                'estado_id'=>$request->xestado_id,
                'nomeRua'=>$request->xnomeRua,
                'cidade_id'=>$request->xcidade_id,
            ];
            $tableCliente->create($dataCreate);

            return response()->json([
                "message" => "Oba, Cliente foi criado com sucesso!"
            ], 201);

        } catch(\Exception $error) {
            return response()->json([
                "message" => 'Sinto muito, mas o CPF está duplicado!'
            ], 400);
        }
        

        
    }

    public function getCliente($id) {
        if (Cliente::where('id', $id)->exists()) {
            $tableCliente = Cliente::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($tableCliente, 200);
        } else {
            return response()->json(["message" => "Lamento, mas o Cliente não foi encontrado"], 404);
        }
    }

    public function updateCliente(ClienteRequest $request, $id) {
        if (Cliente::where('id', $id)->exists()) {
            $tableCliente = Cliente::find($id);
            $dataNascimento = explode("/", $request->xdataNascimento);
            if (checkdate($dataNascimento[1], $dataNascimento[0], $dataNascimento[2])) {
                $dataNascimento = new \DateTime($dataNascimento[2].'-'.$dataNascimento[1].'-'.$dataNascimento[0]);
            } else {
                $dataNascimento = new \DateTime( $tableCliente->dataNascimento );
            }
            $dataUpdate = [
                'numeroCPF'=>is_null($request->xnumeroCPF) ? $tableCliente->numeroCPF : $request->xnumeroCPF,
                'nomeCliente'=>is_null($request->xnomeCliente) ? $tableCliente->nomeCliente : $request->xnomeCliente,
                'dataNascimento'=>is_null($request->xdataNascimento) ? $tableCliente->dataNascimento : $dataNascimento->format('Y-m-d'),
                'sexoCliente'=>is_null($request->xsexoCliente) ? $tableCliente->sexoCliente : $request->xsexoCliente,
                'nomeRua'=>is_null($request->xnomeRua) ? $tableCliente->nomeRua : $request->xnomeRua,
                'estado_id'=>is_null($request->xestado_id) ? $tableCliente->estado_id : $request->xestado_id,
                'cidade_id'=>is_null($request->xcidade_id) ? $tableCliente->cidade_id : $request->xcidade_id,
            ];
            $tableCliente->update($dataUpdate);
            return response()->json(["message" => "Uhuuul, Cliente está atualizado com sucesso!"], 200);
        } else {
            return response()->json(["message" => "Sinto muito, mas o Cliente não foi localizado!"], 404);
            
        }
    }

    public function deleteCliente($id) {
        if(Cliente::where('id', $id)->exists()) {
            $tableCliente = Cliente::find($id);
            $tableCliente->delete();
    
            return response()->json(["message" => "Cliente Removido com Sucesso!!!"], 202);
        } else {
            return response()->json(["message" => "Sinto muito, mas o Cliente não foi localizado!"], 404);
        }
    }

    public function getAllEstados() {
        $tableEstados = Estado::orderby('estado','DESC')->get()->toJson(JSON_PRETTY_PRINT);
        return response($tableEstados, 200);
    }

    public function getEstado($id) {
        if (Estado::where('id', $id)->exists()) {
            $tableEstados = Estado::where('id', $id)->orderby('estado','ASC')->get()->toJson(JSON_PRETTY_PRINT);
            return response($tableEstados, 200);
        } else {
            return response()->json(["message" => "Lamento, mas o Estado não foi encontrado!"], 404);
        }
    }

    public function getAllCidades() {
        $tableCidades = Cidade::get()->toJson(JSON_PRETTY_PRINT);
        return response($tableCidades, 200);
    }

    public function getCidade($id) {
        if (Cidade::where('id', $id)->exists()) {
            $tableCidades = Cidade::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($tableCidades, 200);
        } else {
            return response()->json(["message" => "Sinto muito, mas a Cidade não foi encontrada!"], 404);
        }
    }

    public function getAllCidadeEstado($id) {
        if (Cidade::where('estado_id', $id)->exists()) {
            $tableCidades = Cidade::where('estado_id', $id)->orderby('cidade', 'DESC')->get()->toJson(JSON_PRETTY_PRINT);
            return response($tableCidades, 200);
        } else {
            return response()->json(["message" => "Lamento, mas essas Cidades não foram encontradas para este Estado!"], 404);
        }
    }

    public function getSearchClientes(Request $request) {
        $sSQL = "SELECT vCS.id, 
                        vCS.nomeCliente, 
                        vCS.numeroCPF, 
                        DATE_FORMAT (vCS.dataNascimento, '%d/%m/%Y') as dataNascimento, 
                        vCS.sexoCliente,
                        vCS.nomeRua, 
                        vCS.cidade_id, 
                        vCE.cidade,
                        vCS.estado_id,
                        vES.estado
                   FROM clientes vCS
                        INNER JOIN estados vES ON (vCS.estado_id = vES.id)
                        INNER JOIN cidades vCE ON (vCS.cidade_id = vCE.id AND vCE.estado_id = vES.id)";
        $sWhere = ' WHERE 1=1 ';
        
        $sWhere .=  is_null($request->numeroCPF) ? ""      : " AND vCS.numeroCPF = '".$request->numeroCPF."'";
        $sWhere .=  is_null($request->nomeCliente) ? ""    : " AND vCS.nomeCliente LIKE '%".$request->nomeCliente."%'";
        $sWhere .=  is_null($request->dataNascimento) ? "" : " AND vCS.dataNascimento = '".$request->dataNascimento."'";
        $sWhere .=  is_null($request->sexoCliente) ? ""    : " AND vCS.sexoCliente = '".$request->sexoCliente."'";
        $sWhere .=  is_null($request->estado_id)||$request->estado_id==0 ? ""      : " AND vCS.estado_id = '".$request->estado_id."'";
        $sWhere .=  is_null($request->cidade_id) ? ""      : " AND vCS.cidade_id = '".$request->cidade_id."'";
        
        $aDataRotas = DB::select($sSQL.$sWhere);
        return response(['data'=>$aDataRotas], 200);
    }

}
