<div>
    <div class="modal-overlay" id="modal-novo-usuario" wire:ignore.self>
        <form wire:submit.prevent='save("create")' class="modal modal-lg">
            <div class="modal-header">
                <h3 class="modal-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    Novo Usuário
                </h3>
                <button type="button" class="modal-close" onclick="closeModal('modal-novo-usuario')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div id="form-novo-usuario">
                    <!-- Seleção de Perfil -->
                    <div class="form-group">
                        <label class="form-label">Perfil de Acesso</label>
                        <div class="usr-role-selector">

                            @if ($roles)
                                @php
                                    $var = null;
                                    $admin = null;
                                @endphp
                                @foreach ($roles as $role)
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
                                        .usr-role-badge.usr-{{ Illuminate\Support\Str::slug($role->name) }} {
                                            background: var(--{{ $role->color }}-light);
                                            color: var(--{{ $role->color }});
                                        }

                                        .usr-role-icon.usr-{{ Illuminate\Support\Str::slug($role->name) }} {
                                            background: linear-gradient(135deg, var(--{{ $role->color }}));
                                        }
                                    </style>
                                    @if ($role->slug === 'super-admin')
                                        @php
                                            $var = 'Acesso total ao sistema';
                                            $admin = $role->name;
                                        @endphp
                                    @else
                                        @php $var = $role->name;  @endphp
                                    @endif
                                    <div class="usr-role-card {{ $roleActive == $role->name ? 'usr-selected' : '' }} "
                                        wire:click='AddRole("{{ $role->name }}")'
                                        onclick="selectRole(this, '{{ $admin }}')">
                                        <div class="usr-role-icon usr-{{ Illuminate\Support\Str::slug($role->name) }}">

                                            {!! $roleClass !!}

                                        </div>
                                        <div class="usr-role-name">{{ $role->name }}</div>
                                        <div class="usr-role-desc">
                                            {{ $var }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Nome Completo *</label>
                            <input type="text" class="form-input" placeholder="Ex: João da Silva"
                                wire:model.defer="name" required>
                            @error('name')
                                <span style="color: var(--danger)">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">E-mail *</label>
                            <input type="email" class="form-input" placeholder="joao.silva@email.com"
                                wire:model.defer="email" required>
                            @error('email')
                                <span style="color: var(--danger)">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Matrícula</label>
                            <input type="text" class="form-input" placeholder="Gerado automaticamente" readonly
                                style="background: var(--neutral); color: var(--text-muted);">
                            <span class="form-hint">Gerado automaticamente pelo sistema</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telefone</label>
                            <input type="tel" class="form-input" placeholder="(11) 99999-9999"
                                wire:model.defer="telefone">
                            @error('email')
                                <span style="color: var(--danger)">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Zona de Atuação</label>
                            <select class="form-select" wire:model.defer="zona">
                                <option value="Todas as Zonas">Todas as Zonas</option>
                                <option value="Zona Norte">Zona Norte</option>
                                <option value="Zona Sul">Zona Sul</option>
                                <option value="Zona Leste">Zona Leste</option>
                                <option value="Zona Oeste">Zona Oeste</option>
                                <option value="Centro">Centro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status Inicial</label>
                            <select class="form-select" wire:model.defer='status'>
                                <option value="ativo">Ativo</option>
                                <option value="pendente">Pendente (enviar convite)</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Senha Provisória</label>
                        <div style="display: flex; gap: var(--space-sm);">
                            <input type="text" class="form-input" id="senha-provisoria" wire:model.defer="password"
                                value="AquaNexus@2026" readonly
                                style="background: var(--neutral); font-family: monospace;">
                            <button type="button" class="btn btn-outline" onclick="gerarSenha()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                    <path d="M3 3v5h5" />
                                    <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                                    <path d="M16 21h5v-5" />
                                </svg>
                                Gerar Nova
                            </button>
                        </div>
                        <span class="form-hint">O usuário deverá alterar a senha no primeiro acesso</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" style="display: flex; align-items: center; gap: var(--space-sm);">
                            <label class="toggle" style="margin: 0;">
                                <input type="checkbox" wire:model='send_email'>
                                <span class="toggle-slider"></span>
                            </label>
                            Enviar e-mail de boas-vindas com instruções de acesso
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline"
                    onclick="closeModal('modal-novo-usuario')">Cancelar</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    Criar Usuário
                </button>
            </div>
        </form>
    </div>
    <!-- Modal: Editar Usuário -->
    <div class="modal-overlay" id="modal-editar-usuario" wire:ignore.self>
        <form wire:submit.prevent='create("edit")' class="modal modal-lg">
            <div class="modal-header">
                <h3 class="modal-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                    </svg>
                    Editar Usuário
                </h3>
                <button class="modal-close" onclick="closeModal('modal-editar-usuario')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div id="form-editar-usuario">
                    <div
                        style="display: flex; align-items: center; gap: var(--space-lg); margin-bottom: var(--space-lg); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                        <div class="usr-avatar-lg usr-admin" style="width: 64px; height: 64px; font-size: 1.5rem;">
                            {{ strtoupper(substr($name, 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 1.125rem; color: var(--text-primary);">
                                {{ $name }}</div>
                            <div style="font-size: var(--label-size); color: var(--text-secondary);">USR-000 •
                                @if ($selectedUser)
                                    @php $perfil = null;@endphp
                                    @foreach ($selectedUser->roles as $role)
                                        {{ $role->name }}
                                        @php $perfil = $role->name;@endphp
                                    @endforeach
                                @endif
                            </div>
                            <div style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                                Cadastrado em {{ $created }}</div>
                        </div>
                        <span class="usr-status-badge usr-{{ $status }}" style="margin-left: auto;">●
                            {{ $status }}</span>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Nome Completo</label>
                            <input type="text" class="form-input" wire:model='name' value="Fernando Silva">
                        </div>
                        <div class="form-group">
                            <label class="form-label">E-mail</label>
                            <input type="email" class="form-input" wire:model='email'
                                value="fernando.silva@aquanexus.com.br">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Matrícula</label>
                            <input type="text" class="form-input" value="USR-002" readonly
                                style="background: var(--neutral); font-family: monospace;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telefone</label>
                            <input type="tel" class="form-input" wire:model='telefone' value="(11) 98888-7777">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Perfil</label>
                            <select class="form-select" wire:model='roleActive'>
                                <option>Escolhe um Perfil</option>
                                @if ($selectedUser)
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ $perfil == $role->name ? 'selected' : '' }}>{{ $role->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Zona de Atuação</label>
                            <select class="form-select" wire:model='zona'>
                                <option selected>Norte, Centro</option>
                                <option value="Todas as Zonas">Todas as Zonas</option>
                                <option value="Zona Norte">Zona Norte</option>
                                <option value="Zona Sul">Zona Sul</option>
                                <option value="Zona Leste">Zona Leste</option>
                                <option value="Zona Oeste">Zona Oeste</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-select" wire:model='status'>
                                <option value="ativo" selected>Ativo</option>
                                <option value="inativo">Inativo</option>
                                <option value="pendente">Pendente</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Motivo (se inativo)</label>
                            <input type="text" class="form-input" wire:model='motivo'
                                placeholder="Ex: Férias, Desligamento...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-editar-usuario')">Cancelar</button>
                <button class="btn btn-danger" onclick="excluirUsuario()" style="margin-right: auto;">
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
</div>
