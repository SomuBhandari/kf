<?php
include("../sql.php");
$sql = new sql();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Shopping Cart</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<style>
 .shopping-cart{
  padding-bottom: 50px;
  font-family: 'Montserrat', sans-serif;
}

.shopping-cart.dark{
  background-color: #f6f6f6;
}

.shopping-cart .content{
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
  background-color: white;
}

.shopping-cart .block-heading{
    padding-top: 50px;
    margin-bottom: 40px;
    text-align: center;
}

.shopping-cart .block-heading p{
  text-align: center;
  max-width: 420px;
  margin: auto;
  opacity:0.7;
}

.shopping-cart .dark .block-heading p{
  opacity:0.8;
}

.shopping-cart .block-heading h1,
.shopping-cart .block-heading h2,
.shopping-cart .block-heading h3 {
  margin-bottom:1.2rem;
  color: #3b99e0;
}

.shopping-cart .items{
  margin: auto;
}

.shopping-cart .items .product{
  margin-bottom: 20px;
  padding-top: 20px;
  padding-bottom: 20px;
}

.shopping-cart .items .product .info{
  padding-top: 0px;
  text-align: center;
}

.shopping-cart .items .product .info .product-name{
  font-weight: 600;
}

.shopping-cart .items .product .info .product-name .product-info{
  font-size: 14px;
  margin-top: 15px;
}

.shopping-cart .items .product .info .product-name .product-info .value{
  font-weight: 400;
}

.shopping-cart .items .product .info .quantity .quantity-input{
    margin: auto;
    width: 80px;
}

.shopping-cart .items .product .info .price{
  margin-top: 15px;
    font-weight: bold;
    font-size: 22px;
 }

.shopping-cart .summary{
  border-top: 2px solid #5ea4f3;
    background-color: #f7fbff;
    height: 100%;
    padding: 30px;
}

.shopping-cart .summary h3{
  text-align: center;
  font-size: 1.3em;
  font-weight: 600;
  padding-top: 20px;
  padding-bottom: 20px;
}

.shopping-cart .summary .summary-item:not(:last-of-type){
  padding-bottom: 10px;
  padding-top: 10px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.shopping-cart .summary .text{
  font-size: 1em;
  font-weight: 600;
}

.shopping-cart .summary .price{
  font-size: 1em;
  float: right;
}

.shopping-cart .summary button{
  margin-top: 20px;
}

@media (min-width: 768px) {
  .shopping-cart .items .product .info {
    padding-top: 25px;
    text-align: left; 
  }

  .shopping-cart .items .product .info .price {
    font-weight: bold;
    font-size: 22px;
    top: 17px; 
  }

  .shopping-cart .items .product .info .quantity {
    text-align: center; 
  }
  .shopping-cart .items .product .info .quantity .quantity-input {
    padding: 4px 10px;
    text-align: center; 
  }
}
 
</style>
</head>
<body>
  <main class="page">
    <section class="shopping-cart dark">
      <div class="container">
            <div class="block-heading">
              <div><center>
                <img src="../kf.png" height="150px" style="padding-bottom:0px"><br>
                <font style="font-family: 'Open Sans', sans-serif;font-size: 22px;color: #292929;">KIIT FEST 5.0</font><br><br>
                <font style="font-family: 'Open Sans', sans-serif;font-size: 12px;color: #a09f9f;">
                Check Out Page For KIIT FEST 
                </font>
            </center>
      </div>
            </div>
            <div class="content">
          <div class="row">
            <div class="col-md-12 col-lg-8">
              <div class="items">
                  <?php
                    $kfid = $sql->getKFID();
                    
                    $sql = "SELECT * FROM participants_participant_events,events WHERE participants_participant_events.participant_id = '$kfid' and participants_participant_events.event_id = events.id";
                    $result = mysqli_query($GLOBALS['connect'],$sql);
                    if($result)
                    {
                        $count = 1;
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo '
                  <div class="product">
                  <div class="row">
                    <div class="col-md-3">
                      
                    </div>
                    <div class="col-md-8">
                      <div class="info">
                        <div class="row">
                        <div  class="col-md-2">'.$count++.'</div>
                          <div class="col-md-6 product-name">
                            <div class="product-name">
                              <a href="#">'.$row['event_name'].'</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                            ';

                        }
                        $query = "select * from participants_participant where kf_id = '$kfid'";
                        $result1 = mysqli_query($GLOBALS['connect'],$query);
                        if($result1 > 0)
                        {
                          $row1 = mysqli_fetch_assoc($result1);
                          if($row1['payment_complete'] != 1){
                            $institution = strtoupper($row1['institution']);
                            if($institution == 'KIIT' || $institution == 'KIIT UNIVERSITY' || $institution == 'KIIT DEEMED TO BE UNIVERSITY' || $institution == 'KALINGA INSTITUTE OF INDUSTRIAL TECHNOLOGY')
                            echo ' 
                            </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                            <div class="summary">
                              <h3>Summary</h3>
                              <div class="summary-item"><span class="text">Subtotal</span><span class="price">₹ 208</span></div>
                              <div class="summary-item"><span class="text">Discount</span><span class="price">₹ 0</span></div>
                              <!--<div class="summary-item"><span class="text">Status</span><span class="price">₹ 0</span></div>-->
                              <div class="summary-item"><span class="text">Total</span><span class="price">₹ 208</span></div>
                              <a href="https://kiitfest.org/payment/pay.php"><button type="button" class="btn btn-primary btn-lg btn-block">Checkout</button></a>
                            </div>
                          </div>';
                          else
                          echo ' 
                          </div>
                          </div>
                          <div class="col-md-12 col-lg-4">
                          <div class="summary">
                            <h3>Summary</h3>
                            <div class="summary-item"><span class="text">Subtotal</span><span class="price">₹ 515</span></div>
                            <div class="summary-item"><span class="text">Discount</span><span class="price">₹ 0</span></div>
                            <!--<div class="summary-item"><span class="text">Status</span><span class="price">₹ 0</span></div>-->
                            <div class="summary-item"><span class="text">Total</span><span class="price">₹ 515</span></div>
                            <a href="https://kiitfest.org/payment/pay.php"><button type="button" class="btn btn-primary btn-lg btn-block">Checkout</button></a>
                          </div>
                        </div>';
                              }
                        }

                    }
                    else
                    {
                              echo mysqli_error($connect);
                    }
                ?>


          </div> 
        </div>
      </div>
    </section>
  </main>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){

// Delete 
$('.delete').click(function(){
  var el = this;
  var id = this.id;
  var splitid = id.split("_");

  // Delete id
  var deleteid = splitid[1];

  // AJAX Request
  $.ajax({
    url: 'remove.php',
    type: 'POST',
    data: { id:deleteid },
    success: function(response){

      if(response == 1){
    // Remove row from HTML Table
    $(el).closest('tr').css('background','tomato');
    $(el).closest('tr').fadeOut(800,function(){
       $(this).remove();
    });
     }else{
    alert('Invalid ID.');
     }

   }
  });

});

});
</script>
</body>
</html>