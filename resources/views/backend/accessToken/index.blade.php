@extends('backend_layouts.main')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Token</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('accessToken.index') }}">Token</a></li>
                <li class="breadcrumb-item active" aria-current="page">Token Tabel</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Token</h3>
                </div>
                <div class="card-body">
                    <div class="text-end mb-2">
                        <form action="{{ route('accessToken.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Generate Token</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table border text-nowrap text-md-nowrap table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Token</th>
                                    <th>Used</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accessTokens as $accessToken)
                                    <tr>
                                        <td>{{ $accessToken->token }}</td>
                                        <td>{{ $accessToken->used }}</td>
                                        <td>
                                            <form action="{{ route('accessToken.destroy', $accessToken->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{ route('accessToken.edit', $accessToken->id) }}">
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
                        {{ $accessTokens->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
