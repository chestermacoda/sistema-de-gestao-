 <aside class="sidebar">
     <div class="sidebar-header">
         <div class="logo">

             <img src="{{ Storage::url(App\Models\Company::where('id', 1)->first()->logo) }}" class="logo-icon"
                 alt="">

             {{ App\Models\Company::where('id', 1)->first()->nome_fantasia }}
         </div>
     </div>
     <nav class="sidebar-nav">
         <div class="nav-section">
             <div class="nav-section-title">Principal</div>
             <a href="{{ route('admin.home') }}" class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                     <polyline points="9 22 9 12 15 12 15 22" />
                 </svg>
                 Dashboard
             </a>
             <a href="{{ route('admin.medidores') }}"
                 class="nav-item {{ request()->routeIs('admin.medidores') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <circle cx="12" cy="12" r="10" />
                     <path d="M12 6v6l4 2" />
                 </svg>
                 Medidores
             </a>
             <a href="{{ route('admin.leituras') }}"
                 class="nav-item {{ request()->routeIs('admin.leituras') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                     <polyline points="14 2 14 8 20 8" />
                     <line x1="16" x2="8" y1="13" y2="13" />
                     <line x1="16" x2="8" y1="17" y2="17" />
                     <polyline points="10 9 9 9 8 9" />
                 </svg>
                 Leituras
             </a>
             <a href="{{ route('admin.faturas') }}"
                 class="nav-item  {{ request()->routeIs('admin.faturas') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <rect width="20" height="14" x="2" y="5" rx="2" />
                     <line x1="2" x2="22" y1="10" y2="10" />
                 </svg>
                 Faturas
             </a>
             <a href="{{ route('admin.pagamentos') }}"
                 class="nav-item {{ request()->routeIs('admin.pagamentos') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <line x1="12" x2="12" y1="2" y2="22" />
                     <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                 </svg>
                 Pagamentos
             </a>
         </div>
         <div class="nav-section">
             <div class="nav-section-title">Gestão</div>

             <!-- Clientes: mantém o ícone de grupo (users) -->
             <a href="{{ route('admin.clientes') }}"
                 class="nav-item {{ request()->routeIs('admin.clientes') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                     <circle cx="9" cy="7" r="4" />
                     <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                     <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                 </svg>
                 Clientes
             </a>

             <!-- Usuários: ícone de usuário individual com engrenagem -->
             <a href="{{ route('admin.usuarios') }}"
                 class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                     <circle cx="12" cy="7" r="4" />
                     <path d="M17.5 8.5l1.5 1.5" />
                     <path d="M20 6l-1.5 1.5" />
                     <path d="M14 6l1.5 1.5" />
                     <path d="M17.5 5.5l1.5-1.5" />
                 </svg>
                 Usuários
             </a>

             <!-- Roteiro de Leituristas: ícone de mapa/rota -->
             <a href="{{ route('admin.roteiro') }}"
                 class="nav-item {{ request()->routeIs('admin.roteiro') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <polygon points="3 11 22 2 13 21 11 13 3 11" />
                 </svg>
                 Roteiro de Leituristas
             </a>

             <!-- Relatórios: ícone de gráfico/bar-chart -->
             <a href="{{ route('admin.relatorio') }}"
                 class="nav-item {{ request()->routeIs('admin.relatorio') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <line x1="18" x2="18" y1="20" y2="10" />
                     <line x1="12" x2="12" y1="20" y2="4" />
                     <line x1="6" x2="6" y1="20" y2="14" />
                 </svg>
                 Relatórios
             </a>
         </div>
         <div class="nav-section">
             <div class="nav-section-title">Sistema</div>

             <a href="{{ route('admin.configuracoes') }}"
                 class="nav-item {{ request()->routeIs('admin.configuracoes') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path
                         d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                     <circle cx="12" cy="12" r="3" />
                 </svg>
                 Configurações
             </a>
             <a href="{{ route('admin.configuracoes') }}"
                 class="nav-item {{ request()->routeIs('admin.configuracoes') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                     <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                 </svg>

                 Notificações
             </a>
             <a href="{{ route('admin.permissoes') }}"
                 class="nav-item {{ request()->routeIs('admin.permissoes') ? 'active' : '' }}">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                 </svg>
                 Permissões & Roles
             </a>
         </div>
     </nav>
     <div class="sidebar-footer">
         <div class="user-profile {{ request()->routeIs('admin.perfil') ? 'active' : '' }}"
             onclick="window.location.href='{{ route('admin.perfil') }}'">
             <div class="user-avatar">AD</div>
             <div class="user-info">
                 <div class="user-name">Admin Master</div>
                 <div class="user-role">{{ Auth()->user()->email }}</div>
             </div>
         </div>
     </div>
 </aside>
 <main class="main-content">
     <header class="top-header">
         <div class="header-search">
             <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2">
                 <circle cx="11" cy="11" r="8" />
                 <path d="m21 21-4.3-4.3" />
             </svg>
             <input type="text" placeholder="Pesquisar clientes, medidores, faturas...">
         </div>
         <div class="header-actions">
             <button class="icon-btn">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                     <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                 </svg>
                 <span class="badge">5</span>
             </button>
             <button class="icon-btn" onclick="toggleSidebar()">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <line x1="4" x2="20" y1="12" y2="12" />
                     <line x1="4" x2="20" y1="6" y2="6" />
                     <line x1="4" x2="20" y1="18" y2="18" />
                 </svg>
             </button>

             <!-- Dropdown de Perfil -->
             <div class="header-profile-dropdown">
                 <button class="header-profile-btn" onclick="toggleProfileDropdown(event)">
                     <div class="header-profile-avatar">AD</div>
                     <div class="header-profile-info">
                         <span class="header-profile-name">Admin Master</span>
                         <span class="header-profile-role">Super Administrador</span>
                     </div>
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" class="header-profile-chevron">
                         <polyline points="6 9 12 15 18 9" />
                     </svg>
                 </button>
                 <div class="header-profile-menu" id="profile-menu">
                     <div class="header-profile-header">
                         <div class="header-profile-avatar-lg">AD</div>
                         <div class="header-profile-details">
                             <span class="header-profile-name-lg">Admin Master</span>
                             <span class="header-profile-email">{{ Auth()->user()->email }}</span>
                         </div>
                     </div>
                     <div class="header-profile-divider"></div>
                     <a href="{{ route('admin.perfil') }}" class="header-profile-item">
                         <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                             <circle cx="12" cy="7" r="4" />
                         </svg>
                         Meu Perfil
                     </a>
                     <a href="{{ route('admin.configuracoes') }}" class="header-profile-item">
                         <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path
                                 d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                             <circle cx="12" cy="12" r="3" />
                         </svg>
                         Configurações
                     </a>
                     <div class="header-profile-divider"></div>
                     <form action="{{ route('logout') }}" method="POST">
                         @csrf
                         <button type="submit" class="header-profile-item header-profile-logout"
                             onclick="logout(event)">
                             <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                 <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                 <polyline points="16 17 21 12 16 7" />
                                 <line x1="21" x2="9" y1="12" y2="12" />
                             </svg>
                             Sair do Sistema
                         </button>
                     </form>
                 </div>
             </div>
         </div>
     </header>
