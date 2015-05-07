
<h2>Promotion Group</h2>
	<div class="row">
		<div class="col-md-6">

			<form name="prodGroupForProm" id="prodGroupForProm">
				<table class="table table-bordered">
					<tr>
						<td>Group Code</td>
						<td>
							<input type="text" name="groupCode" id="groupCode">
						</td>
					</tr>
					<tr>
						<td>Group Desc</td>
						<td><textarea name="groupDesc" id="groupDesc" rows="5" cols="50"></textarea></td>
					</tr>
					
				</table>
				<table>
					<tr>
						<input type="submit" class="btn btn-primary btn-xs" id="add" value="Add">
						&nbsp;
						<input type="reset" class="btn btn-primary btn-xs" id="cancel" value="Cancel">
					</tr>
				</table>
			</form>

		</div>
		
	</div>
	<hr>
	<h2>List of Promotion Group</h2>
	<div class="row">
		<div class="col-md-8">
			<table class="table">
				<thead>
					<tr >
						<th>
						Group Code
						</th>
						<th>
						Group Desc
						</th>
						
						<th>
						Manage
						</th>
					</tr>
					<tr>
						<td>
						ED520301
						</td>
						<td>
						EDLP 52/03#1
						</td>
						
						
						<td>
						<button type="button" class="btn btn-primary btn-xs">Edit </button>
						<button type="button" class="btn btn-danger btn-xs">Delete </button>
							<a href="1-2-add-prod-for-prom-group.html">
							<button type="button" class="btn btn-primary btn-xs">Add Item</button>
							</a>
						</td>
					</tr>
					<tr>
						<td>
						ED520302
						</td>
						<td>
						EDLP 52/03#2
						</td>
						
						
						<td>
						<button type="button" class="btn btn-primary btn-xs">Edit </button>
						<button type="button" class="btn btn-danger btn-xs">Delete </button>
							<a href="1-2-add-prod-for-prom-group.html">
							<button type="button" class="btn btn-primary btn-xs">Add Item</button>
							</a>
						</td>
					</tr>
					<tr>
						<td>
						ED520303
						</td>
						<td>
						EDLP 52/03#3
						</td>
						
						
						<td>
						<button type="button" class="btn btn-primary btn-xs">Edit </button>
						<button type="button" class="btn btn-danger btn-xs">Delete </button>
						<a href="1-2-add-prod-for-prom-group.html">
							<button type="button" class="btn btn-primary btn-xs">Add Item</button>
							</a>
						</td>
					</tr>
					<tr>
						<td>
						ED520304
						</td>
						<td>
						EDLP 52/03#4
						</td>
						
						
						<td>
						<button type="button" class="btn btn-primary btn-xs">Edit </button>
						<button type="button" class="btn btn-danger btn-xs">Delete </button>
							<a href="1-2-add-prod-for-prom-group.html">
							<button type="button" class="btn btn-primary btn-xs">Add Item</button>
							</a>
						</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
 
</div>
 
 
     
<!-- Start Large modal -->


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myLargeModalLabel">New Promotion</h4>
        </div>
        <div class="bs-callout bs-callout-info">
				    <h4>Detail Promotion</h4>
				    <div class="row">
				    	<div class="col-md-5">
						    <table class="table">
						    	
						    	<tbody>
							    	<tr>
							    		<td><input type="radio" name="radio1"></td>
							    		<td>As Blank Promotion</td>
							    	</tr>
							    	<tr>
							    		<td><input type="radio" name="radio1"></td>
							    		<td>Copy Existing Promotion</td>
							    		
							    		
							    	</tr>
							    	<tr>
							    		<td><input type="text" size="5"></td>
							    		<td>Promotion No</td>
							    		
							    		
							    	</tr>
							    	
						    	</tbody>
						    	
						    </table>
				    	</div>
				    </div>
				    
			</div>
			
        <div class="modal-body">
        	<h2>Promotion</h2>
	        <div class="row">
			<div class="col-md-12">
				<table class="table">
					<tbody>
						<tr >
							<th>
							Prom Group No
							</th>
							<th>
							Prom Group Desc
							</th>
							<th>
							Start Date
							</th>
							<th>
							End Date
							</th>
							<th>
							Away
							</th>
							
						</tr>
						<tr>
							<td>
							<a href="5-2-setup-free-item-prom-by-group-detail.html">
							DG0908 
							</a>
							</td>
							<td>
							Colo KRMC   
							</td>
							<td>
							28/05/2553
							</td>
							<td>
							28/05/2553
							</td>
							<td></td>
							
							
							
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
            <button type="button" class="btn btn-primary btn-xs">Save </button>
			<button type="button" class="btn btn-danger btn-xs">Cancle </button>
         
        
          
        </div>
    </div>
   
  </div>
</div>

<!-- End Large modal -->
 

