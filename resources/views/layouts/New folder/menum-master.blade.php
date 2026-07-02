<!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       
        <div class="info">
        
        <a  href="{{ ROute('Usuarios.Atualizarsenha',Auth()->user()->id)}}"> <i class="fa fa-pencil-square" aria-hidden="true"> Alter ASenha </i></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview ">
            <a href="/home" class="nav-link  @if($_SERVER['REQUEST_URI']=='/home')  active @endif">
              <i class="nav-icon fa fa-tachometer-alt"></i>
              <p>
             Pagina Inicial 
                
              </p>
            </a>
          </li>
         


		   <li class="nav-item has-treeview  @if(
              $_SERVER['REQUEST_URI']=='/aluno/matricula'||
              $_SERVER['REQUEST_URI']=='/aluno/mensalida'||
              $_SERVER['REQUEST_URI']=='/aluno/aluno'
            )  menu-open @endif">
            <a href="#" class="nav-link @if(
              $_SERVER['REQUEST_URI']=='/aluno/matricula'||
              $_SERVER['REQUEST_URI']=='/aluno/mensalida'||
              $_SERVER['REQUEST_URI']=='/aluno/aluno'
            )  active @endif">
              <i class="fa fa-users fa fa-tachometer-alt"></i>
              <p>
                Registo Académico
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview  ">



     @can('Efetuar-matricula')
       
  
              <li class="nav-item">
                <a href="{{ Route('aluno.matricula') }}" class="nav-link  @if($_SERVER['REQUEST_URI']=='/aluno/matricula') active @endif">
                  <i class="fa  fa-pencil-square nav-icon" aria-hidden="true"></i>
                  <p> Matricula</p>
                </a>
              </li>
                 @endcan
                 @can('Visualizar-lista')
                   
                
              <li class="nav-item">
                <a href="{{ Route('aluno.index') }}" class="nav-link @if($_SERVER['REQUEST_URI']=='/aluno/aluno') active @endif">
                  <i class="fa fa-eye-slash nav-icon"></i>
                  <p> Alunos Inscritos </p>
                </a>
              </li>
 @endcan
   @can('Registar-Mensalidades')
     
  
              
              <li class="nav-item">
                <a href="{{ Route('mensalida.index') }}" class="nav-link  @if( $_SERVER['REQUEST_URI']=='/aluno/mensalida')  active @endif">
                  <i class="fa fa-money nav-icon"></i>
                  <p>Mensalidade</p>
                </a>
              </li>
           
 @endcan
 </ul>
          </li>


<!-- area adimin -->

 @can('Admin-menu')

		   <li class="nav-item has-treeview @if(
              $_SERVER['REQUEST_URI']=='/admin/Usuarios'|| 
              $_SERVER['REQUEST_URI']=='/admin/Usuarios/create' ||
              $_SERVER['REQUEST_URI']=='/admin/permissons/lista' 
              )  menu-open  @endif">
            <a href="#" class="nav-link  @if(
              $_SERVER['REQUEST_URI']=='/admin/Usuarios'||
              $_SERVER['REQUEST_URI']=='/admin/Usuarios/create' ||
              $_SERVER['REQUEST_URI']=='/admin/permissons/lista'
              )  active @endif ">
              <i class="nav-icon fa fa-cogs"></i>
              <p>
                Área administrativa 
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">


@can('visualizar-usuarios')

              <li class="nav-item">
                <a href="{{ Route('Usuarios.index') }}" class="nav-link  @if(
              $_SERVER['REQUEST_URI']=='/admin/Usuarios') active @endif">
                  <i class="fa fa-user-circle-o nav-icon"></i>
                  <p>Lista  de usuários </p>
                </a>
              </li>
			  
 @endcan
			 
			  @can('Registo-Usuario')
              <li class="nav-item">
                <a href="{{ Route('Usuarios.create') }}" class="nav-link  
                 @if($_SERVER['REQUEST_URI']=='/admin/Usuarios/create')   active @endif
                ">
                   <i class="fa fa-edit"></i>
                  <p>Registar usuários </p>
                </a>
              </li>
			  @endcan
@can('Criar-papel')
              </li>
              <li class="nav-item    ">
                <a href="{{ Route('Admin.permissons.lista') }}" class="nav-link @if($_SERVER['REQUEST_URI']=='/admin/permissons/lista')  active @endif">
                  <i class="fa fa-cog nav-icon"></i>
                  <p>Permissões do sistema </p>
                </a>
              </li>
            </ul>
          </li>
@endcan


@endcan

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
