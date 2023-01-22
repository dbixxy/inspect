@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>{{ __('การตรวจสอบ') }}</h3>
                    <a href="{{ route('inspects.create', ['project_id' => $project_id]) }}" class="btn btn-success">เพิ่ม</a>
                </div>

                <div class="card-body">
                    
                    <table id="my_table" class="table table-bordered table-responsive table-hover table-striped">
                        <thead>
                            <tr>
                                <th>การตรวจครั้งที่</th>
                                <th>วันที่เริ่ม</th>
                                <th>วันที่สิ้นสุด</th>
                                <th>ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inspects as $inspect)
                                <tr>
                                    <td>
                                        {{ $inspect->number }}
                                    </td>
                                    <td>
                                        {{ $inspect->date_start }}
                                    </td>
                                    <td>
                                        {{ $inspect->date_end }}
                                    </td>
                                    <td>
                                        <a href="{{ route('issues.index', [$project_id, $inspect]) }}" class="btn btn-success" style="display: inline-block;">รายการตรวจสอบ</a>
                                        <a href="{{ route('inspects.edit', [$project_id, $inspect]) }}" class="btn btn-warning" style="display: inline-block;">แก้ไข</a>
                                        {{-- <form method="POST" action="{{ route('inspects.destroy', [$project_id, $inspect]) }}" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"  onclick="return confirm('คุณต้องการลบ ใช่ หรือ ไม่')">ลบ</button>
                                        </form>    --}}
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