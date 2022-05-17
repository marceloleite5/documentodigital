<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Filial;
use App\Models\Documento;
use App\Models\Imagem;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $filial; 
    public function __construct(Filial $filial, Documento $documento, Imagem $imagem) 
    {
        $this->filial = $filial;      
        $this->documento = $documento;      
        $this->imagem = $imagem;      
    }

    public function index()
    {
        $filiais = $this->filial
                ->orderBy('nome', 'ASC')
                ->get();

        $qtd_doc = $this->documento
                ->get()->count();

        $qtd_img = $this->imagem
                ->get()->count();

        // Dados para o gráfico
        $sql = "SELECT filial.nome, filial.id, count(documento.id) as qtd_doc, 0 as qtd_img FROM documento ";
        $sql = $sql . " right join filial on documento.filial_id = filial.id ";
        $sql = $sql . " group by filial.nome, filial.id ";
        $documentos_por_filial = DB::select($sql);

        $i = 0;
        foreach ($documentos_por_filial as $filial){
            $filial_id = $filial->id;
            
            $sql = "SELECT count(imagem.id) as qtd_img FROM imagem ";
            $sql = $sql . " inner join documento on imagem.documento_id = documento.id ";
            $sql = $sql . " where documento.filial_id = '$filial_id' ";
            $imagens_por_filial = DB::select($sql);

            $documentos_por_filial[$i]->qtd_img = $imagens_por_filial[0]->qtd_img;

            $i = $i + 1;
        }

        return view('admin.home', [
            'filiais' => $filiais,
            'qtd_doc' => $qtd_doc,
            'qtd_img' => $qtd_img,
            'graficos' => $documentos_por_filial
        ]);
    }

    public function filial($id)
    {
        // Pega a Filial pelo ID
        $filial = $this->filial->find($id);
        $filial_nome = $filial->nome;

        $filiais = $this->filial
                ->orderBy('nome', 'ASC')
                ->get();

        $qtd_doc = $this->documento
                ->get()->count();

        $qtd_img = $this->imagem
                ->get()->count();

        // Dados para o gráfico
        $sql = "SELECT setor.nome, setor.id, count(documento.id) as qtd_doc, 0 as qtd_img FROM documento ";
        $sql = $sql . " right join setor on documento.setor_id = setor.id ";
        $sql = $sql . " where documento.filial_id = '$id'  ";
        $sql = $sql . " group by setor.nome, setor.id ";
        $documentos_por_setor = DB::select($sql);
        

        $i = 0;
        foreach ($documentos_por_setor as $setor){
            $setor_id = $setor->id;
            
            $sql = "SELECT count(imagem.id) as qtd_img FROM imagem ";
            $sql = $sql . " inner join documento on imagem.documento_id = documento.id ";
            $sql = $sql . " where documento.setor_id = '$setor_id' ";
            $sql = $sql . " and documento.filial_id = '$id' ";
            $imagens_por_setor = DB::select($sql);

            $documentos_por_setor[$i]->qtd_img = $imagens_por_setor[0]->qtd_img;

            $i = $i + 1;
        }

        return view('admin.home-filial', [
            'filial_nome' => $filial_nome,
            'filiais' => $filiais,
            'qtd_doc' => $qtd_doc,
            'qtd_img' => $qtd_img,
            'graficos' => $documentos_por_setor
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
}
