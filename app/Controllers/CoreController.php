<?php 
class CoreController {

    protected $router ;

    protected function show ($viewName,$viewData=[]) {
        require_once __DIR__ ."/../Views/".$viewName.tpl.php ;
    }


}