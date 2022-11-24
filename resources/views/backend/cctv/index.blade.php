@extends('backend_layouts.main')
@push('style')
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
@endpush
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
                                    <th>CCTV</th>
                                    <th>Name</th>
                                    <th>Lokasi</th>
                                    <th>Kecamatan / Kelurahan</th>
                                    <th>RW / RT</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cctvs as $cctv)
                                    <tr>
                                        <td>
                                            {{-- <video id="my-video{{ $cctv->id }}" width="400" height="300"
                                                preload="auto" class="video-js" controls data-setup='{}'>
                                                <source src="{{ $cctv->liveViewUrl }}" type='application/x-mpegURL' />
                                                <p class="vjs-no-js">
                                                    To view this video please enable JavaScript, and consider upgrading to a
                                                    web browser that
                                                    <a href="https://videojs.com/html5-video-support/"
                                                        target="_blank">supports HTML5 video</a>
                                                </p>
                                            </video> --}}
                                            <a href="{{ $cctv->liveViewUrl }}" target="_blank" class="btn btn-sm btn-primary">Buka
                                                Link</a>
                                        </td>
                                        <td>{{ $cctv->name }} <br>
                                            <div class="badge bg-{{ $cctv->getStatus()[1] }}">{{ $cctv->getStatus()[0] }}
                                            </div>
                                        </td>
                                        <td>{{ $cctv->location?->name }}</td>
                                        <td>{{ $cctv->getKelurahan() }}
                                        <td>{{ $cctv->rw }} | {{ $cctv->rt }}</td>
                                        </td>
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
@push('custom-scripts')
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
@endpush
