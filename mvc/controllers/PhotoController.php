<?php
class PhotoController extends Controller{
    
        
    public function show(int $id=0){
        
        //Auth::admin();
        
        $photo = Photo::findOrFail($id, "No se encontró la foto indicada.");
        
        $comments = $photo->hasMany('V_comment');
        
        
        
        $user= $photo->belongsTo('User');
        
        return view('photo/show',[
            'photo'     => $photo,
            'comments'  => $comments
        ]);
    }
    
    public function edit(int $id=0){
        
        //Login::oneRole(["ROLE_USER", "ROLE-ADMIN"]);
        
        //busca del usuario con ese ID
        $photo = Photo::findOrFail($id, "No se encontró la foto indicada.");
        
        //retorna una ViewResponse con la vista con la vista con el formulario de edición
        return view('photo/edit',[
            'photo'  => $photo
        ]);
    }
    
       
    public function create(int $idplace = 0){
        
        //Login::isAdmin();
        var_dump($idplace);
        
        return view('photo/create',[
            'idplace' => $idplace 
        ]);
    }
    
    public function store(){
        
        //Auth::admin();
        
        
        
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
        
    
    
    public function destroy(){
        
        //Auth::oneRole(['ROLE_ADMIN']);
        
        //comprueba que llega el formulario de confirmación
        if (!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación.');
            
            $id = intval(request()->post('id'));        //recupera el identificador
            $user = User::findOrFail($id);            //recupera el socio
            
            try{
                $user->deleteObject();
                
                if ($user->picture)
                    File::remove('../public/'.USERS_IMAGE_FOLDER.'/'.$user->picture, true);
                    
                    
                    Session::success("Se ha borrado de el usuario $user->displayname.");
                    return view("/User/list");
                    
            }catch (SQLException $e){
                
                Session::error("No se pudo borrar el usuario $user->displayname.");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/User/delete/$id");
                    
            }catch (FileException $e){
                Session::warning("Se eliminó el usuario pero no se pudo eliminar el fichero del disco.");
                
                if (DEBUG)
                    throw new FileException($e->getMessage());
                    
                    return redirect("/User");
                    
            }
    }
    
    
    public function dropcover(){
        
        //Auth::admin();
        
        if (!request()->has('borrar'))
            throw new FormException('Faltan datos para completar la operación');
            
            
            $id = request()->post('id');
            $user = User::findOrFail($id, "No se ha encontrado el usuario.");
            
            $tmp = $user->picture;
            $user->picture = NULL;
            
            try{
                $user->update();
                File::remove('../public/'.USER_IMAGE_FOLDER.'/'.$tmp, true);
                
                Session::success("Borrado de la foto del $user->displayname realizada.");
                return redirect("/User/edit/$id");
                
            }catch (SQLException $e){
                Session::error("No se pudo eliminar la portada");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/User/edit/$id");
                    
            }catch (FileException $e){
                Session::warning("No se pudo eliminar el fichero del disco");
                
                if (DEBUG)
                    throw new FileException($e->getMessage());
                    
                    return redirect("/User/edit/$user->id");
                    
            }
            
    }
    
    
    
}


