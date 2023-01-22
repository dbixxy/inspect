@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>{{ __('Projects') }}</h3>
                    <a href="{{ route('projects.create') }}" class="btn btn-success">เพิ่ม</a>
                </div>

                <div class="card-body">
                    
                    <table id="my_table" class="table table-bordered table-responsive table-hover table-striped">
                        <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>ชื่อโครงการ</th>
                                <th>ลูกค้า</th>
                                <th>กิจกรรม</th>
                                <th>ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>
                                        {{ $project->created_at->format('Y-m-d') }}
                                    </td>
                                    <td>
                                        {{ $project->name }}
                                    </td>
                                    <td>
                                        {{ $project->customer->name }}
                                    </td>
                                    <td>
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-primary" style="display: inline-block;">รายละเอียด</a>
                                        <a href="{{ route('plans.index', $project) }}" class="btn btn-info" style="display: inline-block;">แปลน</a>
                                        <a href="{{ route('inspects.index', $project) }}" class="btn btn-info" style="display: inline-block;">การตรวจสอบ</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning" style="display: inline-block;">แก้ไข</a>
                                        <form method="POST" action="{{ route('projects.destroy', $project) }}" style="display: inline-block;">
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