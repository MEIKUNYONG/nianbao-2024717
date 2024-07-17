<?php

use think\facade\Route;
// 变量规则
Route::pattern([
	"class"  => "[\w\-]+",
	"action" => "[\w\-]+",
]);
