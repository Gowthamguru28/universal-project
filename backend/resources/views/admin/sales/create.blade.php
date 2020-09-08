@extends('layouts.master')
@section('content')

<form class="content container-fluid my-3" action="{{ URL::route('sales.store') }}" method='post'>
		<div class="card">
		<div class="card-header bg-light">
			<h2>Sales Order</h2>
		</div>
		<div class="card-body p-3">
            <div class="row">
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="form-group">
					<label>Purchase Order#</label>
					<input type="text" placeholder="" name="order_number" value="{{ $salesId }}" readonly class="form-control">
					<span style="color:red">{{ $errors->first('order_number') }} </span>
				</div>
			</div>
			
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="form-group">
					<label>Order Date</label>
					<input type="text" autocomplete="off" class="datepick form-control" required name="order_date" value="{{ old('order_date') }}">
					<span style="color:red">{{ $errors->first('order_date') }} </span>
				</div>
			</div>
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
	@if(old('company_id') == '')
	<tr class="entry">
	   <td>
	   <select id="role_type" name="role[]" class="form-control" onchange="getUsers(this);" required>
			<option value="">Select Role</option>
			@if(Auth::user()->isAdmin())
				<option value="2">Distributor</option>
			@endif
			<option value="3">Dealer</option>      
		</select>
			<span style="color:red">{{ $errors->first('role[]') }} </span>
		</td>
		<td><select id="user" name="user_id[]" class="form-control user_id" required>
        <option value="">Select User</option>
		    </select>
			<span style="color:red">{{ $errors->first('user_id[]') }} </span>
		</td>
        <td>
		<select id="new_brand" name="company_id[]" class="form-control company_list" onchange="getProduct(this);" required>
        <option value="">Select Company</option>
                        @foreach($company as $va=>$key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
		    </select>
		</td>
		<td>
			<select id="new_item"  name="product_id[]" required class="form-control product_list brand-creation" onchange="getUnit(this);" >
            <option value="">Select Product</option>
			</select>
			<span style="color:red">{{ $errors->first('product_id') }} </span>
		</td>
		<td><input type="text" id="unit" name="unit[]" readonly class="form-control unit" placeholder="Unit" >
			<span style="color:red">{{ $errors->first('unit') }} </span>
		</td>
		<td><input type="text" id="avilable_qty" name="avilable_qty[]" class="form-control avilable_qty" readonly placeholder="Avilable Qty">
			<span style="color:red">{{ $errors->first('avilable_qty') }} </span>
		</td>
		<td><input type="text" id="new_qty" name="quantity[]" required class="form-control quantity" placeholder="Qty">
			<input type="hidden" class="old_quantity" value="">
             <input type="hidden" class="total_quantity" value="">
			<span style="color:red">{{ $errors->first('quantity') }} </span>
		</td>
		
		<td><input type="button" class="add btn-adds btn-success" onclick="" value="+">
		</td>
		</tr>
		@else
		@foreach(old('role') as $va1=>$key1)
		<tr class="entry">
		<td>
		<select id="role_type_{{ $va1 }}" name="role[]" class="form-control" onchange="getUsers(this);" >
				<option value="">Select Role</option>
				<option value="2" @if(old('role')[$va1] == 2) selected @endif>Distributor</option>
				<option value="3" @if(old('role')[$va1] == 3) selected @endif>Dealer</option>      
			</select>
				<span style="color:red">{{ $errors->first('role.*') }} </span>
			</td>
			<script>
					setTimeout(() => {
						var role = "{{ $va1}}";
							$('#role_type_'+role).trigger('change');
					}, 100);
			</script>
			<td><select id="user_{{ $va1 }}" name="user_id[]" class="form-control user_id">
					<option value="">Select User</option>
				</select>
				<span style="color:red">{{ $errors->first('user_id.*') }} </span>
			</td>
			<td>
			<select id="new_company_{{ $va1 }}" name="company_id[]" class="form-control company_list" onchange="getProduct(this);" >
			<option value="">Select Company</option>
							@foreach($company as $va=>$key)
								<option value="{{ $key->id }}" @if(old('company_id')[$va1] == $key->id) selected @endif>{{ $key->name }}</option>
							@endforeach
				</select>
				<span style="color:red">{{ $errors->first('company_id.*') }} </span>
				<script>
					setTimeout(() => {
						var role = "{{ $va1}}";
							$('#new_company_'+role).trigger('change');
					}, 500);
				</script>

			</td>
			<td>
				<select id="new_product_{{ $va1 }}"  name="product_id[]" class="form-control product_list brand-creation" onchange="getUnit(this);" >
				<option value="">Select Product</option>
				</select>
				<span style="color:red">{{ $errors->first('product_id.*') }} </span>
			</td>
			<script>
					setTimeout(() => {
						var role = "{{ $va1}}";
						var pro_id = "{{ old('product_id')[$va1] }}";
						var id= "new_product_{{ $va1 }}";
							$("#"+id+" option[value=" + pro_id + "]").attr('selected', 'selected');

							var role = "{{ $va1}}";
						var user_id = "{{ old('user_id')[$va1] }}";
						var id= "user_{{ $va1 }}";
							$("#"+id+" option[value=" + user_id + "]").attr('selected', 'selected');
					}, 1000);

					setTimeout(() => {
					
					}, 1000);
				</script>
			<td><input type="text" id="unit" name="unit[]" value="{{ old('unit')[$va1] }}" readonly class="form-control unit" placeholder="Unit" >
				
			</td>
			<td><input type="text" id="avilable_qty" name="avilable_qty[]" value="{{ old('avilable_qty')[$va1] }}" class="form-control avilable_qty" readonly placeholder="Avilable Qty">
		
			</td>
			<td><input type="text" id="new_qty" name="quantity[]" class="form-control quantity" value="{{ old('quantity')[$va1] }}" placeholder="Qty">
				<span style="color:red">{{ $errors->first('quantity.*') }} </span>
				<input type="hidden" class="old_quantity" name="old_quantity[]" value="{{ old('old_quantity')[$va1] }}">
             	<input type="hidden" class="total_quantity" name="total_quantity[]" value="{{ old('total_quantity')[$va1] }}">
			</td>
			
			<td><input type="button" class="add btn-adds btn-success" onclick="" value="+">
			</td>
		</tr>
		@endforeach
		@endif
	</tbody>

</table>
</div>			
		<div class="form-footer">
 
			<button class="btn btn-primary" href="#">Submit</button>
			<a class="btn btn-danger" href="{{ URL::to('admin/purchase') }}">Cancel</a>
			
			 {{ method_field('POST') }}
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
					  var html ="<option value="+val['id']+">"+name+"</option>";							
					  $(obj).parents('tr').find('.user_id').append(html);
				});

			}
		  });	
	}
	function getUnit(obj) {
        var val = obj.value;
        var alreadyQty = 0;
		var base_url = "{{ URL::to('/')}}";
		$.ajax({
			url: base_url+'/get-unit',
			type: 'get',
			data: { product_id: val },
			dataType: "JSON",
			success: function(response) {
                $(obj).parents('tr').find('.unit').val(response.unit);
				$(obj).parents('tr').find('.total_quantity').val(response.total_qty);
				var unit = $(obj).parents('tr').find(".unit").val();
                $(".product_list").each(function( index ) {
					if($(this).val() == val && $(this).parents('tr').find(".quantity").val() != '') {
						alreadyQty +=  dataType(unit, $(this).parents('tr').find(".quantity").val());
						//alert(alreadyQty);
					}
				});
                if (alreadyQty == 0) {
                    $(obj).parents('tr').find('.avilable_qty').val(response.avilable_qty);
                } else {
					//alert(alreadyQty);alert( response.avilable_qty);
                    $(obj).parents('tr').find('.avilable_qty').val(dataType(unit, response.avilable_qty) - alreadyQty);
				}
				//$(obj).parents('tr').find('.avilable_qty').val(response.avilable_qty);
			}
		  });	

	}
	function dataType(unit, number) {
    if(unit == 'Metre') {
        return parseFloat(number);
    } else {
        return parseInt(number);
    }        
}
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
	$(document).on('keypress', '.quantity', function() {
			var unit = $(this).parents('tr').find(".unit").val();
			if(unit == 'Metre') {
				return isNumberDecimal(event,this);
			} else {
				return isNumber(event,this);
			}
	});
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
						var emptyCheck = dataType(unit, $(this).parents('tr').find(".quantity").val());
					}
					enteredQty += emptyCheck;
					totalQty = dataType(unit, $(this).parents('tr').find('.total_quantity').val());
				}
			});
			// enteredQty = toFixes(unit,enteredQty);
			// totalQty = toFixes(unit,totalQty);
			// alert(enteredQty);alert(totalQty);
			if (enteredQty > totalQty ) {
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
	function quantityCheck(obj) {
			var productSelected = $(obj).parents('tr').find(".product_list").val();
			var enteredQty = 0;
			var totalQty = 0;
			$(".product_list").each(function( index ) {
				if($(this).val() == productSelected) { 
					var unit = $(this).parents('tr').find(".unit").val();
					if($(this).parents('tr').find(".quantity").val() == '') {
						var emptyCheck = 0;
					} else {
						var emptyCheck = dataType(unit,$(this).parents('tr').find(".quantity").val());
					}
					enteredQty += emptyCheck;
					totalQty = dataType(unit, $(this).parents('tr').find('.total_quantity').val());
				}
			});
			var avilableQty = $(obj).parents('tr').find(".avilable_qty").val();
			if (enteredQty > totalQty ) {
				//$(this).parents('tr').find(".avilable_qty").val(avilableQty);
				swal('Alert', 'Quantity exceeds');
				enteredQty = enteredQty - $(obj).val();
				$(obj).val('');
			} 
				
				var remainQty = totalQty - enteredQty;
				$(".product_list").each(function( index ) {
					if($(this).val() == productSelected) { 
						$(this).parents('tr').find(".avilable_qty").val(remainQty);
					}
				});
	}
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
	

	$(document).on('click', '.btn-adds',function(e)
 {
	
		 $(".brand-create").select2('destroy');
		 $(".item-create").select2('destroy');
		
	var controlForm = $(this).parents('form').find('.controls tbody'),
		currentEntry = $(this).parents('.entry:first'),
		newEntry = $(currentEntry.clone()).appendTo(controlForm.parent());
    newEntry.find('select').eq(1).html('');
		 newEntry.find('select').eq(0).val("");
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