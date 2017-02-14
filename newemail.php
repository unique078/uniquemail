<?php

include("assets/header.php");

//Set user id (klant nummer)
$_SESSION['user_id'] = 1;
$userid = makesafe($_SESSION["user_id"]);

?>

<script>
function hideShowCC() {
	var className = $('#cc').attr('class');
	console.log(className);

	if (className == 'hidden') {
		$('#cc').removeClass('hidden');
	} else {
		$('#cc').addClass('hidden');
	}
};

function hideShowBCC() {
	var className = $('#bcc').attr('class');
	console.log(className);

	if (className == 'hidden') {
		$('#bcc').removeClass('hidden');
	} else {
		$('#bcc').addClass('hidden');
	}
};
</script>

<div class="main col-md-9 main_panel">
<h1>Welkom Klant</h1>
                                         
<div class="table-responsive" id="inbox">

<p>
	<label>To:</label><br/>
	<input type="text" name="to" placeholder="To">
</p>

<p>
	<label>Subject</label><br/>
	<input type="text" name="subject" placeholder="Subject">         
</p>

<label onclick="hideShowCC()">CC</label><br/>

<div id="cc" class="hidden">
	<p>
		<input type="text" name="cc" placeholder="CC">
	</p>
</div>

<label onclick="hideShowBCC()">BCC</label>

<div id="bcc" class="hidden">
	<p>
		<input type="text" name="bcc" placeholder="BCC">
	</p>
</div>

<p>
	<label>Priority:</label><br/>
	<select>
	  <option value="5">Low Priority</option>
	  <option value="3">Normal Priority</option>
	  <option value="1">High Priority</option>
	</select>
</p>

<p>
	<label>Message</label><br/>
	<textarea rows="4" cols="50"></textarea>
</p>

<p>
	<input type="submit" value="Send Email" class="btn btn-primary">
</p>

<!-- jQuery hosted library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Bootstrap library -->
<script src="js/bootstrap.min.js""></script>
</script>