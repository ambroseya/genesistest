@extends('layout')

@section('header')

	<script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
@stop

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@if(Request::is('*/search*'))
			<h1>Search Results for: {{ $searches }} </h1>
			
			@else
			<h1>All Contacts</h1>

			@endif
				 <form method="POST" action="search">
					{{ csrf_field() }}
						<div class="form-group">
								<input name="searchterms" type="text"></input>
								<button type="submit" class="btn-sm btn-primary">Search</button>
						</div>
				</form>
				@foreach ($contacts as $contact)

					<div>
						<ul class="list-group">
							<li class="list-group-item">
								<a href="{{ url('contacts/'.$contact->id) }}">{{ $contact->fname }} {{ $contact->lname }} </a>
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editContactModal" data-id="{{ $contact->id }}" data-fname="{{ $contact->fname }}" data-lname="{{ $contact->lname }}" data-email="{{ $contact->email }}" data-phone="{{ $contact->phone }}" 
								data-custom1="{{ $contact->custom1 }}" data-custom2="{{ $contact->custom2 }}" data-custom3="{{ $contact->custom3 }}" data-custom4="{{ $contact->custom4 }}" data-custom5="{{ $contact->custom5 }}"> Edit <span class="glyphicon glyphicon-pencil"></span></button>
								<a class="btn btn-primary btn-sm" href="{{ url('contacts/'.$contact->id.'/delete')}}" role="button"> Delete <span class="glyphicon glyphicon-trash"></span></a>
							</li>

					</div>

				@endforeach

				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addContactModal">
 					 Add Contact
				</button>
				<div class="modal fade" id="addContactModal" 
				     tabindex="-1" role="dialog" 
				     aria-labelledby="addContactModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" 
				          data-dismiss="modal" 
				          aria-label="Close">
				          <span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" 
				        id="addContactModalLabel">Add Contact</h4>
				      </div>
				      <div class="modal-body">
					     <form method="POST" action="/contacts/store">
							   {{ csrf_field() }}
								<div class="form-group">
									<p>
										<label for="fname">First Name</label><input class="form-control" type="text" name="fname" />
									</p>
									<p>
										<label for="lname">Last Name</label><input class="form-control" type="text" name="lname" />
									</p>
									<p>
										<label for="phone">Phone Number</label><input class="form-control" type="tel" name="phone" />
									</p>
									<p>
										<label for="email">Email Address</label><input class="form-control" type="email" name="email" />
									</p>

									<div class="form-group">
   										<button class="add_custom_field btn btn-primary"> + </button>
   									</div>
   									<div class="form-group custom_fields">

   									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Add Contact</button>
								</div>
						</form>
				      </div>
				    </div>
				  </div>
				</div>

				<div class="modal fade" id="editContactModal" 
				     tabindex="-1" role="dialog" 
				     aria-labelledby="editContactModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" 
				          data-dismiss="modal" 
				          aria-label="Close">
				          <span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" 
				        id="editContactModalLabel">Edit Contact</h4>
				      </div>
				      <div class="modal-body">
				      	<h3 id="contactName"></h3>
				      	<p id="contactPhone"></p>
				      	<p id="contactEmail"></p>
				      	<p id="contactCustom1"></p>
				      	<p id="contactCustom2"></p>
				      	<p id="contactCustom3"></p>
				      	<p id="contactCustom4"></p>
				      	<p id="contactCustom5"></p>

						<form id="editContactForm" method="POST" action="/contacts/">
				 		  {{ csrf_field() }}
				 		  {{ method_field('PATCH') }}
							<div class="form-group">
							<p><label for="fname">First Name</label>
							<input class="form-control" id="fname" type="text" name="fname" value="" /></p>
							<p><label for="lname">Last Name</label>
							<input class="form-control" id="lname" type="text" name="lname" value="" /></p>
							<p><label for="phone">Phone Number</label>
							<input class="form-control" id="phone" type="tel" name="phone" value="" /></p>
							<p><label for="email">Email Address</label>
							<input class="form-control" id="email" type="email" name="email" value="" /></p>
							</div>
							<div class="form-group">
   								<button class="add_custom_field btn btn-primary"> + </button>
   							</div>
   							<div class="form-group custom_fields">

   							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Update Contact</button>
							</div>

				</form>
		
		</div>
	</div>

@stop

@section ('footer')
	<script>
$(document).ready(function() {
    $('#editContactModal').on("show.bs.modal", function (e) {
    	var fullName = $(e.relatedTarget).data('fname') + ' ' + $(e.relatedTarget).data('lname');

    	 $("#contactName").html(fullName);

         $("#contactPhone").html($(e.relatedTarget).data('phone'));

         $("#contactEmail").html($(e.relatedTarget).data('email'));

         $("#contactCustom1").html($(e.relatedTarget).data('custom1'));

         $("#contactCustom2").html($(e.relatedTarget).data('custom2'));

         $("#contactCustom3").html($(e.relatedTarget).data('custom3'));

         $("#contactCustom4").html($(e.relatedTarget).data('custom4'));

         $("#contactCustom5").html($(e.relatedTarget).data('custom5'));

    	 $("#fname").val($(e.relatedTarget).data('fname'));

         $("#lname").val($(e.relatedTarget).data('lname'));

         $("#phone").val($(e.relatedTarget).data('phone'));

         $("#email").val($(e.relatedTarget).data('email'));
         if($(e.relatedTarget).data('custom1')!=''){ $(".custom_fields").append('<div><div class="col-xs-6"><input class="form-control" type="text" name="custom[]" value="'+$(e.relatedTarget).data('custom1')+'"/></div><a href="#" class="btn btn-primary remove_field" role="button"> - </a></div>'); }
         if($(e.relatedTarget).data('custom2')!=''){ $(".custom_fields").append('<div><div class="col-xs-6"><input class="form-control" type="text" name="custom[]" value="'+$(e.relatedTarget).data('custom2')+'"/></div><a href="#" class="btn btn-primary remove_field" role="button"> - </a></div>'); }
         if($(e.relatedTarget).data('custom3')!=''){ $(".custom_fields").append('<div><div class="col-xs-6"><input class="form-control" type="text" name="custom[]" value="'+$(e.relatedTarget).data('custom3')+'"/></div><a href="#" class="btn btn-primary remove_field" role="button"> - </a></div>'); }
         if($(e.relatedTarget).data('custom4')!=''){ $(".custom_fields").append('<div><div class="col-xs-6"><input class="form-control" type="text" name="custom[]" value="'+$(e.relatedTarget).data('custom4')+'"/></div><a href="#" class="btn btn-primary remove_field" role="button"> - </a></div>'); }
         if($(e.relatedTarget).data('custom5')!=''){ $(".custom_fields").append('<div><div class="col-xs-6"><input class="form-control" type="text" name="custom[]" value="'+$(e.relatedTarget).data('custom5')+'"/></div><a href="#" class="btn btn-primary remove_field" role="button"> - </a></div>'); }

         var id = $(e.relatedTarget).data('id');
         id = 'contacts/' + id;
         $('#editContactForm').attr('action', id);
    });
});</script>
<script>
$(document).ready(function() {
    $(".add_custom_field").click(function(e){ 
  		var x = $('.custom_fields > div').length; if(x-0){x++;}
        e.preventDefault();
        if(x < 6){ 
            x++; 
            $(".custom_fields").append('<div><div class="col-xs-6"><input class="form-control" type="text" name="custom[]"/></div><a href="#" class="btn btn-primary remove_field"> - </a></div>'); 
        }
        else{
        	$(".add_custom_field").addClass('.disabled');
        }
    });
    
   $(".custom_fields").on("click",".remove_field", function(e){ 
        e.preventDefault(); $(this).parent('div').remove(); 
        if(x = 5){ $(".add_custom_field").removeClass('.disabled'); }
        x--;
    })
});
</script>
@stop