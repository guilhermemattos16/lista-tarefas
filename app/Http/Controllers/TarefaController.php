<?php

namespace App\Http\Controllers;

use App\Models\tarefa;
use App\Http\Requests\StoretarefaRequest;
use App\Http\Requests\UpdatetarefaRequest;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarefas = tarefa::orderBy('ordem')->get();
        
        return view('tarefas.index', compact('tarefas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarefas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoretarefaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoretarefaRequest $request)
    {
        $validated = $request->validate([
            'nome' => 'required|unique:tarefas|max:255',
            'custo' => 'required',
            'data' => 'required',
        ]);

        $ultimo = tarefa::orderBy('created_at', 'desc')->first();

        if($ultimo == NULL) {
            $ordem = 1;
        } else {
            $ordem = $ultimo->id + 1;
        }

        $tarefa = tarefa::create([
            'nome' => $request->nome,
            'custo' => $request->custo,
            'data' => $request->data,
            'ordem' => $ordem,
        ]);


        //dd($tarefa);

        return redirect()->route('index')->with('success', 'A tarefa foi criada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(tarefa $tarefa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(tarefa $tarefa)
    {
        //$tarefa = tarefa::findOrFail($tarefa->id);
 
        if ($tarefa) {
            return view('tarefas.update', compact('tarefa'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetarefaRequest  $request
     * @param  \App\Models\tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatetarefaRequest $request, tarefa $tarefa)
    {
        //$tarefa = tarefa::where('id', $id)->update($request->except('_token', '_method'));
        $validated = $request->validate([
            'nome' => 'required|unique:tarefas|max:255',
            'custo' => 'required',
            'data' => 'required',
        ]);

        $tarefa = tarefa::update($request->except('_token', '_method'));
 
        if ($tarefa) {
            return redirect()->route('index')->with('success',"Tarefa ".$tarefa->nome." atualizada com sucesso");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(tarefa $tarefa)
    {
        if (isset($tarefa)){
            $tarefa->delete();
        }
        return redirect()->route('index')->with('info', 'A Tarefa foi excluida com sucesso!');
    }
}
