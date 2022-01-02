<div class="row">
    <div class="col-md-3">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img id="profile-pic" class="profile-user-img img-fluid img-circle"
                 src="{{Auth::user()->profile_photo}}"
                 alt="User profile picture">
          </div>
          <h3 class="profile-username text-center">{{Auth::user()->username}}</h3>
          <p class="text-muted text-center">{{Auth::user()->full_name}}</p>
          <div class="list-group list-group-unbordered">
              <form action="{{route('user.avatar.update')}}" method="POST" class="form-group row" enctype="multipart/form-data">
                  @csrf
                  @method('PATCH')
                  <div class="d-flex w-100 justify-content-between align-items-center">
                      <label class="selectfile" for="choosefile">select picture</label>
                      <input id="choosefile" type="file" name="image" class="d-none">
                      <button type="submit" class="btn btn-warning">save</button>
                  </div>
              </form>
              <form action="{{route('user.avatar.delete')}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <div class="d-flex w-100 justify-content-start">
                      <button type="submit" class="btn btn-danger">Delete avatar</button>
                  </div> 
              </form> 
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Info</a></li>
              <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>            
          </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="settings">
                  <form id="infoForm" action="{{route('user.update', Auth::user()->id)}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                      @csrf
                      @method('PATCH')
                      <div class="form-group row">
                          <label for="inputLogin" class="col-sm-2 col-form-label">Username</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" name="username" id="inputLogin" placeholder="username" value="{{Auth::user()->username}}">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="{{Auth::user()->email}}">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="inputfull_name" class="col-sm-2 col-form-label">Full name</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputfull_name" name="full_name" placeholder="Full name" value="{{Auth::user()->full_name}}">
                          </div>
                      </div>
                  </form>
                  <div class="form-group d-flex justify-content-between">
                      <div class="offset-sm-2">
                      <button id="SubmitInfoForm" type="submit" class="btn btn-success">Save</button>
                      </div>
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-user">Delete account</button>
                  </div>           
              </div>
              <div class="tab-pane" id="password">
                  <form action="{{route('user.password.update')}}" method="POST">
                      @csrf
                      @method('PATCH')
                      <div class="form-group row">
                          <label for="inputCurrPass" class="col-sm-3 col-form-label">Current password</label>
                          <div class="col-sm-9">
                              <input type="password" class="form-control" name="current_password" id="inputCurrPass">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="inputPass" class="col-sm-3 col-form-label">New password</label>
                          <div class="col-sm-9">
                              <input type="password" class="form-control" name="password" id="inputPass">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="inputConfirmPass" class="col-sm-3 col-form-label">Confirm new password</label>
                          <div class="col-sm-9">
                              <input type="password" class="form-control" name="password_confirmation" id="inputConfirmPass">
                          </div>
                      </div>
                      <div class="form-group d-flex justify-content-start">
                          <button type="submit" class="btn btn-warning mt-3">Save</button>
                      </div> 
                  </form>
              </div>
            </div>
        </div>
      </div>
    </div>
</div>

