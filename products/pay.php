<?php require "../includes/header.php"; ?>
<?php
require "../config/config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: http://localhost/coffee-blend');
    exit;
}

$cartCheck = $conn->prepare("SELECT COUNT(*) as total_items FROM cart WHERE user_id = :user_id");
$cartCheck->execute([':user_id' => $_SESSION['user_id']]);
$totalItems = $cartCheck->fetch(PDO::FETCH_ASSOC)['total_items'];

if ($totalItems == 0) {
    header('location: http://localhost/coffee-blend');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("location: " . APPURL . "");
}

?>


<section class="home-slider owl-carousel">

    <div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
                <h1 class="mb-3 mt-5 bread">Pay with PayPal</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span><span>Pay with PayPal</span></p>
            </div>

        </div>
    </div>
    </div>
</section>

<div class="container">
    <script src="https://www.paypal.com/sdk/js?client-id=AZ9TJGW1EqhHD1dwi2YrWVc15ji1rwEhWbBh4XpmaJ1fjC5amzii3eHkm7igXHu1tZs9z1UUL6UNmzat&currency=USD"></script>
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>
    <script>
        paypal.Buttons({
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $_SESSION['total_price']; ?>'
                        }
                    }]
                });
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {

                    window.location.href = 'delete-cart.php';
                });
            }
        }).render('#paypal-button-container');
    </script>
</div>

<?php require "../includes/footer.php"; ?>