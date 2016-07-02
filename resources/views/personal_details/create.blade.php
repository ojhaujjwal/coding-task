@extends('layouts.main')

@section('head')
    <link href="/lib/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="/lib/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.4.3/parsley.min.js"></script-->
    <script src="/js/personal-details/create.js"></script>
@endsection

@section('content')

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <form action="{{route('personal-details.create')}}" method="POST" class="form-horizontal" id="personal-details-form">
        {{ csrf_field() }}

        <div class="row form-group">
            <div class="col-md-6">
                <label for="name" class="col-sm-4 control-label">{{trans('personal_details.label.name')}}</label>

                <div class="col-sm-8">
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <br/>
                <ul id="error-name"></ul>
            </div>
            <div class="col-md-6">
                <label for="gender" class="col-sm-4 control-label">{{trans('personal_details.label.gender')}}</label>

                <div class="col-sm-8">
                    <select name="gender" id="gender" class="form-control" required>
                        @foreach($genders as $key => $value)
                            <option value="{{$value}}">{{trans('personal_details.gender.' . $key)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <label for="phone" class="col-sm-4 control-label">{{trans('personal_details.label.phone')}}</label>

                <div class="col-sm-8">
                    <input type="tel" name="phone" id="phone" class="form-control" required>
                </div>
                <br/>
                <ul id="error-phone"></ul>
            </div>
            <div class="col-md-6">
                <label for="email" class="col-sm-4 control-label">{{trans('personal_details.label.email')}}</label>

                <div class="col-sm-8">
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <br/>
                <ul id="error-email"></ul>
            </div>
        </div>

        <div class="row form-group">
            <label for="address" class="col-sm-2 control-label">{{trans('personal_details.label.address')}}</label>

            <div class="col-sm-10">
                <input type="text" name="address" id="address" class="form-control">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <label for="nationality" class="col-sm-4 control-label">{{trans('personal_details.label.nationality')}}</label>

                <div class="col-sm-8">
                    <select name="nationality" id="nationality" class="form-control" nationality>
                        @foreach($countries as $countryCode => $country)
                            <option value="{{$countryCode}}">{{$country}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label for="dob" class="col-sm-4 control-label">{{trans('personal_details.label.dob')}}</label>

                <div class="col-sm-8">
                    <input type="text" name="dob" id="dob" class="form-control" data-provide="datepicker"
                           data-date-format="yyyy-mm-dd" data-date-end-date="0d">
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label for="preferred_contact_mode" class="col-sm-4">{{trans('personal_details.label.preferred_contact_mode')}}</label>
                <div class="col-sm-8">
                    <select name="preferred_contact_mode" id="preferred_contact_mode" class="form-control" required>
                        @foreach($contactModes as $key => $value)
                            <option value="{{$value}}">{{trans('personal_details.contact_modes.' . $key)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <label for="educational_background" class="col-sm-2 control-label">{{trans('personal_details.label.educational_background')}}</label>

            <div class="col-sm-10">
                <textarea name="educational_background" id="educational_background" class="form-control"></textarea>
            </div>
        </div>

        <!-- Add Task Button -->
        <div class="form-group col-md-6">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> {{trans('personal_details.add')}}
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
