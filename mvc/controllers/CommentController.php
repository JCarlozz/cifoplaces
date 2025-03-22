<?php
class CommentController extends Controller{
    
    
    public function store(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibió el formulario');
            
            $comment = new Comment();       //crea el comentario
            
            //toma los datos que llegan por POST
            $comment->text            =request()->post('text');
            $comment->idplace         =intval(request()->post('idplace'));
            $comment->iduser          =intval(user()->id);
                           
            
            //intenta guardar el comentario, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo libro"
            
            try{
                
                if ($errores = $comment->validate())
                    throw new ValidationException(
                        "<br>".arrayToString($errores, false, false, ".<br>")
                        );
                    
                    //guarda el libro en la base de datos
                    $comment->save();
                    
                    //$place = Comment::findOrFail($comment->idplace);
                    
                    //flashea un mensaje de éxito en sesión
                    Session::success("Guardado el comentario correctamente.");
                    
                    //redirecciona a los detalles del nuevo libro
                    return redirect("/Place/show/$comment->idplace");
                    
                    //si hay un problema de validación...
            }catch (ValidationException $e){
                
                Session::error("Errores de validación.".$e->getMessage());
                
                //regresa al formulario de ceación del lugar
                return redirect("/Place/show/$comment->idplace");
                
                //si falla el guardado del lugar
            }catch (SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el comentario.");
                
                //si está en modo DEBUG vuelve a lanzar la excepción
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa a la vista del lugar donde estan los comentarios
                    //los valores no deberián haberse borrado si usamos los helpers old()
                    return redirect("/Place/show/$comment->idplace");                    
            
            }
    }
    
    public function storephoto(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibió el formulario');
            
            $comment = new Comment();       //crea el comentario
            
            //toma los datos que llegan por POST
            $comment->text            =request()->post('text');
            $comment->idphoto         =intval(request()->post('idphoto'));
            $comment->iduser          =intval(user()->id);
            
            
            //intenta guardar el comentario, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo libro"
            
            try{
                
                if ($errores = $comment->validate())
                    throw new ValidationException(
                        "<br>".arrayToString($errores, false, false, ".<br>")
                        );
                    
                    //guarda el libro en la base de datos
                    $comment->save();
                    
                    //$place = Comment::findOrFail($comment->idplace);
                    
                    //flashea un mensaje de éxito en sesión
                    Session::success("Guardado el comentario correctamente.");
                    
                    //redirecciona a los detalles del nuevo libro
                    return redirect("/Photo/show/$comment->idphoto");
                    
                    //si hay un problema de validación...
            }catch (ValidationException $e){
                
                Session::error("Errores de validación.".$e->getMessage());
                
                //regresa al formulario de ceación del lugar
                return redirect("/Place/show/$comment->idphoto");
                
                //si falla el guardado del lugar
            }catch (SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el comentario.");
                
                //si está en modo DEBUG vuelve a lanzar la excepción
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa a la vista del lugar donde estan los comentarios
                    //los valores no deberián haberse borrado si usamos los helpers old()
                    return redirect("/Place/show/$comment->idphoto");
                    
            }
    }
    
      
    public function destroy(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //comprueba que llega el formulario de confirmación
        if (!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación.');
            
            
            $id = request()->post('id');        //recupera el identificador
            $comment = Comment::findOrFail($id);            //recupera el lugar
            
                        
            
            //sie lelibro tiene ejemplares, no permetimos el borrado
            //más adelante ocultaremos el botón de "Borrar" en estos casos
            //para que no el usuario no llegue al formulario de confirmación
            
            try{
                                                
                $comment->deleteObject();                
                
                
                Session::success("Se ha borrado el comentario.");
                return redirect("/Photo/show/$comment->idphoto");
                    
            }catch (SQLException $e){
                
                Session::error("No se pudo borrar el comentario.");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Place/show/$comment->idplace");
                    
            }
    }
    
    public function destroyplace(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //comprueba que llega el formulario de confirmación
        if (!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación.');
            
            
            $id = request()->post('id');        //recupera el identificador
            $comment = Comment::findOrFail($id);            //recupera el lugar
            
            
            
            //sie lelibro tiene ejemplares, no permetimos el borrado
            //más adelante ocultaremos el botón de "Borrar" en estos casos
            //para que no el usuario no llegue al formulario de confirmación
            
            try{
                
                $comment->deleteObject();
                
                
                Session::success("Se ha borrado el comentario.");
                return redirect("/Place/show/$comment->idplace");
                
            }catch (SQLException $e){
                
                Session::error("No se pudo borrar el comentario.");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Place/show/$comment->idplace");
                    
            }
    }
    
    public function edit(int $id=0){
        
        
        //busca del usuario con ese ID
        $comment = Comment::findOrFail($id, "No se encontró el comentario indicado.");
        
        $user = $comment->belongsTo('User');
        
        if(Login::user()->id == $user->id);
        
        //retorna una ViewResponse con la vista con la vista con el formulario de edición
        return view('photo/edit',[
            'comment'  => $comment,
            'user'   => $user
        ]);
    }
    
    public function update(){
        
        //Auth::admin();
        
        if (!request()->has('actualizar'))      //si no llega el formulario...
            throw new FormException('No se recibieron datos');
            
            $id= intval(request()->post('id'));     //recuperar el ID vía POST
            
            $comment= Comment::findOrFail($id, "No se ha encontrado el comentario.");
            
            $comment->text            =request()->post('text');
            
            $comment->iduser          =intval(user()->iduser);
            
            
            //intenta actualizar el usuario
            try{
                $comment->update();
                
               
                Session::success("Actualización el comentario correctamente.");
                return redirect("/Photo/show/$comment->idphoto");
                
                //si se produce un error al guardar el libro...
            }catch (SQLException $e){
                
                Session::error("Hubo errores en la actualización del comentario.");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Photo/show/$photo->idphoto");
            }
    }  
    
}