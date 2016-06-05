@extends('layouts.app')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/posts">Posts</a></li>
        <li class="active">{{ $post->title }}</li>
    </ol>
    <br></br><hr/>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/posts/{{ $post->id }}/edit">Edit post details</a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Post details
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Title:</th><td>{{ $post->title }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">{!! $post->body !!}</td>
                    </tr>
                    <tr>
                        <th>Created at:</th><td>{{ $post->created_at }}</td>
                    </tr>
                </table>
                <div class="well">
                    @if (count($post->files) == 0)
                        No files attached
                    @else
                    Files attached:
                        <ul>
                            @foreach ($post->files as $file)
                                @include('layouts.file')
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @if($attachments->isEmpty())
            <div class="well">
                Not attached to any grade section subject yet.
            </div>
            @else
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Attched to the following grade section subjects
                </div>
                <table class="table table-striped">
                    <tr>
                        <td></td>
                        <th>Subject name</th>
                        <th>Section name</th>
                        <th>Publish on</th>
                    </tr>
                    <?php $count = 1 ?>
                    @foreach ($attachments as $attachment)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $attachment->gradeSectionSubject->subject->name }}</td>
                        <td>{{ $attachment->gradeSectionSubject->gradeSection->getName->name }}</td>
                        <td>{{ $attachment->getUnformattedDate('publish_on') }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@stop