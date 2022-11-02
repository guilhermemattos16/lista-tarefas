@extends('adminlte::page')

@section('title', 'Lista de Tarefas')

@section('content')

  @if(Session::has('success'))
      <div class="alert alert-success">
          {{ Session::get('success') }}
      </div>
  @endif

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Tarefas</h1>
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
              <!-- /.card-header -->
              <div class="card-body">
                <!-- Trigger the modal with a button -->
                {{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> --}}
                
                <div style="margin-bottom: 20px" class="float-right">
                  <a type="button" class="btn btn-sm btn-primary " href="{{route('create')}}">Incluir Tarefa</a>
                </div>
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Custo</th>
                    <th>Data Limite</th>
                    <th>Ordem</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($tarefas as $tarefa)
                  <tr>
                    <td>{{$tarefa->nome}}</td>
                    <td>{{$tarefa->custo}}</td>
                    <td> {{ \Carbon\Carbon::parse($tarefa->data)->format('d/m/Y')}} </td>
                    <td>{{$tarefa->ordem}}</td>
                    <td>
                      <a href="{{route('edit', $tarefa)}}" class="btn btn-sm btn-warning my-1">Editar</a>
                      <button type="button" class="btn btn-danger btn-sm my-1" data-toggle="modal" data-target="#excluir" data-id="{{$tarefa}}">Excluir</button>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal Excluir -->
    <div class="modal fade" id="excluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Excluir Tarefa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form method="POST" enctype="multipart/form-data" name="form_delete" id="form_delete">
                      @csrf
                      @method('DELETE')
                      <p>Deseja realmente excluir essa tarefa?</p>
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-danger" form="form_delete">Excluir</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              </div>
          </div>
      </div>
  </div>
  <!-- Fim Modal Excluir -->
@endsection

@section('script')
    <script>
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Botão que acionou o modal
            var recipient = button.data('get2') // Extrai informação dos atributos data-*
            // Se necessário, você pode iniciar uma requisição AJAX aqui e, então, fazer a atualização em um callback.
            // Atualiza o conteúdo do modal. Nós vamos usar jQuery, aqui. No entanto, você poderia usar uma biblioteca de data binding ou outros métodos.
            var modal = $(this)
            modal.find('.modal-body img#imagem').attr('src',recipient)
        })
        $('#excluir').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            $('#form_delete').attr('action',button.attr('data-id'))
        });
    </script>
@endsection