@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            
            @if($errors->any())
                <div class="text-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            

            <div class="card">
                <div class="card-header">{{ __('แปลน') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ !empty($plan) ? route('plans.update', [$project_id, $plan]) : route('plans.store', $project_id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="project_id" name="project_id" value="{{ $project_id }}">
                        @if(!empty($plan))
                            @method('PUT')
                            <input type="hidden" id="plan" name="plan_id" value="{{ $plan->id }}">
                        @endif
                        <div class="form-group">
                            <label for="plan_name">ชื่อแปลน:</label>
                            <input type="text" class="form-control" id="plan_name" name="name" value="{{ old('name', $plan->name ?? '') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="floor_number">หมายเลขชั้น:</label>
                            <input type="text" class="form-control" id="floor_number" name="floor_number" value="{{ old('floor_number', $plan->floor_number ?? '') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="image">Cover Image (Upload File):</label>
                            <input type="file" accept="image/*" class="form-control-file" id="image" name="image"  value="{{ old('image') }}">
                            <br>
                            @if(!empty($plan->image))
                                <img src="{{ Storage::url($plan->image) }}" style="max-width: 100%; max-height: 300px;">
                            @endif
                        </div>
                        <br>
                        <div class="form-group row">
                            <button type="submit" class="col-6 btn btn-success">บันทึก</button>
                            <button type="button" class="col-6 btn btn-danger" onclick="history.back()">ยกเลิก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    
@endsection