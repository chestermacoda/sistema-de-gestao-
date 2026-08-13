<div class="modal-overlay" id="modal-nova-role">
    <form wire:submit.prevent="save" class="modal modal-lg">
        <div class="modal-header">
            <h3 class="modal-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="vertical-align: middle; margin-right: 8px;">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Nova Role
            </h3>
            <button class="modal-close" onclick="closeModal('modal-nova-role')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>

        </div>
        <div class="modal-body">
            <div id="form-nova-role">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Nome da Role *</label>
                        <input type="text" class="form-input" wire:model="name" placeholder="Ex: Gerente de Zona"
                            required>
                        @error('name')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Slug (nome único) *</label>
                        <input type="text" class="form-input" wire:model="slug" placeholder="Ex: gerente-zona"
                            required>
                        @error('slug')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                        <span class="form-hint">Apenas letras minúsculas, números e hífens</span>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Guard *</label>
                        <select class="form-select" wire:model="guard_name" required>
                            <option value="web" selected>web</option>
                            <option value="api">api</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cor do Identificador</label>
                        {{-- <div class="perm-color-picker">
                            @php
                                $colors = [
                                    'primary',
                                    'secondary',
                                    'tertiary',
                                    'success',
                                    'warning',
                                    'danger',
                                    'purple',
                                    'orange',
                                ];
                            @endphp

                            @foreach ($colors as $colorName)
                                <div wire:key="color-{{ $colorName }}"
                                    wire:click.stop="$set('color', '{{ $colorName }}')"
                                    class="perm-color-option perm-color-{{ $colorName }} {{ $color === $colorName ? 'selected' : '' }}"
                                    data-color="{{ $colorName }}" style="cursor: pointer;">
                                </div>
                            @endforeach



                        </div> --}}
                        <div class="perm-color-picker" x-data="{ selectedColor: @entangle('color') }">

                            @foreach (['primary', 'secondary', 'tertiary', 'success', 'warning', 'danger', 'purple', 'orange'] as $colorName)
                                <div wire:key="color-{{ $colorName }}" @click="selectedColor = '{{ $colorName }}'"
                                    class="perm-color-option perm-color-{{ $colorName }}"
                                    :class="{ 'selected': selectedColor === '{{ $colorName }}' }"
                                    style="cursor: pointer; width: 30px; height: 30px; border-radius: 50%; display: inline-block; margin-right: 5px;">
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Descrição</label>
                    <textarea class="form-textarea" wire:model="description" rows="3"
                        placeholder="Descreva as responsabilidades desta role..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Permissões Iniciais</label>
                    <div class="perm-role-permissoes-select">



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
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('modal-nova-role')">Cancelar</button>
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M20 6 9 17l-5-5" />
                </svg>
                Criar Role
            </button>
        </div>
    </form>
</div>
