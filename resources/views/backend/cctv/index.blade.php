@extends('backend_layouts.main')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Cctv</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cctv.index') }}">Cctv</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cctv Tabel</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cctv</h3>
                </div>
                <div class="card-body">
                    <div class="text-end mb-2">
                        <a href="{{ route('cctv.create') }}" class="btn btn-sm btn-primary">Tambah</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table border text-nowrap text-md-nowrap table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Lokasi</th>
                                    <th>Kelurahan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cctvs as $cctv)
                                    <tr>
                                        <td>{{ $cctv->name }}</td>
                                        <td>{{ $cctv->location?->name }}</td>
                                        <td>{{ $cctv->kelurahan?->nama_kelurahan }}</td>
                                        <td>
                                            <form action="{{ route('cctv.destroy', $cctv->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{ route('cctv.edit', $cctv->id) }}">
                                                    Edit
                                                </a>
                                                <input type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')" value="Delete" id="">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        {{ $cctvs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
