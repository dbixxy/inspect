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
                <div class="card-header">{{ __('การตรวจสอบ') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ !empty($inspect) ? route('inspects.update', [$project_id, $inspect]) : route('inspects.store', $project_id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="project_id" name="project_id" value="{{ $project_id }}">
                        @if(!empty($inspect))
                            @method('PUT')
                            <input type="hidden" id="inspect" name="inspect_id" value="{{ $inspect->id }}">
                        @endif
                        <div class="form-group">
                            <label for="inspect_number">การตรวจครั้งที่:</label>
                            <input type="number" class="form-control" id="inspect_number" name="number" min="1" step="1" value="{{ old('number', $inspect->number ?? $inspect_count) }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="date_start">วันที่เริ่มต้น:</label>
                            <input type="date" class="form-control" id="date_start" name="date_start" value="{{ old('date_start', $inspect->date_start ?? date('Y-m-d')) }}">
                        </div>
                        <div class="form-group">
                            <label for="date_end">วันที่สิ้นสุด:</label>
                            <input type="date" class="form-control" id="date_end" name="date_end" value="{{ old('date_end', $inspect->date_end ?? date('Y-m-d')) }}">
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