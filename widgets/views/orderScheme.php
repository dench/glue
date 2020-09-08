<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 04.02.18
 * Time: 17:55
 *
 * @var $baseUrl string
 */
?>
<div class="card how mt-3 mb-4">
    <div class="card-body text-center">
        <div class="h1">Схема заказа</div>
        <div class="row">
            <div class="col-sm-4 px-lg-5">
                <div>
                    <img src="<?= $baseUrl . '/img/how-1.png' ?>" alt="Заказ товара">
                </div>
                <div class="my-2">
                    <a href="#" class="h3"><span class="text-primary">1.</span> Заказ товара</a>
                </div>
                <div class="text-muted">
                    Сделайте заказ на сайте через корзину либо свяжитесь по телефону.
                </div>
            </div>
            <div class="col-sm-4 px-lg-5">
                <div>
                    <img src="<?= $baseUrl . '/img/how-2.png' ?>" alt="100% предоплата">
                </div>
                <div class="my-2">
                    <a href="#" class="h3"><span class="text-primary">2.</span> Оплата</a>
                </div>
                <div class="text-muted">
                    Выберите удобную форму оплаты:<br>
                    - Оплата при получении<br>
                    - Оплата на сайте
                </div>
            </div>
            <div class="col-sm-4 px-lg-5">
                <div>
                    <img src="<?= $baseUrl . '/img/how-3.png' ?>" alt="Доставка">
                </div>
                <div class="my-2">
                    <a href="#" class="h3"><span class="text-primary">3.</span> Доставка</a>
                </div>
                <div class="text-muted">
                    Получите товар в отделении Новой Почты либо заберите сами в нашем офисе.
                </div>
            </div>
        </div>
    </div>
</div>