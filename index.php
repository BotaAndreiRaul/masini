<?php include "inc/header.php" ?>
<?php
    // Setare valori goale
  $marca = $model = $culoare = '';
  $marcaErr = $modelErr = $culoareErr = $imagineErr ='';
  $db = new Dbconfig();

  class Masina extends Dbconfig {

    public $marca, $model, $culoare;
    public $marcaErr, $modelErr, $culoareErr, $imagineErr;
    public $img_name, $img_size, $tmp_name, $error;  
    public function __construct() {
      $this->marca = $this->model = $this->culoare = '';
      $this->marcaErr = $this->modelErr = $this->culoareErr = $this->imagineErr ='';
    }
  
    public function validare() {
      if(isset($_POST["submit"])) {
        //Validare nume
        if(empty($_POST["marca"])) {
          $this->marcaErr = "Introduceti marca";
        }
        else {
          $this->marca = filter_input(INPUT_POST, "marca", FILTER_SANITIZE_SPECIAL_CHARS);
        }
  
        //Validare model
        if(empty($_POST["model"])) {
          $this->modelErr = "Introduceti modelul";
        }
        else{
          $this->model = filter_input(INPUT_POST, "model", FILTER_SANITIZE_SPECIAL_CHARS);
        }
  
        //Validare culoare
        if(empty($_POST["culoare"])) {
          $this->culoareErr = "Introduceti culoarea";
        }
        else {
          $this->culoare = filter_input(INPUT_POST, "culoare", FILTER_SANITIZE_SPECIAL_CHARS);
        }
  
        if(isset($_FILES["imagine"])) {
          $this->img_name = $_FILES['imagine']['name'];
          $this->img_size = $_FILES['imagine']['size'];
          $this->tmp_name = $_FILES['imagine']['tmp_name'];
          $this->error = $_FILES['imagine']['error'];
          
  
          if($this->error === 0 && empty($this->marcaErr) && empty($this->modelErr) && empty($this->culoareErr)) {   // "===" -> verifica daca sunt egale si valorile sunt de acelasi tip    
              if($this->img_size > 1250000) {
                  $em = "Fisierul este de dimensiuni prea mari!";
                  header("Location: index.php?error=$em");
              }
              else {
                  $img_ex = pathinfo($this->img_name, PATHINFO_EXTENSION);
                  $img_ex_lc = strtolower($img_ex);
     
                 $allowed_exs = array("jpg", "jpeg", "png"); 
     
                 if(in_array($img_ex_lc, $allowed_exs) ) {                         
                      $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                      $img_upload_path = 'upload/'.$new_img_name;
                      move_uploaded_file($this->tmp_name, $img_upload_path);   
                      global $db;
                      $sql = "INSERT INTO masini(marca, model, culoare, imagine) VALUE ('$this->marca', '$this->model', '$this->culoare', '$new_img_name')";
                      if(mysqli_query($db->conn, $sql)) {
                        //Succes
                        header("Location: lista.php");
                      }
                      else {
                        echo "ERROR: " , mysqli_error($db->conn);
                      }
                }              
                 else {
                     $em = "Nu puteti incarca fisiere de acest tip";
                     header("Location: index.php?error=$em");
                 }
             }
          }
          else {
            $this->imagineErr = "Introduceti Imaginea";
          }
        }
      }

    }
  }
?>

<?php $mas = new Masina();
      $mas->validare();
?>

<h2>Adaugare masini</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
      class="mt-4 w-75" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="marca" class="form-label">Marca</label>
        <input type="text" class="form-control <?php echo !$mas->marcaErr ?:
          "is-invalid"; ?>" id="marca" name="marca" placeholder="Introduceti marca" value="<?php echo $mas->marca; ?>">
          <div class="invalid-feedback">
            <?php echo $mas->marcaErr; ?>
          </div>
      </div>
      <div class="mb-3">
        <label for="model" class="form-label">Model</label>
        <input type="text" class="form-control <?php echo !$mas->modelErr ?:
          "is-invalid"; ?>" id="model" name="model" placeholder="Introduceti modelul" value="<?php echo $mas->model; ?>">
          <div class="invalid-feedback">
            <?php echo $mas->modelErr; ?>
          </div>
      </div>
      <div class="mb-3">
        <label for="culoare" class="form-label">Culoare</label>
        <input type="text" class="form-control <?php echo !$mas->culoareErr ?:
          "is-invalid"; ?>" id="culoare" name="culoare" placeholder="Introduceti culoarea" value="<?php echo $mas->culoare; ?>">
          <div class="invalid-feedback">
            <?php echo $mas->culoareErr; ?>
          </div>
      </div>
      <div class="mb-3">
        <label for="imagine" class="form-label">Imagine</label>
        <input type="file" class="form-control <?php echo $mas->error!=0 ? "is-invalid"
        : null ?>" id="imagine" name="imagine" >
        <div class="invalid-feedback">
            <?php echo $mas->imagineErr; ?>
          </div>
      </div>
      <div class="mb-3">
        <input type="submit" name="submit" value="Submit " class="btn btn-dark w-100">
      </div>
    </form>

<?php include "inc/footer.php" ?>