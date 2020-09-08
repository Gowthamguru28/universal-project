@extends('layouts.master')
@section('content')

<form class="content container-fluid my-3" action="{{ URL::route('sales.update', $sale->id) }}" method='post'>
		<div class="card">
		<div class="card-header bg-light">
			<h2>Sales Order</h2>
		</div>
		<div class="card-body p-3">
            <div class="row">
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="form-group">
					<label>Purchase Order#</label>
					<input type="text" placeholder="" name="order_number" value="{{ $sale->order_number }}" readonly class="form-control">
					<span style="color:red">{{ $errors->first('order_number') }} </span>
				</div>
			</div>
			
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="form-group">
					<label>Order Date</label>
					<input type="text" autocomplete="off" class="datepick form-control" required name="order_date" value="{{ $sale->order_date }}">
					<span style="color:red">{{ $errors->first('order_date') }} </span>
				</div>
			</div>
			<input type="hidden" class="sale_id" value="{{ $sale->id }}">
			<div class="col-md-12">
			<div class="table-responsive">
<table id="purchase_table" class="order-table controls table table-light table-bordered table-striped table-hover">
	<thead>
	<tr>
		<th colspan="1">Role</th>
		<th colspan="1">User</th>
		<th colspan="1">Company</th>
        <th>Product</th>
		<th colspan="1">Unit</th>
		<th>Avilable Qty</th>
		<th colspan="1">Quantity</th>
		</tr>
	</thead>
	<tbody>
    @foreach($sale->items as $va1=>$key1)
	<tr class="entry">
	   <td>
	   
	   <select id="role_type" name="role[]" class="form-control" onchange="getUsers(this);" required >
			<option value="">Select Role</option>
			@if(Auth::user()->isAdmin())
				<option value="2" @if($key1->user->role == 2) selected @endif >Distributor</option>
			@endif
			<option value="3" @if($key1->user->role == 3) selected @endif>Dealer</option>      
		</select>
			<span style="color:red">{{ $errors->first('role[]') }} </span>
		</td>
		<td><select id="user" name="user_id[]" class="form-control user_id" required>
                <option value="">Select User</option>
                @foreach($key1->allusers as $va=>$key)
                     <option value="{{ $key->id }}" @if($key1->user->id == $key->id) selected @endif >{{ $key->name }}</option>
                @endforeach
		    </select>
			<span style="color:red">{{ $errors->first('user_id[]') }} </span>
		</td>
        <td>
		<select id="new_brand" name="company_id[]" class="form-control company_list" onchange="getProduct(this);" required>
            <option value="">Select Company</option>
            @foreach($company as $va=>$key)
                <option value="{{ $key->id }}"  @if($key1->product->company_id == $key->id) selected @endif>{{ $key->name }}</option>
            @endforeach
		    </select>
		</td>
		<td>
			<select id="new_item"  name="product_id[]" class="form-control product_list brand-creation" onchange="getUnit(this);" required>
            <option value="">Select Product</option>
                @foreach($key1->allproducts as $va=>$key)
                     <option value="{{ $key->id }}" @if($key1->product_id == $key->id) selected @endif >{{ $key->name }}</option>
                @endforeach
			</select>
			<span style="color:red">{{ $errors->first('product_id') }} </span>
		</td>
		<td><input type="text" id="unit" name="unit[]" readonly class="form-control unit" value="{{ $key1->product->unit->name }}" placeholder="Unit" >
			<span style="color:red">{{ $errors->first('unit') }} </span>
		</td>
		<td><input type="text" id="avilable_qty" name="avilable_qty[]" class="form-control avilable_qty" value="{{ $key1->avilablepro }}" readonly placeholder="Avilable Qty">
			<input type="hidden" class="old_original"  value="{{ $key1->avilablepro }}">
            <span style="color:red">{{ $errors->first('avilable_qty') }} </span>
		</td>
		<td><input type="text" id="new_qty" name="quantity[]" class="form-control quantity" required value="{{ $key1->qty }}" placeholder="Qty">
             <input type="hidden" class="old_quantity" value="{{ $key1->qty }}">
             <input type="hidden" class="total_quantity" value="{{ $key1->totalqty }}">
			 <input type="hidden" class="sale_qty" value="{{ $key1->saleqty }}">
             
            <span style="color:red">{{ $errors->first('quantity') }} </span>
		</td>
		
		<td>	
				@if(count($sale->items) == $va1+1)
					<input type="button" class="add btn-adds btn-success" onclick="" value="+">
				@else
					<input type="button" class="add btn-removes btn-danger" onclick="" value="-">
				@endif
				
		</td>
		</tr>
		@endforeach
	</tbody>

</table>
</div>			
		<div class="form-footer">
 
			<button class="btn btn-primary" href="#">Submit</button>
			<a class="btn btn-danger" href="{{ URL::to('admin/purchase') }}">Cancel</a>
			
			 {{ method_field('PUT') }}
              {{ csrf_field() }}
			
		</div>	
			
			</div>
			</div>
			</div></div>
	</form>	
	
	
	
	<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create item</h4>
      </div>
		<form>
      <div class="modal-body">
          <div class="form-body">

			<div class="">

				<div class="form-group">

					<label>Product name</label>

					<input type="text" placeholder="" name='product_name' value="" required>
                    
				</div>

			</div>
      </div>
      </div>
      <div class="modal-footer">
		   <button type="button" class="btn btn-success" onclick="submits(this)">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	   </form>
    </div>

  </div>
</div>
<script>
	 $('.brand-create').select2({
            theme: 'bootstrap4',
        });
	$('.item-create').select2({
            theme: 'bootstrap4',
        });
	
	/*$('.brand-create')
	.select2()
	.on('select2:open', () => {
	$(".select2-results:not(:has(a))").append('<a onclick="create_item()">Create new brand</a>');
	});
	
	$('.item-create')
	.select2()
	.on('select2:open', () => {
	$(".select2-results:not(:has(a))").append('<a href="item-creation.php" style="font-size:13px;line-height:1.6;display: inline-table;">Create new item</a>');
	});*/
	
	$('.datepick').datepicker({
	language: 'en',
    dateFormat: "yyyy-mm-dd"
	})
	
	function status_change(tis)
	{
		if($(tis).val() == 2)
		{
			$('#pay_type').attr('style','display:inline');
		}
		else
		{
			$('#pay_type').attr('style','display:none');
		}
	}
	function getUsers(obj) {
		var val = obj.value;
		var base_url = "{{ URL::to('/')}}";
		$.ajax({
			url: base_url+'/get-users',
			type: 'get',
			data: { role_id: val },
			dataType: "JSON",
			success: function(response) {
				 $(obj).parents('tr').find('.user_id').html("");
				$.each(response, function(key,val){
						@if(Auth::user()->isAdmin())
							var name = val['name'];
						@else
							var name = val['email'];
						@endif
					  if(key == 0) {
                        $(obj).parents('tr').find('.user_id').append("<option value='' selected>Select User</option>");
                      }
					  var html ="<option value="+val['id']+">"+val['name']+"</option>";							
					  $(obj).parents('tr').find('.user_id').append(html);
				});

			}
		  });	
	}
	function dataTypeNotFixed(unit,number){
		if(unit == 'Metre') {
       		return  parseFloat(number);
		
		} else {
			return parseInt(number);
		}      
	}
	function toFixes(unit, number){
		if(unit == 'Metre') {
       		return  number.toFixed(2);
		
		} else {
			return number;
		}      
	}
	function getUnit(obj) {
        var unit = $(obj).parents('tr').find(".unit").val();
        var val = obj.value;
        var alreadyQty = 0;
       
	
		var base_url = "{{ URL::to('/')}}";
		var sale_id = $('.sale_id').val();
		$.ajax({
			url: base_url+'/get-unit',
			type: 'get',
			data: { product_id: val, sale_id:sale_id },
			dataType: "JSON",
			success: function(response) {
				$(obj).parents('tr').find('.quantity').val("");
                $(obj).parents('tr').find('.unit').val(response.unit);
                $(obj).parents('tr').find('.total_quantity').val(response.total_qty);
				$(obj).parents('tr').find('.sale_qty').val(response.sale_qty);
                
				$(".product_list").each(function( index ) {
					if($(this).val() == val && $(this).parents('tr').find(".quantity").val() != '') {			
						var unit1 = $(this).parents('tr').find(".unit").val();
						//alert(unit);
						alreadyQty +=  dataTypeNotFixed(unit1, $(this).parents('tr').find(".quantity").val());	
					}
				});
				alreadyQty = toFixes(unit, alreadyQty);

                if (alreadyQty == 0) {
                    $(obj).parents('tr').find('.avilable_qty').val(response.avilable_qty);
                } else {
					//var balance = dataType(unit ,response.avilable_qty - alreadyQty);
                    $(obj).parents('tr').find('.avilable_qty').val(response.avilable_qty - alreadyQty);
				}
				//$(obj).parents('tr').find('.avilable_qty').val(response.avilable_qty);
			}
		  });	

	}
	$(document).on('click', '.btn-removes', function() {
			var totalQty = parseFloat($(this).parents('tr').find('.total_quantity').val());
			var productSelected = $(this).parents('tr').find(".product_list").val();
			var available = parseFloat($(this).parents('tr').find(".avilable_qty").val());
			var thisQty = parseFloat($(this).parents('tr').find(".quantity").val());
			
			$(".product_list").each(function( index ) {
				if($(this).val() == productSelected) { 
					$(this).parents('tr').find(".avilable_qty").val(available + thisQty);
				}
			});
	});
    function getProduct(obj) {
        var val = obj.value;
		var base_url = "{{ URL::to('/')}}";
		$.ajax({
			url: base_url+'/products',
			type: 'get',
			data: { company_id: val },
			dataType: "JSON",
			success: function(response) {
				 $(obj).parents('tr').find('.product_list').html("");
				$.each(response, function(key,val){
					  if(key == 0) {
                        $(obj).parents('tr').find('.product_list').append("<option value='' selected>Select Product</option>");
                      }
					  var html ="<option value="+val['id']+">"+val['name']+"</option>";							
					  $(obj).parents('tr').find('.product_list').append(html);
				});

			}
		  });	
    }
	
	function brand_change(tis)
	{		
		    
		
		var val = tis.value;
		var base_url = "{{ URL::to('/')}}/";
		//var html ="<option  selected>Select Brand</option>";	
		$.ajax({
			url: base_url+'brand-by-item',
			type: 'get',
			data: { product_id: val },
			dataType: "JSON",
			success: function(response){ 
				var obj = response;
				// var html ="<option value="" selected>Select Brand</option>";	
				 $(tis).parents('tr').find('.item-create').html("");
				$.each(obj, function(key,val){
					  if(key == 0)
						   $(tis).parents('tr').find('.item-create').append("<option value='' selected>Select item</option>");
					  var html ="<option value="+val['id']+">"+val['name']+"</option>";							
					  $(tis).parents('tr').find('.item-create').append(html);
				});

			}
		  });	
			
	}
	 function item_change(tis)
	{
		     var values='';

			$(tis).parents('tbody').find(".brand-creation").each(function() {
				if(values=='') 
					values=$(this).val();
				else
					values=values+','+$(this).val();
			});
			var sa = $(tis).val();
			var match = values.split(',');
			var select_count=0;

			for (var a in match)
			{
				var variable = match[a];

				if(sa==variable)
					select_count++;
			}
			if(select_count==1)
			{
				
					var val = tis.value;
					var base_url = "{{ URL::to('/')}}/";

					$.ajax({
						url: base_url+'item-by-price',
						type: 'get',
						data: { item_id: val },
						//dataType: "JSON",
						success: function(response){ 										
                                // console.log(response.purchase_price);
								$(tis).parents('tr').find(".rate").val(parseInt(response.p_price));
							    $(tis).parents('tr').find(".discount").val(parseInt(response.purchase_discount));
							    $(tis).parents('tr').find(".discounted_amount").val(parseInt(response.new_price));
							
						}
					  });	
			}
			else
			{				
				    // $(tis).parents('tr').find('.available').val(0); 
				    alert('This product already selected.');
				    $(tis).val(" ");
				    $(tis).select2();
				
			}
	}
	
	function delivery_addr(tis)
	{
           
        if($('#vendor_id').val() =='')
		{
			alert('please select a vendor');
			$("option:selected").prop("selected", false)
			//$('#delivery_to').prop("selected",false);
			return false;
		}
		if(tis.value == 3)
		{
			   $("#address").attr('readonly',false);
			   $('#address').html('');
		}
		else
		{
			var contactId =$('#vendor_id').val();
			
				var val = tis.value;
					var base_url = "{{ URL::to('/')}}/";
					
					$.ajax({
						url: base_url+'address',
						type: 'get',
						data: { contactId: contactId ,address_id:val },
						//dataType: "JSON",
						success: function(response){
							 $("#address").attr('readonly',false);
							 $('#address').html('');
							$("#address").html(response);
							$("#address").attr('readonly',true);	
														//console.log(response['available']);
								//$(tis).parents('tr').find(".rate").val(parseInt(response));		
						}
					  });		
				 //$('#new_address').attr('style','display:none');
		}
	}
    function dataType(unit, number) {
    if(unit == 'Metre') {
        var uu =  parseFloat(number);
		return uu.toFixed(2);
    } else {
        return parseInt(number);
    }        
}
$(document).on('keypress', '.quantity', function() {
			var unit = $(this).parents('tr').find(".unit").val();
			if(unit == 'Metre') {
				return isNumberDecimal(event,this);
			} else {
				return isNumber(event,this);
			}
	});
	function isNumberDecimal(evt, element) {
			var charCode = (evt.which) ? evt.which : evt.keyCode
			if (
				(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
				(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
				(charCode < 48 || charCode > 57))
				return false;
				
	} 
	function isNumber(evt, element) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				return false;
			}
			
	}
$(document).on('keyup', '.quantity', function() {
			var unit = $(this).parents('tr').find(".unit").val();;
			var productSelected = $(this).parents('tr').find(".product_list").val();;
			var enteredQty = 0;
			var totalQty = 0;
			$(".product_list").each(function( index ) {
				if($(this).val() == productSelected) { 
					if($(this).parents('tr').find(".quantity").val() == '') {
						var emptyCheck = 0;
					} else {
						var emptyCheck = parseFloat($(this).parents('tr').find(".quantity").val());
					}
					enteredQty += emptyCheck;
					totalQty = parseFloat($(this).parents('tr').find('.total_quantity').val());
				}
			});
			enteredQty = parseFloat($(this).parents('tr').find('.sale_qty').val())+enteredQty;
			
			if (enteredQty > totalQty ) {
				//$(this).parents('tr').find(".avilable_qty").val(avilableQty);
				swal('Alert', 'Quantity exceeds');
				enteredQty = enteredQty - $(this).val();
				$(this).val('');
			} 
				
				var remainQty = totalQty - enteredQty;
				var remainFixed = dataType(unit ,remainQty);
				$(".product_list").each(function( index ) {
					if($(this).val() == productSelected) { 
						$(this).parents('tr').find(".avilable_qty").val(remainFixed);
					}
				});
    });
	
	function unitChange(obj) {
		// $.each(response, function(key,val){
		// 	if(key == 0) {
		// 	$(obj).parents('tr').find('.product_list').append("<option value='' selected>Select Product</option>");
		// 	}
		// 	var html ="<option value="+val['id']+">"+val['name']+"</option>";							
		// 	$(obj).parents('tr').find('.product_list').append(html);
		// });

		// $( "li" ).each(function( index ) {
		// 	console.log( index + ": " + $( this ).text() );
		// });
	}

	$(document).on('keyup', '.net_discount', function() {
        var qty = $(this).val();
		var price = $(this).parents('tr').find("input[class='discounted_amount']").val();
		var result = qty * price;
		 $(this).parents('tr').find(".amount").val(parseInt(result));
		
		 var total_amount = 0;
        $(this).parents('form').find(".amount").each(function() {
            if ($(this).val() != '')
                total_amount += parseInt($(this).val());
        });
		
		var num =  $(this).parents('table').find(".sub").val();
		var per =  $(this).val();
		var dis_amount = (num/100)*per;
		var net_amout =parseInt(num)-parseInt(dis_amount);
		
		
		$(this).parents('table').find(".total").val(net_amout);
		//alert($(this).parents('table').next('tfoot').find('.sub'));
    });
	
	function submits(tis)
	{
		
		var baseUrl = "{{ URL::to('/')}}";
		 var formData = $(tis).closest('form').serialize();
       $.ajax({
            url : baseUrl+'/ajaxaddproduct',
            type : 'POST',
            data : formData,
            success : function(response)
            {
				if(response != 0)
				{ 
					    $('#new_brand').append('<option selected value='+response['id']+'>'+response['name']+'</option>');
						$("#myModal").modal('toggle');
				}
                
            }
        });
		
	}
	function create_item()
	{
		$("#myModal").modal();
	}

	$(document).on('click', '.btn-adds',function(e)
 {
	
		 $(".brand-create").select2('destroy');
		 $(".item-create").select2('destroy');
		
	var controlForm = $(this).parents('form').find('.controls tbody'),
		currentEntry = $(this).parents('.entry:first'),
		newEntry = $(currentEntry.clone()).appendTo(controlForm.parent());
    newEntry.find('select').eq(1).html('');
         newEntry.find('select').eq(0).val("");
        // newEntry.find('select').eq(2).html("");
         newEntry.find('select').eq(3).html("");
         newEntry.find('select').eq(2).val("");
	newEntry.find('input').val('');
	newEntry.find('.btn-success').val('+');
	controlForm.find('.entry:not(:last) .btn-adds')
		.removeClass('btn-adds').addClass('btn-removes')
		.removeClass('btn-success').addClass('btn-danger')
		.val('-');
		
		//$(this).parents('tr').find('.item-create').html('');
		$('.brand-create').select2({
            theme: 'bootstrap4',
        });
	$('.brand-create').select2({
            theme: 'bootstrap4',
        });
		//.select2()
		//.on('select2:open', () => {
		//$(".select2-results:not(:has(a))").append('<a onclick="create_item()">Create new brand</a>');
	//});
		$('.item-create').select2({
            theme: 'bootstrap4',
        });

        // $('.company_list').select2({
        //     theme: 'bootstrap4',
        // });
        // $('.product_list').select2({
        //     theme: 'bootstrap4',
        // });
		
		//.on('select2:open', () => {
		//$(".select2-results:not(:has(a))").append('<a href="item-creation.php" style="font-size:13px;line-height:1.6;display: inline-table;">Create new item</a>');
	//});
}).on('click', '.btn-removes', function(e)
{
	$(this).parents('.entry:first').remove();
	
	e.preventDefault();
	return false;
});
	
	
	
</script>
@endsection