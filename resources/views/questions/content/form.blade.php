<div class="form-group">
    <div class="col-md-6">
        <label>
            Path
        </label>
        <ol class="breadcrumb">
            <li><a href="/categories/{{ $category->name }}">{{ $category->name }}</a></li>
            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}">{{ $topic->name }}</a></li>
            <li class="active">{{ $subtopic->name }}</li>
        </ol>
    </div>
</div>

<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    {!! Form::label('title', 'Title:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('title', null, ['class' => 'form-control']) !!}

        @if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
    {!! Form::label('body', 'Body:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('body', null, ['class' => 'form-control']) !!}

        @if ($errors->has('body'))
            <span class="help-block">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        @endif
    </div>
</div>
<hr/>