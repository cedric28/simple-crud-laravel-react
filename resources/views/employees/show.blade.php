@extends('layouts.app')

@section('content')
		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Employee</span> -  {{ strtoupper($employee->first_name)." ".strtoupper($employee->last_name) }} Details</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ route('home')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                            <a href="{{ route('employees.index')}}" class="breadcrumb-item"> Employees</a>
                            <a href="{{ route('employees.show', $employee->id )}}" class="breadcrumb-item active"> {{ strtoupper($employee->first_name)." ".strtoupper($employee->last_name) }} Details</a>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">

				<!-- Clean blog layout #1 -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title font-weight-semibold">
                        <a href="#" class="text-default">{{ strtoupper($employee->first_name)." ".strtoupper($employee->last_name) }}</a>
                        </h5>
                    </div>

                    <div class="card-body">
                        <blockquote class="blockquote blockquote-bordered py-2 pl-3 mb-0">
							<p class="mb-2 font-size-base">{{ $employee->email }}</p>
							<p class="mb-2 font-size-base">{{ $employee->phone }}</p>
							<p class="mb-2 font-size-base">{{ $employee->company->name }}</p>
                        </blockquote>
                    </div>
                </div>
                <!-- /clean blog layout #1 -->
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