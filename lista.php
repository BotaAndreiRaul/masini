<?php include "inc/header.php" ?>

<form class="d-flex" method="POST">
    <input class="form-control me-1" type="text" name="search" placeholder="Cautare masini">
    <button class="btn btn-dark" type="submit">Cauta</button>
</form>
<div class="col-md-5">
  <form action="" method="POST">
    <div class="card shadow mt-2">
      <div class="card-header">
        <h5>Filtrare
            <input type="submit" class="btn btn-dark btn-sm float-end" name="filtrare" value="filtrare">
        </h5>
          <div class="card-body">
            <h6>Lista masini</h6>
            <hr>
            Audi: <input type="checkbox" name="brands[]" value="Audi"><br>  
            BMW: <input type="checkbox" name="brands[]" value="BMW"><br>
            Mercedes: <input type="checkbox" name="brands[]" value="Mercedes"><br>
            Skoda: <input type="checkbox" name="brands[]" value="Skoda"><br>
            Volkswagen: <input type="checkbox" name="brands[]" value="Volkswagen"><br>                                
         </div>
    </div>      
   </div> 
  </form> 
</div>     
<br>
<h2>Lista de masini</h2>

<?php
$db = new Dbconfig();
class Lista {
  
  public function listare() {
    global $db;
    $sql = 'SELECT * FROM masini';
    $result = mysqli_query($db->conn, $sql);
    $masini = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (empty($masini)): ?>
      <p class="lead mt-3">Nu sunt masini</p>
    <?php endif;
    foreach ($masini as $item): ?>
      <div class="card my-1 w-75">
       <div class="card-body text-center">
         <?php echo $item['marca'] . " " . $item['model']; ?>
         <a href="detalii.php?id=<?= $item['id']; ?>" class="btn btn-dark">Detalii</a>
       </div> 
     </div>
    <?php endforeach; 
  }

  public function cautare() {
    global $db;
    $var = $_POST['search'];
    $sql = "SELECT * FROM masini WHERE marca LIKE '%$var%'";
    $result = mysqli_query($db->conn, $sql);
    $masini = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (empty($masini)): ?>
    <p class="lead mt-3">Nu sunt masini</p>
    <?php endif; 
      foreach ($masini as $item): ?>
      <div class="card my-1 w-75">
        <div class="card-body text-center">
          <?php echo $item['marca'] . " " . $item['model']; ?>
          <a href="detalii.php?id=<?= $item['id']; ?>" class="btn btn-dark">Detalii</a>
        </div> 
      </div>
    <?php endforeach; 
  }

  public function filtrare() {
    global $db;
    $branchecked = [];
    $branchecked = $_POST['brands'];
    foreach($branchecked as $rowbrand) {
      $sql = "SELECT * FROM masini WHERE marca = '$rowbrand'";
      $result = mysqli_query($db->conn, $sql);
      $masini = mysqli_fetch_all($result, MYSQLI_ASSOC);
      foreach($masini as $item) :?>
        <div class="card my-1 w-75">
          <div class="card-body text-center">
            <?php echo $item['marca'] . " " . $item['model']; ?>
              <a href="detalii.php?id=<?= $item['id']; ?>" class="btn btn-dark">Detalii</a>
          </div> 
        </div>
      <?php endforeach; 
    }
  }
}

$lista = new Lista();

if(isset($_POST['search'])) {
  $lista->cautare();
}
elseif(isset($_POST["brands"])) {
    $lista->filtrare();
  }
  else {
    $lista->listare();
  }
?>
  
<?php 
    if(isset($_POST['submit']))
        header("Location: detalii.php");
?>

<?php include 'inc/footer.php'; ?>