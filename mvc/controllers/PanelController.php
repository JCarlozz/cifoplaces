<?php
class PanelController extends Controller{
    
    public function index(){
        
        Auth::allRoles(["ROLE_ADMIN"]);
        
        return view('panel/list');
    }
    
    public function admin(){
        
        Auth::allRoles(["ROLE_ADMIN"]);
        
        return view('panel/paneladmin');
    }    
    
}