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
                <div class="card-header">{{ __('Project') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ !empty($project) ? route('projects.update', $project->id) : route('projects.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($project))
                            @method('PUT')
                            <input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
                            <input type="hidden" id="customer_id" name="customer_id" value="{{ $project->customer->id }}">
                        @endif
                        <div class="form-group">
                            <label for="project_name">ชื่อ Project:</label>
                            <input type="text" class="form-control" id="project_name" name="project_name" value="{{ old('project_name', $project->name ?? '') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="customer_name">ชื่อลูกค้า:</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name', $project->customer->name ?? '') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="customer_phone_number">เบอร์โทรศัพท์ ลูกค้า:</label>
                            <input type="text" class="form-control" id="customer_phone_number" name="customer_phone_number" value="{{ old('customer_phone_number', $project->customer->phone_number ?? '') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="development_name">ชื่อโครงการ:</label>
                            <input type="text" class="form-control" id="development_name" name="development_name" value="{{ old('development_name', $project->development_name ?? '') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="property_type">ประเภท:</label>
                            <input type="text" class="form-control" id="property_type" name="property_type" value="{{ old('property_type', $project->property_type ?? '') }}">
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="area_name">แปลง:</label>
                            <input type="text" class="form-control" id="area_name" name="area_name" value="{{ old('area_name', $project->area_name ?? '') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="gps_position">ตำแหน่งพิกัด GPS :</label>
                            <button type="button" class="btn btn-primary" onclick="getGpsPosition()">Get</button>
                            <input type="text" class="form-control" id="gps_position" name="gps_position" value="{{ old('gps_position', $project->gps_position ?? '') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="image_file">Cover Image (Upload File):</label>
                            <input type="file" accept="image/*" class="form-control-file" id="image_file" name="image_file"  value="{{ old('image_file') }}">
                            @if(!empty($project->image))
                                <img src="{{ Storage::url($project->image) }}" style="width: 100%; max-height: 300px;">
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
    
    <script>

        function getGpsPosition(){
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    console.log("Latitude: " + latitude + ", Longitude: " + longitude);
                    $("#gps_position").val(latitude + ", " + longitude);
                });
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

    </script>
@endsection