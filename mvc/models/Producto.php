<?php
    class Producto extends Model{
        
        public function productos(){
            
            return $this->hasMany('Producto', 'idusers'); // Especifica 'idusers' como clave foránea
        }
        
    }