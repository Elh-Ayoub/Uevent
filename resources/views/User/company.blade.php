<h3 class="text-info">Company entity</h3>
@php
    $company = App\Models\Company::find(Auth::user()->company_id);
@endphp
@if (!$company)
<button class="btn btn-info" id="create-company-btn"><i class="fas fa-plus"></i>Add company</button>
<div class="card card-info mt-3" style="display: none;" id="create-company-form">
    <div class="card-header">
        <h3 class="card-title">Create company entity</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <form class="card-body" action="{{route('company.create')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <div class="row justify-content-center align-items-center col-12">
                <input type="text" placeholder="Company name" name="name" class="form-control col-sm-6">
                <input type="email" placeholder="Company email" name="email" class="form-control col-sm-6">
            </div>
            <div class="row col-md-12 mt-2">
                <input type="text" placeholder="Company location" name="location" class="form-control">
            </div>
            <div class="row col-md-6 mt-2 upload-container justify-content-center mx-auto">
                <input type="file" id="logo" name="logo" class="d-none">
                <label for="logo" class="col-sm-8 d-flex justify-content-center align-items-center" style="cursor: pointer;"><i class="fas fa-upload mr-2"></i><span id="upload-logo-label">Company logo</span></label>
            </div>
        </div>
        <div class="form-group row justify-content-around mb-0">
            <a href="#" id="cancel-company-btn" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Create</button>
        </div>
    </form>
</div>
@else
<div class="content row">
    <div class="card company-card">
        <div class="firstinfo row align-items-lg-start">
            <img class="border" src="{{$company->logo}}"/>
            <div class="profileinfo">
                <h1>{{$company->name}}</h1>
                <h3>{{$company->email}}</h3>
                <p class="bio">{{$company->location}}</p>
            </div>
            <div>
                <a class="link-muted mr-1" data-toggle="modal" data-target="#edit-company"><i class="fas fa-pen"></i></a>
                <a class="link-muted ml-1" data-toggle="modal" data-target="#delete-company"><i class="fas fa-times"></i></a>
            </div>
        </div>
    </div>
</div>
@endif
