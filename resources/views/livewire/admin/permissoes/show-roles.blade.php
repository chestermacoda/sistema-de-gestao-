     <div>
         <div id="tab-roles" class="perm-tab-content">
             <div class="perm-roles-grid">
                 <!-- Role Card: Super Admin -->
                 @foreach ($this->roles as $role)
                     @php
                         $roleClass = match ($role->name) {
                             'Admin'
                                 => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                            </svg>',
                             'Leiturista'
                                 => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>',
                             'Financeiro' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <line x1="12" x2="12" y1="2" y2="22" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>',
                             'Super Admin'
                                 => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>',
                             default => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M20 7h-9" />
                                <path d="M14 17H5" />
                                <circle cx="17" cy="17" r="3" />
                                <circle cx="7" cy="7" r="3" />
                            </svg>',
                         };
                     @endphp

                     <style>
                         .perm-{{ Illuminate\Support\Str::slug($role->name) }}-card::before {
                             background: var(--{{ $role->color }});
                         }

                         .perm-role-icon.perm-{{ Illuminate\Support\Str::slug($role->name) }} {
                             /* background: linear-gradient(135deg, var(--{{ $role->color }}), #b91c1c); */
                             background: var(--{{ $role->color }});
                         }

                         .perm-role-badge.perm-{{ Illuminate\Support\Str::slug($role->name) }} {
                             background: var(--{{ $role->color }}-light);
                             color: var(--{{ $role->color }});
                         }
                     </style>
                     <div class="perm-role-card perm-{{ Illuminate\Support\Str::slug($role->name) }}-card">
                         <div class="perm-role-card-header">
                             <div class="perm-role-icon perm-{{ Illuminate\Support\Str::slug($role->name) }}">
                                 {!! $roleClass !!}
                             </div>
                             <div class="perm-role-info">
                                 <div class="perm-role-name">{{ $role->name }}</div>
                                 <div class="perm-role-slug">{{ $role->slug }}</div>
                             </div>
                             <span class="perm-role-badge perm-{{ Illuminate\Support\Str::slug($role->name) }}">Guard:
                                 {{ $role->guard_name }}</span>
                         </div>
                         <div class="perm-role-stats">
                             <div class="perm-stat">
                                 <span class="perm-stat-value">{{ $role->permissions_count }}</span>
                                 <span class="perm-stat-label">Permissões</span>
                             </div>
                             <div class="perm-stat">
                                 <span class="perm-stat-value">{{ $role->users_count ?? 0 }}</span>
                                 <span class="perm-stat-label">Usuário</span>
                             </div>
                         </div>
                         <div class="perm-role-desc">
                             {{ $role->description }}
                         </div>
                         <div class="perm-role-footer">
                             <span class="perm-role-created">Criado em {{ $role->created_at->format('d/m/Y') }}</span>
                             <div style="display: flex; gap: var(--space-xs);">
                                 <button class="btn btn-sm btn-ghost" wire:click='editar({{ $role->id }},editar)'
                                     title="Editar">
                                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2">
                                         <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                     </svg>
                                 </button>
                                 <button class="btn btn-sm btn-ghost" wire:click='editar({{ $role->id }},ver)'
                                     title="Ver permissões">
                                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2">
                                         <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                         <circle cx="12" cy="12" r="3" />
                                     </svg>
                                 </button>
                             </div>
                         </div>
                     </div>
                 @endforeach

             </div>
         </div>




         <!-- Modal: Editar Role -->
         <div class="modal-overlay" id="modal-editar-role">
             <form wire:submit.prevent='updateRole' class="modal modal-lg">
                 <div class="modal-header">
                     <h3 class="modal-title">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                             <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                         </svg>
                         Editar Role
                     </h3>
                     <button class="modal-close" onclick="closeModal('modal-editar-role')">
                         <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M18 6 6 18" />
                             <path d="m6 6 12 12" />
                         </svg>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div id="form-editar-role">
                         <div
                             style="display: flex; align-items: center; gap: var(--space-lg); margin-bottom: var(--space-lg); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                             <div class="perm-role-icon perm-{{ Illuminate\Support\Str::slug($name) }}"
                                 style="width: 56px; height: 56px;">
                                 <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                 </svg>
                             </div>
                             <div>
                                 <div style="font-weight: 700; font-size: 1.125rem; color: var(--text-primary);">
                                     {{ $name }}</div>
                                 <div style="font-size: var(--label-size); color: var(--text-secondary);">
                                     {{ $slug }} • Guard:
                                     {{ $guard_name }}
                                 </div>
                                 <div style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                                     Criado em {{ $created_at }}</div>
                             </div>
                             <span class="perm-role-badge perm-{{ Illuminate\Support\Str::slug($name) }}"
                                 style="margin-left: auto;">Guard:
                                 {{ $guard_name }}</span>
                         </div>

                         <div class="grid-2">
                             <div class="form-group">
                                 <label class="form-label">Nome da Role</label>
                                 <input type="text" class="form-input" value="" wire:model='name'>
                             </div>
                             <div class="form-group">
                                 <label class="form-label">Slug</label>
                                 <input type="text" class="form-input" value="" wire:model='slug' readonly
                                     style="background: var(--neutral); font-family: monospace;">
                                 <span class="form-hint">O slug não pode ser alterado</span>
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="form-label">Descrição</label>
                             <textarea class="form-textarea" rows="3" wire:model='description'>Gestão operacional completa. Pode cadastrar e editar clientes, medidores, faturas e leituras.</textarea>
                         </div>
                         @if ($permissoes)
                             @foreach ($permissoes as $module => $permissions)
                                 <div class="perm-modulo-group">
                                     <div class="perm-modulo-header" onclick="toggleModuloPerm(this)">
                                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                             {!! $moduleIcons[$module] ?? '' !!}
                                         </svg>
                                         {{ $module }}
                                         <span class="perm-modulo-toggle">▼</span>
                                     </div>
                                     <div class="perm-modulo-list">
                                         @foreach ($permissions as $permission)
                                             <label class="perm-checkbox-item">
                                                 <input type="checkbox" wire:model="selectedPermissions"
                                                     value="{{ $permission['id'] }}">
                                                 <span>{{ $permission['name'] }}</span>

                                             </label>
                                         @endforeach
                                     </div>
                                 </div>
                             @endforeach
                         @endif
                         {{-- <div
                             style="border-top: 1px solid var(--neutral-dark); padding-top: var(--space-lg); margin-top: var(--space-lg);">
                             <h4
                                 style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                                 Permissões Atribuídas (28)</h4>
                             <div class="perm-role-permissoes-select">
                                 <div class="perm-modulo-group">
                                     <div class="perm-modulo-header" onclick="toggleModuloPerm(this)">
                                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                             <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                             <polyline points="9 22 9 12 15 12 15 22" />
                                         </svg>
                                         Dashboard
                                         <span class="perm-modulo-toggle">▼</span>
                                     </div>
                                     <div class="perm-modulo-list">
                                         <label class="perm-checkbox-item">
                                             <input type="checkbox" checked>
                                             <span>dashboard.view</span>
                                         </label>
                                         <label class="perm-checkbox-item">
                                             <input type="checkbox" checked>
                                             <span>dashboard.export</span>
                                         </label>
                                     </div>
                                 </div>
                                 <div class="perm-modulo-group">
                                     <div class="perm-modulo-header" onclick="toggleModuloPerm(this)">
                                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                             <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                             <circle cx="9" cy="7" r="4" />
                                             <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                             <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                         </svg>
                                         Clientes
                                         <span class="perm-modulo-toggle">▼</span>
                                     </div>
                                     <div class="perm-modulo-list">
                                         <label class="perm-checkbox-item">
                                             <input type="checkbox" checked>
                                             <span>clientes.view</span>
                                         </label>
                                         <label class="perm-checkbox-item">
                                             <input type="checkbox" checked>
                                             <span>clientes.create</span>
                                         </label>
                                         <label class="perm-checkbox-item">
                                             <input type="checkbox" checked>
                                             <span>clientes.edit</span>
                                         </label>
                                         <label class="perm-checkbox-item">
                                             <input type="checkbox" checked>
                                             <span>clientes.delete</span>
                                         </label>
                                     </div>
                                 </div>
                             </div>
                         </div> --}}
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-outline"
                         onclick="closeModal('modal-editar-role')">Cancelar</button>
                     <button type="button" class="btn btn-danger"
                         wire:click="$dispatch('confirm-action', {
                    message: 'Desejas eliminar esta Permissão?',
                    action: 'delete-roles',
                    payload: { id: {{ $roleId }} }
                    })"
                         style="margin-right: auto;">
                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M3 6h18" />
                             <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                             <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                         </svg>
                         Excluir Role
                     </button>
                     <button type="submit" class="btn btn-primary">
                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M20 6 9 17l-5-5" />
                         </svg>
                         Salvar Alterações
                     </button>
                 </div>
             </form>
         </div>


         <!-- Modal: Ver Role -->
         <div class="modal-overlay" id="modal-ver-role">
             <div class="modal modal-lg">
                 <div class="modal-header">
                     <h3 class="modal-title">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             style="vertical-align: middle; margin-right: 8px;">
                             <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                             <circle cx="12" cy="12" r="3" />
                         </svg>
                         Detalhes da Role
                     </h3>
                     <button class="modal-close" onclick="closeModal('modal-ver-role')">
                         <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M18 6 6 18" />
                             <path d="m6 6 12 12" />
                         </svg>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div
                         style="display: flex; align-items: center; gap: var(--space-lg); margin-bottom: var(--space-xl); padding: var(--space-lg); background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: var(--radius-lg); color: white;">
                         <div
                             style="width: 72px; height: 72px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 2rem; border: 3px solid rgba(255,255,255,0.3);">
                             <svg width="36" height="36" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                 <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                             </svg>
                         </div>
                         <div style="flex: 1;">
                             <div style="font-weight: 700; font-size: 1.5rem;">{{ $name }}</div>
                             <div style="font-size: var(--label-size); opacity: 0.9; margin-top: 4px;">
                                 {{ $name }} • Guard:
                                 {{ $guard_name }}
                             </div>
                             <div style="display: flex; gap: var(--space-sm); margin-top: var(--space-sm);">
                                 <span
                                     style="background: rgba(255,255,255,0.2); padding: var(--space-xs) var(--space-sm); border-radius: 9999px; font-size: var(--small-size); font-weight: 600;">{{ $role->permissions_count ?? 0 }}
                                     permissões</span>
                                 <span
                                     style="background: rgba(255,255,255,0.2); padding: var(--space-xs) var(--space-sm); border-radius: 9999px; font-size: var(--small-size); font-weight: 600;">{{ $role->users_count }}
                                     usuários</span>
                             </div>
                         </div>
                     </div>

                     <div class="perm-detail-grid">
                         <div class="perm-detail-section">
                             <h4
                                 style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                                 Informações</h4>
                             <div class="perm-detail-row">
                                 <span class="perm-detail-label">Slug</span>
                                 <span class="perm-detail-value"
                                     style="font-family: monospace;">{{ $slug }}</span>
                             </div>
                             <div class="perm-detail-row">
                                 <span class="perm-detail-label">Guard</span>
                                 <span class="perm-detail-value">{{ $guard_name }}</span>
                             </div>
                             <div class="perm-detail-row">
                                 <span class="perm-detail-label">Criada em</span>
                                 <span class="perm-detail-value">{{ $created_at }}</span>
                             </div>
                             <div class="perm-detail-row">
                                 <span class="perm-detail-label">Última atualização</span>
                                 <span class="perm-detail-value">{{ $updated_at }}</span>
                             </div>
                         </div>

                         <div class="perm-detail-section">
                             <h4
                                 style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                                 Estatísticas</h4>
                             <div class="perm-detail-row">
                                 <span class="perm-detail-label">Total de permissões</span>
                                 <span class="perm-detail-value">28 / 42</span>
                             </div>
                             <div class="perm-detail-row">
                                 <span class="perm-detail-label">Módulos cobertos</span>
                                 <span class="perm-detail-value">6 / 8</span>
                             </div>
                             <div class="perm-detail-row">
                                 <span class="perm-detail-label">Usuários ativos</span>
                                 <span class="perm-detail-value" style="color: var(--success);">3</span>
                             </div>
                             <div class="perm-detail-row">
                                 <span class="perm-detail-label">Taxa de uso</span>
                                 <span class="perm-detail-value" style="color: var(--success);">66.7%</span>
                             </div>
                         </div>
                     </div>

                     <div style="margin-top: var(--space-xl);">
                         <h4
                             style="font-size: var(--label-size); font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                             Permissões por Módulo</h4>
                         <div class="perm-modulos-grid">
                             @if ($permissoes)
                                 @foreach ($permissoes as $module => $permissions)
                                     <div class="perm-modulo-categoria">
                                         <div class="perm-modulo-categoria-title">
                                             <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2">
                                                 {!! $moduleIcons[$module] ?? '' !!}
                                             </svg>
                                             {{ $module }}
                                         </div>

                                         @foreach ($permissions as $permission)
                                             <div class="perm-modulo-item">
                                                 <span class="perm-modulo-label">{{ $permission['name'] }}</span>
                                                 <span style="color: var(--success); font-weight: 600;">✓</span>
                                             </div>
                                         @endforeach
                                     </div>
                                 @endforeach
                             @endif
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button class="btn btn-outline" onclick="closeModal('modal-ver-role')">Fechar</button>
                     {{-- <button class="btn btn-primary" wire:click='editar({{ $roleId }},editar)'>
                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                         </svg>
                         Editar Role
                     </button> --}}
                 </div>
             </div>
         </div>
     </div>
