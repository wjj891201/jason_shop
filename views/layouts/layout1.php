<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use Yii;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <?php $this->registerMetaTag(['http-equiv' => 'Content-Type', 'content' => 'text/html; charset=UTF-8']); ?>
        <?php $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0, user-scalable=no']); ?>
        <?php $this->registerMetaTag(['name' => 'author', 'content' => '']); ?>
        <?php $this->registerMetaTag(['name' => 'robots', 'content' => 'all']); ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!-- Favicon -->
        <link rel="shortcut icon" href="/images/favicon.ico">
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div class="wrapper">
            <?php
            NavBar::begin([
                'options' => ['class' => 'top-bar animate-dropdown']
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
                        ['label' => '首页', 'url' => ['/index/index']],
                    !Yii::$app->user->isGuest ? (['label' => '我的购物车', 'url' => ['/cart/index']]) : '',
                    !Yii::$app->user->isGuest ? (['label' => '我的订单', 'url' => ['/order/index']]) : '',
                ]
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    Yii::$app->user->isGuest ? (['label' => '注册', 'url' => ['/member/auth']]) : '',
                    Yii::$app->user->isGuest ? (['label' => '登录', 'url' => ['/member/auth']]) : '',
                    !Yii::$app->user->isGuest ? ('欢迎您回来，' . Yii::$app->user->identity->username . Html::a('退出', ['/member/logout'])) : '',
                ]
            ]);
            NavBar::end();
            ?>

            <header>
                <div class="container no-padding">

                    <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                        <div class="logo">
                            <a href="<?= Url::to(['index/index']) ?>">
                                <img alt="logo" src="/images/logo.PNG" width="233" height="54"/>
                            </a>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder no-margin">
                        <div class="contact-row">
                            <div class="phone inline">
                                <i class="fa fa-phone"></i> (+086) 123 456 7890
                            </div>
                            <div class="contact inline">
                                <i class="fa fa-envelope"></i> contact@<span class="le-color">jason.com</span>
                            </div>
                        </div>

                        <div class="search-area">
                            <form>
                                <div class="control-group">
                                    <input class="search-field" placeholder="搜索商品" />

                                    <ul class="categories-filter animate-dropdown">
                                        <li class="dropdown">

                                            <a class="dropdown-toggle"  data-toggle="dropdown" href="category-grid.html">所有分类</a>

                                            <ul class="dropdown-menu" role="menu" >
                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="category-grid.html">电子产品</a></li>
                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="category-grid.html">电子产品</a></li>
                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="category-grid.html">电子产品</a></li>
                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="category-grid.html">电子产品</a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                    <a style="padding:15px 15px 13px 12px" class="search-button" href="#" ></a>    
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 top-cart-row no-margin">
                        <div class="top-cart-row-container">
                            <div class="top-cart-holder dropdown animate-dropdown">
                                <div class="basket">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <div class="basket-item-count">
                                            <span class="count"><?= count($this->params['cart']['products']) ?></span>
                                            <img src="/images/icon-cart.png" alt="" />
                                        </div>
                                        <div class="total-price-basket"> 
                                            <span class="lbl">您的购物车:</span>
                                            <span class="total-price">
                                                <span class="sign">￥</span><span class="value"><?= $this->params['cart']['total'] ?></span>
                                            </span>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach ((array) $this->params['cart']['products'] as $product): ?>
                                            <li>
                                                <div class="basket-item">
                                                    <div class="row">
                                                        <div class="col-xs-4 col-sm-4 no-margin text-center">
                                                            <div class="thumb">
                                                                <img alt="" src="<?= $product['cover'] ?>-picsmall" />
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-8 col-sm-8 no-margin">
                                                            <div class="title"><?= $product['title'] ?></div>
                                                            <div class="price">￥ <?= $product['price'] ?></div>
                                                        </div>
                                                    </div>
                                                    <a class="close-btn" href="<?= Url::to(['cart/del', 'cartid' => $product['cartid']]) ?>"></a>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                        <li class="checkout">
                                            <div class="basket-item">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-6">
                                                        <a href="<?= Url::to(['cart/index']) ?>" class="le-button inverse">查看购物车</a>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-6">
                                                        <a href="<?= Url::to(['cart/index']) ?>" class="le-button">去往收银台</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <?= $content; ?>
            <footer id="footer" class="color-bg">
                <div class="container">
                    <div class="row no-margin widgets-row">
                        <div class="col-xs-12  col-sm-4 no-margin-left">
                            <!-- ============================================================= FEATURED PRODUCTS ============================================================= -->
                            <div class="widget">
                                <h2>推荐商品</h2>
                                <div class="body">
                                    <ul>
                                        <?php foreach ($this->params['tui'] as $pro): ?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-9 no-margin">
                                                        <a href="<?= Url::to(['product/detail', 'productid' => $pro->productid]); ?>"><?= $pro->title ?></a>
                                                        <div class="price">
                                                            <div class="price-prev">￥<?= $pro->price ?></div>
                                                            <div class="price-current">￥<?= $pro->saleprice ?></div>
                                                        </div>
                                                    </div>  
                                                    <div class="col-xs-12 col-sm-3 no-margin">
                                                        <a href="<?= Url::to(['product/detail', 'productid' => $pro->productid]) ?>" class="thumb-holder">
                                                            <img alt="<?= $pro->title ?>" src="<?= $pro->cover ?>-picsmall" data-echo="<?= $pro->cover ?>-picsmall" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-4 ">
                            <div class="widget">
                                <h2>热卖商品</h2>
                                <div class="body">
                                    <ul>
                                        <?php foreach ($this->params['hot'] as $pro): ?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-9 no-margin">
                                                        <a href="<?= Url::to(['product/detail', 'productid' => $pro->productid]); ?>"><?= $pro->title ?></a>
                                                        <div class="price">
                                                            <div class="price-prev">￥<?= $pro->price ?></div>
                                                            <div class="price-current">￥<?= $pro->saleprice ?></div>
                                                        </div>
                                                    </div>  

                                                    <div class="col-xs-12 col-sm-3 no-margin">
                                                        <a href="<?= Url::to(['product/detail', 'productid' => $pro->productid]) ?>" class="thumb-holder">
                                                            <img alt="<?= $pro->title ?>" src="<?= $pro->cover ?>-picsmall" data-echo="<?= $pro->cover ?>-picsmall" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 ">
                            <div class="widget">
                                <h2>最新商品</h2>
                                <div class="body">
                                    <ul>
                                        <?php foreach ($this->params['new'] as $pro): ?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-9 no-margin">
                                                        <a href="<?= Url::to(['product/detail', 'productid' => $pro->productid]); ?>"><?= $pro->title ?></a>
                                                        <div class="price">
                                                            <div class="price-prev">￥<?= $pro->price ?></div>
                                                            <div class="price-current">￥<?= $pro->saleprice ?></div>
                                                        </div>
                                                    </div>  
                                                    <div class="col-xs-12 col-sm-3 no-margin">
                                                        <a href="<?= Url::to(['product/detail', 'productid' => $pro->productid]) ?>" class="thumb-holder">
                                                            <img alt="<?= $pro->title ?>" src="<?= $pro->cover ?>-picsmall" data-echo="<?= $pro->cover ?>-picsmall" />
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sub-form-row">
                    <!--<div class="container">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
                            <form role="form">
                                <input placeholder="Subscribe to our newsletter">
                                <button class="le-button">Subscribe</button>
                            </form>
                        </div>
                    </div>-->
                </div>
                <div class="link-list-row">
                    <div class="container no-padding">
                        <div class="col-xs-12 col-md-4 ">
                            <div class="contact-info">
                                <div class="footer-logo">
                                    <img alt="logo" src="/images/logo.PNG" width="233" height="54"/>
                                </div>
                                <p class="regular-bold"> 请通过电话，电子邮件随时联系我们</p>
                                <p>
                                    西城区二环到三环德胜门外大街10号TCL大厦3层(马甸桥南), 北京市西城区, 中国
                                    <br/>慕课网 (QQ群:416465236)
                                </p>
                                <!--<div class="social-icons">
                                    <h3>Get in touch</h3>
                                    <ul>
                                        <li><a href="http://facebook.com/transvelo" class="fa fa-facebook"></a></li>
                                        <li><a href="#" class="fa fa-twitter"></a></li>
                                        <li><a href="#" class="fa fa-pinterest"></a></li>
                                        <li><a href="#" class="fa fa-linkedin"></a></li>
                                        <li><a href="#" class="fa fa-stumbleupon"></a></li>
                                        <li><a href="#" class="fa fa-dribbble"></a></li>
                                        <li><a href="#" class="fa fa-vk"></a></li>
                                    </ul>
                                </div>-->
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-8 no-margin">
                            <div class="link-widget">
                                <div class="widget">
                                    <h3>最新商品</h3>
                                    <ul>
                                        <?php foreach ($this->params['new'] as $pro): ?>
                                            <li><a href="<?= Url::to(['product/detail', 'productid' => $pro->productid]) ?>"><?= $pro->title; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="link-widget">
                                <div class="widget">
                                    <h3>热门商品</h3>
                                    <ul>
                                        <?php foreach ($this->params['hot'] as $pro): ?>
                                            <li><a href="<?= Url::to(['product/detail', 'productid' => $pro->productid]) ?>"><?= $pro->title; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="link-widget">
                                <div class="widget">
                                    <h3>促销商品</h3>
                                    <ul>
                                        <?php foreach ($this->params['sale'] as $pro): ?>
                                            <li><a href="<?= Url::to(['product/detail', 'productid' => $pro->productid]) ?>"><?= $pro->title; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright-bar">
                    <div class="container">
                        <div class="col-xs-12 col-sm-6 no-margin">
                            <div class="copyright">
                                &copy; <a href="<?= Url::to(['index/index']) ?>">Imooc.com</a> - all rights reserved
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 no-margin">
                            <div class="payment-methods ">
                                <ul>
                                    <li><img alt="" src="/images/payments/payment-visa.png"></li>
                                    <li><img alt="" src="/images/payments/payment-master.png"></li>
                                    <li><img alt="" src="/images/payments/payment-paypal.png"></li>
                                    <li><img alt="" src="/images/payments/payment-skrill.png"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!--
                <script>
                    $("#createlink").click(function () {
                        $(".billing-address").slideDown();
                    });
                    $(".minus").click(function () {
                        var cartid = $("input[name=productnum]").attr('id');
                        var num = parseInt($("input[name=productnum]").val()) - 1;
                        if (parseInt($("input[name=productnum]").val()) <= 1) {
                            var num = 1;
                        }
                        var total = parseFloat($(".value.pull-right span").html());
                        var price = parseFloat($(".price span").html());
                        changeNum(cartid, num);
                        var p = total - price;
                        if (p < 0) {
                            var p = "0";
                        }
                        $(".value.pull-right span").html(p + "");
                        $(".value.pull-right.ordertotal span").html(p + "");
                    });
                    $(".plus").click(function () {
                        var cartid = $("input[name=productnum]").attr('id');
                        var num = parseInt($("input[name=productnum]").val()) + 1;
                        var total = parseFloat($(".value.pull-right span").html());
                        var price = parseFloat($(".price span").html());
                        changeNum(cartid, num);
                        var p = total + price;
                        $(".value.pull-right span").html(p + "");
                        $(".value.pull-right.ordertotal span").html(p + "");
                    });
                    function changeNum(cartid, num)
                    {
                        $.get('<?= Url::to(['cart/mod']) ?>', {'productnum': num, 'cartid': cartid}, function (data) {
                            location.reload();
                        });
                    }
                    var total = parseFloat($("#total span").html());
                    $(".le-radio.express").click(function () {
                        var ototal = parseFloat($(this).attr('data')) + total;
                        $("#ototal span").html(ototal);
                    });
                    $("input.address").click(function () {
                        var addressid = $(this).val();
                        $("input[name=addressid]").val(addressid);
                    });
                </script>-->
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
