<?php
class PhotoController extends Controller{
    
        
    public function show(int $id=0){
        
        //Auth::admin();
        
        $photo = Photo::findOrFail($id, "No se encontró la foto indicada.");
        
        $comments = $photo->hasMany('V_comment');
        
        $place = $photo->belongsTo('Place');       
        
        $user= $photo->belongsTo('User');
        
        return view('photo/show',[
            'photo'     => $photo,
            'comments'  => $comments,
            'user'      => $user,
            'place'     => $place
        ]);
    }
    
    public function edit(int $id=0){
        
        
        //busca del usuario con ese ID
        $photo = Photo::findOrFail($id, "No se encontró la foto indicada.");
        
        $user = $photo->belongsTo('User');        
        
        if(Login::user()->id == $user->id && $user->active);
        
        //retorna una ViewResponse con la vista con la vista con el formulario de edición
        return view('photo/edit',[
            'photo'  => $photo,
            'user'   => $user
        ]);
    }
    
    public function update(){
        
        //Auth::admin();
        
        if (!request()->has('actualizar'))      //si no llega el formulario...
            throw new FormException('No se recibieron datos');
            
            $id= intval(request()->post('id'));     //recuperar el ID vía POST
            
            $photo= Photo::findOrFail($id, "No se ha encontrado la foto.");
            
            $photo->name            =request()->post('name');
            $photo->alt             =request()->post('alt');
            $photo->description     =request()->post('description');
            $photo->date            =request()->post('date');
            $photo->time            =request()->post('time');
            $photo->idplace         =request()->post('idplace');
            $photo->iduser          =intval(user()->id);
            
            
            //intenta actualizar el usuario
            try{
                $photo->update();
                
                $file = request()->file(
                    'file',
                    8000000,
                    ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
                    );
                
                //si hay fichero, lo guardo y actualizamos el campo "portada"
                if ($file){
                    if ($photo->file)    //elimina el fichero anterior (si lo hay)
                        File::remove('../public/'.FOTO_IMAGE_FOLDER.'/'.$photo->file);
                        
                        $photo->file = $file->store('../public/'.FOTO_IMAGE_FOLDER, 'FOTO_');
                        $photo->update();
                }
                Session::success("Actualización la foto $photo->name correcta.");
                return redirect("/Photo/show/$photo->id");
                
                //si se produce un error al guardar el libro...
            }catch (SQLException $e){
                
                Session::error("Hubo errores en la actualización del usuario $user->displayname.");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Photo/edit/$photo->id");
                    
            }catch (UploadException $e){
                Session::warning("Cambios guardados, pero no se modificó la imagen.");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                    return redirect("/Photo/edit/$photo->id");
            }
    }  
    
       
    public function create(int $idplace = 0){
        
        //Login::isAdmin();
        var_dump($idplace);
        
        return view('photo/create',[
            'idplace' => $idplace 
        ]);
    }
    
    public function store(){        
        
        
        if(!request()->has('guardar'))
            throw new FormException('No se recibió el formulario');
            
            $photo = new Photo();
            
            $photo->name            =request()->post('name');            
            $photo->alt             =request()->post('alt');
            $photo->description     =request()->post('description');
            $photo->date            =request()->post('date');
            $photo->time            =request()->post('time'); 
            $photo->idplace         =request()->post('idplace');
            $photo->iduser          =intval(user()->id);
                
                
                try{                    
                    $file = request()->file(
                        'file',
                        8000000,
                        ['image/png', 'image/jpeg', 'image/gif']
                        );
                    
                    if ($file) {
                        $photo->file = $file->store('../public/' .FOTO_IMAGE_FOLDER, 'FOTO_');
                        $photo->save();
                    }
                    
                    Session::success("Nuevo foto $photo->name creado con éxito.");
                    return redirect("/Place/list");
                    
                }catch (ValidationException $e){
                    
                    Session::error($e->getMessage());
                    return redirect("/Photo/create");
                    
                }catch (SQLException $e){
                    
                    Session::error("Se produjo un error al guardar la foto $photo->name.");
                    
                    if(DEBUG)
                        throw new Exception($e->getMessage());
                        return redirect("/Photo/create");
                        
                }catch (UploadException $e){
                    Session::warning("La foto se guardó correctamente, pero no se pudo subir el fichero de imagen.");
                    
                    if (DEBUG)
                        throw new Exception($e->getMessage());
                        
                        return redirect("Photo/edit/$photo->id");
                        
                }
    }   
    
    public function delete(int $id = 0){
        
        //Auth::admin();
        
        $photo = Photo::findOrFail($id, "No existe la foto.");
        
        $user = $photo->belonsTo('User');
        
        if(Login::user()->id == $user->id && $user->active);
        
        return view('photo/delete', [
            'photo'=>$photo
        ]);
    }
        
    
    
    public function destroy(){
        
        if(Login::user()->id == $user->id && $user->active || Login::isAdmin());
        
        //comprueba que llega el formulario de confirmación
        if (!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación.');
            
            $id = intval(request()->post('id'));        //recupera el identificador
            $photo = Photo::findOrFail($id);            //recupera el socio
            
            try{
                $photo->deleteObject();
                
                if ($photo->file)
                    File::remove('../public/'.FOTO_IMAGE_FOLDER.'/'.$photo->file, true);
                    
                    
                    Session::success("Se ha borrado de el usuario $photo->name.");
                    return view("/Place/show/$id");
                    
            }catch (SQLException $e){
                
                Session::error("No se pudo borrar el usuario $photo->name.");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Photo/delete/$id");
                    
            }catch (FileException $e){
                Session::warning("Se eliminó el usuario pero no se pudo eliminar el fichero del disco.");
                
                if (DEBUG)
                    throw new FileException($e->getMessage());
                    
                    return redirect("/Place/list");
                    
            }
    }
    
    
    public function dropcover(){
        
        if(Login::user()->id == $user->id && $user->active || Login::isAdmin());
        
        if (!request()->has('borrar'))
            throw new FormException('Faltan datos para completar la operación');
            
            
            $id = request()->post('id');
            $photo = Photo::findOrFail($id, "No se ha encontrado la foto.");
            
            $tmp = $photo->file;
            $photo->file = NULL;
            
            try{
                $photo->update();
                File::remove('../public/'.FOTO_IMAGE_FOLDER.'/'.$tmp, true);
                
                Session::success("Borrado de la foto del $photo->name realizada.");
                return redirect("/Photo/show/$id");
                
            }catch (SQLException $e){
                Session::error("No se pudo eliminar la portada");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Photo/show/$id");
                    
            }catch (FileException $e){
                Session::warning("No se pudo eliminar el fichero del disco");
                
                if (DEBUG)
                    throw new FileException($e->getMessage());
                    
                    return redirect("//Photo/show/$id");
                    
            }
            
    }
    
    
    
}


