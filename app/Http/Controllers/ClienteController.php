<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use Illuminate\Support\Facades\Input;
use App\Cliente;
use App\Software;
use App\ClienteSoftware;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::orderBy('razao_social', 'asc')->get();
        return view('clientes.clientes-lista', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $softs = Software::all();
        return view('clientes.cliente-cadastro',compact('softs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {
        $cliente = new Cliente();
        $cliente->nome_fantasia = $request->input('nome_fantasia');
        $cliente->razao_social = $request->input('razao_social');
        $cliente->cnpj = $request->input('cnpj');
        $cliente->segmento = $request->input('segmento');
        $cliente->email = $request->input('email');
        $cliente->telefone = $request->input('telefone');

        $id = \Auth::user()->id;
        $cliente->user_id = $id;

        $cliente->save();

        $cliente_software = new ClienteSoftware();
        $cliente_software->cliente_id = $cliente->id;
        $cliente_software->software_id = $request->input('software');

        $cliente_software->save();

        return redirect('/cadastro/cliente')->with('alert', 'Cliente Cadastrado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $softs = Software::all();
        $c = Cliente::find($id);
        return view('clientes.cliente-dados', compact('softs', 'c'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        $cliente->nome_fantasia = $request->input('nome_fantasia');
        $cliente->razao_social = $request->input('razao_social');
        $cliente->cnpj = $request->input('cnpj');
        $cliente->segmento = $request->input('segmento');
        $cliente->email = $request->input('email');
        $cliente->telefone = $request->input('telefone');

        $cliente->software_id = $request->input('software');

        $cliente->save();

        return redirect('/cliente/{id}/dados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        return redirect('/pesquisar');
    }

    public function indexWithTrashed(){
        $clientes = Cliente::onlyTrashed()->get();
        return view('corpo/cliente-deletar', compact('clientes'));
    }

    public function restore($id){
        $cliente = Cliente::onlyTrashed()->find($id);
        $cliente->restore();
        return redirect('/pesquisar');
    }

    public function delete($id){
        $cliente = Cliente::onlyTrashed()->find($id);
        $cliente->forceDelete();
        return redirect('/pesquisar');
    }
}
