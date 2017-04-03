<?php

include("assets/header.php");

//Set user id (klant nummer)
$_SESSION['user_id'] = 1;
$id = makesafe($_GET["id"]);
$userid = makesafe($_SESSION["user_id"]);
$i = 0;

//Check if post exists, and make variables safe to prevent XSS attacks/exploiting
if (isset($userid)) {
	echo emailController::getOutbox($id, $userid);
}

if(isset($_SESSION['sent'])) {
    $data = $_SESSION['sent'];
    unset($_SESSION['sent']);
} else {
    $data = "";
}

?>


<div class="main col-md-9 main_panel">
<h1>Welkom Klant</h1>
                                         
<div class="table-responsive" id="inbox">          
<table class="table">
<thead>
  <tr>
    <th style="width: 70%;">Onderwerp</th>
    <th style="width: 10%;">Ontvanger</th>
    <th style="width: 10%;">Datum</th>
    <th style="width: 10%;">Grootte</th>
  </tr>

<?php
foreach($data as $out):
if($i == 10){
  break;
} else {
?>
  <tr>
    <td><a href="readsent?message=<?=$out["date"]?>&id=<?=$id?>"><?=$out['subject']?></a></td>
    <td><?=$out['receiver']?></td>
    <td><?=date('d/m/Y', $out['date'])?></td>
    <td><?=$out['size']/1000?> kb</td>
    <td><a href="maildel?mailid=['id']"><span class="glyphicon glyphicon-trash"></span></td>
  </tr>


<?php
$i++;
}
endforeach;
?>

 </tbody>
</table>
