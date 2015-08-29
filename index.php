<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015 https://www.fifiblog.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: LittleGreyGrey <lgg@mail.com> <https://www.fifiblog.com>
// +----------------------------------------------------------------------

/***
  *
  * index.php
  *
  * 首页
  * @author LittleGreyGrey<lgg@mail.com>
  *
  */

require 'Get_favicon.class.php';

$get_favicon = new Get_favicon;

$get_favicon->get($_REQUEST['u'], $_REQUEST['a']);

