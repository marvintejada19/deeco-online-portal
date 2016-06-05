<div class="panel panel-default">
    <div class="panel-heading">
    	{{ $article->title }}
    	<div class="pull-right">
            Published at: {{ $article->getUnformattedDate('publish_on') }}
        </div>
    </div>
    <div class="panel-body">
        {!! $article->body !!}
    </div>
</div>
