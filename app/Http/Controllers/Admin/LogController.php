<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $log; 
    public function __construct(Log $log, User $user) 
    {
        $this->log = $log;     
        $this->user = $user;     
    }

    public function index()
    {
        $users = $this->user
                ->orderBy('name', 'ASC')
                ->get();
        
        return view('admin.log.sel_log', [
                    'usuarios' => $users, 
        ]);
    }

   
    public function relatorio(Request $request)
    {
        $dataForm = $request->all();
        $data1 = $dataForm['data1'];
        $data2 = $dataForm['data2'];
        $user_id = $dataForm['user_id'];
        if ($data1 != null && $data2 == null){
            $data2 = $data1;
        }
        if ($data1 == null && $user_id == null){
            return redirect()
                    ->route('rel.log')
                    ->withErrors(['errors' => 'Informe pelo menos uma condição de pesquisa']);
        }
        $query = Log::query();
        if ($user_id != null) {
            $query->where('user_id', '=', $user_id);   
        }
        if ($data1 != null){
            $query->whereBetween('data', [$data1, $data2]);
        }
        $logs = $query->orderBy('data', 'DESC')->get();

        $k = 0;
        $i = 1;
        foreach ($logs as $log){
            $logs[$k]->linha = $i;
            $k = $k + 1;
            $i = $i + 1;
            if ($i > 17){
                $i = 1;
            }
        }
        return view('admin.log.relatorio', [
            'logs' => $logs
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
