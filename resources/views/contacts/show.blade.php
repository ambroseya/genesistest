@extends('layout')



@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h1>{{ $contact->fname }} {{ $contact->lname }}</h1>

			<p>Phone: {{ $contact->phone }}</p>
			<p>Email: {{ $contact->email }}</p>

			@if($contact->custom1!='')
				<p>{{ $contact->custom1 }}</p>
			@endif
			@if($contact->custom2!='')
				<p>{{ $contact->custom2 }}</p>
			@endif
			@if($contact->custom3!='')
				<p>{{ $contact->custom3 }}</p>
			@endif
			@if($contact->custom4!='')
				<p>{{ $contact->custom4 }}</p>
			@endif
			@if($contact->custom5!='')
				<p>{{ $contact->custom5 }}</p>
			@endif

			<p><a href="{{ url('contacts/') }}" class="btn btn-primary">Back to Contact List</a></p>
		</div>
	</div>

@stop