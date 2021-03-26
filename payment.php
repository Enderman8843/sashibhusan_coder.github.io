<?php  

define('MERCHANT_KEY', 'CaBYgYFd');
define('SALT', 'admOkoFXu8');

define('PAYU_BASE_URL', 'https://secure.payu.in');  //actual URL Use in production mode
define('SUCCESS_URL', 'order-success.php');  //order sucess url replace with your complete url
define('FAIL_URL', 'order-fail.php');    //add complete url 
$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$email = $_GET['email'];
$mobile = $_GET['mobile_no'];
$firstName = $_GET['first_name'];
$lastName =  $_GET['last_name'];
$totalCost = $_GET['amount'];
$hash         = '';
$hash_string = MERCHANT_KEY."|".$txnid."|".$totalCost."|"."productinfo|".$firstName."|".$email."|||||||||||".SALT;
$hash = strtolower(hash('sha512', $hash_string));
$action = PAYU_BASE_URL . '/_payment'; 
 
?>
<form action="<?php echo $action; ?>" method="post" name="payuForm" id="payuForm" style="display: none">
    <input type="hidden" name="key" value="<?php echo MERCHANT_KEY ?>" />
    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
    <input name="amount" type="number" value="<?php echo $totalCost; ?>" />
    <input type="text" name="firstname" id="firstname" value="<?php echo $firstName; ?>" />
    <input type="email" name="email" id="email" value="<?php echo $email; ?>" />
    <input type="text" name="phone" value="<?php echo $mobile; ?>" />
    <textarea name="productinfo"><?php echo "productinfo"; ?></textarea>
    <input type="text" name="surl" value="<?php echo SUCCESS_URL; ?>" />
    <input type="text" name="furl" value="<?php echo  FAIL_URL?>"/>
    <input type="text" name="service_provider" value="payu_paisa"/>
    <input type="text" name="lastname" id="lastname" value="<?php echo $lastName ?>" />
</form>
<script type="text/javascript">
    var payuForm = document.forms.payuForm;
    payuForm.submit();
</script>
step 4 : After that create page for order success give the name order-success.php

1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
<?php
 
$status = $_POST["status"];
$firstname = $_POST["firstname"];
$amount = $_POST["amount"];
$txnid = $_POST["txnid"];
$posted_hash = $_POST["hash"];
$key = $_POST["key"];
$productinfo = $_POST["productinfo"];
$email = $_POST["email"];
$salt = "GQs7yium";
 
If (isset($_POST["additionalCharges"])) {
    $additionalCharges = $_POST["additionalCharges"];
    $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
} else {
 
    $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
}
$hash = hash("sha512", $retHashSeq);
 
if ($hash != $posted_hash) {
    echo "Invalid Transaction. Please try again";
} else {
 
    echo "<h3>Thank You For Order . Your order status is " . $status . ".</h3>";
    echo "<h4>Your Transaction ID for this transaction is " . $txnid . ".</h4>";
    echo "<h4>We have received a payment of Rs. " . $amount . ". Your order will soon be shipped.</h4>";
}
?> 
