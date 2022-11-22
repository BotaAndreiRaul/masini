<?php include 'inc/header.php'; ?>
  
<style>
		body {
			justify-content: center;
			align-items: center;
			min-height: 100vh;
		}
		.alb {
			width: 500px;
			height: 250px;
			padding: 5px;
		}
		.alb img {
			width: 100%;
			height: 100%;
		}
	</style>

<?php

class Detalii {

	public static function afisare() {
		$db = new Dbconfig();
		if(isset($_GET['id'])) {
			$masina_id = mysqli_real_escape_string($db->conn, $_GET['id']);
			$sql = "SELECT * FROM masini WHERE id='$masina_id'";
			$result = mysqli_query($db->conn, $sql);
			$masini = mysqli_fetch_assoc($result);
		}    
		return $masini;
	}
}
	
?>
<?php /*$detalii = new Detalii(); puteam sa fac si cu function call dar am ales sa folosesc metoda statica*/ ?>

<div class="card my-3 w-50">
    <div class="card-body text-center">
       <?php echo "ID=" . Detalii::afisare()['id'] .  ", data: " .  Detalii::afisare()['data_adaugarii'] . "<br>" . Detalii::afisare()['marca'] . " " . Detalii::afisare()['model'] . " " . Detalii::afisare()['culoare']?>
    </div> 
</div>
<div class="alb">
    <img src="upload/<?=Detalii::afisare()['imagine']?>" class="center">
</div>

<?php include 'inc/footer.php'; ?>