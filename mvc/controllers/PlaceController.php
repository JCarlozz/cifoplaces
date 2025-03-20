<?php
class PlaceController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(int $page = 1){
        //analiza si hay filtro
        $filtro = Filter::apply('places');
        
        //recupera el número de resultados por página
        $limit = RESULTS_PER_PAGE;
        
        //si hay filtro
        if($filtro){
            //recupera los lugares que cumplen los criterios del filtro
            $total = Place::filteredResults($filtro);
            
            //crea el objeto paginador
            $paginator = new Paginator('/Place/list', $page, $limit, $total);
            
            //recupera los lugares que cumplen con los criterios
            $places = Place::filter($filtro, $limit, $paginator->getOffset());
            
            //si no hay filtro
        }else{
            
            //recupera el total de libros
            $total = Place::total();
            
            //crea el objeto paginador
            $paginator = new Paginator('/Place/list', $page, $limit, $total);
            
            //recupera todos los libros
            $places = Place::orderBy('name', 'ASC', $limit, $paginator->getOffset());
            
        }
        //carga la vista
        return view('place/list', [
            'places'    => $places,
            'paginator' => $paginator,
            'filtro'    => $filtro
        ]);
    }
    
    public function show(int $id=0){
        
        $place = Place::findOrFail($id, "No se encontró el lugar indicado.");
        
        $comments = $place->hasMany('V_comment');
        
        $photos = $place->hasMany('Photo', 'idplace', 'id');
        
        return view('place/show',[
            'place'         => $place,
            'comments'      => $comments,
            'photos'        => $photos
        ]);
    }
    
    public function create(){
        
        //Auth::check();
        
        
        return view('place/create', [
            'place' => new Place()            
        ]);
    }
    
    
    
    public function store(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibió el formulario');
            
            $place = new Place();       //crea el lugar
            
            //toma los datos que llegan por POST
            $place->name            =request()->post('name');
            $place->type            =request()->post('type');
            $place->location        =request()->post('location');
            $place->description     =request()->post('description');
            
            $place->latitude        =request()->post('latitude');
            $place->longitude       =request()->post('longitude');
            
            
            //intenta guardar el libro, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo libro"
            
            try{
                
                if ($errores = $place->validate())
                    throw new ValidationException(
                        "<br>".arrayToString($errores, false, false, ".<br>"));
                        
                    
                    //guarda el libro en la base de datos
                    $place->save();
                    
                    
                    //recupera la portada como objeto UploadFile es null si no llega)
                    $file = request()->file(
                        'mainpicture',
                        8000000,
                        ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
                        );
                    
                    //si hay fichero, lo guardo y actualizamos el campo "portada"
                    if ($file){
                        $place->mainpicture = $file->store('../public/'.FOTO_IMAGE_FOLDER, 'FOTO_');
                        $place->update();
                    }
                    //flashea un mensaje de éxito en sesión
                    Session::success("Guardado del lugar $place->name correcto.");
                    
                    //redirecciona a los detalles del nuevo libro
                    return redirect("/Place/show/$place->id");
                    
                    //si hay un problema de validación...
            }catch (ValidationException $e){
                
                Session::error("Errores de validación.".$e->getMessage());
                
                //regresa al formulario de ceación del lugar
                return redirect("/Place/create");
                
                //si falla el guardado del lugar
            }catch (SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el lugar $place->name.");
                
                //si está en modo DEBUG vuelve a lanzar la excepción
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de libro
                    //los valores no deberián haberse borrado si usamos los helpers old()
                    return redirect("/Place/create");
                    
            }catch(UploadException $e){
                
                Session::warning("El lugar $place->name se guardó correctamente, pero no se pudo
                                subir el fichero de imagen.");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                    redirect("/Place/edit/$place->id");
            }
    }
    
    public function edit(int $id=0){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //busca el libro con ese ID
        $place = Place::findOrFail($id, "No se encontró el lugar.");
        
        //retorna una ViewResponse con la vista con la vista con el formulario de edición
        return view('place/edit',[
            'place'=> $place
        ]);
    }
    
    public function update(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        if (!request()->has('actualizar'))      //si no llega el formulario...
            throw new FormException('No se recibieron datos');
            
            $id= intval(request()->post('id'));     //recuperar el ID vía POST
            
            $place= Place::findOrFail($id, "No se ha encontrado el lugar.");
            
                        
            //toma los datos que llegan por POST
            $place->name            =request()->post('name');
            $place->type            =request()->post('type');
            $place->location        =request()->post('location');
            $place->description     =request()->post('description');
            $place->mainpicture     =request()->post('mainpicture');
            $place->latitude        =request()->post('latitude');
            $place->longitude       =request()->post('longitude');
            
            //intenta actualizar el libro
            try{
                $place->update();
                
                $file = request()->file(
                    'mainpicture',
                    8000000,
                    ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
                    );
                
                //si hay fichero, lo guardo y actualizamos el campo "portada"
                if ($file){
                    if ($place->mainpicture)    //elimina el fichero anterior (si lo hay)
                        File::remove('../public/'.FOTO_IMAGE_FOLDER.'/'.$place->mainpicture);
                        
                        $place->mainpicture = $file->store('../public/'.FOTO_IMAGE_FOLDER, 'PLA_');
                        $place->update();
                }
                Session::success("Actualización del lugar $place->name correcta.");
                return redirect("/Place/show/$id");
                
                //si se produce un error al guardar el libro...
            }catch (SQLException $e){
                
                Session::error("Hubo errores en la actualización del lugar $place->name.");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Place/edit/$id");
                    
            }catch (UploadException $e){
                Session::warning("Cambios guardados, pero no se modificó la portada.");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                    return redirect("/Place/edit/$id");
            }
    }
    
    public function delete(int $id = 0){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        $place = Place::findOrFail($id, "No existe el lugar.");
        
        return view('place/delete', [
            'place' =>$place
        ]);
    }
    
    public function destroy(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //comprueba que llega el formulario de confirmación
        if (!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación.');
            
            $id = intval(request()->post('id'));        //recupera el identificador
            $place = Place::findOrFail($id);            //recupera el lugar
            
            //sie lelibro tiene ejemplares, no permetimos el borrado
            //más adelante ocultaremos el botón de "Borrar" en estos casos
            //para que no el usuario no llegue al formulario de confirmación
            
            try{
                $place->deleteObject();
                
                if ($place->mainpicture)
                    File::remove('../public/'.FOTO_IMAGE_FOLDER.'/'.$place->mainpicture, true);
                    
                    
                    Session::success("Se ha borrado el lugar $place->name.");
                    return view("/Place/show/$place->id");
                    
            }catch (SQLException $e){
                
                Session::error("No se pudo borrar el lugar $place->name.");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Place/delete/$id");
                    
            }catch (FileException $e){
                Session::warning("Se eliminó el lugar pero no se pudo eliminar el fichero del disco.");
                
                if (DEBUG)
                    throw new FileException($e->getMessage());
                    
                    return redirect("/Place/list");
                    
            }
    }
    
    
}
