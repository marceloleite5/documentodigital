<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\FormGrupo;
use App\Models\User;
use App\Http\Requests\Admin\GrupoFormRequest;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $grupo; 
    public function __construct(Grupo $grupo, FormGrupo $formgrupo, User $user) 
    {
        $this->grupo = $grupo;        
        $this->formgrupo = $formgrupo;        
        $this->user = $user;        
    }

    public function index()
    {
        $grupos = $this->grupo
                ->orderBy('nome', 'ASC')->get(); 
        return view('admin.grupo.index', ['grupos' => $grupos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.grupo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoFormRequest $request)
    {
        $dataForm = $request->all();
        // Vai inserir
        $insert = $this->grupo->insert([
            'nome' => $dataForm['nome'] 
        ]);
        if ( $insert )
           return redirect()
           ->route('grupos.index')
           ->with(['success' => 'Registro Cadastrado com Sucesso'])
           ->withInput();
        else
            return redirect()
                ->route('grupos.create')
                ->withErrors(['errors' => 'Erro no Insert'])
                ->withInput();
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
        $grupo = $this->grupo->find($id);
        return view('admin.grupo.edit', ['grupo'=> $grupo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoFormRequest $request, $id)
    {
        $grupo = $this->grupo->find($id);
        $dataForm = $request->all();
        $update = $grupo->update($dataForm);
        if ( $update )
            return redirect()
                 ->route('grupos.index') 
                 ->with(['success' => 'Registro Alterado com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('grupos.edit', $id)
                 ->withErrors(['errors' => 'Erro no Update'])
                 ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request['grupo_id'];
        $grupo = $this->grupo->find($id);
        $busca = $this->formgrupo
            ->Where('grupo_id', '=', $id)
            ->get()->count();
        if ($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' Forms ligados a este Grupo !';
            return redirect()
                 ->route('grupos.index')
                 ->withErrors(['errors' => $message])
                 ->withInput();
        }

        $busca = $this->user
            ->Where('grupo_id', '=', $id)
            ->get()->count();
        if ($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' Usuários ligados a este Grupo !';
            return redirect()
                 ->route('grupos.index')
                 ->withErrors(['errors' => $message])
                 ->withInput();
        }
        $delete = $grupo->delete();
        if ( $delete )
            return redirect()
                 ->route('grupos.index')
                 ->with(['success' => 'Registro excluido com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('grupos.index')
                 ->withErrors(['errors' => 'Erro no Delete'])
                 ->withInput();
    }
}
