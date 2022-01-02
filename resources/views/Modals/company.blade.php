@php
    $company = App\Models\Company::find(Auth::user()->company_id);
@endphp
@if ($company)
<div id="edit-company" class="modal fade">
    <div class="modal-dialog">
        <form class="modal-content" action="{{route('company.update', $company->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="modal-header bg-gradient-warning">
                <h5 class="modal-title">Edit company entity</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <label>Company name:</label>
                <input type="text" placeholder="Company name" name="name" class="form-control" value="{{$company->name}}">
                <label>Company email:</label>
                <input type="email" placeholder="Company email" name="email" class="form-control" value="{{$company->email}}">
                <label>Company location:</label>
                <input type="text" placeholder="Company location" name="location" class="form-control" value="{{$company->location}}">
                <div class="row col-md-12 mt-2 upload-container justify-content-center mx-auto">
                    <input type="file" id="logo" name="logo" class="d-none">
                    <label for="logo" class="col-sm-8 d-flex justify-content-center align-items-center" style="cursor: pointer;"><i class="fas fa-upload mr-2"></i><span id="upload-logo-label">Company logo</span></label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-warning">Save</button>
            </div>
        </form>
    </div>
</div>
<div id="delete-company" class="modal fade">
    <div class="modal-dialog">
        <form class="modal-content" action="{{route('company.delete', $company->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('DELETE')
            <div class="modal-header bg-gradient-danger">
                <h5 class="modal-title">Delete company entity</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="text-bold text-lg-center text-danger">You're about to delete your company entity! To confirm input password.</p>
                <div class="form-group input-container col-12">
                    <input type="password" placeholder="Password..." name="password" class="form-control container__input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>
@endif
<div class="modal fade" id="modal-delete-user">
    <div class="modal-dialog">
        <form action="{{route('user.delete')}}" method="POST" class="modal-content bg-danger">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h4 class="modal-title">Delete account</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You're about to delete your account, all your will be deleted as well. Are you sure ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-light">Delete</button>
            </div>
        </form>
    </div>
</div>
