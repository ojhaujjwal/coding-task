@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="page-header">
            <h2>{{trans('personal_details.title.list')}}</h2>
        </div>

        @if(!count($records))
            <div class="alert alert-info">
                {{trans('personal_details.messages.no_records')}}
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>{{trans('personal_details.SN')}}</th>
                        <th>{{trans('personal_details.label.name')}}</th>
                        <th>{{trans('personal_details.label.gender')}}</th>
                        <th>{{trans('personal_details.label.phone')}}</th>
                        <th>{{trans('personal_details.label.email')}}</th>
                        <th>{{trans('personal_details.label.nationality')}}</th>
                        <th>{{trans('personal_details.label.age')}}</th>
                    </tr>
                    @foreach($records as $i => $record)
                        <tr>
                            <td>{{$i + 1}}</td>
                            <td><a href="{{route('personal-details.view', ['id' => $record['id']])}}">{{$record['name']}}</a></td>
                            <td>{{trans('personal_details.gender.' . $genders[$record['gender']])}}</td>
                            <td>{{$record['phone']}}</td>
                            <td>{{$record['email']}}</td>
                            <td>{{$countries[$record['nationality']]}}</td>
                            <td>
                                @if($record['dob'])
                                    {{\Carbon\Carbon::createFromFormat('Y-m-d', $record['dob'])->age}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {!! $pagerfantaBarHtml !!}
        @endif
    </div>
@endsection
