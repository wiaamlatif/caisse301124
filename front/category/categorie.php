<?php include "C:/caisse191124/front/category/count_items.php"?>

<?php 
    var_dump($panier);    
?>

<?php
//Cookies
if(isset($_POST['ajouter'])){

    $idProduct = $_POST['idProduct']; 
    $qty = $_POST['qtyInput']; 
  
    $name_cookie=$idProduct;
    $cookie_value = $qty;
    setcookie($name_cookie,$cookie_value,time() + (86400 * 30),'/'); 
     //// 86400 = 1 day
   } 
?>


<?php
    $idCategory = $_GET['id']; 
    require_once 'C:/caisse191124/include/database.php';

    $sqlstm = $pdo -> prepare('SELECT * FROM categories
                               WHERE id_category=?');
    $sqlstm -> execute([$idCategory]); 
    $categorie= $sqlstm -> fetch(PDO::FETCH_ASSOC);  

   
    $sqlstm = $pdo -> prepare('SELECT * FROM products
                               WHERE id_category=?');
    $sqlstm -> execute([$idCategory]); 
    $produits= $sqlstm -> fetchAll(PDO::FETCH_ASSOC);

?>

<?php 
       $title=$categorie['name_category']; 
?>

<?php ob_start();?>
            <a href="cookies.php" class="btn btn-danger">Clear Cookies</a>
    <h3><?=$title?></h3>    
    <div class="container">
        <div class="row">

            <?php 
              foreach ($produits as $produit) {
            ?>
            <!--==============================--->
            <div class="card mb-3 col-md-3 m-1">
                <img src="/uploads/products/<?=$produit['imgSrc']?>" class="card-img-top w-50 mx-auto" alt="...">
                <div class="card-body">
                    <a href="detail_produit.php?id=<?=$produit['id_product']?>" class="btn stretched-link">Afficher detail</a>
                    <h5 class="card-title"><?=$produit['name_product']?></h5>
                    <p class="card-text"><?=$produit['description']?></p>
                    <p class="card-text"><small class="text-muted"> <?=$produit['price']?> MAD</small></p>
                    <p class="card-text"> <?= date_format(date_create($produit['created_at']),format:'Y/m/d' )  ?></p>
                </div>
                <div class="card-footer" style="z-index:10">
                 
                <!--action="add_cart.php?id=<?=""//$idCategory?>"-->
                <!--FFFFFFFFFFFFFFFFFFFFFFFF-->
                 <form action="" method="post" class="counter d-flex justify-content-center" id="myForm">
                    <div class="d-flex justify-content-center">   

                        <?php if(in_array($produit['id_product'],array_keys($panier))) { ?>  
                        <button formaction="supItemCart.php" type="submit" name="suprimer" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        <?php } ?>
                    
                        <button class="btnMinus btn btn-primary btn-sm mx-2" id="btnMinus<?=$idProduct?>" onclick="return false">
                            <strong>-</strong>
                        </button>  

                        <input  class="idProduct" type="hidden" name="idProduct" value="<?=$produit['id_product']?>">

                        <?php
                           if(in_array($produit['id_product'],array_keys($panier))){
                            $quantityItem=$panier[$produit['id_product']];
                           } else {
                            $quantityItem=0;
                           }                                            
                        ?>   
                        <input  class="qtyInput" type="text" name="qtyInput" id="qtyInput<?=$idProduct?>" min="0" max="10" value="<?=$quantityItem?>" readonly>    



                        <button class="btnPlus btn btn-primary btn-sm mx-2" id="btnPlus<?=$idProduct?>" onclick="return false">
                            <strong>+</strong>
                        </button>  

                        <button type="submit" name="ajouter" class="ajouter btn btn-success" value="true">
                            <i class="fa fa-shopping-cart"></i>
                        </button>

                    </div>
                </form> 
                 <!--FFFFFFFFFFFFFFFFFFFFFFFF-->   
                </div>
            </div>            
            <!--==============================--->
            <?php
              }
            ?>
     

        </div>
    </div>
    
<?php $content = ob_get_clean(); ?>

<?php $role=0;//$role= array(0 => Visitor, 1 => Admin, 2 => Seller)?>
<?php $varSell="Sell";$varData="Data";?>
<?php require_once 'C:\caisse191124\layout.php'?>











<?php echo $_GET['id'];?>