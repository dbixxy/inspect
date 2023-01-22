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
                <div class="card-header">{{ __('จุดตรวจสอบ การตรวจครั้งที่:') }}{{ $inspect->number }} </div>

                <div class="card-body">
                    <form method="POST" action="{{ !empty($issue) ? route('issues.update', [$project_id, $inspect_id, $issue]) : route('issues.store', [$project_id, $inspect_id]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="project_id" name="project_id" value="{{ $project_id }}">
                        <input type="hidden" id="inspect_id" name="inspect_id" value="{{ $inspect_id }}">
                        @if(!empty($issue))
                            @method('PUT')
                            <input type="hidden" id="issue" name="issue_id" value="{{ $issue->id }}">
                        @endif
                        <div class="form-group">
                            <label for="plan_id">แปลน:</label>
                            <select id="plan_id" name="plan_id" class="form-control"  onchange="showPlanImage()">
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                @endforeach
                            </select>
                            <br>
                            @foreach($plans as $plan)
                                <img id="image_plan_id_{{ $plan->id }}" class="plan_image" src="{{ Storage::url($plan->image) }}" style="width: 100%; display: none" >
                                <br>
                            @endforeach
                            <div class="form-group" id="plan-image-container">
                                <img src="{{ asset('image/marker.png') }}" id="marker" width="32px" style="display: none;">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="position_x">position x:</label>
                                <input type="number" class="form-control" id="position_x" name="position_x" value="{{ old('position_x', $issue->position_x ?? 0) }}">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="position_y">position y:</label>
                                <input type="number" class="form-control" id="position_y" name="position_y" value="{{ old('position_y', $issue->position_y ?? 0) }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="issue_number">จุดตรวจที่:</label>
                            <input type="number" class="form-control" id="issue_number" name="number" min="1" step="1" value="{{ old('number', $issue->number ?? $issue_count) }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="ref_issue_id">อ้างอิงจาก จุดตรวจที่:</label>
                            <select id="ref_issue_id" name="ref_issue_id" class="form-control">
                                <option value="" selected>เลือกจุดตรวจอ้างอิง</option>
                                @foreach($issues as $ref_issue)
                                    <option value="{{ $ref_issue->id }}">{{ $ref_issue->number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="problem">ปัญหา:</label>
                            <textarea class="form-control" id="problem" name="problem" >{{ old('problem', $issue->problem ?? '') }}</textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="suggest">แนวทางแก้ปัญหา:</label>
                            <textarea class="form-control" id="suggest" name="suggest" >{{ old('suggest', $issue->suggest ?? '') }}</textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="is_closed">เสร็จ:</label>
                            <input type="checkbox" id="is_closed" name="is_closed" value="1" {{ old('is_closed', $issue->is_closed ?? '') ? 'checked' : '' }} >
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="files">Image Files (Upload Files):</label>
                            <input type="file" accept="image/*" class="form-control-file" id="files" name="files[]"  value="{{ old('files') }}" multiple>
                            <br>
                            @if(!empty($issue_files))
                                @foreach($issue_files as $issue_file)
                                    <div class="div-img-preview col-6 col-md-4 col-lg-3 col-xl-2" id="div_issue_file_id_{{ $issue_file->id }}">
                                        <a href="{{ Storage::url($issue_file->file) }}" target="_blank"><img src="{{ Storage::url($issue_file->file) }}" class="img-preview" ></a>
                                        <img src="{{ asset('image/close.png') }}" class="img-close" style="height: 24px;" onclick="return deleteIssueFile({{ $issue_file->id }})">
                                    </div>
                                @endforeach
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
        var activeTarget;

        $(document).ready(function(){
            $('.plan_image').css('display','none');
            showPlanImage();
            @if(!empty($issue))
                showMarker();
            @endif
        });


        $(".plan_image").click(function(e) {
            activeTarget = e.target;
            var ratioX = e.target.naturalWidth / e.target.offsetWidth;
            var ratioY = e.target.naturalHeight / e.target.offsetHeight;
            var imgX = Math.round(e.offsetX * ratioX);
            var imgY = Math.round(e.offsetY * ratioY);

            console.log(imgX, imgY);

            $("#position_x").val(imgX);
            $("#position_y").val(imgY);

            var x = Math.round(imgX / ratioX) + 16;
            var y = Math.round(imgY / ratioY) + 105;
            var marker = $('#marker').css({
                'position':'absolute',
                'left':x+'px',
                'top':y+'px',
                'display' : 'block',
                'z-index':'1'
            });
        });

        $(window).on('resize', function(){
            showMarker();
        });


        function showPlanImage(){
            $('.plan_image').css('display','none');
            var select_plan = $("#plan_id");
            var element_id = select_plan.val();
            var element = $("#image_plan_id_" + element_id); 
            element.css('display','block');
        }


        function showMarker(){
            var select_plan = $("#plan_id");
            var element_id = select_plan.val();
            var element = document.getElementById("image_plan_id_" + element_id); 
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

        function deleteIssueFile(issue_file_id){
            $confirm = confirm('คุณต้องการลบ ใช่ หรือ ไม่');
            if($confirm){
                document.getElementById('div_issue_file_id_' + issue_file_id).remove();
                axios.delete('/issueFiles/' + issue_file_id, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        // handle success
                        console.log(response.data);
                    })
                    .catch(error => {
                        // handle error
                        console.log(error);
                    });
            }
            return $confirm;
        }
    </script>
@endsection