@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="page-header">
            <h2>{{trans('personal_details.title.view')}}</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                  <li class="list-group-item">
                    <span class="badge">{{$personalDetails['name']}}</span>
                    {{trans('personal_details.label.name')}}
                  </li>
                  <li class="list-group-item">
                    <span class="badge">{{$personalDetails['phone']}}</span>
                    {{trans('personal_details.label.phone')}}
                  </li>
                  <li class="list-group-item">
                    <span class="badge">
                        {{$personalDetails['dob']}}
                    </span>
                    {{trans('personal_details.label.dob')}}
                  </li>
                  <li class="list-group-item">
                    <span class="badge">{{$contactModes[$personalDetails['preferred_contact_mode']]}}</span>
                    {{trans('personal_details.label.preferred_contact_mode')}}
                  </li>                                   
                </ul>                
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                  <li class="list-group-item">
                    <span class="badge">
                        {{trans('personal_details.gender.' . $genders[$personalDetails['gender']])}}
                    </span>
                    {{trans('personal_details.label.gender')}}
                  </li>
                  <li class="list-group-item">
                    <span class="badge">{{$personalDetails['email']}}</span>
                    {{trans('personal_details.label.email')}}
                  </li>
                  <li class="list-group-item">
                    <span class="badge">
                        {{$countries[$personalDetails['nationality']]}}
                    </span>
                    {{trans('personal_details.label.nationality')}}
                  </li>                                    
                </ul>                
            </div>            
        </div>
        <div class="row">
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="badge">{{$personalDetails['address']}}</span>
                    {{trans('personal_details.label.address')}}
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">{{trans('personal_details.label.educational_background')}}</h3>
              </div>
              <div class="panel-body">
                {!! nl2br(e($personalDetails['educational_background'])) !!}
              </div>
            </div>            
        </div>
    </div>
@endsection
