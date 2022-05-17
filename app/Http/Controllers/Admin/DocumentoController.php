<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Imagem;
use App\Models\TipoDocumento;
use App\Models\Setor;
use App\Models\Filial;
use App\Models\Log;
use App\Http\Requests\Admin\DocumentoFormRequest;
use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $documento;
    public function __construct(Documento $documento, TipoDocumento $tipodocumento, Setor $setor, Filial $filial, Log $log, Imagem $imagem)
    {
        $this->documento = $documento;                           
        $this->imagem = $imagem;                           
        $this->tipodocumento = $tipodocumento;        
        $this->setor = $setor;        
	    $this->filial = $filial;
	    $this->log = $log;
    }
    public function index() 
    {
        $documentos = $this->documento
                ->orderBy('nome', 'ASC')
                ->paginate(2);
        
        $tipodocumentos = $this->tipodocumento
                ->orderBy('nome', 'ASC')
                ->get();
        $setores = $this->setor
                ->orderBy('nome', 'ASC')
                ->get();
        $filiais = $this->filial
                ->orderBy('nome', 'ASC')
                ->get();
        return view('admin.documento.index', [
            'documentos' => $documentos, 
            'tipodocumentos' => $tipodocumentos, 
            'setores' => $setores, 
            'filiais' => $filiais
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipodocumentos = $this->tipodocumento
                ->orderBy('nome', 'ASC')
                ->get();
        $setores = $this->setor
                ->orderBy('nome', 'ASC')
                ->get();
        $filiais = $this->filial
                ->orderBy('nome', 'ASC')
                ->get();
        return view('admin.documento.create', [
            'tipodocumentos' => $tipodocumentos, 
            'setores' => $setores, 
            'filiais' => $filiais
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentoFormRequest $request)
    {
        $dataForm = $request->all();
        $user_id = auth()->user()->id;
        // Verifica se o registro com nome e data já existe no banco
        $busca = $this->documento
                ->Where('nome', '=', $dataForm['nome'])
                ->Where('data_documento', '=', $dataForm['data_documento'])
                ->get()->first();
        if ($busca != null){
            return redirect()
                    ->route('documentos.create')
                    ->withErrors(['errors' => 'Já existe no cadastro este Nome e Data!'])
                    ->withInput();                
        }
        DB::beginTransaction();
        $dataForm['data_inclusao'] = date('Y-m-d');
        $dataForm['user_id'] = $user_id;
        $insert1 = Documento::create($dataForm);
        if( $insert1 ) {
            $tipobj = "DOC";
            $objeto = $dataForm['nome'];
            $operacao_id = 1;   // Incluiu
            $data = date('Y-m-d');
            $insert2 = Log::create([
                'user_id'    => $user_id,
                'operacao_id'     => $operacao_id,
                'tipobj'     => $tipobj,
                'objeto'     => $objeto,
                'data'     => $data,
            ]);
            if( $insert2 ) {
                DB::commit();
                return redirect()
                    ->route('documentos.index')
                    ->with(['success' => 'Registro incluido com sucesso']);
            }else{
                DB::rollBack();
                return redirect()
                    ->route('documentos.create')
                    ->withErrors(['errors' => 'Falha ao Incluir Log']);
            }
        }else{
            DB::rollBack();
            return redirect()
                    ->route('documentos.create')
                    ->withErrors(['errors' => 'Falha ao Incluir Documento']);
        }
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
        $documento = $this->documento->find($id);
        $tipodocumentos = $this->tipodocumento
                ->orderBy('nome', 'ASC')
                ->get();
        $setores = $this->setor
                ->orderBy('nome', 'ASC')
                ->get();
        $filiais = $this->filial
                ->orderBy('nome', 'ASC')
                ->get();
        return view('admin.documento.edit', [
            'documento' => $documento, 
            'tipodocumentos' => $tipodocumentos, 
            'setores' => $setores, 
            'filiais' => $filiais
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentoFormRequest $request, $id)
    {
        $documento = $this->documento->find($id);
        $user_id = auth()->user()->id;
        $dataForm = $request->all();
        DB::beginTransaction();
        $update = $documento->update($dataForm);
        if ( $update ){
            $tipobj = "DOC";
            $objeto = $dataForm['nome'];
            $operacao_id = 2;   // Alterar
            $data = date('Y-m-d');
            $insert2 = Log::create([
                'user_id'    => $user_id,
                'operacao_id'     => $operacao_id,
                'tipobj'     => $tipobj,
                'objeto'     => $objeto,
                'data'     => $data,
            ]);
            if( $insert2 ) {
                DB::commit();
                return redirect()
                 ->route('documentos.index') 
                 ->with(['success' => 'Registro Alterado com Sucesso'])
                 ->withInput();
            }else{
                DB::rollBack();
                return redirect()
                 ->route('documentos.edit', $id)
                 ->withErrors(['errors' => 'Erro no Update do Log'])
                 ->withInput();
            }
        }else{
            DB::rollBack();
            return redirect()
                 ->route('documentos.edit', $id)
                 ->withErrors(['errors' => 'Erro no Update do Documento'])
                 ->withInput();
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request['documento_id'];
        $documento = $this->documento->find($id);
        $user_id = auth()->user()->id;
        DB::beginTransaction();

        // Deletar todos as Imagens deste Documento
        $sql = "delete from imagem";
        $sql = $sql . " where documento_id = '$id' ";
        $del = DB::select($sql);

        //gravar log
        $tipobj = "DOC";
        $objeto = $documento->nome;
        $operacao_id = 3;   // Excluiu
        $data = date('Y-m-d');
        $insert2 = Log::create([
            'user_id'    => $user_id,
            'operacao_id'     => $operacao_id,
            'tipobj'     => $tipobj,
            'objeto'     => $objeto,
            'data'     => $data,
        ]);
        if( $insert2 ) {
            $delete = $documento->delete();
            if ($delete){
                DB::commit();
                return redirect()
                    ->route('documentos.index') 
                    ->with(['success' => 'Registro Excluido com Sucesso'])
                    ->withInput();
            }else{
                DB::rollBack();
                return redirect()
                    ->route('documentos.index')
                    ->withErrors(['errors' => 'Erro no delete documento'])
                    ->withInput();
            }
        }else{
            DB::rollBack();
            return redirect()
                 ->route('documentos.index')
                 ->withErrors(['errors' => 'Erro no insert do Log'])
                 ->withInput();
        }
    }

    public function search(Request $request)
    {
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $data1 = $dataForm['data1'];
        $data2 = $dataForm['data2'];
        $setor_id = $dataForm['setor_id'];
        $filial_id = $dataForm['filial_id'];
        if ($data1 != null && $data2 == null){
            $data2 = $data1;
        }
        if ($nome == '%%' && $data1 == null && $setor_id == null && $filial_id == null){
            return redirect()
                    ->route('documentos.index')
                    ->withErrors(['errors' => 'Informe pelo menos uma condição de pesquisa']);
        }
        
        $query = Documento::query();
        if ($nome != null) {
            $query->where('nome', 'like', $nome);
        }
        if ($setor_id != null) {
            $query->where('setor_id', '=', $setor_id);
        }
        if ($data1 != null){
            $query->whereBetween('data_documento', [$data1, $data2]);
        }
        $documentos = $query->orderBy('nome', 'ASC')->get();

        $setores = $this->setor
            ->orderBy('nome', 'ASC')
            ->get();

        $filiais = $this->filial
            ->orderBy('nome', 'ASC')
            ->get();
        
        return view('admin.documento.index', [
            'documentos' => $documentos, 
            'setores' => $setores, 
            'filiais' => $filiais,
            'dataForm' => $dataForm
        ]);
    }
}
