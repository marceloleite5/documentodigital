<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Email;
use App\Http\Requests\Admin\EmailFormRequest;


class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $email; 
    public function __construct(Email $email) 
    {
        $this->email = $email;     
    }
    public function index()
    {
        $emails = $this->email
                ->orderBy('email', 'ASC')
                ->paginate(5);
        return view('admin.email.index', ['emails' => $emails]);
    }

    public function teste()
    {
        $emails = $this->email
                ->orderBy('email', 'ASC')
                ->get();
        
        return view('admin.email.teste', ['emails' => $emails]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.email.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailFormRequest $request)
    {
        $dataForm = $request->all();
        // Vai inserir
        $insert = $this->email->insert([
            'email' => $dataForm['email'] 
        ]);
        if ( $insert )
           return redirect()
           ->route('emails.index')
           ->with(['success' => 'Registro Cadastrado com Sucesso'])
           ->withInput();
        else
            return redirect()
                ->route('emails.create')
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
        $email = $this->email->find($id);
        return view('admin.email.edit', ['email'=> $email]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmailFormRequest $request, $id)
    {
        $email = $this->email->find($id);
        $dataForm = $request->all();
        $update = $email->update($dataForm);
        if ( $update )
            return redirect()
                 ->route('emails.index')
                 ->with(['success' => 'Registro Alterado com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('emails.edit', $id)
                 ->withErrors(['errors' => 'Erro no Update'])
                 ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {  
        $id = $request['email_id'];
        $email = $this->email->find($id);
        $delete = $email->delete();
        if ( $delete )
            return redirect()
                 ->route('emails.index')
                 ->with(['success' => 'Registro excluido com Sucesso'])
                 ->withInput();
        else
            return redirect()
                 ->route('emails.index')
                 ->withErrors(['errors' => 'Erro no Delete'])
                 ->withInput();
    }

    public function search(Request $request)
    {  
        $dataForm = $request->all();
        $nome = '%' . $dataForm['nome'] . '%';
        $emails = $this->email
            ->where('email', 'LIKE', $nome)
            ->orderBy('email', 'ASC')
            ->paginate(2);

        return view('admin.email.index', ['emails' => $emails, 'dataForm'=> $dataForm]);
    }
}
