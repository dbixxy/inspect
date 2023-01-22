@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">

            <!-- Content Row -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card-counter primary">
                        <i class="fa fa-code-fork"></i>
                        <span class="count-numbers">{{ $projects->count() }}</span>
                        <span class="count-name">จำนวนโครงการ</span>
                    </div>
                </div>
            
                <div class="col-md-3">
                    <div class="card-counter danger">
                        <i class="fa fa-ticket"></i>
                        <span class="count-numbers">{{ $inspects_count }}</span>
                        <span class="count-name">จำนวนการเข้าตรวจสอบ</span>
                    </div>
                </div>
            
                <div class="col-md-3">
                    <div class="card-counter info">
                        <i class="fa fa-users"></i>
                        <span class="count-numbers">{{ $issues_count }}</span>
                        <span class="count-name">จำนวนจุดตรวจสอบ</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-counter success">
                        <i class="fa fa-database"></i>
                        <span class="count-numbers">{{ $success_percent }}%</span>
                        <span class="count-name">สำเร็จ</span>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
<br>
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <table id="my_table" class="table table-bordered table-responsive table-hover table-striped">
                        <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>ชื่อโครงการ</th>
                                <th>ลูกค้า</th>
                                <th>แปลน</th>
                                <th>การตรวจ(ครั้ง)</th>
                                <th>จุดตรวจ(เสร็จ)</th>
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
                                        {{ $project->plans->count() }}
                                    </td>
                                    <td>
                                        {{ $project->inspects->count() }}
                                    </td>
                                    <td>
                                        {{ $project->issues()->where('is_closed', '1')->count() }} / {{ $project->issues->count() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-primary" style="display: inline-block;">รายละเอียด</a>
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