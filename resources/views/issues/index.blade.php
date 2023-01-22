@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>{{ __('จุดตรวจสอบ การตรวจครั้งที่:') }} {{ $inspect->number }} </h3>
                    <div>
                        <a href="{{ route('inspects.index', ['project_id' => $project_id]) }}" class="btn btn-info">การตรวจสอบ</a>
                        <a href="{{ route('issues.create', ['project_id' => $project_id, 'inspect_id' => $inspect_id]) }}" class="btn btn-success">เพิ่ม</a>
                    </div>
                </div>

                <div class="card-body">
                    
                    <table id="my_table" class="table table-bordered table-responsive table-hover table-striped">
                        <thead>
                            <tr>
                                <th>การตรวจครั้งที่</th>
                                <th>หมายเลข</th>
                                <th>ชั้น</th>
                                <th>ปัญหา</th>
                                <th>สถานะ</th>
                                <th>ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issues as $issue)
                                <tr>
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
                                        <a href="{{ route('issues.show', [$project_id, $inspect_id, $issue]) }}" class="btn btn-success" style="display: inline-block;">รายละเอียด</a>
                                        <a href="{{ route('issues.edit', [$project_id, $inspect_id, $issue]) }}" class="btn btn-warning" style="display: inline-block;">แก้ไข</a>
                                        <form method="POST" action="{{ route('issues.destroy', [$project_id, $inspect_id, $issue]) }}" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"  onclick="return confirm('คุณต้องการลบ ใช่ หรือ ไม่')">ลบ</button>
                                        </form>   
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    
    <script>

        $(document).ready( function () {
            $('#my_table').DataTable();
        } );

    </script>
@endsection