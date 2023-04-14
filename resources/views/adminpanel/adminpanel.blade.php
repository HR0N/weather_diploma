@extends('layouts.app')

@section('content')
    <div class="adminpanel_wrap">
        <div class="adminpanel">
            @foreach($data['groups'] as $group)
                <label>Make ur choose
                    <select name="groups" id="groups" class="form-control">
                        <option value="{{ $group['group_id'] }}">{{ $group['group_title'] }}</option>
                    </select>
                </label>
            @endforeach
        </div>
    </div>
@endsection
