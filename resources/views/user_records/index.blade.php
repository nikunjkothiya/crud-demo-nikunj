@extends('layouts.master')

@section('content')

<div class="container">
	@if (session()->has('message'))
	<div class="alert alert-dismissable alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>
			{!! session()->get('message') !!}
		</strong>
	</div>
	@endif
	<div class="row">
		<div class="col-6 col-sm-6">User Records</div>
		<div class="col-6 col-sm-5" style="text-align: right;">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
				Add New
			</button>
		</div>
	</div>

	<div class="box">
		<div class="box-body">
			<table class="table table-responsive">
				<thead>
					<tr>
						<th>Avatar</th>
						<th>Name</th>
						<th>Email</th>
						<th>Experience</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>

					@foreach($records as $user)
					<tr>
						<td>{{$user->avatar ?? ''}}</td>
						<td>{{$user->name ?? ''}}</td>
						<td>{{$user->email ?? ''}}</td>
						<td>
							<?php

							if (isset($user->date_joining) && isset($user->date_leaving)) {
								$date1 = new DateTime($user->date_joining);
								$date2 = new DateTime($user->date_leaving);
								$interval = $date1->diff($date2);
							} else if (isset($user->date_leaving)) {
								$today = \Carbon\Carbon::now()->format('Y-m-d');
								$date1 = new DateTime($user->date_joining);
								$date2 = new DateTime($today);
								$interval = $date1->diff($date2);
							}
							?>
							{{ $interval->y}} years {{ $interval->m }} months
						</td>
						<td>
							<button class="btn btn-info" id="show.bs.modal" data-id='{{$user->id}}' data-url="{{route('editdetail')}}" data-toggle="modal" data-target="#edit">Edit</button>
							/
							<button class="btn btn-danger" id="show.bs.modal" data-id='{{$user->id}}' data-toggle="modal" data-target="#delete">Delete</button>
						</td>
					</tr>

					@endforeach
				</tbody>


			</table>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">New User</h4>
			</div>
			<form action="{{route('userrecords.store')}}" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
				<div class="modal-body">
					@include('user_records.form')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit User Detail</h4>
			</div>
			<form action="{{route('updateProfile')}}" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
				<div class="modal-body">
					<input type="hidden" name="user_id" id="old_user_id" value="">
					@include('user_records.form')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save Changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
			</div>
			<form action="{{route('deleteUser')}}" method="post">
				{{csrf_field()}}
				<div class="modal-body">
					<p class="text-center">
						Are you sure you want to delete this?
					</p>
					<input type="hidden" name="user_id" id="delete_user_id" value="">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal">No, Cancel</button>
					<button type="submit" class="btn btn-warning">Yes, Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection