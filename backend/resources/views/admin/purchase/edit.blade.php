@extends('layouts.master')
@section('content')

<form class="content container-fluid my-3" action="{{ URL::route('purchase.update', $purchase->id) }}" method='post'>
		<div class="card">
		<div class="card-header bg-light">
			<h2>Purchase Order</h2>
		</div>
		<div class="card-body p-3">
            <div class="row">
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="form-group">
					<label>Purchase Order#</label>
					<input type="text" placeholder="" name="order_number" value="{{ $purchase->order_number }}" readonly class="form-control">
					<span style="color:red">{{ $errors->first('order_number') }} </span>
				</div>
			</div>
			
			<div class="col-md-6 col-lg-4 col-xl-3">
				<div class="form-group">
					<label>Order Date</label>
					<input type="text" class="datepick form-control"  name="order_date" required value="{{ $purchase->order_date }}">
					<span style="color:red">{{ $errors->first('order_date') }} </span>
				</div>
			</div>
			<div class="col-md-12">
			<div class="table-responsive">
<table id="purchase_table" class="order-table controls table table-light table-bordered table-striped table-hover">
	<thead>
	<tr>
		<th colspan="1">Company</th>
        <th>Product</th>
		<th>Unit</th>
		<th width="100">Quantity</th>
		</tr>
	</thead>
	<tbody>
	
		@foreach($purchase->items as $va1=>$key1)
		<tr class="entry">
		<td><select id="new_brand" name="company_id[]" required class="form-control company_list" onchange="getProduct(this);" >
			 <option value="">Select Company</option>
				@foreach($company as $va=>$key)
				 	<option value="{{ $key->id }}"@if($key1['company_id'] == $key->id) selected @endif >{{ $key->name }}</option>
				@endforeach
		    </select>
			<span style="color:red">{{ $errors->first('company_id.*') }} </span>
		</td>
		<td>
			 <?php $items =  DB::table('products')->where('company_id',$key1['company_id'])->get();  ?>
			<select id="new_item"  name="product_id[]" required class="form-control product_list brand-creation" onchange="item_change(this);">
				<option value="">Select Product</option>
				@foreach($items as $va2=>$key2)			   		
				    <option value="{{ $key2->id }}"@if($key1['product_id'] == $key2->id) selected @endif >{{ $key2->name }}</option>
				@endforeach
			</select>
			<span style="color:red">{{ $errors->first('product_id.*') }} </span>
		</td>
		<td><input type="text" readonly class="form-control unit" value="{{ $key1['product']['unit']['name'] }}"></td>
		 @if($key1['product']['unit']['name'] != 'Metre') 
		 	<?php $qty = round($key1['qty']); ?>
		 @else
		 	<?php $qty = ($key1['qty']); ?>
		 @endif
		<td><input type="text" id="new_qty" name="quantity[]" required placeholder="Qty" class="form-control quantity" value="{{ $qty }}">
			<span style="color:red">{{ $errors->first('quantity.*') }} </span>
		</td>
		
		<td>
             @if(count($purchase->items) == $va1+1)
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
	$(document).on('keypress', '.quantity', function() {
		var unit = $(this).parents('tr').find(".unit").val();
		if(unit == 'Metre') {
			return isNumberDecimal();
		} else {
			return isNumber();
		}
    });
	function item_change(tis)
	{
		var base_url = "{{ URL::to('/')}}/";
		//var html ="<option  selected>Select Brand</option>";	
		var val = $(tis).val();
		$.ajax({
			url: base_url+'admin/unit-by-product',
			type: 'get',
			data: { product_id: val },
			//dataType: "JSON",
			success: function(response){ 
				 $(tis).parents('tr').find('.unit').val(response);
				 $(tis).parents('tr').find('.quantity').val(0);
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
			return true;
	} 
	function isNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				return false;
			}
			return true;
	}
	
	
	$(document).on('keyup', '.quantity', function() {
        var qty = $(this).val();
		var price = $(this).parents('tr').find("input[class='discounted_amount']").val();
		var result = qty * price;
		 $(this).parents('tr').find(".amount").val(parseInt(result));
		
		 var total_amount = 0;
        $(this).parents('form').find(".amount").each(function() {
            if ($(this).val() != '')
                total_amount += parseInt($(this).val());
        });
		
		 $(this).parents('table').find(".sub").val(total_amount);
		$(this).parents('table').find(".total").val(total_amount);
		//alert($(this).parents('table').next('tfoot').find('.sub'));
		
			var num =  $(this).parents('table').find(".sub").val();
		var per =  $(this).parents('table').find(".net_discount").val();
		var dis_amount = (num/100)*per;
		var net_amout =parseInt(num)-parseInt(dis_amount);
		
		
		$(this).parents('table').find(".total").val(net_amout);
    });
	
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

       // controlForm.find('.entry:last .btn-adds').html('<i class="fa fa-fw fa-minus"></i>');
		
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