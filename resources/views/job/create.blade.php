@php
$chatgpt = Utility::getValByName('enable_chatgpt');
@endphp

@extends('layouts.admin')
@section('page-title')
{{ __('Create Job') }}
@endsection
@push('css-page')
<link href="{{ asset('public/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/summernote/summernote-bs4.css') }}">
@endpush
@push('script-page')
<!-- <script src='{{ asset('assets/js/plugins/tinymce/tinymce.min.js') }}'></script>  -->
<script src="{{ asset('public/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<script>
    var e = $('[data-toggle="tags"]');
    e.length && e.each(function() {
        $(this).tagsinput({
            tagClass: "badge badge-primary"
        })
    });
</script>
<script src="{{ asset('css/summernote/summernote-bs4.js') }}"></script>

<script>
    $(document).on('change', 'select[name=branch]', function() {
        var branch_id = $(this).val();
        console.log(branch_id);
        getDepartment(branch_id);
    });

    function getDepartment(bid) {
        console.log("CSRF Token: {{ csrf_token() }}");

        $.ajax({
            url: '{{ route('monthly.getdepartment') }}',
            type: 'POST',
            data: {
                "branch_id": bid,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                $('.department_id').empty();
                var emp_select = `<select class="form-control department_id" name="department" placeholder="Select Department"></select>`;
                $('.department_div').html(emp_select);

                $('.department_id').append('<option value=""> {{ __('
                    Select Department ') }} </option>');
                $.each(data, function(key, value) {
                    $('.department_id').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }
</script>
@endpush

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
<li class="breadcrumb-item"><a href="{{ route('job.index') }}">{{ __('Manage Job') }}</a></li>
<li class="breadcrumb-item">{{ __('Create Job') }}</li>
@endsection


@section('content')
@if ($chatgpt == 'on')
<div class="text-end">
    <a href="#" class="btn btn-sm btn-primary" data-size="medium" data-ajax-popup-over="true" data-url="{{ route('generate', ['job']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
        <i class="fas fa-robot"></i>{{ __(' Generate With AI') }}
    </a>
</div>
@endif

{{ Form::open(['url' => 'job', 'method' => 'post']) }}
<div class="row mt-3">
    <div class="col-md-6 ">
        <div class="card card-fluid job-card">
            <div class="card-body ">
                <div class="row">
                    <div class="form-group col-md-12">
                        {!! Form::label('title', __('Job Title'), ['class' => 'col-form-label']) !!}
                        {!! Form::text('title', old('title'), [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder' => 'Enter job title',
                        ]) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('branch', __('Branch'), ['class' => 'col-form-label']) !!}
                        {{ Form::select('branch', $branches, null, ['class' => 'form-control select2', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('department_id', __('Department'), ['class' => 'col-form-label']) }}
                        <select class="form-control department_id" name="department" id="department_id" placeholder="Select Department">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contract_type" class="col-form-label">{{ __('Contract Type') }}</label>
                        <select name="contract_type" id="contract_type" class="form-control select2" required>
                            <option value="">Select Contract Type</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Apprenticeship">Apprenticeship</option>
                            <option value="Zero Hours">Zero Hours</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('category', __('Job Category'), ['class' => 'col-form-label']) !!}
                        {{ Form::select('category', $categories, null, ['class' => 'form-control select2', 'required' => 'required']) }}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('position', __('No. of Positions'), ['class' => 'col-form-label']) !!}
                        {!! Form::text('position', old('positions'), [
                        'class' => 'form-control',
                        'required' => 'required',
                        'placeholder' => 'Enter job Positions',
                        ]) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('status', __('Status'), ['class' => 'col-form-label']) !!}
                        {{ Form::select('status', $status, null, ['class' => 'form-control select2', 'required' => 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) !!}
                        {!! Form::date('start_date', old('start_date'), [
                        'class' => 'form-control current_date',
                        'autocomplete' => 'off',
                        'placeholder' => 'Select start date',
                        ]) !!}
                    </div>
                    <div class="form-group col-md-6">
                        {!! Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) !!}
                        {!! Form::date('end_date', old('end_date'), [
                        'class' => 'form-control current_date',
                        'autocomplete' => 'off',
                        'placeholder' => 'Select end date',
                        ]) !!}
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-form-label" for="skill">{{ __('Skill Box') }}</label>
                        <input type="text" class="form-control" value="" data-toggle="tags" name="skill" placeholder="Skill" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="card card-fluid job-card">
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h6>{{ __('Need to Ask ?') }}</h6>
                            <div class="my-4">
                                <div class="form-check custom-checkbox">
                                    <input type="checkbox" class="form-check-input" name="applicant[]" value="gender" id="check-gender">
                                    <label class="form-check-label" for="check-gender">{{ __('Gender') }} </label>
                                </div>
                                <div class="form-check custom-checkbox">
                                    <input type="checkbox" class="form-check-input" name="applicant[]" value="dob" id="check-dob">
                                    <label class="form-check-label" for="check-dob">{{ __('Date Of Birth') }}</label>
                                </div>
                                <div class="form-check custom-checkbox">
                                    <input type="checkbox" class="form-check-input" name="applicant[]" value="address" id="check-address">
                                    <label class="form-check-label" for="check-address">{{ __('Address') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h6>{{ __('Need to show Options ?') }}</h6>
                            <div class="my-4">
                                <div class="form-check custom-checkbox">
                                    <input type="checkbox" class="form-check-input" name="visibility[]" value="profile" id="check-profile">
                                    <label class="form-check-label" for="check-profile">{{ __('Profile Image') }}
                                    </label>
                                </div>
                                <div class="form-check custom-checkbox">
                                    <input type="checkbox" class="form-check-input" name="visibility[]" value="resume" id="check-resume">
                                    <label class="form-check-label" for="check-resume">{{ __('Resume') }}</label>
                                </div>
                                <div class="form-check custom-checkbox">
                                    <input type="checkbox" class="form-check-input" name="visibility[]" value="letter" id="check-letter">
                                    <label class="form-check-label" for="check-letter">{{ __('Cover Letter') }}</label>
                                </div>
                                <div class="form-check custom-checkbox">
                                    <input type="checkbox" class="form-check-input" name="visibility[]" value="terms" id="check-terms">
                                    <label class="form-check-label" for="check-terms">{{ __('Terms And Conditions') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <h6>{{ __('Custom Questions') }}</h6>
                        <div class="my-4">
                            @foreach ($customQuestion as $question)
                            <div class="form-check custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="custom_question[]" value="{{ $question->id }}" @if ($question->is_required == 'yes') required @endif
                                id="custom_question_{{ $question->id }}">
                                <label class="form-check-label" for="custom_question_{{ $question->id }}">{{ $question->question }}
                                    @if ($question->is_required == 'yes')
                                    <span class="text-danger">*</span>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        {!! Form::label('question-template', __('Questions Template'), ['class' => 'col-form-label']) !!}
                        {{ Form::select('question-template', [Qualification', 'Extra skills'], null, ['class' => 'form-control select2']) }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-fluid job-card">
            <div class="card-body ">
                <div class="row">
                    <div class="form-group col-md-12">
                        {!! Form::label('description', __('Job Description'), ['class' => 'col-form-label']) !!}
                        <textarea class="form-control editor summernote-simple-2" name="description" id="description" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-fluid job-card">
            <div class="card-body ">
                <div class="row">
                    <div class="form-group col-md-12">
                        {!! Form::label('requirement', __('Job Requirement'), ['class' => 'col-form-label']) !!}
                        @if ($chatgpt == 'on')
                        <a href="#" data-size="md" class="btn btn-primary btn-icon btn-sm float-end" data-ajax-popup-over="true" id="grammarCheck" data-url="{{ route('grammar', ['grammar']) }}" data-bs-placement="top" data-title="{{ __('Grammar check with AI') }}">
                            <i class="ti ti-rotate"></i> <span>{{ __('Grammar check with AI') }}</span>
                        </a>
                        @endif
                        <textarea class="form-control editor summernote-simple" name="requirement" id="requirement" rows="3"></textarea>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-end row">
        <div class="form-group">
            <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
        </div>
    </div>
    {{ Form::close() }}
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
