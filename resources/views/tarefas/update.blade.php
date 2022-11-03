@extends('adminlte::page')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Criar Tarefa</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- form start -->
                            <form role="form" action="{{route('update', $tarefa)}}" method="POST">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input class="form-control" name="nome" value="{{ $tarefa->nome}}" type="text" placeholder="Nome da Tarefa" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="custo">Custo</label>
                                        <input class="form-control" name="custo" step="0.01" value="{{ $tarefa->custo}}" placeholder="0.00" type="number" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="data">Data Limite</label>
                                        <input type="date" class="form-control" name="data" value="{{ \Carbon\Carbon::parse($tarefa->data)->format('Y-m-d')}}" required>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Editar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection