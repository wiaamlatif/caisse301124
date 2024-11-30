<?php include "count_items.php"?>
<?php   
   //echo "counItem :".$counItem;
   //echo "<pre>";
   //var_dump($panier);
   //echo "</pre>";
?>

<?php
$title ="Panier";
ob_start();
?>
  <!---------Lines Cart-------------->
  <?php
 
  if(!empty($panier)){
      
    require_once 'C:/caisse191124/include/database.php';

    // Display cart's items
    $prd=array_keys($panier);

    $prdPanier=implode(",",$prd);
                    
    $sqlstm = $pdo -> prepare('SELECT * FROM products 
                               WHERE id_product IN (' . $prdPanier . ') ');
    $sqlstm -> execute();
    $prdPanier = $sqlstm -> fetchAll(PDO::FETCH_ASSOC);

    //echo "prdPanier :";
    //echo "<pre>";
    //var_dump($prdPanier);
    //echo "</pre>";
  }

  ?>
  <!------End Lines Cart------------->
   
    <div class="container py-2">  
          
                <div class="container">
                  <div class="row">
                  <?php
                  if(empty($panier)){
                  ?>
                     <div class='alert alert-warning' role='alert'>
                      Votre panier est vide !
                     </div>
                  <?php       
                  }else{
                  ?>
          
              <table class="table table-striped table-hover">
                <thead>
                  <tr><!-- table row--->
                    <th width="10%">Id</th><!-- table head--->       
                    <th width="20%">imgSrc</th>          
                    <th width="20%">Product</th>          
                    <th width="10%" style="text-align:center;">Quantite</th> 
                    <th width="10%">Prix</th> 
                    <th width="20%">Total</th>                             
                  </tr>
                </thead>
                <tbody>
                <?php   
          
                    $totalTicket=0;        
                    foreach ($prdPanier as $produit){ 
                      $idProduct=$produit['id_product'];
                      $idCategory=$produit['id_category'];
                      $quantityItem=$panier[$produit['id_product']];
                      $totalItem=$produit['price']*$quantityItem;
                      $totalTicket+=$totalItem;           
                ?>              
                  <tr>
                     <td><?=$idProduct?></td>
          
                     <td>            
                      <img class="img img-fluid" src="/uploads/products/<?=$produit['imgSrc']?>" width="70px" alt="">
                     </td>           
          
                     <td><?=$produit['name_product']?></td>
                               
                     <td><!---Form Quantity---------------->
                        <!--FFFFFFFFFFFFFFFFFFFFFFFF-->
                        <form action="add_cart.php?id=<?=$idCategory?>" method="post" class="counter d-flex justify-content-center" id="myForm">
                            <div class="d-flex mb-3 justify-content-center"> 
                                                            
                                <button class="btnMinus btn btn-primary btn-sm mx-2" id="btnMinus<?=$idProduct?>" onclick="return false">
                                    <strong>-</strong>
                                </button>  

                                <input  class="idProduct" type="hidden" name="idProduct" value="<?=$produit['id_product']?>">

                                <input  class="qtyInput" type="text" name="qtyInput" id="qtyInput<?=$idProduct?>" min="0" max="10" value="<?=$quantityItem?>" readonly>    

                                <button class="btnPlus btn btn-primary btn-sm mx-2" id="btnPlus<?=$idProduct?>" onclick="return false">
                                    <strong>+</strong>
                                </button>  

                                <button type="submit" name="ajouter" class="btn btn-success ajouter" value="true">
                                    <i class="fa fa-shopping-cart"></i>
                                </button>

                            </div>
                        </form> 
                        <!--FFFFFFFFFFFFFFFFFFFFFFFF-->                        
                     </td><!---Form Quantity---------------->            
                     
                     <td class="tdPrice"><?=$produit['price']?></td>
          
                     <td class="tdtotalItem"><?= $totalItem ?></td>
          
                  </tr>  
                <?php     
                    }                             
                ?>          
                </tbody> 
                <tfoot>
                  <tr>
                    <th colspan="5" style="text-align:right;" ><strong>Total</strong></th>
                    <th id="thtotalTicket"><strong><?=$totalTicket?></strong></th>
                  </tr>    
                  <tr>
                    <th colspan="5" style="text-align:right;" >
                      <form action="actionPanier.php" method="post">
                        <input type="hidden" name="nr_ticket" value="">
                        <input type="hidden" name="total_ticket" value="<?=$totalTicket?>">
                        <input type="submit" name="valider" class="btn btn-success" value="Valider">
                        <input type="submit" name="vider"   class="btn btn-danger" value="Vider" onclick="return confirm('Confirmer vider panier?')">
                      </form>            
                    </th>          
                  </tr>    
                </tfoot> 
          
              </table>        
                                
                  <?php
                       }
                  ?>  
                                           
                  </div><!---row--->
                </div><!-----container--->
              </div><!-----container py-2 --->
          
<?php $content = ob_get_clean(); ?>

<?php $role=0;//$role= array(0 => Visitor, 1 => Admin, 2 => Seller)?>
<?php $varSell="Sell";$varData="Data";?>
<?php require_once 'C:\caisse191124\layout.php'?>