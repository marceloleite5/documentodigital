<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setor;
use App\Models\Documento;
use App\Http\Requests\Admin\SetorFormRequest;
use League\CommonMark\Block\Element\Document;

class SetorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $setor; 
    public function __construct(Setor $setor, Documento $documento) 
    {
        $this->setor = $setor;     
        $this->documento = $documento;     
    }
    public function index() 
    {
        $setores = $this->setor
                ->orderBy('nome', 'ASC')
                ->paginate(5);
        return view('admin.setor.index', ['setores' => $setores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SetorFormRequest $request)
    {
        $dataForm = $request->all();
        // Vai inserir
        $insert = $this->setor->insert([
            'nome' => $dataForm['nome'] 
        ]);
        if ( $insert )
           return redirect()
           ->route('setores.index')
           ->with(['success' => 'Registro Cadastrado com Sucesso'])
           ->withInput();
        else
            return redirect()
                ->route('setores.create')
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
        $setor = $this->setor->find($id);
        return view('admin.setor.edit', ['setor'=> $setor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SetorFormRequest $request, $id)
    {
        $setor = $this->setor->find($id);
        $dataForm = $request->all();
        $update = $setor->update($dataForm);
        if ( $update )
            return redirect()
                 ->route('setores.index')
                 ->with(['success' => 'Registro Alterado com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('setores.edit', $id)
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
        $id = $request['setor_id'];
        $setor = $this->setor->find($id);

        $busca = $this->documento
            ->Where('setor_id', '=', $id)
            ->get()->count();
        if ($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' Documentos ligados a este Setor !';
            return redirect()
                 ->route('setores.index')
                 ->withErrors(['errors' => $message])
                 ->withInput();
        }

        $delete = $setor->delete();
        if ( $delete )
            return redirect()
                 ->route('setores.index')
                 ->with(['success' => 'Registro excluido com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('setores.index')
                 ->withErrors(['errors' => 'Erro no Delete'])
                 ->withInput();
    }

    public function search(Request $request)
    {  
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $setores = $this->setor
            ->where('nome', 'LIKE', $nome) 
            ->orderBy('nome', 'ASC')
            ->paginate(2);

        return view('admin.setor.index', ['setores' => $setores, 'dataForm'=> $dataForm]);
    }
}
