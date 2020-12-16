<!--
<script type="text/javascript">
$(document).ready(function() {
	
	$("#login").click(function() {
	
		var action = $("#horizontalForm").attr('action');
		var form_data = {
			username: $("#username").val(),
			password: $("#password").val(),
			is_ajax: 1
		};
		
		$.ajax({
			type: "POST",
			url: action,
			data: form_data,
			success: function(response)
			{
				if(response == 'success')
					$("#horizontalForm").slideUp('slow', function() {
						$("#message").html("<p class='success'>You have logged in successfully!</p>");
					});
				else
					$("#message").html("<p class='error'>Invalid username and/or password.</p>");	
			}
		});
		
		return false;
	});
	
});-->
</script>
<div id="content">
<form id="horizontalForm"  name="horizontalForm" action="index.php?opc=valida" method="POST">
			<fieldset>
				<legend>
				 	Cambiar Clave
				</legend>
                <fieldset style=" width:210px;">
                	<label for="username">
                        Clave Anterior
                        <input id="largo" name="claveAnt"  id="username" type="password" />
                    </label>
                    <label for="username">
                        Nueva Clave
                        <input id="largo" name="claveNue"  id="username" type="password" />
                    </label>
                    
                  
                    <input class="submit" type="submit" value="Cambiar" id="login" name="login" />
                    
               </fieldset>
                 
			</fieldset>
			
</form>
  <div id="message"></div>
</div>
