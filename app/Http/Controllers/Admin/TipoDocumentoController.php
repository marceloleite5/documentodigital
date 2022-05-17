<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tipodocumento;
use App\Models\Documento;
use App\Http\Requests\Admin\TipoDocumentoFormRequest;

class TipoDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $tipodocumento; 
    public function __construct(TipoDocumento $tipodocumento, Documento $documento) 
    {
        $this->tipodocumento = $tipodocumento;   
        $this->documento = $documento;    
    }

    public function index()
    {
        $tipodocumentos = $this->tipodocumento
                ->orderBy('nome', 'ASC')
                ->paginate(5);
        return view('admin.tipodocumento.index', ['tipodocumentos' => $tipodocumentos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tipodocumento.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoDocumentoFormRequest $request)
    {
        $dataForm = $request->all();
        // Vai inserir
        $insert = $this->tipodocumento->insert([
            'nome' => $dataForm['nome'] 
        ]);
        if ( $insert )
           return redirect()
           ->route('tipodocumentos.index')
           ->with(['success' => 'Registro Cadastrado com Sucesso'])
           ->withInput();
        else
            return redirect()
                ->route('tipodocumentos.create')
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
        $tipodocumento = $this->tipodocumento->find($id);
        return view('admin.tipodocumento.edit', ['tipodocumento'=> $tipodocumento]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoDocumentoFormRequest $request, $id)
    {
        $tipodocumento = $this->tipodocumento->find($id);
        $dataForm = $request->all();
        $update = $tipodocumento->update($dataForm);
        if ( $update )
            return redirect()
                 ->route('tipodocumentos.index')
                 ->with(['success' => 'Registro Alterado com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('tipodocumentos.edit', $id)
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
        $id = $request['tipodocumento_id'];
        $tipodocumento = $this->tipodocumento->find($id);

        $busca = $this->documento
            ->Where('tipodocumento_id', '=', $id)
            ->get()->count();
        if ($busca > 0){
            $message = 'Falha no Delete! Existem ' . $busca . ' Documentos ligados a este Tipo Documento !';
            return redirect()
                 ->route('tipodocumentos.index')
                 ->withErrors(['errors' => $message])
                 ->withInput();
        }

        $delete = $tipodocumento->delete();
        if ( $delete )
            return redirect()
                 ->route('tipodocumentos.index')
                 ->with(['success' => 'Registro excluido com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('tipodocumentos.index')
                 ->withErrors(['errors' => 'Erro no Delete'])
                 ->withInput();
    } 

    public function search(Request $request)
    {  
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $tipodocumentos = $this->tipodocumento
            ->where('nome', 'LIKE', $nome)
            ->orderBy('nome', 'ASC')
            ->paginate(2);

        return view('admin.tipodocumento.index', ['tipodocumentos' => $tipodocumentos, 'dataForm'=> $dataForm]);
    }

}
