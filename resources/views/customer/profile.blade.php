@extends('layouts.admin')

@section('content')
<div class="page-body">
    @include('partials.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Customer Page</h5>
                        <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/'.auth()->user()->photo) }}" alt="" width="200">
                            </div>
                            <div class="col-md-8">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>{{ auth()->user()->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ auth()->user()->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>{{ auth()->user()->status() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
