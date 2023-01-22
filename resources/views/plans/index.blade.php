@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>{{ __('แปลน') }}</h3>
                    <a href="{{ route('plans.create', ['project_id' => $project_id]) }}" class="btn btn-success">เพิ่ม</a>
                </div>

                <div class="card-body">
                    
                    <table id="my_table" class="table table-bordered table-responsive table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ชั้น</th>
                                <th>ชื่อแปลน</th>
                                <th>รูปภาพ</th>
                                <th>ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plans as $plan)
                                <tr>
                                    <td>
                                        {{ $plan->floor_number }}
                                    </td>
                                    <td>
                                        {{ $plan->name }}
                                    </td>
                                    <td>
                                        <a href="{{ Storage::url($plan->image) }}" target="_blank"><img src="{{ Storage::url($plan->image) }}" style="max-width: 100%; max-height: 300px;"></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('plans.edit', [$project_id, $plan]) }}" class="btn btn-warning" style="display: inline-block;">แก้ไข</a>
                                        <form method="POST" action="{{ route('plans.destroy', [$project_id, $plan]) }}" style="display: inline-block;">
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