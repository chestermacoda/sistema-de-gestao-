<div>
    <div id="tab-permissoes" class="perm-tab-content ">
        <div class="card" style="padding: 0; overflow: hidden;">
            <div
                style="padding: var(--space-lg); border-bottom: 1px solid var(--neutral-dark); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary);">
                        Lista de Permissões</h3>
                    <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                        Todas as permissões registradas no Spatie Permission</p>
                </div>
                <div style="display: flex; gap: var(--space-sm);">
                    <div style="position: relative;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2"
                            style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <input type="text" class="form-input" wire:model.live="search"
                            placeholder="Buscar permissão..." style="padding-left: 2.5rem; width: 250px;">
                    </div>
                    <select class="form-select" wire:model.live="moduleFilter" style="width: auto; min-width: 140px;">
                        <option value="">Todos os Módulos</option>

                        <option value="Dashboard">Dashboard</option>
                        <option value="Clientes">Clientes</option>
                        <option value="Medidores">Medidores</option>
                        <option value="Leituras">Leituras</option>
                        <option value="Faturas">Faturas</option>
                        <option value="Pagamentos">Pagamentos</option>
                        <option value="Usuarios">Usuarios</option>
                        <option value="Configuracoes">Configuracoes</option>
                    </select>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table class="perm-list-table">
                    <thead>
                        <tr>
                            <th>Permissão</th>
                            <th>Módulo</th>
                            <th>Guard</th>
                            <th>Roles</th>
                            <th>Usuários</th>
                            <th>Criada em</th>
                            <th style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $permission)
                            <tr>
                                <td>
                                    <div class="perm-name-cell">
                                        <span class="perm-tag">{{ $permission->name }}</span>
                                        <span class="perm-desc">{{ $permission->description ?? '-' }}</span>
                                    </div>
                                </td>

                                <td>
                                    <span class="perm-modulo-tag">
                                        {{ $permission->module ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="perm-guard-badge">
                                        {{ $permission->guard_name }}
                                    </span>
                                </td>

                                <td>
                                    <span class="perm-count-badge">
                                        {{ $permission->roles->count() }} roles
                                    </span>
                                </td>

                                <td>
                                    <span class="perm-count-badge">
                                        {{ $permission->users_count ?? 0 }} users
                                    </span>
                                </td>

                                <td>
                                    {{ $permission->created_at->format('d/m/Y') }}
                                </td>


                                <td>
                                    <div style="display: flex; gap: var(--space-xs);">
                                        <button class="btn btn-sm btn-ghost"
                                            wire:click='edit({{ $permission->id }},editar)' title="Editar">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm btn-ghost"
                                            wire:click='edit({{ $permission->id }},ver)' {{-- onclick="openModal('modal-ver-permissao')" --}}
                                            title="Ver detalhes">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm btn-ghost"
                                            wire:click='edit({{ $permission->id }},ver)' {{-- onclick="openModal('modal-ver-permissao')" --}}
                                            title="Ver detalhes">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">

                                                <path d="M3 6h18" />
                                                <path d="M8 6V4h8v2" />
                                                <path d="M19 6l-1 14H6L5 6" />
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />

                                            </svg>
                                        </button>
                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding: 20px;">
                                    Nenhuma permissão encontrada
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <div
                style="padding: var(--space-md) var(--space-lg);
    border-top: 1px solid var(--neutral-dark);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--neutral);">

                <!-- Info -->
                <span style="font-size: var(--small-size); color: var(--text-muted);">
                    Mostrando {{ $permissions->firstItem() ?? 0 }}
                    até {{ $permissions->lastItem() ?? 0 }}
                    de {{ $permissions->total() }} permissões
                </span>

                <!-- Paginação -->
                <div style="display: flex; gap: var(--space-xs); align-items: center;">

                    {{-- Anterior --}}
                    @if ($permissions->onFirstPage())
                        <button class="btn btn-sm btn-ghost" disabled>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                        </button>
                    @else
                        <button class="btn btn-sm btn-ghost" wire:click="previousPage" wire:loading.attr="disabled">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                        </button>
                    @endif

                    {{-- Páginas --}}
                    @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $page => $url)
                        <button wire:click="gotoPage({{ $page }})"
                            class="btn btn-sm {{ $permissions->currentPage() === $page ? 'btn-primary' : 'btn-ghost' }}"
                            style="min-width: 34px; justify-content: center;">
                            {{ $page }}
                        </button>
                    @endforeach

                    {{-- Próxima --}}
                    @if ($permissions->hasMorePages())
                        <button class="btn btn-sm btn-ghost" wire:click="nextPage" wire:loading.attr="disabled">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </button>
                    @else
                        <button class="btn btn-sm btn-ghost" disabled>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </button>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Editar Permissão -->
    <div class="modal-overlay" id="modal-editar-permissao">
        <form wire:submit.prevent="update" class="modal modal-lg">
            <div class="modal-header">
                <h3 class="modal-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                    </svg>
                    Editar Permissão
                </h3>
                <button class="modal-close" onclick="closeModal('modal-editar-permissao')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div id="form-editar-permissao">
                    <div
                        style="display: flex; align-items: center; gap: var(--space-lg); margin-bottom: var(--space-lg); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                        <div
                            style="width: 56px; height: 56px; border-radius: var(--radius-md); background: rgba(0, 51, 102, 0.1); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 1.125rem; color: var(--text-primary);">
                                {{ $name }}</div>
                            <div style="font-size: var(--label-size); color: var(--text-secondary);">Guard: web •
                                Módulo: {{ $module }}</div>
                            <div style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                                Criado em {{ $data_create }}</div>
                        </div>
                        <span class="perm-modulo-tag" style="margin-left: auto;">Clientes</span>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Nome da Permissão</label>
                            <input type="text" class="form-input" wire:model="name" readonly
                                style="background: var(--neutral); font-family: monospace;">
                            <span class="form-hint">O nome não pode ser alterado</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nome de Exibição</label>
                            <input type="text" class="form-input" wire:model="display_name" required>
                            @error('display_name')
                                <span class="form-hint">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Módulo</label>
                            <select class="form-select" wire:model='module'>
                                <option value="Dashboard">Dashboard</option>
                                <option value="Clientes">Clientes</option>
                                <option value="Medidores">Medidores</option>
                                <option value="Leituras">Leituras</option>
                                <option value="Faturas">Faturas</option>
                                <option value="Pagamentos">Pagamentos</option>
                                <option value="Usuarios">Usuários</option>
                                <option value="Configurações">Configurações</option>
                            </select>
                            @error('module')
                                <span class="form-hint">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Guard</label>
                            <select class="form-select" wire:model='guard_name'>
                                <option value="web">web</option>
                                <option value="api">api</option>
                            </select>
                            @error('guard_name')
                                <span class="form-hint">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-textarea" rows="3" wire:model='description'></textarea>
                        @error('description')
                            <span class="form-hint">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Permite cadastrar novos clientes no sistema, incluindo dados pessoais, endereço e informações de ligação de água. --}}

                    <div
                        style="border-top: 1px solid var(--neutral-dark); padding-top: var(--space-lg); margin-top: var(--space-lg);">
                        <h4
                            style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                            Roles com esta Permissão ({{ $selectedPermission?->roles->count() ?? 0 }})</h4>
                        <div style="display: flex; flex-wrap: wrap; gap: var(--space-sm);">
                            {{-- <span class="perm-role-badge perm-superadmin">Super Admin</span>
                            <span class="perm-role-badge perm-admin">Admin</span>
                            <span class="perm-role-badge perm-gerente">Gerente Zona</span>
                            <span class="perm-role-badge perm-operador">Operador</span> --}}

                            @if ($selectedPermission && $selectedPermission->roles->count())
                                @foreach ($selectedPermission->roles as $role)
                                    @php
                                        $roleClass = match ($role->name) {
                                            'Admin' => 'perm-admin',
                                            'Gerente Zona' => 'perm-gerente',
                                            'Operador' => 'perm-operador',
                                            'Super Admin' => 'perm-superadmin',
                                            default => 'perm-default',
                                        };
                                    @endphp

                                    <span class="perm-role-badge {{ $roleClass }}">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            @else
                                <span style="color: var(--text-muted); font-size: var(--small-size);">
                                    Nenhum role associado
                                </span>
                            @endif


                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-outline"
                    onclick="closeModal('modal-editar-permissao')">Cancelar</button>
                <button type="button" class="btn btn-danger"
                    wire:click="$dispatch('confirm-action', {
                    message: 'Desejas eliminar esta Permissão?',
                    action: 'delete-permissao',
                    payload: { id: {{ $id }} }
                    })"
                    style="margin-right: auto;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                    </svg>
                    Excluir
                </button>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    <!-- Modal: Ver Permissão -->
    <div class="modal-overlay" id="modal-ver-permissao">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Detalhes da Permissão
                </h3>
                <button class="modal-close" onclick="closeModal('modal-ver-permissao')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div
                    style="display: flex; align-items: center; gap: var(--space-lg); margin-bottom: var(--space-xl); padding: var(--space-lg); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: var(--radius-lg); color: white;">
                    <div
                        style="width: 64px; height: 64px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border: 3px solid rgba(255,255,255,0.3);">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 1.25rem;">clientes.create</div>
                        <div style="font-size: var(--label-size); opacity: 0.9; margin-top: 4px;">Cadastrar Clientes
                        </div>
                        <div style="display: flex; gap: var(--space-sm); margin-top: var(--space-sm);">
                            <span
                                style="background: rgba(255,255,255,0.2); padding: var(--space-xs) var(--space-sm); border-radius: 9999px; font-size: var(--small-size); font-weight: 600;">4
                                roles</span>
                            <span
                                style="background: rgba(255,255,255,0.2); padding: var(--space-xs) var(--space-sm); border-radius: 9999px; font-size: var(--small-size); font-weight: 600;">16
                                users</span>
                        </div>
                    </div>
                </div>

                <div class="perm-detail-grid">
                    <div class="perm-detail-section">
                        <h4
                            style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                            Informações</h4>
                        <div class="perm-detail-row">
                            <span class="perm-detail-label">Nome</span>
                            <span class="perm-detail-value" style="font-family: monospace;">clientes.create</span>
                        </div>
                        <div class="perm-detail-row">
                            <span class="perm-detail-label">Exibição</span>
                            <span class="perm-detail-value">Cadastrar Clientes</span>
                        </div>
                        <div class="perm-detail-row">
                            <span class="perm-detail-label">Módulo</span>
                            <span class="perm-detail-value">Clientes</span>
                        </div>
                        <div class="perm-detail-row">
                            <span class="perm-detail-label">Guard</span>
                            <span class="perm-detail-value">web</span>
                        </div>
                        <div class="perm-detail-row">
                            <span class="perm-detail-label">Criada em</span>
                            <span class="perm-detail-value">10/01/2026</span>
                        </div>
                    </div>

                    <div class="perm-detail-section">
                        <h4
                            style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                            Estatísticas</h4>
                        <div class="perm-detail-row">
                            <span class="perm-detail-label">Total de roles</span>
                            <span class="perm-detail-value">4 / 7</span>
                        </div>
                        <div class="perm-detail-row">
                            <span class="perm-detail-label">Usuários afetados</span>
                            <span class="perm-detail-value" style="color: var(--success);">16</span>
                        </div>
                        <div class="perm-detail-row">
                            <span class="perm-detail-label">Usos (30 dias)</span>
                            <span class="perm-detail-value">342</span>
                        </div>
                        <div class="perm-detail-row">
                            <span class="perm-detail-label">Último uso</span>
                            <span class="perm-detail-value">08/05/2026 14:32</span>
                        </div>
                    </div>
                </div>

                <div style="margin-top: var(--space-xl);">
                    <h4
                        style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                        Descrição</h4>
                    <p style="font-size: var(--label-size); color: var(--text-secondary); line-height: 1.6;">
                        Permite cadastrar novos clientes no sistema, incluindo dados pessoais, endereço e informações de
                        ligação de água.
                        Esta permissão é necessária para acessar o formulário de cadastro e salvar novos registros na
                        base de dados.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-ver-permissao')">Fechar</button>
                <button class="btn btn-primary"
                    onclick="closeModal('modal-ver-permissao'); openModal('modal-editar-permissao')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                    </svg>
                    Editar
                </button>
            </div>
        </div>
    </div>




</div>
