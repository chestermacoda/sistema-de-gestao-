<div class="modal-overlay" id="modal-permissoes" wire:ignore.self>
    <div class="modal modal-lg">
        <div class="modal-header">
            <h3 class="modal-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="vertical-align: middle; margin-right: 8px;">
                    <path
                        d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                Gerenciar Permissões
            </h3>
            <button class="modal-close" onclick="closeModal('modal-permissoes')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div
                style="display: flex; align-items: center; gap: var(--space-md); margin-bottom: var(--space-lg); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                <div class="usr-avatar-lg usr-admin">FS</div>
                <div>
                    <div style="font-weight: 700; color: var(--text-primary);">{{ isset($user) ? $user->name : '' }}
                    </div>
                    <div style="font-size: var(--small-size); color: var(--text-muted);">
                        {{ isset($user) ? $user->roles[0]->name : '' }} • USR-002
                    </div>
                </div>
                <div style="margin-left: auto; display: flex; gap: var(--space-sm);">
                    @foreach ($roles as $role)
                        <button class="btn btn-sm btn-outline" wire:click="aplicarPreset({{ $role->id }})">
                            {{ $role->name }}
                        </button>
                    @endforeach

                </div>
            </div>
            <div
                style="background: rgba(var(--primary-rgb, 0, 102, 204), 0.08); border-left: 4px solid var(--primary); padding: var(--space-md); border-radius: var(--radius-md); margin-bottom: var(--space-lg); display: flex; align-items: flex-start; gap: var(--space-sm);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="color: var(--primary); flex-shrink: 0; margin-top: 2px;">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" x2="12" y1="16" y2="12" />
                    <line x1="12" x2="12" y1="8" y2="8" />
                </svg>
                <div>
                    <strong
                        style="color: var(--text-primary); display: block; font-size: var(--small-size); margin-bottom: 2px;">Permissões
                        Diretas (Exceções)</strong>
                    <p style="color: var(--text-muted); font-size: 12px; margin: 0; line-height: 1.4;">
                        Os interruptores abaixo gerenciam permissões atribuídas <strong>diretamente</strong> a este
                        utilizador. Elas servem como regras adicionais ou exceções ao perfil padrão dele.
                    </p>
                </div>
            </div>

            <div class="usr-permissoes-grid">
                <!-- Módulo: Dashboard -->
                @foreach ($permissionsGrouped as $module => $permissions)
                    <div class="usr-permissao-categoria">

                        <div class="usr-permissao-categoria-title">

                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">

                                {!! $moduleIcons[$module] ?? '' !!}

                            </svg>

                            {{ ucfirst($module) }}

                        </div>

                        @foreach ($permissions as $permission)
                            @php
                                $herdadaDaRole = in_array($permission['name'], $rolePermissions);
                            @endphp

                            <div class="usr-permissao-item" style="{{ $herdadaDaRole ? 'opacity: 0.85;' : '' }}">

                                <div style="display: flex; flex-direction: column;">

                                    <span class="usr-permissao-label">
                                        {{ $permission['label'] }}
                                    </span>

                                    @if ($herdadaDaRole)
                                        <span style="font-size: 10px; color: var(--primary); font-weight: 600;">

                                            Herdada do perfil
                                            ({{ $user->roles->first()->name ?? 'Role' }})
                                        </span>
                                    @else
                                        <span style="font-size: 10px; color: var(--text-muted); font-style: italic;">

                                            Atribuição direta

                                        </span>
                                    @endif

                                </div>

                                <label class="usr-toggle"
                                    title="{{ $herdadaDaRole ? 'Esta permissão já está ativa pelo perfil do usuário' : '' }}">

                                    @if ($herdadaDaRole)
                                        <input type="checkbox" checked disabled style="pointer-events: none;">

                                        <span class="usr-toggle-slider"
                                            style="background-color: #a5d6a7; filter: grayscale(30%);">
                                        </span>
                                    @else
                                        <input type="checkbox" class="perm-check" data-modulo="{{ $module }}"
                                            value="{{ $permission['name'] }}" wire:model.live="selectedPermissions">

                                        <span class="usr-toggle-slider"></span>
                                    @endif

                                </label>

                            </div>
                        @endforeach

                    </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('modal-permissoes')">Cancelar</button>
            <button class="btn btn-secondary" onclick="resetarPermissoes()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                    <path d="M3 3v5h5" />
                </svg>
                Resetar Padrão
            </button>
            <button class="btn btn-primary" wire:click='salvarPermissoes'>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M20 6 9 17l-5-5" />
                </svg>
                Salvar Permissões
            </button>
        </div>
    </div>
</div>
