@extends('backend_layouts.main')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <div class="row" id="app">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6 class="">Total CCTV</h6>
                            <h2 class="mb-0 number-font">@{{ data.totalCctv }}</h2>
                        </div>
                        <div class="ms-auto">
                            <div class="chart-wrapper mt-1">
                                <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6 class="">Total CCTV Hidup</h6>
                            <h2 class="mb-0 number-font">@{{ data.cctvHidup }}</h2>
                        </div>
                        <div class="ms-auto">
                            <div class="chart-wrapper mt-1">
                                <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6 class="">Total CCTV Mati</h6>
                            <h2 class="mb-0 number-font">@{{ data.cctvMati }}</h2>
                        </div>
                        <div class="ms-auto">
                            <div class="chart-wrapper mt-1">
                                <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6 class="">Total Pengecekan</h6>
                            <h2 class="mb-0 number-font">@{{ data.done_jobs }}/@{{ data.total_jobs }}</h2>
                        </div>
                        <div class="ms-auto">
                            <div class="chart-wrapper mt-1">
                                <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <form @submit.prevent="startQueue">
                    <button type="submit">Start Queue</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.2/axios.min.js"
        integrity="sha512-QTnb9BQkG4fBYIt9JGvYmxPpd6TBeKp6lsUrtiVQsrJ9sb33Bn9s0wMQO9qVBFbPX3xHRAsBHvXlcsrnJjExjg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const {
            createApp
        } = Vue

        createApp({
            data() {
                return {
                    message: 'Hello Vue!',
                    data: ""
                }
            },
            mounted() {
                this.getFirstBatch()
                window.setInterval(() => {
                    this.getFirstBatch()
                }, 2000)
            },
            methods: {
                getFirstBatch() {
                    axios.get("{{ route('getFirstBatch') }}")
                        .then((res) => {
                            this.data = res.data;
                        })
                },
                startQueue() {
                    axios.post("{{ route('work') }}")
                        .then((res) => {
                            console.log(res)
                        });
                }
            },
        }).mount('#app')
    </script>
@endpush
