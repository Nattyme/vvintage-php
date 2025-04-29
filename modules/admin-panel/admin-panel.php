<?php
// Сообщения
$messagesNewCounter = R::count('messages', ' status = ? ', ['new']);
$messagesDisplayLimit = 9; 

// Заказы
$ordersNewCounter = R::count('orders', ' status = ?', ['new']);
$ordersDisplayLimit = 9; 

// Комментарии
$commentsNewCounter = R::count('comments', ' status = ?', ['new']);
$commentsDisplayLimit = 9; 

