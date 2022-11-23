@extends('backend_layouts.main')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Location</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('location.index') }}">Location</a></li>
                <li class="breadcrumb-item active" aria-current="page">Location Tabel</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Location</h3>
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form
                        action="@isset($location) {{ route('location.update', $location->id) }} @endisset @empty($location) {{ route('location.store') }} @endempty"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($location)
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control"
                                value="{{ isset($location) ? $location->name : @old('name') }}" required name="name">
                        </div>
                        <div class="text-end">
                            <a class="btn btn-warning" href="{{ url()->previous() }}">Kembali</a>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
@endpush
