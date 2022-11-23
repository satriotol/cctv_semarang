@extends('backend_layouts.main')
@push('style')
    <style>
        #map {
            height: 280px;
        }
    </style>
@endpush
@section('content')
    <div class="page-header">
        <h1 class="page-title">CCTV</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cctv.index') }}">CCTV</a></li>
                <li class="breadcrumb-item active" aria-current="page">CCTV Tabel</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form CCTV</h3>
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    <form
                        action="@isset($cctv) {{ route('cctv.update', $cctv->id) }} @endisset @empty($cctv) {{ route('cctv.store') }} @endempty"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($cctv)
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control"
                                value="{{ isset($cctv) ? $cctv->name : @old('name') }}" required name="name">
                        </div>
                        <div id="map"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="text" class="form-control"
                                        value="{{ isset($cctv) ? $cctv->latitude : @old('latitude') }}" name="latitude">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="text" class="form-control"
                                        value="{{ isset($cctv) ? $cctv->longitude : @old('longitude') }}" name="longitude">
                                </div>
                            </div>
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        var map = L.map('map', {
            doubleClickZoom: false
        }).locate({
            setView: true,
            maxZoom: 16
        });
        var theMarker = {};

        function addMarker(e) {
            var newMarker = L.marker(e.latlng).addTo(map);
        }
        @isset($cctv)
            L.marker([$('input[name=latitude]').val(), $('input[name=longitude]').val()]).addTo(map)
                .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                .openPopup();
        @endisset
        map.on('click', function(e) {
            lat = e.latlng.lat;
            lon = e.latlng.lng;
            console.log("You clicked the map at LAT: " + lat + " and LONG: " + lon);
            if (theMarker != undefined) {
                map.removeLayer(theMarker);
            };
            $('input[name=latitude]').val(lat);
            $('input[name=longitude]').val(lon);
            theMarker = L.marker([lat, lon]).addTo(map);
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    </script>
@endpush
