<?php
/* WishlistController.php --- 
 * 
 * Filename: WishlistController.php
 * Description: 
 * Author: Gu Weigang  * Maintainer: 
 * Created: Tue Feb 25 21:08:15 2014 (+0800)
 * Version: 
 * Last-Updated: Tue Feb 25 21:23:33 2014 (+0800)
 *           By: Gu Weigang
 *     Update #: 7
 * 
 */

/* Change Log:
 * 
 * 
 */

/* This program is part of "Baidu Darwin PHP Software"; you can redistribute it and/or
 * modify it under the terms of the Baidu General Private License as
 * published by Baidu Campus.
 * 
 * You should have received a copy of the Baidu General Private License
 * along with this program; see the file COPYING. If not, write to
 * the Baidu Campus NO.10 Shangdi 10th Street Haidian District, Beijing The People's
 * Republic of China, 100085.
 */

/* Code: */

namespace BullSoft\Sample\Controllers;
use BullSoft\Sample\Models\Wishlist as WishlistModel;
    
class WishlistController extends ControllerBase
{
    public function createAction()
    {
		$productId = $this->request->getPost("product_id", "int");
        if(!$this->user) {
            $this->flashJson(403);
            return ;
        }
        $model = WishlistModel::findFirst("user_id=".$this->user->id." AND product_id=".$productId);
        if(empty($model)) {
            $model = new WishlistModel();
            $model->user_id = $this->user->id;
            $model->product_id = $productId;
            $time = date('Y-m-d H:i:s');
            $model->addtime = $time;
            $model->modtime = $time;
            if($model->save() == false) {
                $this->flashJson(500, array('type' => 'create'), "数据库插入失败");
                return;
            }
        }
		$model2 = WishlistModel::find("product_id=".$productId);
        $this->flashJson(200, array('type' => 'create', 'count'=> $model2->count()));
		return;
    }

    public function removeAction()
    {
        // $productId = 2;
		$productId = $this->request->getPost("product_id", "int");
		
        if(!$this->user) {
            $this->flashJson(403);
            return ;
        }
        $model = WishlistModel::findFirst("user_id=".$this->user->id." AND product_id=".$productId);
        if(!empty($model)) {
            if($model->delete() == false) {
                $this->flashJson(500, array('type' => 'remove'), "数据库delete失败");
                return;
            }
        }
		$model2 = WishlistModel::find("product_id=".$productId);
        $this->flashJson(200, array('type' => 'remove', 'count'=> $model2->count()));
		return ;
    }
}

/* WishlistController.php ends here */