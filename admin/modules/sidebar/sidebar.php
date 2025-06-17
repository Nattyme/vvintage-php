<?php

// Комментарии
$commentsNewCounter = R::count('comments', ' status = ?', ['new']);
$commentsDisplayLimit = 9; 


