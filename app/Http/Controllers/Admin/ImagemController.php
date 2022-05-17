<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Imagem;
use App\Models\Documento;
use App\Models\Log;
use App\Models\Email;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarEMail;



class ImagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $imagem;
    public function __construct(Imagem $imagem, Documento $documento, Log $log, Email $email)
    {                         
        $this->imagem = $imagem;                          
        $this->documento = $documento;                          
        $this->log = $log;
        $this->email = $email;                                                   
    }
    public function index($id)
    {
        $documento = $this->documento->find($id);
        $imagens = $this->imagem
            ->Where('documento_id', '=', $id)
            ->orderBy('endereco')
            ->get();
        
        $emails = $this->email
            ->orderBy('email')
            ->get();

        return view('admin.imagem.index', [
            'documento' => $documento,
            'imagens' => $imagens,
            'emails' => $emails
        ]);
    }

    public function send(Request $request)
    {
        $id = $request['imagem_id'];
        $imagem = $this->imagem->find($id);
        $documento_id = $imagem->documento_id;
        $email_id = $request['email_id'];
        // Verifica se selecionou o email
        if ($email_id == null){
            return redirect()
                ->route('imagens.index', $documento_id)
                ->withErrors(['success' => 'É necessário selecionar o Email !'])
                ->withInput();
        }
        $email = $this->email->find($email_id);
        $email_to = $email->email;
        $email_from = "ricardorochacosta52@gmail.com";
        
        Mail::to($email_to)->send(new EnviarEMail($imagem));

        return redirect()
                ->route('imagens.index', $documento_id)
                ->with(['success' => 'Imagem enviada com Sucesso'])
                ->withInput();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if ($request->file('imagem')->isValid()){
            $ext = $request->file('imagem')->extension();
            if ($ext != 'pdf' && $ext != 'jpg'){
                return redirect()
                    ->route('imagens.index', $id)
                    ->withErrors(['errors' => 'Apenas imagens jpg ou pdf são permitidos!'])
                    ->withInput();
            }
            $endereco = $request->file('imagem')->getClientOriginalName();
            DB::beginTransaction();
            $insert1 = Imagem::create([
                'documento_id'    => $id,
                'endereco'     => $endereco,
                'tipo'     => $ext,
            ]);
            if ($insert1){
                // Vai gravar o Log
                $documento = $this->documento->find($id);
                $user_id = auth()->user()->id;
                $tipobj = "IMG";
                $objeto = $documento->nome . "/" . $endereco;
                $operacao_id = 1;   // Incluiu
                $data = date('Y-m-d');
                $insert2 = Log::create([
                    'user_id'    => $user_id,
                    'operacao_id'     => $operacao_id,
                    'tipobj'     => $tipobj,
                    'objeto'     => $objeto,
                    'data'     => $data,
                ]);
                if( $insert2 ){
                    if ($request->file('imagem')->move('imagens', $endereco)){
                        DB::commit();
                        return redirect()
                            ->route('imagens.index', $id)
                            ->with(['success' => 'Registro incluido com sucesso']);
                    }else{
                        DB::rollBack();
                        return redirect()
                            ->route('imagens.index', $id)
                            ->withErrors(['errors' => 'Falha ao salvar a Imagem']);
                    }
                }else{
                    DB::rollBack();
                    return redirect()
                        ->route('imagens.index', $id)
                        ->withErrors(['errors' => 'Erro no Insert do Log'])
                        ->withInput();
                }
            }else{
                DB::rollBack();
                return redirect()
                    ->route('imagens.index', $id)
                    ->withErrors(['errors' => 'Falha ao incluir a Imagem no Banco de Dados']);
            }
        }else{
            return redirect()
                    ->route('imagens.index', $id)
                    ->withErrors(['errors' => 'Arquivo inválido ']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $imagem = $this->imagem->find($id);
        return view('admin.imagem.print', [
            'imagem' => $imagem
        ]);
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
        $imagem = $this->imagem->find($id);
        $image_path = 'imagens/' . $imagem->endereco;
        $documento_id = $imagem->documento_id;
        $documento = $this->documento->find($documento_id);
        $documento_nome = $documento->nome;
        $endereco = $imagem->endereco;

        DB::beginTransaction();
        $delete = $imagem->delete();
        if ( $delete ){
            // Vai deletar a imagem física
            if (unlink($image_path)){
                // gravar o log
                $user_id = auth()->user()->id;
                $tipobj = "IMG";
                $objeto = $documento_nome . "/" . $endereco;
                $operacao_id = 3;   // Excluiu
                $data = date('Y-m-d');
                $insert2 = Log::create([
                    'user_id'    => $user_id,
                    'operacao_id'     => $operacao_id,
                    'tipobj'     => $tipobj,
                    'objeto'     => $objeto,
                    'data'     => $data,
                ]);
                if ($insert2){
                    DB::commit();
                    return redirect()
                        ->route('imagens.index', $documento_id)
                        ->with(['success' => 'Registro excluido com Sucesso'])
                        ->withInput();
                }else{
                    DB::rollBack();
                    return redirect()
                        ->route('imagens.index', $documento_id)
                        ->withErrors(['errors' => 'Erro ao gravar Log'])
                        ->withInput();
                }
            }else{
                DB::rollBack();
                return redirect()
                    ->route('imagens.index', $documento_id)
                    ->withErrors(['errors' => 'Erro ao Deletar a imagem física'])
                    ->withInput();
            }
        }else{
            DB::rollBack();
            return redirect()
                 ->route('imagens.index', $documento_id)
                 ->withErrors(['errors' => 'Erro ao Deletar no Banco de Dados'])
                 ->withInput();
        }
    }
}
