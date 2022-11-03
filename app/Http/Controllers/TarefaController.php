<?php

namespace App\Http\Controllers;

use App\Models\tarefa;
use App\Http\Requests\StoretarefaRequest;
use App\Http\Requests\UpdatetarefaRequest;
use Illuminate\Http\Request;

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
        $ultimo = tarefa::orderBy('ordem', 'desc')->first();
        
        return view('tarefas.index', compact('tarefas', 'ultimo'));
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

        $ultimo = tarefa::orderBy('ordem', 'desc')->first();

        if($ultimo == NULL) {
            $ordem = 1;
        } else {
            $ordem = $ultimo->ordem + 1;
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
        
        //dd($tarefa);
        //$tarefa = tarefa::where('id', $id)->update($request->except('_token', '_method'));
        $validated = $request->validate([
            'nome' => 'required|unique:tarefas|max:255',
            'custo' => 'required',
            'data' => 'required',
        ]);

        $novo = tarefa::find($tarefa->id)->update($request->except('_token', '_method'));

        if ($novo) {
            return redirect()->route('index')->with('success','Tarefa '. $tarefa->nome .' foi atualizada com sucesso');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarefa = tarefa::findOrFail($id);

        $objetos = tarefa::orderBy('ordem')->get();
        // dd($objetos);
        $ultimo = $objetos->last();

        $ordem = $tarefa->ordem;

        if (isset($tarefa)){
            $tarefa->delete();
        }

        for ($i=$ordem; $i < $ultimo->ordem; $i++) { 
            if($objetos[$i]->ordem != NULL) {
                tarefa::find($objetos[$i]->id)->update(['ordem' => $ordem]);
                $ordem += 1;
            }
        }
        
        return redirect()->route('index')->with('success', 'A Tarefa foi excluida com sucesso!');
    }

    public function sobe(tarefa $tarefa)
    {
        $ordem = $tarefa->ordem;

        $aux = tarefa::where('ordem', $ordem-1)->first();
        tarefa::where('ordem',$ordem)->update(['ordem' => $ordem-1]);
        tarefa::find($aux->id)->update(['ordem' => $ordem]);
        return redirect()->route('index');
    }

    public function desce(tarefa $tarefa)
    {
        // dd($tarefa);
        $ordem = $tarefa->ordem;

        $aux = tarefa::where('ordem', $ordem+1)->first();
        tarefa::where('ordem',$ordem)->update(['ordem' => $ordem+1]);
        tarefa::find($aux->id)->update(['ordem' => $ordem]);
        return redirect()->route('index');
    }
}
