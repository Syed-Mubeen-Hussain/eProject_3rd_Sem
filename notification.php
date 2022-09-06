<?php
require('top.php');
if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '') {
    $customer_id = $_SESSION['USER_ID'];
    $res = mysqli_query($con, "select * from notifications where n_fk_customer_id = '$customer_id' order by n_id desc");
    $notifications_count = mysqli_num_rows($res);
} else {
?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}
?>
<style>
    #main_div {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
    }

    #main_div #title {
        margin-bottom: 10px;
        font-size: 15px;
        font-weight: 400;
    }



    .row .card {
        width: 100%;
        margin-bottom: 5px;
        display: block;
        transition: opacity 0.3s;
    }

    .card-body {
        padding: 0.5rem;
    }

    .card-body table {
        width: 100%;
    }

    .card-body table tr {
        display: flex;
    }

    .card-body table tr td a.btn {
        font-size: 0.8rem;
        padding: 3px;
    }


    .card-body table tr td:nth-child(2) {
        text-align: right;
        justify-content: space-around;
    }

    .card-title:before {
        display: inline-block;
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 1.1rem;
        text-align: center;
        border: 2px solid grey;
        border-radius: 100px;
        width: 30px;
        height: 30px;
        padding-bottom: 3px;
        margin-right: 10px;
    }


    .notification-warning .card-body .card-title:before {
        color: #ffe082;
        border-color: #ffe082;
        content: "";
    }

    .notification-danger .card-body .card-title:before {
        color: #ffab91;
        border-color: #ffab91;
        content: "";
    }

    .notification-reminder .card-body .card-title:before {
        color: #ce93d8;
        border-color: #ce93d8;
        content: "";
    }

    .card.display-none {
        display: none;
        transition: opacity 2s;
    }
</style>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Notifications</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->


<div class="contact-main-page mt-60 mb-40 mb-md-40 mb-sm-40 mb-xs-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-5 col-md-12 order-2 order-lg-1" style="padding: 0px!important;">
                <h2 style="text-align: center;font-size: 28px;">Notifications (<?php echo $notifications_count ?>)</h2>
                <div class="row notification-container">
                    <div class="card notification-card notification-invitation" style="border: none;">
                        <div class="card-body" style="padding: 30px;">
                            <table>
                                <?php
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                ?>
                                        <tr>
                                            <td style="width: 100%;background: white;box-shadow: 0px 0px 3px 0px lightblue;padding: 10px 23px;border-radius: 12px;margin: 10px 0px;position:relative;">
                                                <div class="card-title" style="margin: 8px 0px;">
                                                    <div style="display: flex;align-items: center;">
                                                        <img src=" <?php echo IMAGE_SITE_PATH . "notification.png" ?>" style="width:38px;object-fit:cover;">
                                                        <span style="margin-left:10px;font-size:19px;width:100%;"> <?php echo $row['n_text'] ?></span>
                                                    </div>
                                                    <div style="color: #523eff;font-weight: 600;position: absolute;top: 24px;right: 21px;font-size: 14px;"><?php echo $row['added_on'] ?></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr id="main_div">
                                        <td id="title">
                                            There are no Notifications
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>