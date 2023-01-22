@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-header">{{ __('Project') }}</div>

                <div class="card-body">

                    <div class="form-group">
                        <label for="project_name">ชื่อ Project:</label> {{ $project->name }}
                    </div>
                    <div class="form-group">
                        <label for="customer_name">ชื่อลูกค้า:</label> {{ $project->customer->name }}
                    </div>
                    <div class="form-group">
                        <label for="customer_phone_number">เบอร์โทรศัพท์ ลูกค้า:</label> {{ $project->customer->phone_number }}
                    </div>
                    <div class="form-group">
                        <label for="development_name">ชื่อโครงการ:</label> {{ $project->development_name }}
                    </div>
                    <div class="form-group">
                        <label for="property_type">ประเภท:</label> {{ $project->property_type }}
                    </div>
                    <div class="form-group">
                        <label for="area_name">แปลง:</label> {{ $project->area_name }}
                    </div>
                    <div class="form-group">
                        <label for="gps_position">ตำแหน่งพิกัด GPS :</label> {{ $project->gps_position }}
                        <button type="button" class="btn btn-primary" onclick="openMap({{ $project->gps_position }})">เปิด</button>
                        <button type="button" class="btn btn-primary" onclick="copyToClipboard('{{ $project->gps_position }}')">Copy</button>
                    </div>
                    <div class="form-group">
                        <label for="image_file">Cover Image:</label><br>
                        <img src="{{ Storage::url($project->image) }}" style="max-width: 100%; max-height: 300px;">
                    </div>


                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header">{{ __('แปลน') }}</div>
            <div class="card-body">
                @if(!empty($project->plans))
                    @foreach($project->plans as $plan)
                        <div class="form-group">
                            <label for="img_plan_id_{{ $plan->id }}">ชื่อแปลน: </label> {{ $plan->name }} ชั้น {{ $plan->floor_number }}
                            @if(!empty($plan->image))
                                <img src="{{ Storage::url($plan->image) }}" id="img_plan_id_{{ $plan->id }}" style="width: 100%; position: relative;" >
                                <div class="" id="container_img_plan_id_{{ $plan->id }}">
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    
        <div class="card">
            <div class="card-header">{{ __('จุดตรวจสอบ') }}</div>
            <div class="card-body">
                @if(!empty($project->issues))
                    <table id="my_table" class="table table-bordered table-responsive table-hover table-striped">
                        <thead>
                            <tr>
                                <th>การตรวจครั้งที่</th>
                                <th>หมายเลข</th>
                                <th>ชั้น</th>
                                <th>ปัญหา</th>
                                <th>แนวทางแก้ปัญหา</th>
                                <th>สถานะ</th>
                                <th>ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($project->issues as $issue)
                                <tr id="issue_id_{{ $issue->id }}">
                                    <td>
                                        {{ $issue->inspect->number }}
                                    </td>
                                    <td>
                                        {{ $issue->number }}
                                    </td>
                                    <td>
                                        {{ $issue->plan->floor_number }}
                                    </td>
                                    <td>
                                        {{ $issue->problem }}
                                    </td>
                                    <td>
                                        {{ $issue->suggest }}
                                    </td>
                                    <td>
                                        @if($issue->is_closed)
                                            <span class="text-success">สำเร็จ ตรวจครั้งที่ 
                                                @if(!empty($issue->closeAtInspect))
                                                    {{ $issue->closeAtInspect->number }}
                                                @endif    
                                            </span>
                                        @else
                                            <span class="text-danger">ยังไม่ผ่าน</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('issues.show', [$project->id, $issue->inspect->id, $issue]) }}" class="btn btn-success" style="display: inline-block;">รายละเอียด</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- Modal HTML -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<div class="icon-box">
					<i class="material-icons">&#xE876;</i>
				</div>
				{{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="closeModal()">&times;</button> --}}
			</div>
			<div class="modal-body text-center">
				<h4 id="alert-modal-title">Great!</h4>	
				<p id="alert-modal-content">Your account has been created successfully.</p>
				<button class="btn btn-success" data-dismiss="modal" onclick="closeModal()"><span>ปิด</span></button>
			</div>
		</div>
	</div>
</div> 

@endsection

@section('script')
<script>

    $(document).ready(function(){
        addMarker();
    });

    function openMap(latitude, longitude) {
        window.open(`https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`, "_blank");
    }

    function copyToClipboard(text) {
        var dummy = document.createElement("textarea");
        // to avoid breaking orgain page when copying more words
        // cant copy when adding below this code
        // dummy.style.display = 'none'
        document.body.appendChild(dummy);
        //Be careful if you use texarea. setAttribute('value', value), which works with "input" does not work with "textarea". – Eduard
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);

        $('#alert-modal-title').text('สำเร็จ');
        $('#alert-modal-content').text('copy to clipboard');
        $('#myModal').modal('show');
        
    }

    function closeModal(){
        $('#myModal').modal('hide');
    }

    function addMarker(){
        var element, activeTarget, ratioX, ratioY, imgX, imgY, x, y;
        @if(!empty($project->issues))
            @foreach($project->issues as $issue)
                element = document.getElementById("img_plan_id_" + {{ $issue->plan->id }}); 
                if(element){
                    activeTarget = element;
                    ratioX = activeTarget.naturalWidth / activeTarget.offsetWidth;
                    ratioY = activeTarget.naturalHeight / activeTarget.offsetHeight;
                    imgX = {{ $issue->position_x }};
                    imgY = {{ $issue->position_y }};
                    x = Math.round(imgX / ratioX) + 16;
                    y = Math.round(imgY / ratioY) + 105;

                    var marker = $('<div>').css({
                        'position':'absolute',
                        'left':x+'px',
                        'top':y+'px',
                        'display' : 'block',
                        'z-index':'1'
                    });
                    marker.addClass("marker-block");
                    marker.attr("id", "marker_issue_id_" + {{ $issue->id }});
                    marker.text("{{ $issue->number }}");
                    var link = $('<a>').attr('href', '#issue_id_' + {{ $issue->id }});
                    link.append(marker);
                    $("#container_img_plan_id_" +  {{ $issue->plan->id }}).append(link);
                }
            @endforeach
        @endif
        
    }

</script>

@endsection