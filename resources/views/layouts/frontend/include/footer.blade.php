<footer class="site-footer">
    <div class="container">
        <div class="row justify-content-between  section-padding">
            <div class=" col-xl-3 col-lg-4 col-sm-6">
                <div class="single-footer pb--40">
                    <div class="brand-footer footer-title">
                        <img src="image/logo--footer.png" alt="">
                    </div>
                    <div class="footer-contact">
                        <p><span class="label">Address:</span><span class="text">{{ isset($settings) ? $settings->address ?? "" : "" }}</span></p>
                        <p><span class="label">Phone:</span><span class="text">{{ isset($settings) ? $settings->phone ?? "" : "" }}</span></p>
                        <p><span class="label">Email:</span><span class="text">{{ isset($settings) ? $settings->email ?? "" : "" }}</span></p>
                    </div>
                </div>
            </div>
            
            <div class=" col-xl-3 col-lg-2 col-sm-6">
                <div class="single-footer pb--40">
                    <div class="footer-title">
                        <h3>Extras</h3>
                    </div>
                    <ul class="footer-list normal-list">
                        <li><a href="">About Us</a></li>
                        <li><a href="">Contact us</a></li>
                    </ul>
                </div>
            </div>
            <div class=" col-xl-3 col-lg-4 col-sm-6">
                
                <div class="social-block">
                    <h3 class="title">STAY CONNECTED</h3>
                    <ul class="social-list list-inline">
                        <li class="single-social facebook"><a href=""><i class="ion ion-social-facebook"></i></a>
                        </li>
                        <li class="single-social twitter"><a href=""><i class="ion ion-social-twitter"></i></a></li>
                        <li class="single-social google"><a href=""><i
                                    class="ion ion-social-googleplus-outline"></i></a></li>
                        <li class="single-social youtube"><a href=""><i class="ion ion-social-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
           
            <a href="#" class="payment-block">
                <img src="image/icon/payment.png" alt="">
            </a>
            <p class="copyright-text">Copyright © 2019 <a href="#" class="author">PharmaStore</a>. All Right Reserved.
                <br>
                Design By PharmaStore</p>
        </div>
    </div>
</footer>

<!-- start bottom notification area -->
<div class="notification-area">
	<p>This is Test Notification</p>
</div>
<!-- end bottom notification area -->

