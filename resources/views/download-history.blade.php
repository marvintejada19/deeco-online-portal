@extends('layouts.app')

@section('title')
    Download history
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>{{ $file->file_name }}</h3>
                </div>
                @if ($list->isEmpty())
                <div class="panel-body">
                    <div class="well">
                        No one has downloaded this file yet.
                    </div>
                </div>
                @else
                <table class="table">
                    <tr>
                        <td></td>
                        <th>Username:</th>
                        <th>Downloaded at:</th>
                    </tr>
                    <?php $count = 1 ?>
                    @foreach ($list as $item)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $item->getUser()->username }}</td>
                        <td>{{ $item->downloaded_at }}</td>
                    </tr>
                    @endforeach
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@stop