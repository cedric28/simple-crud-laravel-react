@extends('layouts.app')

@section('content')
		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Employees</span> - New Record</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
							<a href="{{ route('employees.index')}}" class="breadcrumb-item"> Employees</a>
							<a href="{{ route('employees.create')}}" class="breadcrumb-item active"> Add New Employee</a>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">
				<div class="card">
					<div class="card-header">
						@include('partials.message')
					    @include('partials.errors')
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<div class="header-elements-inline">
									<h5 class="card-title">Employee Form</h5>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<form action="{{ route('employees.store')}}" method="POST">
									@csrf
	
									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Firstname:</label>
                                        <div class="col-lg-9">	
                                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="@error('first_name') is-invalid @enderror form-control" placeholder="Firstname" >
                                        </div>
									</div>
									
									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Lastname:</label>
                                        <div class="col-lg-9">	
                                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="@error('last_name') is-invalid @enderror form-control" placeholder="Lastname" >
                                        </div>
									</div>

									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Email:</label>
                                        <div class="col-lg-9">	
                                            <input type="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror form-control" placeholder="Email" >
                                        </div>
									</div>
									
									<div class="form-group row">
										<label class="col-lg-3 col-form-label">Company:</label>
										<div class="col-lg-9">
											<select id="role-id" name="company_id" class="form-control">
												<option value="">Select company</option>
												@foreach ($companies as $company)
													<option value="{{ $company->id }}"{{ ($company->name === old('company_id')) ? ' selected' : '' }}>{{ strtoupper($company->name) }}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Phone:</label>
                                        <div class="col-lg-9">	
                                            <input type="number" name="phone" class="@error('phone') is-invalid @enderror form-control" placeholder="Phone" >
                                        </div>
									</div>


									<div class="text-right">
										<button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /content area -->
		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->
        @push('scripts')
        <!-- Javascript -->
        <!-- Vendors -->
      
        <script src="{{ asset('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>
        @endpush('scripts')
@endsection