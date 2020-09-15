@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ route('notes.index') }}">Note</a>
            </li>
            <li class="breadcrumb-item active">Insert</li>
        </ol>
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
        @endif
        <div class="row">
            <div class="col-xl-8 offset-2">
                <div class="card mx-auto mt-5">
                    <div class="card-header">Insert New Note</div>
                    <div class="card-body">
                        <form action="{{ route('notes.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" id="note_title" class="form-control" placeholder="Note Details" required="required" autofocus="autofocus" name="note_title">
                                    <label for="note_title">Note Description</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="number" step="any" min="0.01" id="note_amount" class="form-control" placeholder="Note Amount" required="required" name="note_amount">
                                    <label for="note_amount">Note Amount</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="date" id="note_date" class="form-control" placeholder="Note Date" required="required" name="note_date" value="{{ date('Y-m-d') }}">
                                    <label for="note_date">Note Date</label>
                                </div>
                            </div>
                            <div class="float-right">
                                <a href="{{ route('notes.index') }}" class="btn btn-success">Back</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection