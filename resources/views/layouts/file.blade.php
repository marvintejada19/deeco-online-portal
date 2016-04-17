{!! Form::open(['url' => 'download']) !!}
    {!! Form::hidden('destinationPath', $file->destination_path) !!}
    {!! Form::hidden('fileName', $file->file_name) !!}
    <span class='glyphicon glyphicon-download-alt'></span>
    <input type="submit" class="submitLink" value="{{ $file->file_name }}">
    <div class="dropdown pull-right">
        <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="/files/download-history/{{ $file->id }}/">View download history</a></li>
        </ul>
    </div>
{!! Form::close() !!}