@extends('admin.layouts.app')
@section('content')

    <div class="card rounded-3 overflow-hidden mb-3">
        <div class="card-body">
            <div class="row align-items-center g-0">
                <div class="col light">
                    <h4 class=" mb-0">Today <span id="total-today">0</span></h4>
                    <p class="fs--1 fw-semi-bold ">
                        Yesterday <span id="total-yesterday" class="opacity-50">0</span>
                    </p>
                </div>
                <div class="col-auto d-none d-sm-flex align-items-center chart-config select">
                    <button class="btn btn-sm btn-outline-light me-2 refresh-chart" type="button" title="Update Chart">
                        <i class="fas fa-sync"></i>
                    </button>
                    <select class="form-select form-select-sm" id="chart-status" aria-label="">
                        <option value="successful" selected="selected">Successful Payments</option>
                        <option value="other">Other Payments</option>
                    </select>
                </div>
            </div>
            <div id="revenue-chart" style="height: 250px;"></div>
        </div>
    </div>

@endsection
