@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               
                @if (count($magazines) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <!-- Заголовок таблицы -->
                            <thead>
                                <tr>
                                    <th>Все журналы</th>
                                    <th>Действия с журналом</th>
                                </tr>
                            </thead>
                            <!-- Тело таблицы -->
                            <tbody>
                                @foreach ($magazines as $magazine)
                                <tr>
                                    <!-- Имя задачи -->
                                    <td class="table-text">
                                        <div>{{ $magazine->name }}</div>
                                    </td>
                                    <td style="display: flex">
                                        <form action="{{route('magazines.destroy',$magazine->id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button><i class="fa fa-trash"></i></button>
                                        </form>
                                        <form action="{{route('magazines.edit',$magazine->id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('GET') }}
                                            <button><i class="fa fa-edit"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
