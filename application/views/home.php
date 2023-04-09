<?php $this->load->view('head'); ?>
<?php $this->load->view('nav'); ?>

	<div class="row">
		<div class="col-md-4">
			<br><br>
			<div class="card">
				<div class="card-header bg-dark text-white">Profile</div>
				<div class="card-body">
			<table class="table table">
				<tr><th id="name"></th></tr>
				<tr><th id="email"></th></tr>
				<tr><th id="upi"></th></tr>
				<tr><th id="amount"></th></tr>
				<tr><th id="created_at"></th></tr>
			</table>
		</div>
		<div class="card-footer">
			<div class="form-group">
			<label>Transfer Money (Using UPI ID)</label>
			<input type="email" placeholder="Enter UPI" class="form-control" id="upiID" onkeyup="getUpi()"> 
			<p id="upiName"></p>
			<div class="form-group" id="afterVerify" style="display: none;">
				<label>Enter Amount</label>
				<input type="number" id="amt" class="form-control">
				<br>
				<button class="btn btn-dark" onclick="transferAmount()">Send</button>
			</div>
		</div>
		</div>
		</div>
		</div>
		<div class="col-md-8">
			<br><br>
			<div class="card">
				<div class="card-header bg-dark text-white">Transactions</div>
				<div class="card-body">
			<table class="table table-striped">
				<thead>
				<tr>
				<th>S.No</th>
				<th>Amount</th>
				<th>Type</th>
				<th>Time</th>
			   </tr>
			   </thead>
			   <tbody id="trans">
			   	
			   </tbody>
			</table>
		</div>
	</div>
	</div>
	</div>

	<script type="text/javascript">
		function getUserDeatils() {
			$(document).ready(function(){
				$.ajax({
		        type: "get",
		        url: "<?php echo base_url().'index.php/Welcome/userDetails'; ?>",
		        success: function(data)
		        {
			        var response = JSON.parse(data);
			        if (response.status_code == 200) {
			        	$("#name").html("Name : "+ response.data.name);
			        	$("#email").html("Email : "+ response.data.email);
			        	$("#amount").html("Amount : "+ response.data.amount);
			        	$("#created_at").html("Created_at : "+ response.data.created_at);
			        	$("#upi").html("UPI ID : "+ response.data.upi_id);
			        } 
		        } 
		    });
			})
		}

		function getTransaction() {
			$(document).ready(function(){
				$("#trans").html(" ");
				$.ajax({
		        type: "get",
		        url: "<?php echo base_url().'index.php/Welcome/getTransaction'; ?>",
		        success: function(data)
		        {
			        var response = JSON.parse(data);
			        if (response.status_code == 200) {
			        	var l = 0;
			        	var n = 1;
			        	var currentUser = "<?php echo $this->session->userdata('user')->id; ?>";
			        	while (response.data.length > l)
			        	{
			        		if (currentUser == response.data[l].sender_id) {
			        			var trasType = 'Debit <br> ('+response.data[l].receiver_upi_id+')';
			        		} else if (currentUser == response.data[l].receiver_id) {
			        			var trasType = 'Credit <br> ('+response.data[l].sender_upi_id+')';
			        		}
			        		$("#trans").append("<tr><td>"+n+++"</td>\
			        			<td>"+response.data[l].amount+"</td>\
			        			<td>"+trasType+"</td>\
			        			<td>"+response.data[l].created_at+"</td><tr>")
			        		l++;
			        	}
			        }
			        
		        } 
		    });
			})
		}

		function getUpi() {
			$(document).ready(function(){
				$("#afterVerify").css({'display' : 'none'});
				$("#upiName").html(" ");
				$.ajax({
		        type: "post",
		        url: "<?php echo base_url().'index.php/Welcome/getUPI'; ?>",
		        data: {'upi' : $("#upiID").val()},
		        success: function(data)
		        {
			        var response = JSON.parse(data);
			        if (response.status_code == 200) {
			        	$("#upiName").html('<span style="color:green">Verify UPI</span> : '+response.data.name);
			        	$("#afterVerify").css({'display' : ''});
			        } else if(response.status_code == 422) {
			        	$("#upiName").html('<span style="color:red">'+response.message+'</span>');
			        }
		        } 
		    });
			})
		}

		function transferAmount() {
			$(document).ready(function(){
				if ($("#amt").val() == '') {
					alert("Enter Amount");
					return false;
				}
				$.ajax({
		        type: "post",
		        url: "<?php echo base_url().'index.php/Welcome/transferAmount'; ?>",
		        data: {'upi' : $("#upiID").val(), 'amount' : $("#amt").val()},
		        success: function(data)
		        {
			        var response = JSON.parse(data);
			        if (response.status_code == 200) {
			        	$("#upiName").html('<span style="color:green">'+response.message+'</span>');
			        	$("#afterVerify").css({'display' : 'none'});
			        	$("#upiID").val(" ");
			        	$("#amt").val(" ");
			        	getUserDeatils();
						getTransaction();
			        } else if(response.status_code == 422) {
			        	$("#upiName").html('<span style="color:red">'+response.message+'</span>');
			        }
		        } 
		    });
			})
		}
		getUserDeatils();
		getTransaction();
	</script>