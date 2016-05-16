@extends('layouts.app')

@section('title')
    Finish examination
@endsection

@section('content')
<div class="container">
    {!! $navbar !!}
    <hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5>Are you sure you want to finish your examination and get your results?</h5>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Questions answered:</th>
                        <td>
                            <b>
                            <font color={{ ($answeredQuestions == $totalQuestions) ? 'green' : 'red' }}>
                                {{ $answeredQuestions }}
                            </font>
                            / {{ $totalQuestions }}
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            {!! Form::open(['url' => '/classes/' . $subject->id . '/examinations/' . $examination->id . '/instances/' . $instance->id . '/page/finish']) !!}
                                {!! Form::submit('Finish', ['class' => 'btn btn-primary form-control']) !!}
                            {!! Form::close() !!}
                        </td> 
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection