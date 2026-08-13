<div id="tab-usuarios" class="perm-tab-content">
    <div class="card" style="padding: 0; overflow: hidden;">
        <div
            style="padding: var(--space-lg); border-bottom: 1px solid var(--neutral-dark); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary);">
                    Usuários por Role</h3>
                <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                    Visualize a distribuição de usuários entre as roles</p>
            </div>
            <div style="display: flex; gap: var(--space-sm);">
                {{-- <select class="form-select" style="width: auto; min-width: 160px;">
                    <option>Todas as Roles</option>
                    <option>Super Admin</option>
                    <option>Administrador</option>
                    <option>Leiturista</option>
                    <option>Financeiro</option>
                    <option>Operador</option>
                    <option>Gerente Zona</option>
                    <option>Sem Role</option>
                </select> --}}
                <select class="form-select" style="width: auto; min-width: 160px;"
                    wire:change="setRoleFilter($event.target.value)">
                    <option value="all">Todas as Roles</option>
                    <option value="Super Admin">Super Admin</option>
                    <option value="Admin">Admin</option>
                    <option value="Leiturista">Leiturista</option>
                    <option value="Financeiro">Financeiro</option>
                    <option value="Operador">Operador</option>
                    <option value="Gerente Zona">Gerente Zona</option>
                </select>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="perm-users-table">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Matrícula</th>
                        <th>Role Principal</th>
                        <th>Roles Adicionais</th>
                        <th>Permissões Diretas</th>
                        <th>Status</th>
                        <th style="width: 100px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="perm-user-cell">
                                    <div class="perm-user-avatar perm-superadmin">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="perm-user-info">
                                        <div class="perm-user-name">{{ $user->name }}</div>
                                        <div class="perm-user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="perm-matricula">
                                    {{ $user->matricula ?? '—' }}
                                </span>
                            </td>

                            {{-- ROLE PRINCIPAL --}}
                            <td>
                                @if ($user->roles->first())
                                    <span class="perm-role-pill">
                                        {{ $user->roles->first()->name }}
                                    </span>
                                @else
                                    <span class="perm-empty">Sem Role</span>
                                @endif
                            </td>

                            {{-- ROLES ADICIONAIS --}}
                            <td>
                                @if ($user->roles->count() > 1)
                                    @foreach ($user->roles->skip(1) as $role)
                                        <span class="perm-role-pill-sm">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="perm-empty">—</span>
                                @endif
                            </td>

                            {{-- PERMISSÕES DIRETAS --}}
                            <td>
                                @if ($user->permissions->count())
                                    @foreach ($user->permissions as $perm)
                                        <span class="perm-perm-direct">
                                            {{ $perm->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="perm-empty">—</span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td>
                                <span class="perm-status-badge perm-ativo">
                                    {{ $user->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>

                            {{-- AÇÕES --}}
                            <td>
                                {{-- <button class="btn btn-sm btn-ghost"
                                    wire:click="$dispatch('open-user-roles', { id: {{ $user->id }} })"
                                    title="Gerenciar roles">
                                    ⚙️
                                </button> --}}

                                <button class="btn btn-sm btn-ghost" onclick="openModal('modal-gerenciar-user-roles')"
                                    title="Gerenciar roles">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                {{-- <tbody>
                    <tr>
                        <td>
                            <div class="perm-user-cell">
                                <div class="perm-user-avatar perm-superadmin">AM</div>
                                <div class="perm-user-info">
                                    <div class="perm-user-name">Admin Master</div>
                                    <div class="perm-user-email">admin@aquanexus.com.br</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="perm-matricula">USR-001</span></td>
                        <td><span class="perm-role-pill perm-superadmin">Super Admin</span></td>
                        <td><span class="perm-empty">—</span></td>
                        <td><span class="perm-empty">—</span></td>
                        <td><span class="perm-status-badge perm-ativo">Ativo</span></td>
                        <td>
                            <button class="btn btn-sm btn-ghost" onclick="openModal('modal-gerenciar-user-roles')"
                                title="Gerenciar roles">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="perm-user-cell">
                                <div class="perm-user-avatar perm-admin">FS</div>
                                <div class="perm-user-info">
                                    <div class="perm-user-name">Fernando Silva</div>
                                    <div class="perm-user-email">fernando.silva@aquanexus.com.br
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td><span class="perm-matricula">USR-002</span></td>
                        <td><span class="perm-role-pill perm-admin">Admin</span></td>
                        <td><span class="perm-empty">—</span></td>
                        <td><span class="perm-empty">—</span></td>
                        <td><span class="perm-status-badge perm-ativo">Ativo</span></td>
                        <td>
                            <button class="btn btn-sm btn-ghost" onclick="openModal('modal-gerenciar-user-roles')"
                                title="Gerenciar roles">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="perm-user-cell">
                                <div class="perm-user-avatar perm-leiturista">CM</div>
                                <div class="perm-user-info">
                                    <div class="perm-user-name">Carlos Mendes</div>
                                    <div class="perm-user-email">carlos.mendes@aquanexus.com.br
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td><span class="perm-matricula">USR-003</span></td>
                        <td><span class="perm-role-pill perm-leiturista">Leiturista</span></td>
                        <td><span class="perm-role-pill-sm perm-viewer">Viewer</span></td>
                        <td><span class="perm-empty">—</span></td>
                        <td><span class="perm-status-badge perm-ativo">Ativo</span></td>
                        <td>
                            <button class="btn btn-sm btn-ghost" onclick="openModal('modal-gerenciar-user-roles')"
                                title="Gerenciar roles">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="perm-user-cell">
                                <div class="perm-user-avatar perm-financeiro">AP</div>
                                <div class="perm-user-info">
                                    <div class="perm-user-name">Ana Paula Costa</div>
                                    <div class="perm-user-email">ana.costa@aquanexus.com.br
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td><span class="perm-matricula">USR-004</span></td>
                        <td><span class="perm-role-pill perm-financeiro">Financeiro</span></td>
                        <td><span class="perm-empty">—</span></td>
                        <td><span class="perm-perm-direct">faturas.cancel</span></td>
                        <td><span class="perm-status-badge perm-ativo">Ativo</span></td>
                        <td>
                            <button class="btn btn-sm btn-ghost" onclick="openModal('modal-gerenciar-user-roles')"
                                title="Gerenciar roles">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="perm-orphan-row">
                        <td>
                            <div class="perm-user-cell">
                                <div class="perm-user-avatar"
                                    style="background: var(--neutral-darker); color: var(--text-muted);">
                                    RS</div>
                                <div class="perm-user-info">
                                    <div class="perm-user-name" style="color: var(--text-muted);">
                                        Roberto Santos</div>
                                    <div class="perm-user-email">roberto.santos@email.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="perm-matricula">USR-005</span></td>
                        <td><span class="perm-role-pill perm-orphan">Sem Role</span></td>
                        <td><span class="perm-empty">—</span></td>
                        <td><span class="perm-empty">—</span></td>
                        <td><span class="perm-status-badge perm-pendente">Pendente</span></td>
                        <td>
                            <button class="btn btn-sm btn-ghost" onclick="openModal('modal-gerenciar-user-roles')"
                                title="Gerenciar roles">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody> --}}
            </table>
        </div>
    </div>
</div>
