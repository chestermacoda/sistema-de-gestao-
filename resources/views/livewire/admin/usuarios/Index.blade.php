@extends('admin.Layout.layouts')

@section('content')
    <div class="page-content">
        <!-- Page Header -->
        <div class="page-header">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <h1 class="page-title">Gestão de Usuários</h1>
                    <p class="page-subtitle">Administração de usuários, perfis e permissões do sistema</p>
                </div>
                <div style="display: flex; gap: var(--space-sm);">
                    <button wire:click="$dispatch('abrir-modal-auditoria')" class="btn btn-outline"
                        onclick="openModal('modal-audit')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                        </svg>
                        Logs de Auditoria
                    </button>


                    <button class="btn btn-primary" onclick="openModal('modal-novo-usuario')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                        Novo Usuário
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid" style="margin-bottom: var(--space-xl);">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $usuario->count() ?? 0 }}</div>
                    <div class="stat-label">Total de Usuários</div>
                    <div class="stat-change positive">+3 este mês</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $usuario->where('status', 'ativo')->count() ?? 0 }}</div>
                    <div class="stat-label">Usuários Ativos</div>
                    <div class="stat-change positive">87.5% do total</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $usuario->where('status', 'pendente')->count() ?? 0 }}</div>
                    <div class="stat-label">Pendentes</div>
                    <div class="stat-change negative">Aguardando ativação</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon danger">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="m15 9-6 6" />
                        <path d="m9 9 6 6" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $usuario->where('status', 'inativo')->count() ?? 0 }}</div>
                    <div class="stat-label">Inativos</div>
                    <div class="stat-change negative">Bloqueados</div>
                </div>
            </div>
        </div>

        <!-- Filters Bar -->
        <div class="card" style="padding: var(--space-md) var(--space-lg); margin-bottom: var(--space-lg);">
            <div style="display: flex; gap: var(--space-md); align-items: center; flex-wrap: wrap;">
                <div style="position: relative; flex: 1; min-width: 250px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2"
                        style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <input type="text" wire:model.live.debounce.500ms="search" class="form-input"
                        placeholder="Buscar por nome, e-mail, matrícula..." style="padding-left: 2.5rem;">
                </div>
                <select wire:model.live="status" class="form-select" style="width: auto; min-width: 160px;">
                    <option>Todos os Status</option>
                    <option>Ativo</option>
                    <option>Inativo</option>
                    <option>Pendente</option>
                </select>
                <select wire:model.live="role" class="form-select" style="width: auto; min-width: 160px;">
                    <option>Todos os Perfis</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <select wire:model.live="zona" class="form-select" style="width: auto; min-width: 160px;">
                    <option value="">Todas as Zonas</option>
                    <option value="Zona Norte">Zona Norte</option>
                    <option value="Zona Sul">Zona Sul</option>
                    <option value="Zona Leste">Zona Leste</option>
                    <option value="Zona Oeste">Zona Oeste</option>
                    <option value="Centro">Centro</option>
                </select>
                <button type="button" wire:click="export" class="btn btn-outline btn-sm">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" x2="12" y1="15" y2="3" />
                    </svg>
                    Exportar
                </button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs" style="margin-bottom: var(--space-lg);">
            <button class="tab {{ $tab == 'todos' ? 'active' : '' }}" wire:click="setTab('todos')"
                onclick="switchTabUsr(this, 'tab-todos')">Todos</button>
            <button class="tab {{ $tab == 'ativos' ? 'active' : '' }}" wire:click="setTab('ativos')"
                onclick="switchTabUsr(this, 'tab-ativos')">Ativos</button>
            <button class="tab {{ $tab == 'pendentes' ? 'active' : '' }}" wire:click="setTab('pendentes')"
                onclick="switchTabUsr(this, 'tab-pendentes')">Pendentes</button>
            <button class="tab {{ $tab == 'inativos' ? 'active' : '' }}" wire:click="setTab('inativos')"
                onclick="switchTabUsr(this, 'tab-inativos')">Inativos</button>
        </div>

        <!-- Usuários Grid -->
        <div class="usr-grid" style="margin-bottom: var(--space-xl);">
            <!-- Usuário 1 - Super Admin -->
            @foreach ($users as $userd)
                <style>
                    .usr-avatar-lg.usr-admin {
                        background: linear-gradient(135deg, var(--danger), #b91c1c);
                    }

                    .usr-session-status.usr-{{ $userd->status }} {
                        color: var(--success);
                    }
                </style>
                <div class="usr-card usr-{{ $userd->status }}">
                    <div class="usr-card-header">
                        <div class="usr-avatar-lg usr-admin">{{ strtoupper(substr($userd->name, 0, 2)) }}</div>
                        <div class="usr-info">
                            <div class="usr-nome"> {{ $userd->name }}</div>
                            <div class="usr-email"> {{ $userd->email }}</div>
                            @foreach ($userd->roles as $role)
                                <span class="usr-role-badge usr-{{ \Illuminate\Support\Str::slug($role->name) }}">
                                    ● {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                        <span class="usr-status-badge usr-{{ $userd->status }}">● {{ ucfirst($userd->status) }}</span>
                    </div>
                    <div class="usr-body">
                        <div class="usr-info-row">
                            <span class="usr-info-label">Matrícula</span>
                            <span class="usr-info-value" style="font-family: monospace;">USR-000</span>
                        </div>
                        <div class="usr-info-row">
                            <span class="usr-info-label">Telefone</span>
                            <span class="usr-info-value">(+258) {{ $userd->telefone }}</span>
                        </div>
                        <div class="usr-info-row">
                            <span class="usr-info-label">Zona</span>
                            <span class="usr-info-value">{{ $userd->zona }}</span>
                        </div>
                        @php
                            $counts = 0;
                            $userModules = $userd->getAllPermissions()->pluck('module')->unique()->toArray();
                        @endphp
                        <div class="usr-info-row">
                            <span class="usr-info-label">Permissões</span>
                            @foreach ($modules as $module)
                                @php
                                    $counts += in_array($module, $userModules);
                                @endphp
                            @endforeach
                            <span class="usr-info-value">Todas
                                ({{ $counts }}/{{ $modules->count() }})
                            </span>
                        </div>

                        <div class="usr-permissoes-preview">
                            @foreach ($modules as $module)
                                @php
                                    $hasModule = in_array($module, $userModules);
                                @endphp
                                <span class="usr-permissao-tag {{ $hasModule ? 'usr-ok' : 'usr-deny' }}">
                                    {{ $module }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="usr-footer">
                        <span class="usr-last-login">Último acesso:
                            {{ optional($userd->last_login_at)->format('d/m/Y H:i') }}</span>
                        <div style="display: flex; gap: var(--space-xs);">
                            {{-- onclick="openModal('modal-ver-usuario')" --}}

                            {{--
                            wire:click="$dispatch('confirm-action', { id: {{ $id }} })"

                            --}}
                            <button type="button" wire:click="viewUser({{ $userd->id }})"
                                class="btn btn-sm btn-ghost" title="Detalhes">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                            {{-- onclick="openModal('modal-editar-usuario')" wire:click="editUser({{ $user->id }})" --}}
                            @if ($userd->status == 'ativo')
                                <button type="button"
                                    wire:click="$dispatch('open-editUser', { id: {{ $userd->id }} })"
                                    class="btn btn-sm btn-ghost" title="Editar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                    </svg>
                                </button>
                                {{-- onclick="openModal('modal-permissoes')" --}}
                                <button type="button"
                                    wire:click="$dispatch('permitions-user', { id: {{ $userd->id }} })"
                                    class="btn btn-sm btn-ghost" title="Permissões">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            @elseif ($userd->status == 'pendente')
                                {{-- onclick="ativarUsuario()" --}}
                                <button type="button" wire:click="activateUser({{ $userd->id }})"
                                    class="btn btn-sm btn-primary" title="Ativar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M20 6 9 17l-5-5" />
                                    </svg>
                                </button>
                                {{-- onclick="rejeitarUsuario()" --}}
                                <button type="button" wire:click="reactivateUser({{ $userd->id }})"
                                    class="btn btn-sm btn-danger" title="Rejeitar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M18 6 6 18" />
                                        <path d="m6 6 12 12" />
                                    </svg>
                                </button>
                            @else
                                <button class="btn btn-sm btn-ghost" wire:click="reactivateUser({{ $userd->id }})"
                                    title="Reativar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                        <path d="M3 3v5h5" />
                                    </svg>
                                </button>
                            @endif



                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        @if ($users->hasPages())
            <div
                style="padding: var(--space-md) var(--space-lg); border-top: 1px solid var(--neutral-dark); display: flex; justify-content: space-between; align-items: center; background: var(--neutral);">

                <span style="font-size: var(--small-size); color: var(--text-muted);">
                    Mostrando {{ $users->firstItem() }} até {{ $users->lastItem() }} de
                    {{ $users->total() }} permissões
                </span>

                <div style="display: flex; gap: var(--space-sm);">
                    {{-- Botão Anterior --}}
                    @if ($users->onFirstPage())
                        <button class="btn btn-sm btn-ghost" disabled style="opacity: 0.5; cursor: not-allowed;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                        </button>
                    @else
                        <button wire:click="previousPage" wire:loading.attr="disabled" class="btn btn-sm btn-ghost">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                        </button>
                    @endif

                    {{-- Números das Páginas --}}
                    {{-- Gerando links simples para evitar a lógica complexa de "$elements" --}}
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        <button wire:click="gotoPage({{ $page }})" wire:key="page-{{ $page }}"
                            class="btn btn-sm {{ $page == $users->currentPage() ? 'btn-primary' : 'btn-ghost' }}"
                            style="min-width: 32px; justify-content: center;">
                            {{ $page }}
                        </button>
                    @endforeach

                    {{-- Botão Próximo --}}
                    @if ($users->hasMorePages())
                        <button wire:click="nextPage" wire:loading.attr="disabled" class="btn btn-sm btn-ghost">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </button>
                    @else
                        <button class="btn btn-sm btn-ghost" disabled style="opacity: 0.5; cursor: not-allowed;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- ==================== MODAIS ==================== -->


    <!-- Modal: Novo Usuário -->
    <livewire:admin.usuarios.create />
    <!-- Modal: Editar Usuário -->


    <!-- Modal: Ver Usuário (Detalhes) -->
    <div class="modal-overlay" id="modal-ver-usuario">
        <div class="modal modal-lg">
            <div class="modal-header">
                <h3 class="modal-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Detalhes do Usuário
                </h3>
                <button class="modal-close" onclick="closeModal('modal-ver-usuario')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <!-- Perfil Header -->

                <div
                    style="display: flex; align-items: center; gap: var(--space-lg); margin-bottom: var(--space-xl); padding: var(--space-lg); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: var(--radius-lg); color: white;">
                    <div
                        style="width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; border: 3px solid rgba(255,255,255,0.3);">
                        {{ strtoupper(substr(isset($user) ? $user->name : '', 0, 2)) }}</div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 1.5rem;">{{ isset($user) ? $user->name : '' }}</div>
                        <div style="font-size: var(--label-size); opacity: 0.9; margin-top: 4px;">
                            {{ isset($user->email) ? $user->email : '' }}
                        </div>
                        <div style="display: flex; gap: var(--space-sm); margin-top: var(--space-sm);">
                            @if ($user)
                                @foreach ($user->roles as $role)
                                    <span
                                        style="background: rgba(255,255,255,0.2); padding: var(--space-xs) var(--space-sm); border-radius: 9999px; font-size: var(--small-size); font-weight: 600;">●
                                        {{ $role->name }}</span>
                                @endforeach
                            @endif
                            <span
                                style="background: rgba(255,255,255,0.2); padding: var(--space-xs) var(--space-sm); border-radius: 9999px; font-size: var(--small-size); font-weight: 600;">●

                                @isset($user)
                                    {{ $user->status }}
                                @endisset

                            </span>
                        </div>
                    </div>
                </div>

                <div class="usr-detail-grid">
                    <!-- Informações Pessoais -->
                    <div class="usr-detail-section">
                        <h4
                            style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                            Informações</h4>
                        <div class="usr-detail-row">
                            <span class="usr-detail-label">Matrícula</span>
                            <span class="usr-detail-value" style="font-family: monospace;">USR-000</span>
                        </div>
                        <div class="usr-detail-row">
                            <span class="usr-detail-label">Telefone</span>
                            <span class="usr-detail-value">(+258)
                                {{ isset($user->telefone) ? $user->telefone : '' }}</span>
                        </div>
                        <div class="usr-detail-row">
                            <span class="usr-detail-label">Zona</span>
                            <span class="usr-detail-value">: {{ isset($user->zona) ? $user->zona : '' }}</span>
                        </div>
                        <div class="usr-detail-row">
                            <span class="usr-detail-label">Cadastrado em</span>
                            <span
                                class="usr-detail-value">{{ isset($user->created_at) ? $user->created_at->format('d/m/Y') : '' }}</span>
                        </div>
                        <div class="usr-detail-row">
                            <span class="usr-detail-label">Último acesso</span>
                            <span class="usr-detail-value">{{ isset($user->created_at) ? $user->created_at : '' }}</span>
                        </div>
                        <div class="usr-detail-row">
                            <span class="usr-detail-label">IP do último acesso</span>
                            <span class="usr-detail-value" style="font-family: monospace;">192.....</span>
                        </div>
                    </div>


                </div>

                <!-- Permissões Detalhadas -->
                <div style="margin-top: var(--space-xl);">
                    <h4
                        style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                        Permissões Detalhadas</h4>
                    <div class="usr-permissoes-grid">
                        @if ($permissoes)
                            @foreach ($permissoes as $module => $permissions)
                                <div class="usr-permissao-categoria">
                                    <div class="usr-permissao-categoria-title">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            {!! $moduleIcons[$module] ?? '' !!}
                                        </svg>
                                        {{ $module }}
                                    </div>
                                    @foreach ($permissions as $permission)
                                        <div class="usr-permissao-item">
                                            <span class="usr-permissao-label">{{ $permission['name'] }}
                                                {{-- <div class="usr-permissao-desc">Acesso à tela principal</div> --}}
                                            </span>
                                            <span style="color: var(--success); font-weight: 600;">✓ Permitido</span>
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Sessões Ativas -->
                <div style="margin-top: var(--space-xl);">
                    <h4
                        style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                        Sessões Ativas</h4>
                    <div class="usr-sessions-list">
                        @if ($sessions)
                            @forelse ($sessions as $session)
                                <div class="usr-session-item">
                                    <div class="usr-session-info">
                                        <div class="usr-session-device">
                                            @if (Str::contains($session->user_agent, ['Windows', 'Linux', 'Mac']))
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <rect width="18" height="12" x="3" y="4" rx="2"
                                                        ry="2" />
                                                    <line x1="2" x2="22" y1="20" y2="20" />
                                                </svg>
                                            @else
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <rect width="14" height="20" x="5" y="2" rx="2"
                                                        ry="2" />
                                                    <path d="M12 18h.01" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="usr-session-details">
                                            <div class="usr-session-name"> {{ $session->user_agent }}</div>
                                            <div class="usr-session-meta">IP: {{ $session->ip_address }} • Iniciada:
                                                {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    @if (session()->getId() == $session->id)
                                        <span class="usr-session-status usr-active">● Ativa agora</span>


                                        <button type="button" wire:click="encerrarSessao('{{ $session->id }}')"
                                            class="btn btn-sm btn-danger">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                        </button>
                                    @else
                                        <span class="usr-session-status" style="color: var(--text-muted);">

                                            ● Inativa
                                        </span>
                                        <button class="btn btn-sm btn-ghost" onclick="removerSessao(this)">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M3 6h18" />
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                            </svg>
                                        </button>
                                    @endif

                                </div>
                            @empty

                                <div class="text-muted">
                                    Nenhuma sessão encontrada.
                                </div>
                            @endforelse
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-ver-usuario')">Fechar</button>
                <button class="btn btn-primary"
                    wire:click="$dispatch('open-editUser', { id: {{ isset($userd) ? $userd->id : '' }} })">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                    </svg>
                    Editar Usuário
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Gerenciar Permissões -->
    <livewire:admin.usuarios.gerenciar-permissoes />

    <!-- Modal: Logs de Auditoria -->
    <livewire:admin.usuarios.log />
    {{-- <livewire:admin.usuarios.logs-auditorio /> --}}




    <!-- Toast Container -->
    <div id="toast-container"
        style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: var(--space-sm);">
    </div>
    <!-- ==================== SCRIPTS ==================== -->
    <script>
        // ======== TABS DE USUÁRIOS ========
        function switchTabUsr(btn, tabId) {
            document.querySelectorAll('.tabs .tab').forEach(tab => {
                tab.classList.remove('active');
            });

            btn.classList.add('active');

            const cards = document.querySelectorAll('.usr-card');

            cards.forEach(card => {
                if (tabId === 'tab-todos') {
                    card.style.display = '';
                } else if (tabId === 'tab-ativos') {
                    card.style.display = card.classList.contains('usr-ativo') ? '' : 'none';
                } else if (tabId === 'tab-pendentes') {
                    card.style.display = card.classList.contains('usr-pendente') ? '' : 'none';
                } else if (tabId === 'tab-inativos') {
                    card.style.display = card.classList.contains('usr-inativo') ? '' : 'none';
                }
            });
        }

        // ======== NOVO USUÁRIO ========
        function selectRole(card, role) {
            document.querySelectorAll('.usr-role-card').forEach(c => {
                c.classList.remove('usr-selected');
            });

            card.classList.add('usr-selected');
        }

        function gerarSenha() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%&*';
            let senha = '';

            for (let i = 0; i < 12; i++) {
                senha += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            document.getElementById('senha-provisoria').value = senha;

            showToast('Nova senha gerada com sucesso!', 'success');
        }

        function salvarUsuario() {
            if (!validateForm('form-novo-usuario')) {
                showToast('Preencha todos os campos obrigatórios.', 'error');
                return;
            }

            closeModal('modal-novo-usuario');

            showToast(
                'Usuário criado com sucesso! E-mail de boas-vindas enviado.',
                'success'
            );
        }

        // ======== EDITAR USUÁRIO ========
        function salvarEdicao() {
            closeModal('modal-editar-usuario');
            showToast('Alterações salvas com sucesso!', 'success');
        }

        function excluirUsuario() {
            confirmDelete(
                'Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.',
                function() {
                    closeModal('modal-editar-usuario');
                    showToast('Usuário excluído com sucesso.', 'success');
                }
            );
        }

        // ======== ATIVAR / REJEITAR / REATIVAR ========
        function ativarUsuario() {
            showToast('Usuário ativado com sucesso! Acesso liberado.', 'success');
        }

        function rejeitarUsuario() {
            confirmDelete(
                'Tem certeza que deseja rejeitar este usuário?',
                function() {
                    showToast('Convite rejeitado e usuário removido.', 'warning');
                }
            );
        }

        function reativarUsuario() {
            showToast('Usuário reativado com sucesso!', 'success');
        }

        // ======== PERMISSÕES ========
        function aplicarPreset(preset) {
            const checks = document.querySelectorAll('#modal-permissoes .perm-check');

            const presets = {
                leiturista: {
                    dashboard: [true, true],
                    clientes: [false, false, false],
                    medidores: [true, false, false],
                    leituras: [true, true, false],
                    faturas: [false, false, false],
                    pagamentos: [false, false, false],
                    usuarios: [false, false, false],
                    configuracoes: [false, false, false]
                },

                financeiro: {
                    dashboard: [true, true],
                    clientes: [true, false, false],
                    medidores: [false, false, false],
                    leituras: [false, false, false],
                    faturas: [true, true, false],
                    pagamentos: [true, true, true],
                    usuarios: [false, false, false],
                    configuracoes: [false, false, false]
                },

                admin: {
                    dashboard: [true, true],
                    clientes: [true, true, true],
                    medidores: [true, true, false],
                    leituras: [true, true, false],
                    faturas: [true, true, false],
                    pagamentos: [true, true, true],
                    usuarios: [false, false, false],
                    configuracoes: [false, false, false]
                }
            };

            const p = presets[preset];

            if (!p) return;

            checks.forEach(chk => {
                const modulo = chk.dataset.modulo;

                const items = document.querySelectorAll(
                    '.perm-check[data-modulo="' + modulo + '"]'
                );

                const vals = p[modulo] || [];

                items.forEach((item, idx) => {
                    item.checked = vals[idx] || false;
                });
            });

            showToast(
                'Preset "' +
                preset.charAt(0).toUpperCase() +
                preset.slice(1) +
                '" aplicado.',
                'success'
            );
        }

        function resetarPermissoes() {
            confirmDelete(
                'Deseja resetar as permissões para o padrão do perfil atual?',
                function() {
                    showToast('Permissões resetadas para o padrão.', 'warning');
                }
            );
        }

        function salvarPermissoes() {
            closeModal('modal-permissoes');
            showToast('Permissões salvas com sucesso!', 'success');
        }

        // ======== DETALHES DO USUÁRIO ========
        function encerrarSessao(btn) {
            const item = btn.closest('.usr-session-item');

            item.style.opacity = '0.5';

            btn.disabled = true;

            btn.innerHTML = `
            <svg width="14" height="14" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 6 9 17l-5-5"/>
            </svg>
        `;

            showToast('Sessão encerrada com sucesso.', 'success');
        }

        function removerSessao(btn) {
            const item = btn.closest('.usr-session-item');

            item.style.transition = 'all 0.3s';
            item.style.opacity = '0';
            item.style.transform = 'translateX(20px)';

            setTimeout(() => {
                item.remove();
            }, 300);

            showToast('Sessão removida do histórico.', 'success');
        }

        // ======== AUDITORIA ========
        function exportarAuditoria() {
            showToast(
                'Exportação iniciada. O download começará em breve.',
                'success'
            );
        }

        // ======== FILTROS ========
        document.addEventListener('DOMContentLoaded', function() {

            // Busca
            const searchInput = document.querySelector('.card input[type="text"]');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const term = this.value.toLowerCase();

                    document.querySelectorAll('.usr-card').forEach(card => {
                        const text = card.textContent.toLowerCase();

                        card.style.display = text.includes(term) ? '' : 'none';
                    });
                });
            }

            // Status
            const statusSelect = document.querySelector('.card select:nth-of-type(1)');

            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    const val = this.value.toLowerCase();

                    document.querySelectorAll('.usr-card').forEach(card => {
                        if (val === 'todos os status') {
                            card.style.display = '';
                        } else {
                            card.style.display = card.classList.contains('usr-' + val) ?
                                '' :
                                'none';
                        }
                    });
                });
            }

            // Perfil
            const perfilSelect = document.querySelector('.card select:nth-of-type(2)');

            if (perfilSelect) {
                perfilSelect.addEventListener('change', function() {
                    const val = this.value.toLowerCase();

                    document.querySelectorAll('.usr-card').forEach(card => {

                        if (val === 'todos os perfis') {
                            card.style.display = '';
                            return;
                        }

                        const badge = card.querySelector('.usr-role-badge');

                        const badgeText = badge ?
                            badge.textContent.toLowerCase() :
                            '';

                        card.style.display = badgeText.includes(val) ?
                            '' :
                            'none';
                    });
                });
            }

            // Zona
            const zonaSelect = document.querySelector('.card select:nth-of-type(3)');

            if (zonaSelect) {
                zonaSelect.addEventListener('change', function() {
                    const val = this.value.toLowerCase();

                    document.querySelectorAll('.usr-card').forEach(card => {

                        if (val === 'todas as zonas') {
                            card.style.display = '';
                            return;
                        }

                        const zonaValue = card.querySelector(
                            '.usr-info-row:nth-child(3) .usr-info-value'
                        );

                        const zonaText = zonaValue ?
                            zonaValue.textContent.toLowerCase() :
                            '';

                        card.style.display =
                            zonaText.includes(val.replace('zona ', '')) ||
                            zonaText.includes(val) ?
                            '' :
                            'none';
                    });
                });
            }
        });

        // ======== UTILITÁRIOS ========
        function confirmDelete(message, callback) {
            if (confirm(message || 'Tem certeza que deseja excluir este item?')) {
                callback();
            }
        }

        function validateForm(formId) {
            const form = document.getElementById(formId);

            if (!form) return true;

            let valid = true;

            form.querySelectorAll('[required]').forEach(field => {

                if (!field.value.trim()) {
                    field.style.borderColor = '#DC2626';
                    valid = false;
                } else {
                    field.style.borderColor = '';
                }
            });

            return valid;
        }
    </script>
@endsection
