<?php
function showErrors($errors, $name){
    if($errors->has($name)){
        echo ' <div class="alert alert-danger" role="alert">';
        echo '<strong>'.$errors->first($name).'</strong>';
         echo '</div>';
     } 
}
function getCate($cate,$parent,$tab,$idselect){
    foreach($cate as $value){
        if ($value['parent']==$parent) {
            if ($value['id']==$idselect) {
                echo '<option selected value="'.$value['id'].'">'.$tab.$value['name'].'</option>'; 
            }
            else{
                echo '<option value="'.$value['id'].'">'.$tab.$value['name'].'</option>';
            }
            
            getCate($cate,$value['id'],$tab.'--|',$idselect);
        }
    }
}
function showCate($arr,$parent,$tab){
    foreach($arr as $value){
        if($value['parent']==$parent){
           echo '<div class="item-menu"><span>'.$tab.$value['name'].'</span>';
			echo '<div class="category-fix">';
			echo '<a class="btn-category btn-primary" href="/admin/category/edit/'.$value['id'].'"><i class="fa fa-edit"></i></a>';
			echo '<a onclick="return DelCate('."'".$value->name."'".');"  class="btn-category btn-danger" href="/admin/category/del/'.$value['id'].'"><i class="fas fa-times"></i></i></a>';

			echo '</div>';
            echo '</div>';
            showCate($arr,$value['id'],$tab.'--|');
        }
    }
}


