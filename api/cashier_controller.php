<?php

require_once __DIR__.'/../_init.php';

if (post('action') === 'proccess_order') {
    $order = Order::create();

    foreach ($_POST['cart_item'] as $item) {
        OrderItem::add($order->id, $item);
    }

    flashMessage('transaction', 'Successfull transaction.', FLASH_SUCCESS);
    redirect('../index.php');    
}
