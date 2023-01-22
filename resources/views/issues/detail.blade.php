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
                <div class="card-header d-flex justify-content-between">
                    <h3>{{ __('จุดตรวจสอบ:') }} {{ $issue->number }} </h3>
                    <div>
                        <a href="{{ route('issues.index', ['project_id' => $project_id, 'inspect_id' => $inspect_id]) }}" class="btn btn-info">รายการจุดตรวจสอบ</a>
                    </div>
                </div>
                <div class="card-body">
                        <div class="form-group">
                            <label for="plan_id">แปลน: </label> {{ $issue->plan->name }} ชั้น {{ $issue->plan->floor_number }}
                            
                            <br>
                            <img id="image_plan" class="plan_image" src="{{ Storage::url($issue->plan->image) }}" style="width: 100%; display: block" >
                            <div class="form-group" id="plan-image-container">
                                <img src="{{ asset('image/marker.png') }}" id="marker" width="32px" style="display: none;">
                            </div>
                            <input type="hidden" id="position_x" name="position_x" value="{{ $issue->position_x }}">
                            <input type="hidden" id="position_y" name="position_y" value="{{ $issue->position_y }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="issue_number">จุดตรวจที่:</label> {{ $issue->number }}
                        </div>
                        <br>
                        @if(!empty($issue->referenceIssue))
                            <div class="form-group">
                                <label for="ref_issue_id">อ้างอิงจาก จุดตรวจที่:</label>  {{ $issue->referenceIssue->number }} 
                                <a href="{{ route('issues.show', [$project_id, $inspect_id, $issue->referenceIssue]) }}" class="btn btn-success" style="display: inline-block;" target="_blank">เปิดจุดอ้างอิง</a>
                            </div>
                            <br>
                        @endif
                        <div class="form-group">
                            <label for="problem">ปัญหา:</label>
                            <br>
                            {{ $issue->problem }}
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="suggest">แนวทางแก้ปัญหา:</label>
                            <br>
                            {{ $issue->suggest }}
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="is_closed">เสร็จ:</label> 
                            @if($issue->is_closed)
                                <span class="text-success">สำเร็จ ตรวจครั้งที่ 
                                    @if(!empty($issue->closeAtInspect))
                                        {{ $issue->closeAtInspect->number }}
                                    @endif    
                                </span>
                            @else
                                <span class="text-danger">ยังไม่ผ่าน</span>
                            @endif
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="files">Image Files:</label>
                            <br>
                            @if(!empty($issue_files))
                                @foreach($issue_files as $issue_file)
                                    <div class="div-img-preview col-6 col-md-4 col-lg-3 col-xl-2" id="div_issue_file_id_{{ $issue_file->id }}">
                                        <a href="{{ Storage::url($issue_file->file) }}" target="_blank"><img src="{{ Storage::url($issue_file->file) }}" class="img-preview" ></a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        var activeTarget;

        $(document).ready(function(){
            @if(!empty($issue))
                showMarker();
            @endif
        });

        $(window).on('resize', function(){
            showMarker();
        });

        function showMarker(){
            var element = document.getElementById("image_plan"); 
            activeTarget = element;
            var ratioX = activeTarget.naturalWidth / activeTarget.offsetWidth;
            var ratioY = activeTarget.naturalHeight / activeTarget.offsetHeight;
            var imgX = $("#position_x").val();
            var imgY = $("#position_y").val();
            var x = Math.round(imgX / ratioX) + 16;
            var y = Math.round(imgY / ratioY) + 105;
            var marker = $('#marker').css({
                'position':'absolute',
                'left':x+'px',
                'top':y+'px',
                'display' : 'block',
                'z-index':'1'
            });

        }

    </script>
@endsection