@extends('layouts.admin')
@section('page-title')
    {{ __('P11 Report') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('P11 Report') }}</li>
@endsection

@section('content')
     <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class=" mt-2 " id="multiCollapseExample1" style="">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['report.p11-report'], 'method' => 'get', 'id' => 'timesheet_filter']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                                <div class="btn-box">
                                    {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                                    {{ Form::text('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : '', ['class' => 'month-btn form-control d_week current_date start_date', 'autocomplete' => 'off']) }}
                                    
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                                <div class="btn-box">
                                    {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                                    {{ Form::text('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : '', ['class' => 'month-btn form-control d_week current_date end_date', 'autocomplete' => 'off']) }}
                                </div>
                        </div>
                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('timesheet_filter').submit(); return false;"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('report.p11-report') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="Reset">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div> 

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    @if (\Auth::user()->type != 'employee')
                                        <th>{{ __('Employee Id') }}</th>
                                        <th>{{ __('Employee Name') }}</th>
                                    @endif
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Date Requested') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($eclaims as $eclaim)
                                    <tr>
                                        @if (\Auth::user()->type != 'employee')
                                            <td>
                                                <a href="#" class="btn btn-outline-primary">{{ \Auth::user()->employeeIdFormat($eclaim->employee_id) }}</a>
                                            </td>
                                            <td>{{ !empty($eclaim->employee) ? $eclaim->employee->name : '' }}</td>
                                        @endif
                                        <td>{{env('CURRENCY_SYMBOL') ?? '£'}}{{ $eclaim->amount }}</td>
                                        <td>
                                            @if($eclaim->status=="pending")
                                                <button class="btn bg-warning btn-sm">{{ucfirst($eclaim->status)}}</button>
                                            @elseif($eclaim->status=="approved by HR")
                                                <button class="btn bg-info btn-sm">{{ucfirst($eclaim->status)}}</button>
                                            @elseif($eclaim->status=="approved")
                                                <button class="btn bg-success btn-sm">{{ucfirst($eclaim->status)}}</button>
                                            @else
                                                <button class="btn bg-danger btn-sm">{{ucfirst($eclaim->status)}}</button>
                                            @endif
                                        </td>
                                        <td>{{ \Auth::user()->dateFormat($eclaim->created_at) }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <h4>Total Amount: {{$totalAmount}} </h4>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('script-page')
        <script>
            $(document).ready(function() {
                var now = new Date();
                var month = (now.getMonth() + 1);
                var day = now.getDate();
                if (month < 10) month = "0" + month;
                if (day < 10) day = "0" + day;
                var today = now.getFullYear() + '-' + month + '-' + day;
                $('.current_date').val(today);
            });
        </script>
    @endpush