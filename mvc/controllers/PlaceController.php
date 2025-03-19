<?php
class PlaceController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(int $page = 1){
        //analiza si hay filtro
        $filtro = Filter::apply('productos');
        
        //recupera el número de resultados por página
        $limit = RESULTS_PER_PAGE;
        
        //si hay filtro
        if($filtro){
            //recupera los productos que cumplen los criterios del filtro
            $total = Producto::filteredResults($filtro);
            
            //crea el objeto paginador
            $paginator = new Paginator('/Producto/list', $page, $limit, $total);
            
            //recupera los productos que cumplen con los criterios
            $productos = Producto::filter($filtro, $limit, $paginator->getOffset());
            
            //si no hay filtro
        }else{
            
            //recupera el total de libros
            $total = Producto::total();
            
            //crea el objeto paginador
            $paginator = new Paginator('/Producto/list', $page, $limit, $total);
            
            //recupera todos los libros
            $productos = Producto::orderBy('titulo', 'ASC', $limit, $paginator->getOffset());
            
        }
        //carga la vista
        return view('producto/list', [
            'productos' => $productos,
            'paginator' => $paginator,
            'filtro'    => $filtro
        ]);
    }
    
    public function show(int $id=0){
        
        $producto = Producto::findOrFail($id, "No se encontró el producto indicado.");
        
        
        return view('producto/show',[
            'producto'         => $producto
        ]);
    }
    
    public function create(){
        
        Auth::check();
        
        
        return view('producto/create', [
            'producto' => new Producto()
            
        ]);
    }
    
    
    
    public function store(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibió el formulario');
            
            $producto = new Producto();       //crea el producto
            
            //toma los datos que llegan por POST
            $producto->idusers      =request()->post('idusers');
            $producto->titulo       =request()->post('titulo');
            $producto->descripcion  =request()->post('descripcion');
            $producto->precio       =request()->post('precio');
            $producto->foto         =request()->post('foto');
            $producto->estado       =request()->post('estado');
            
            
            //intenta guardar el libro, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo libro"
            
            try{
                
                if ($errores = $producto->validate())
                    throw new ValidationException(
                        "<br>".arrayToString($errores, false, false, ".<br>")
                        );
                    
                    //guarda el libro en la base de datos
                    $producto->save();
                    
                    
                    //recupera la portada como objeto UploadFile es null si no llega)
                    $file = request()->file(
                        'foto',
                        8000000,
                        ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
                        );
                    
                    //si hay fichero, lo guardo y actualizamos el campo "portada"
                    if ($file){
                        $producto->foto = $file->store('../public/'.PRO_IMAGE_FOLDER, 'PRO_');
                        $producto->update();
                    }
                    //flashea un mensaje de éxito en sesión
                    Session::success("Guardado del producto $producto->titulo correcto.");
                    
                    //redirecciona a los detalles del nuevo libro
                    return redirect("/Producto/show/$producto->id");
                    
                    //si hay un problema de validación...
            }catch (ValidationException $e){
                
                Session::error("Errores de validación.".$e->getMessage());
                
                //regresa al formulario de ceación del producto
                return redirect("/Producto/create");
                
                //si falla el guardado del producto
            }catch (SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el producto $producto->titulo.");
                
                //si está en modo DEBUG vuelve a lanzar la excepción
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de libro
                    //los valores no deberián haberse borrado si usamos los helpers old()
                    return redirect("/Producto/create");
                    
            }catch(UploadException $e){
                
                Session::warning("El producto se guardó correctamente, pero no se pudo
                                subir el fichero de imagen.");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                    redirect("/Producto/edit/$producto->id");
            }
    }
    
    public function edit(int $id=0){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //busca el libro con ese ID
        $producto = Producto::findOrFail($id, "No se encontró el producto.");
        
        //retorna una ViewResponse con la vista con la vista con el formulario de edición
        return view('producto/edit',[
            'producto'=> $producto
        ]);
    }
    
    public function update(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        if (!request()->has('actualizar'))      //si no llega el formulario...
            throw new FormException('No se recibieron datos');
            
            $id= intval(request()->post('id'));     //recuperar el ID vía POST
            
            $producto= Producto::findOrFail($id, "No se ha encontrado el producto.");
            
            $producto->titulo       =request()->post('titulo');
            $producto->descripcion  =request()->post('descripcion');
            $producto->precio       =request()->post('precio');
            $producto->foto         =request()->post('foto');
            $producto->estado       =request()->post('estado');
            
            //intenta actualizar el libro
            try{
                $producto->update();
                
                $file = request()->file(
                    'portada',
                    8000000,
                    ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
                    );
                
                //si hay fichero, lo guardo y actualizamos el campo "portada"
                if ($file){
                    if ($producto->foto)    //elimina el fichero anterior (si lo hay)
                        File::remove('../public/'.PRO_IMAGE_FOLDER.'/'.$producto-foto);
                        
                        $producto->foto = $file->store('../public/'.PRO_IMAGE_FOLDER, 'PRO_');
                        $producto->update();
                }
                Session::success("Actualización del producto $producto->titulo correcta.");
                return redirect("/producto/show/$id");
                
                //si se produce un error al guardar el libro...
            }catch (SQLException $e){
                
                Session::error("Hubo errores en la actualización del producto $producto->titulo.");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Producto/edit/$id");
                    
            }catch (UploadException $e){
                Session::warning("Cambios guardados, pero no se modificó la portada.");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                    return redirect("/Producto/edit/$id");
            }
    }
    
    public function delete(int $id = 0){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        $producto = Producto::findOrFail($id, "No existe el producto.");
        
        return view('producto/delete', [
            'producto'=>$producto
        ]);
    }
    
    public function destroy(){
        
        //Auth::role('ROLE_LIBRARIAN');
        
        //comprueba que llega el formulario de confirmación
        if (!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación.');
            
            $id = intval(request()->post('id'));        //recupera el identificador
            $producto = Producto::findOrFail($id);            //recupera el producto
            
            //sie lelibro tiene ejemplares, no permetimos el borrado
            //más adelante ocultaremos el botón de "Borrar" en estos casos
            //para que no el usuario no llegue al formulario de confirmación
            
            try{
                $producto->deleteObject();
                
                if ($producto->foto)
                    File::remove('../public/'.PRO_IMAGE_FOLDER.'/'.$producto->foto, true);
                    
                    
                    Session::success("Se ha borrado el producto $producto->titulo.");
                    return view("/Producto/list");
                    
            }catch (SQLException $e){
                
                Session::error("No se pudo borrar el producto $producto->titulo.");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Producto/delete/$id");
                    
            }catch (FileException $e){
                Session::warning("Se eliminó el producto pero no se pudo eliminar el fichero del disco.");
                
                if (DEBUG)
                    throw new FileException($e->getMessage());
                    
                    return redirect("/Producto/list");
                    
            }
    }
    
    
}
