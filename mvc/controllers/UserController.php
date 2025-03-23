<?php
    class UserController extends Controller {
        
        public function index(){
            
            //Auth::isCheck();
            
            return $this->list();
        }
        
        public function list(int $page = 1){
                        
            Login::isAdmin();
            
            //analiza si hay filtro
            $filtro = Filter::apply('users');
            
            //recupera el número de resultados por página
            $limit = RESULTS_PER_PAGE;
            
            //si hay filtro
            if($filtro){
                //recupera de ususarios que cumplen los criterios del filtro
                $total = User::filteredResults($filtro);
                
                //crea el objeto paginador
                $paginator = new Paginator('/User/list', $page, $limit, $total);
                
                //recupera los usuarios que cumplen los criterios del filtro
                $users = User::filter($filtro, $limit, $paginator->getOffset());
                
                //si no hay filtro
            }else{
                
                //recupera el total de usuarios
                $total = User::total();
                
                //crea el objeto paginador
                $paginator = new Paginator('/User/list', $page, $limit, $total);
                
                //recupera todos los usuarios
                $users = User::orderBy('displayname', 'ASC', $limit, $paginator->getOffset());
                
            }
            //carga la vista
            return view('user/list', [
                'users'    => $users,
                'paginator' => $paginator,
                'filtro'    => $filtro
            ]);
        }
        
        public function show(int $id=0){ 
            
            $user = User::findOrFail($id, "No se encontró el usuario.");
            
            if (Login::user()->id == $user->id ||  Login::isAdmin()) {
                
                echo "";
                
            } else {
                
                return redirect("/User/show/".user()->id);
                
            }
            
            $places = $user->hasMany('Place');
            
            return view('user/show',[
                'user'  => $user,
                'places' =>$places
            ]);
        }
        
       public function edit(int $id=0){
            
            
            
            //busca del usuario con ese ID
            $user = User::findOrFail($id, "No se encontró el usuario.");
            
            if (Login::isAdmin() || Login::user()->id == $user->id) {
                
                echo "Contenido restringido";
                
            } else {
                
                return redirect("/User/edit/".user()->id);
                
            }
                        
            //retorna una ViewResponse con la vista con la vista con el formulario de edición
            return view('user/edit',[
                'user'  => $user
            ]);
        }        
        
        
        public function create(){
            
            //Login::isAdmin();
            
            return view('user/create');
        }
        
        public function store(){
            
            //Auth::check();
            
            if(!request()->has('guardar'))
                throw new FormException('No se recibió el formulario');
                
                $user = new User();
                
                $user->password =md5($_POST['password']);
                $repeat         =md5($_POST['repeatpassword']);
                
                if ($user->password != $repeat)
                    throw new ValidationException("Las claves no coinciden.");
                    
                    $user->displayname   = request()->post('displayname');
                    $user->email         = request()->post('email');
                    $user->phone         = request()->post('phone');
                    
                    
                    $user->addRole('ROLE_USER');
                    
                    
                    try{
                        $user->save();
                        
                        $file = request()->file(
                            'picture',
                            8000000,
                            ['image/png', 'image/jpeg', 'image/gif']
                            );
                        
                        if ($file) {
                            $user->picture = $file->store('../public/'.USER_IMAGE_FOLDER, 'USER_');
                            $user->update();
                        }
                        
                        Session::success("Nuevo usuario $user->displayname creado con éxito.");
                        return redirect("/Place/list/");
                        
                    }catch (ValidationException $e){
                        
                        Session::error($e->getMessage());
                        return redirect("/User/create");
                        
                    }catch (SQLException $e){
                        
                        Session::error("Se produjo un error al guardar el usuario $user->displayname.");
                        
                        if(DEBUG)
                            throw new Exception($e->getMessage());
                            return redirect("/User/create");
                            
                    }catch (UploadException $e){
                        Session::warning("El usuario se guardó correctamente, pero no se pudo subir el fichero de imagen.");
                        
                        if (DEBUG)
                            throw new Exception($e->getMessage());
                            
                            return redirect("User/edit/$user->id");
                            
                    }
        }
      
      public function update(){
          
          //Auth::admin();
          
          if (!request()->has('actualizar'))      //si no llega el formulario...
              throw new FormException('No se recibieron datos');
              
              $id= intval(request()->post('id'));     //recuperar el ID vía POST
              
              $user= User::findOrFail($id, "No se ha encontrado el usuario.");
              
              $user->displayname           =request()->post('displayname');
              $user->email                 =request()->post('email');
              $user->phone                 =request()->post('phone');
              
              
              //intenta actualizar el usuario
              try{
                  $user->update();
                  
                  $file = request()->file(
                      'picture',
                      8000000,
                      ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
                      );
                  
                  //si hay fichero, lo guardo y actualizamos el campo "portada"
                  if ($file){
                      if ($user->picture)    //elimina el fichero anterior (si lo hay)
                          File::remove('../public/'.USER_IMAGE_FOLDER.'/'.$user->picture);
                          
                          $user->picture = $file->store('../public/'.USER_IMAGE_FOLDER, 'USER_');
                          $user->update();
                  }
                  Session::success("Actualización del usuario $user->displayname correcta.");
                  return redirect("/User/list");
                  
                  //si se produce un error al guardar el libro...
              }catch (SQLException $e){
                  
                  Session::error("Hubo errores en la actualización del usuario $user->displayname.");
                  
                  if(DEBUG)
                      throw new SQLException($e->getMessage());
                      
                      return redirect("/User/edit/$id");
                      
              }catch (UploadException $e){
                  Session::warning("Cambios guardados, pero no se modificó la imagen.");
                  
                  if(DEBUG)
                      throw new UploadException($e->getMessage());
                      
                      return redirect("/User/edit/$id");
              }
      }  
      
      public function delete(int $id = 0){
          
          Auth::check();
          
          $user = User::findOrFail($id, "No existe el usuario.");
          
          return view('user/delete', [
              'user'=>$user
          ]);
      }
      
      public function destroy(){
          
          Auth::check();
          
          //comprueba que llega el formulario de confirmación
          if (!request()->has('borrar'))
              throw new FormException('No se recibió la confirmación.');
              
              $id = intval(request()->post('id'));        //recupera el identificador
              $user = User::findOrFail($id);            //recupera el socio
              
                  try{
                      $user->deleteObject();
                      
                      if ($user->picture)
                          File::remove('../public/'.USER_IMAGE_FOLDER.'/'.$user->picture, true);
                          
                          
                          Session::success("Se ha borrado de el usuario $user->displayname.");
                          return redirect("/Logout");
                          
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
      
      public function addrole(){
          
          Auth::admin();
          
          if(empty(request()->post('add')))
              throw new FormException("No se recibió el formulario");
              
              $role = request()->post('role'); 
              $id = request()->post('id');;            
              
              $user   = User::findOrFail($id, "No se encontró el usuario");              
              
              try{
                  $user->addRole($role);
                  $user->update();
                  
                  Session::success("Se ha añadido '$role' al $user->displayname.");
                  return redirect("/User/list/");
                  
              }catch(SQLException $e){
                  
                  Session::error("No se pudo añadir el $user->roles al $user->displayname.");
                  
                  if(DEBUG)
                      throw new SQLException($e->getMessage());
                      
                      return redirect("/User/edit/$id");
              }
      }
      
      public function addTemplate() {
          if (!Login::check()) {
              throw new Exception("No tienes permiso para cambiar el template.");
          }
          
          $template = request()->post('template');
          
          // Validar que el template seleccionado esté en la lista permitida
          if (!in_array($template, TEMPLATE)) {
              throw new Exception("Template no válido.");
          }
          
          // Obtener el usuario actual
          $user = Login::user();
          
          $user->template = $template;
          
          $user->update();
          
          // Guardar el template en la sesión
          Session::set('template', $template);
          
          Session::success("Se cambió el template a $template.");
          return redirect("/User/show/$user->id");
      }
      
      public function removerole() {
          
          Auth::admin();
          
          if (empty(request()->post('remove'))) {
              throw new FormException("No se recibió el formulario");
          }
          
          $role = request()->post('role'); // Rol a eliminar
          $id = request()->post('id'); // ID del usuario
          
          // Buscar el usuario por ID
          $user = User::findOrFail($id);
          
          if (!$user) {
              throw new FormException("No se encontró el usuario.");
          }
          
          // Verificar si el usuario tiene el rol
          if (!in_array($role, $user->roles)) {
              throw new FormException("El usuario no tiene el rol especificado.");
          }
          
          try {
              // Eliminar el rol del array de roles
              $user->roles = array_values(array_diff($user->roles, [$role]));
              
              // Guardar cambios en la base de datos
              $user->update();
              
              Session::success("Se ha eliminado el rol '$role' de {$user->displayname}.");
              return redirect("/User/list/");
          } catch (SQLException $e) {
              Session::error("No se pudo eliminar el rol '$role' de {$user->displayname}.");
              
              if (DEBUG) {
                  throw new SQLException($e->getMessage());
              }
              
              return redirect("/User/edit/$user->id");
          }
      }
      
            
      public function dropcover(){
          
          
          
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
      
      public function checkemail(string $email = ''):JsonResponse{
          
          //esta operación solamente la puedes hacer el administrador, si el usuario
          //no tiene permiso para hacerla, retornaremos una JsonResponse de error
          
          
          //recupera el susuario con ese email
          $user = User::whereExactMatch(['email' => $email]);
          
          //retorna una nueva JsonResponse con el campo "found" a
          //true o false dependiendo de si lo ha encontrado o no  
          return new JsonResponse([
              'found' => $user ? true : false
          ]);
      }
      
      public function checkphone(string $phone = ''):JsonResponse{
          
          //esta operación solamente la puedes hacer el administrador, si el usuario
          //no tiene permiso para hacerla, retornaremos una JsonResponse de error
         
          
          //recupera el susuario con ese email
          $user = User::whereExactMatch(['phone' => $phone]);
          
          //retorna una nueva JsonResponse con el campo "found" a
          //true o false dependiendo de si lo ha encontrado o no
          return new JsonResponse([
              'found' => $user ? true : false
          ]);
      }      
            
}
     
  