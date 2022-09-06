<?php
require('top.php');
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
    $customer_id = $_SESSION['USER_ID'];
    $cart = mysqli_query($con, "select * from cart where car_fk_cus_id = '$customer_id' order by car_id desc");
    if (mysqli_num_rows($cart) > 0) {
        $customer_details = mysqli_fetch_assoc(mysqli_query($con, "select * from customer where c_id = '$customer_id'"));
    } else {
?>
        <script>
            window.location.href = 'login.php';
        </script>
    <?php
    }
} else {
    ?>
    <script>
        window.location.href = 'login.php';
    </script>
    <?php
}


$address = '';
$phone = '';
$email = '';
$zip = '';
$credit_card_number = '';
$pin_code = '';
if (isset($_POST['submitBtn'])) {
    $address = get_safe_value($con, $_POST['o_address']);
    $phone = get_safe_value($con, $_POST['o_phone']);
    $email = get_safe_value($con, $_POST['o_email']);
    $zip = get_safe_value($con, $_POST['o_zip']);
    $cash_on_delivery = $_POST['cash_on_delivery_payment'] ?? "";
    $credit_card_payment = $_POST['credit_card_payment'] ?? "";
    $credit_card_number = get_safe_value($con, $_POST['credit_card_number']);
    $pin_code = get_safe_value($con, $_POST['credit_card_pin']);
    $date = date_create(date('y-m-d h:i:s'));
    date_add($date, date_interval_create_from_date_string("7 days"));
    $order_endDate = date_format($date, "y-m-d h:i:s");
    $added_on = date('y-m-d h:i:s');
    if ($cash_on_delivery == 1) {
        function check_id($con)
        {
            $order_id = rand(11111111, 99999999);
            $check_order_id = mysqli_query($con, "select * from orders where o_id = $order_id");
            if (mysqli_num_rows($check_order_id) > 0) {
                check_id($con);
            } else {
                return $order_id;
            }
        }
        $o_id = check_id($con);
        $res = mysqli_query($con, "INSERT INTO orders(o_id,o_fk_cus_id,o_address,o_phone,o_email,o_zip,o_total_amout,cash_payment,o_status,added_on,o_end_date) values('$o_id','$customer_id','$address','$phone','$email','$zip','$totalAmount',1,'Pending','$added_on','$order_endDate')");
        if ($res) {
            $product_id = 0;
            while ($cart_data = mysqli_fetch_assoc($cart)) {
                $product_id = $cart_data['car_fk_product_id'];
                mysqli_query($con, "INSERT INTO order_details(od_fk_product_id,od_product_qty,od_fk_o) values('$cart_data[car_fk_product_id]','$cart_data[car_product_qty]','$o_id')");

                $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$cart_data[car_fk_product_id]'"));

                $update_qty = $product['p_qty'] - $cart_data['car_product_qty'];
                mysqli_query($con, "update product set p_qty = '$update_qty' where p_id = '$cart_data[car_fk_product_id]'");

                $eo_id = check_id($con);
                $employee_order = mysqli_query($con, "INSERT INTO employee_orders(eo_id,eo_fk_cus_id,eo_fk_emp_id,eo_address,eo_phone,eo_email,eo_zip,cash_payment,eo_status,added_on) values('$eo_id','$customer_id','$product[p_added_by]','$address','$phone','$email','$zip',1,'Pending','$added_on')");

                mysqli_query($con, "INSERT INTO employee_order_details(eod_fk_product_id,eod_product_qty,eod_fk_o) values('$cart_data[car_fk_product_id]','$cart_data[car_product_qty]','$eo_id')");
            }
            $update_order = mysqli_query($con,"update orders set order_id_show = 1$product_id$o_id where o_id = '$o_id'");
            $_SESSION['ORDER_ID'] = '1' . $product_id . $o_id;
            $message = "Your Order Has Been Placed Order Status Is Pending Order Id #" . $_SESSION['ORDER_ID'] . " ";
            mysqli_query($con, "INSERT INTO notifications(n_text,n_fk_customer_id,added_on) values('$message','$customer_id','$added_on')");
            $delete_cart = mysqli_query($con, "delete from cart where car_fk_cus_id = '$customer_id'");
            if ($delete_cart) {
            ?>
                <script>
                    window.location.href = 'thank_you.php';
                </script>
            <?php
            }
        }
    } else if ($credit_card_payment == 1) {
        function check_id($con)
        {
            $order_id = rand(11111111, 99999999);
            $check_order_id = mysqli_query($con, "select * from orders where o_id = $order_id");
            if (mysqli_num_rows($check_order_id) > 0) {
                check_id($con);
            } else {
                return $order_id;
            }
        }
        $o_id = check_id($con);
        $eo_id = check_id($con);
        $res = mysqli_query($con, "INSERT INTO orders(o_id,o_fk_cus_id,o_address,o_phone,o_email,o_zip,o_total_amout,credit_card_number,credit_card_pin,o_status,added_on,o_end_date) values('$o_id','$customer_id','$address','$phone','$email','$zip','$totalAmount','$credit_card_number','$pin_code','Pending','$added_on','$order_endDate')");
        if ($res) {
            $product_id = 0;
            while ($cart_data = mysqli_fetch_assoc($cart)) {
                $product_id = $cart_data['car_fk_product_id'];
                mysqli_query($con, "INSERT INTO order_details(od_fk_product_id,od_product_qty,od_fk_o) values('$cart_data[car_fk_product_id]','$cart_data[car_product_qty]','$o_id')");

                $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$cart_data[car_fk_product_id]'"));
                $update_qty = $product['p_qty'] - $cart_data['car_product_qty'];
                mysqli_query($con, "update product set p_qty = '$update_qty' where p_id = '$cart_data[car_fk_product_id]'");

                $eo_id = check_id($con);
                $employee_order = mysqli_query($con, "INSERT INTO employee_orders(eo_id,eo_fk_cus_id,eo_fk_emp_id,eo_address,eo_phone,eo_email,eo_zip,credit_card_number,credit_card_pin,eo_status,added_on) values('$eo_id','$customer_id','$product[p_added_by]','$address','$phone','$email','$zip','$credit_card_number','$pin_code','Pending','$added_on')");

                mysqli_query($con, "INSERT INTO employee_order_details(eod_fk_product_id,eod_product_qty,eod_fk_o) values('$cart_data[car_fk_product_id]','$cart_data[car_product_qty]','$eo_id')");
            }
            $update_order = mysqli_query($con,"update orders set order_id_show = 2$product_id$o_id where o_id = '$o_id'");
            $_SESSION['ORDER_ID'] = '2' . $product_id . $o_id;
            $message = "Your Order Has Been Placed Order Status Is Pending Order Id #" . $_SESSION['ORDER_ID'] . " ";
            mysqli_query($con, "INSERT INTO notifications(n_text,n_fk_customer_id,added_on) values('$message','$customer_id','$added_on')");
            $delete_cart = mysqli_query($con, "delete from cart where car_fk_cus_id = '$customer_id'");
            if ($delete_cart) {
            ?>
                <script>
                    window.location.href = 'thank_you.php';
                    </script>
            <?php
            }
        }
    } else {
        ?>
        <script>
            alert("Please select payment method");
        </script>
<?php
    }
}
?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Checkout</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!--Checkout Area Strat-->
<div class="checkout-area pt-60 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <form method="POST" id="formData">
                    <div class="checkbox-form">
                        <h3>Customer Details</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>First Name <span class="required">*</span></label>
                                    <input type="text" style="border: 1px solid red;" disabled value="<?php echo $customer_details['c_firstname'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Last Name <span class="required">*</span></label>
                                    <input type="text" style="border: 1px solid red;" disabled value="<?php echo $customer_details['c_lastname'] ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Address <span class="required">*</span></label>
                                    <input type="text" name="o_address" value="<?php echo $customer_details['c_address'] ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Phone Number</label>
                                    <input type="number" style="background: #fff none repeat scroll 0 0;border: 1px solid #e5e5e5;" name="o_phone" value="<?php echo $customer_details['c_phone'] ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Postcode / Zip <span class="required">*</span></label>
                                    <input type="number" style="background: #fff none repeat scroll 0 0;border: 1px solid #e5e5e5;" name="o_zip" value="<?php echo $zip ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Email Address <span class="required">*</span></label>
                                    <input type="email" name="o_email" value="<?php echo $customer_details['c_email'] ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h3>Payment Method</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list create-acc">
                                    <input style="cursor: pointer;" name="credit_card_payment" id="cbox" type="checkbox" class="chk">
                                    <label style="cursor: pointer;" for="cbox">Credit Card Payment</label>
                                </div>
                                <div id="cbox-info" class="checkout-form-list create-account">
                                    <div class="col-md-12 mt-5">
                                        <label>Card Number <span class="required">*</span></label>
                                        <input type="number" name="credit_card_number" placeholder="16 digit credit card number" style="background: #fff none repeat scroll 0 0;border: 1px solid #e5e5e5;">
                                    </div>
                                    <div class="col-md-12 mt-20">
                                        <label>Pincode <span class="required">*</span></label>
                                        <input type="number" name="credit_card_pin" placeholder="4 digit pin code number" style="background: #fff none repeat scroll 0 0;border: 1px solid #e5e5e5;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list create-acc">
                                    <input style="cursor: pointer;" checked value="1" name="cash_on_delivery_payment" id="cashbox" type="checkbox" class="chk">
                                    <label style="cursor: pointer;" for="cashbox">Cash On Delivery</label>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="your-order">
                    <h3>Your order</h3>
                    <div class="your-order-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-product-name" style="font-weight: bold;">Product</th>
                                    <th class="cart-product-total" style="font-weight: bold;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($cart) > 0) {
                                    while ($cart_details = mysqli_fetch_assoc($cart)) {
                                        $product = mysqli_fetch_assoc(mysqli_query($con, "select * from product where p_id = '$cart_details[car_fk_product_id]'"));
                                ?>
                                        <tr style="font-weight: 500;" class="cart_item">
                                            <td class="cart-product-name"><?php echo $product['p_name'] ?>
                                                <strong class="product-quantity"> × <?php echo $cart_details['car_product_qty'] ?></strong>
                                                <div>Rs <?php echo $product['p_price'] ?></div>
                                            </td>
                                            <td class="cart-product-total"><span class="amount">Rs <?php echo $product['p_price'] * $cart_details['car_product_qty'] ?></span></td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr>
                                        <td>No Product In Cart</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <th style="font-weight: 700;">Order Total</th>
                                    <td><strong><span class="amount">Rs <?php echo $totalAmount ?></span></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div>
                        <div class="payment-accordion">
                            <div class="order-button-payment">
                                <input id="submit" value="Place order" name="submitBtn" type="submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Checkout Area End-->
<?php
require('footer.php');
?>
<script>
    $('input.chk').on('change', function() {
        $('input.chk').not(this).prop('checked', false).prop('value', 0);
        $(this).val(1);
        $(this).prop('checked', true);
        if(document.getElementById('cbox').value == '0'){
            $("#cbox-info").slideUp("slow");
        }else{
            $("#cbox-info").slideDown("slow");
        }
    });

    $('#formData').validate({
        rules: {
            o_address: {
                required: true,
                minlength: 3,
                maxlength: 50,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            o_phone: {
                required: true,
                minlength: 11,
                maxlength: 11,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            o_email: {
                required: true,
                email: true,
                maxlength: 50,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            o_zip: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            credit_card_number: {
                required: true,
                minlength: 16,
                maxlength: 16,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            credit_card_pin: {
                required: true,
                minlength: 4,
                maxlength: 4,
                normalizer: function (value) {
                    return $.trim(value);
                }
            }
        },
        messages: {
            o_address: {
                required: "Address is required",
                minlength: "minimum 3 letters ",
                maxlength: "maximum 50 letters",
            },
            o_phone: {
                required: "Phone number is required",
                minlength: "minimum 11 letters ",
                maxlength: "maximum 11 letters",
            },
            o_email: {
                required: "Email is required",
                email: "Invalid email",
                maxlength: "maximum 50 letters",
            },
            o_zip: {
                required: "Zip code is required",
            },
            credit_card_number: {
                required: "Credit card number is required",
                minlength: "minimum 16 letters ",
                maxlength: "maximum 16 letters",
            },
            credit_card_pin: {
                required: "Credit card pin is required",
                minlength: "minimum 4 letters ",
                maxlength: "maximum 4 letters",
                
            }
        }
    });

    $("#submit").click(function() {
        if ($("#formData").valid()) {}
    });
</script>