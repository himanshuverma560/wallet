<script type="text/javascript">
	$(document).ready(function(){
		$("#mySignupForm").submit(function(event){
			var name = $("#name").val();
			var email = $("#email").val();
			var password = $("#password").val();
			$("span").html(" ");
			
			$.ajax({
		        type: "POST",
		        url: "<?php echo base_url().'index.php/Auth/signupAction'; ?>",
		        data: {'name': name, 'email' : email, 'password' : password},
		        success: function(data)
		        {
		        	console.log(data);
			           var response = JSON.parse(data);
			           if (response.status_code == 422) {
			           	if(response.message.name) {
			           		$("#name-error").html(response.message.name);
			           	}
			           	if(response.message.email) {
			           		$("#email-error").html(response.message.email);
			           	}
			           	if(response.message.password) {
			           		$("#password-error").html(response.message.password);
			           	}
		           } else if (response.status_code == 200) {
		        		$("#message").html(response.message);
		        		$("#mySignupForm")[0].reset();
		        	} else {

		        	}
		        } 
		    });
		    event.preventDefault();
		});


       $("#myLoginForm").submit(function(event){
			var email = $("#login-email").val();
			var password = $("#login-password").val();
			$("span").html(" ");
			
			$.ajax({
		        type: "POST",
		        url: "<?php echo base_url().'index.php/Auth/loginAction'; ?>",
		        data: {'email' : email, 'password' : password},
		        success: function(data)
		        {
		        	console.log(data);
			           var response = JSON.parse(data);
			           if (response.status_code == 422) {
			           	if(response.message.email) {
			           		$("#login-email-error").html(response.message.email);
			           	}
			           	if(response.message.password) {
			           		$("#login-password-error").html(response.message.password);
			           	}
		           } else if (response.status_code == 401) {
		        		$("#loginMessage").html(response.message);
		        	} else if (response.status_code == 200) {
		        		window.location.href = "<?= base_url().'index.php/Welcome/index'; ?>";
		        	}
		        } 
		    });
		    event.preventDefault();
		});


	});
</script>

</body>
</html>