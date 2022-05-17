<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filial;
use App\Models\Documento;
use App\Http\Requests\Admin\FilialFormRequest;

class FilialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $filial; 
    public function __construct(Filial $filial, Documento $documento) 
    {
        $this->filial = $filial;   
        $this->documento = $documento;    
    }

    public function index()
    {
        $filiais = $this->filial
                ->orderBy('nome', 'ASC')
                ->paginate(5);
        return view('admin.filial.index', ['filiais' => $filiais]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.filial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilialFormRequest $request)
    {
        $dataForm = $request->all();
        // Vai inserir
        $insert = $this->filial->insert([
            'nome' => $dataForm['nome'] 
        ]);
        if ( $insert )
           return redirect()
           ->route('filiais.index')
           ->with(['success' => 'Registro Cadastrado com Sucesso'])
           ->withInput();
        else
            return redirect()
                ->route('filiais.create')
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
        $filial = $this->filial->find($id);
        return view('admin.filial.edit', ['filial'=> $filial]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FilialFormRequest $request, $id)
    {
        $filial = $this->filial->find($id);
        $dataForm = $request->all();
        $update = $filial->update($dataForm);
        if ( $update )
            return redirect()
                 ->route('filiais.index')
                 ->with(['success' => 'Registro Alterado com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('filiais.edit', $id)
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
        $id = $request['filial_id'];
        $filial = $this->filial->find($id);

        $busca = $this->documento
            ->Where('filial_id', '=', $id)
            ->get()->count();
        if ($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' Documentos ligados a esta Filial !';
            return redirect()
                 ->route('filiais.index')
                 ->withErrors(['errors' => $message])
                 ->withInput();
        }

        $delete = $filial->delete();
        if ( $delete )
            return redirect()
                 ->route('filiais.index')
                 ->with(['success' => 'Registro excluido com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('filiais.index')
                 ->withErrors(['errors' => 'Erro no Delete'])
                 ->withInput();
    }

    public function search(Request $request)
    {  
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $filiais = $this->filial
            ->where('nome', 'LIKE', $nome)
            ->orderBy('nome', 'ASC')
            ->paginate(2);

        return view('admin.filial.index', ['filiais' => $filiais, 'dataForm'=> $dataForm]);
    }

}
