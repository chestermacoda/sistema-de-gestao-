@extends('admin.Layout.layouts')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/permissoes.css') }}">

    <div class="page-content">
        <!-- Page Header -->
        <div class="page-header">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <h1 class="page-title">Permissões & Roles</h1>
                    <p class="page-subtitle">Gerenciamento de permissões Spatie Permission e papéis de acesso do
                        sistema</p>
                </div>
                <div style="display: flex; gap: var(--space-sm);">
                    <button class="btn btn-outline" onclick="openModal('modal-nova-role')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        Nova Role
                    </button>
                    {{--  onclick="openModal('modal-nova-permissao')"   wire:click="$dispatch('edit-produto')" --}}
                    <button class="btn btn-primary" onclick="openModal('modal-nova-permissao')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        Nova Permissão
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
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $permissoes }}</div>
                    <div class="stat-label">Total de Permissões</div>
                    <div class="stat-change positive">{{ $permissoes }} este mês</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon secondary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $roles }}</div>
                    <div class="stat-label">Roles Cadastradas</div>
                    <div class="stat-change positive">{{ $roles }} personalizadas</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon tertiary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">6</div>
                    <div class="stat-label">Módulos Protegidos</div>
                    <div class="stat-change positive">100% coberto</div>
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
                    <div class="stat-value">3</div>
                    <div class="stat-label">Sem Role</div>
                    <div class="stat-change negative">Usuários órfãos</div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs" style="margin-bottom: var(--space-lg);">
            <button class="tab active" onclick="switchTabPerm(this, 'tab-matriz')">Matriz de Permissões</button>
            <button class="tab" onclick="switchTabPerm(this, 'tab-roles')">Roles</button>
            <button class="tab" onclick="switchTabPerm(this, 'tab-permissoes')">Permissões</button>
            <button class="tab" onclick="switchTabPerm(this, 'tab-usuarios')">Usuários por Role</button>
        </div>

        <!-- Tab: Matriz de Permissões -->
        <livewire:admin.permissoes.matriz-acesso />

        <!-- Tab: Permissões -->
        <livewire:admin.permissoes.show-permissoes />
        <!-- Tab: Roles -->
        <livewire:admin.permissoes.show-roles />
        <!-- Tab: Usuários por Role -->
        <livewire:admin.permissoes.usuarios />

    </div>
    {{-- </div> --}}

    <!-- ==================== MODAIS ==================== -->

    <!-- Modal: Nova Permissão -->
    <livewire:admin.permissoes.create-permissao />

    <!-- Modal: Nova Role -->
    <livewire:admin.permissoes.create-roles />






    <!-- Modal: Gerenciar User Roles -->
    <div class="modal-overlay" id="modal-gerenciar-user-roles">
        <div class="modal modal-lg">
            <div class="modal-header">
                <h3 class="modal-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <path
                            d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Gerenciar Roles do Usuário
                </h3>
                <button class="modal-close" onclick="closeModal('modal-gerenciar-user-roles')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="perm-user-roles-header">
                    <div class="perm-user-avatar perm-admin" style="width: 48px; height: 48px; font-size: 1.125rem;">FS
                    </div>
                    <div>
                        <div style="font-weight: 700; color: var(--text-primary);">Fernando Silva</div>
                        <div style="font-size: var(--small-size); color: var(--text-muted);">
                            fernando.silva@aquanexus.com.br • USR-002</div>
                    </div>
                </div>

                <div class="perm-user-roles-list">
                    <div class="perm-user-role-item perm-active">
                        <div class="perm-user-role-info">
                            <div class="perm-user-role-icon"
                                style="background: linear-gradient(135deg, var(--primary), var(--primary-light));">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="perm-user-role-name">Administrador</div>
                                <div class="perm-user-role-desc">Gestão operacional completa do sistema</div>
                            </div>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" checked onchange="toggleUserRole(this)">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="perm-user-role-item">
                        <div class="perm-user-role-info">
                            <div class="perm-user-role-icon"
                                style="background: linear-gradient(135deg, var(--tertiary), var(--tertiary-light));">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </div>
                            <div>
                                <div class="perm-user-role-name">Leiturista</div>
                                <div class="perm-user-role-desc">Coleta de leituras de medidores</div>
                            </div>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" onchange="toggleUserRole(this)">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="perm-user-role-item">
                        <div class="perm-user-role-info">
                            <div class="perm-user-role-icon"
                                style="background: linear-gradient(135deg, var(--secondary), var(--secondary-light));">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <line x1="12" x2="12" y1="2" y2="22" />
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                            </div>
                            <div>
                                <div class="perm-user-role-name">Financeiro</div>
                                <div class="perm-user-role-desc">Gestão financeira e faturas</div>
                            </div>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" onchange="toggleUserRole(this)">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="perm-user-role-item">
                        <div class="perm-user-role-info">
                            <div class="perm-user-role-icon"
                                style="background: linear-gradient(135deg, var(--warning), #b45309);">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M20 7h-9" />
                                    <path d="M14 17H5" />
                                    <circle cx="17" cy="17" r="3" />
                                    <circle cx="7" cy="7" r="3" />
                                </svg>
                            </div>
                            <div>
                                <div class="perm-user-role-name">Gerente de Zona</div>
                                <div class="perm-user-role-desc">Gestão regional e supervisão</div>
                            </div>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" onchange="toggleUserRole(this)">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div
                    style="margin-top: var(--space-lg); padding: var(--space-md); background: var(--warning-light); border-radius: var(--radius-md); border-left: 3px solid var(--warning);">
                    <div style="font-weight: 600; font-size: var(--label-size); color: var(--warning);">Permissões
                        Diretas</div>
                    <div style="font-size: var(--small-size); color: var(--text-secondary); margin-top: 4px;">
                        Você também pode atribuir permissões diretas a este usuário sem usar roles.
                        <a href="#" style="color: var(--primary); font-weight: 600;">Clique aqui</a> para
                        gerenciar.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-gerenciar-user-roles')">Cancelar</button>
                <button class="btn btn-primary" onclick="salvarUserRoles()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    Salvar Alterações
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container"
        style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: var(--space-sm);">
    </div>



    <script>
        // ==================== GERENCIAMENTO DE ABAS ====================
        const PERM_TAB_KEY = 'perm_active_tab';

        function switchTabPerm(element, tabId) {
            // 1. Tabs do menu atual
            const tabsContainer = element.closest('.tabs');

            tabsContainer.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });

            element.classList.add('active');

            // 2. Esconde conteúdos
            document.querySelectorAll('.perm-tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // 3. Mostra tab selecionada
            const target = document.getElementById(tabId);

            if (target) {
                target.classList.add('active');

                // 4. SALVA no localStorage
                localStorage.setItem(PERM_TAB_KEY, tabId);
            }
        }


        document.addEventListener('DOMContentLoaded', () => {
            const savedTab = localStorage.getItem(PERM_TAB_KEY);

            if (savedTab) {
                const targetTab = document.getElementById(savedTab);
                const targetButton = document.querySelector(`[onclick*="${savedTab}"]`);

                // Remove todos ativos
                document.querySelectorAll('.perm-tab-content').forEach(c => {
                    c.classList.remove('active');
                });

                document.querySelectorAll('.tabs .tab').forEach(t => {
                    t.classList.remove('active');
                });

                // Ativa salvo
                if (targetTab) targetTab.classList.add('active');
                if (targetButton) targetButton.classList.add('active');
            } else {
                // fallback: primeira tab ativa
                const firstTab = document.querySelector('.perm-tab-content');
                const firstButton = document.querySelector('.tabs .tab');

                if (firstTab) firstTab.classList.add('active');
                if (firstButton) firstButton.classList.add('active');
            }
        });


        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', () => {
                const savedTab = localStorage.getItem(PERM_TAB_KEY);

                if (!savedTab) return;

                document.querySelectorAll('.perm-tab-content')
                    .forEach(el => el.classList.remove('active'));

                document.querySelectorAll('.tabs .tab')
                    .forEach(el => el.classList.remove('active'));

                const targetTab = document.getElementById(savedTab);
                const targetBtn = document.querySelector(`[onclick*="${savedTab}"]`);

                if (targetTab) targetTab.classList.add('active');
                if (targetBtn) targetBtn.classList.add('active');
            });
        });
        // ==================== MODAIS ====================
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        // function closeModal(modalId) {
        //     const modal = document.getElementById(modalId);
        //     if (modal) {
        //         modal.classList.remove('active');
        //         document.body.style.overflow = '';
        //     }
        // }

        // Fechar modal ao clicar no overlay
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Fechar modal com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                    modal.classList.remove('active');
                });
                document.body.style.overflow = '';
            }
        });

        // ==================== TOGGLE DE MÓDULOS NO MODAL ====================
        function toggleModuloPerm(header) {
            const group = header.closest('.perm-modulo-group');
            group.classList.toggle('collapsed');
        }

        // ==================== COLOR PICKER ====================
        // function selectColor(element) {
        //     document.querySelectorAll('.perm-color-option').forEach(opt => {
        //         opt.classList.remove('selected');
        //     });
        //     element.classList.add('selected');
        // }

        // ==================== AÇÕES DE PERMISSÃO ====================
        function salvarPermissao() {
            const form = document.getElementById('form-nova-permissao');
            if (form.checkValidity()) {
                showToast('Permissão criada com sucesso!', 'success');
                closeModal('modal-nova-permissao');
                form.reset();
            } else {
                form.reportValidity();
            }
        }

        function salvarEdicaoPermissao() {
            showToast('Permissão atualizada com sucesso!', 'success');
            closeModal('modal-editar-permissao');
        }

        function excluirPermissao() {
            if (confirm('Tem certeza que deseja excluir esta permissão? Esta ação não pode ser desfeita.')) {
                showToast('Permissão excluída com sucesso!', 'success');
                closeModal('modal-editar-permissao');
            }
        }

        // ==================== AÇÕES DE ROLE ====================
        function salvarRole() {
            const form = document.getElementById('form-nova-role');
            if (form.checkValidity()) {
                showToast('Role criada com sucesso!', 'success');
                closeModal('modal-nova-role');
                form.reset();
            } else {
                form.reportValidity();
            }
        }

        function salvarEdicaoRole() {
            showToast('Role atualizada com sucesso!', 'success');
            closeModal('modal-editar-role');
        }

        function excluirRole() {
            if (confirm(
                    'Tem certeza que deseja excluir esta role? Todos os usuários associados perderão estas permissões.')) {
                showToast('Role excluída com sucesso!', 'success');
                closeModal('modal-editar-role');
            }
        }

        // ==================== AÇÕES DE USUÁRIO/ROLE ====================
        function toggleUserRole(checkbox) {
            const item = checkbox.closest('.perm-user-role-item');
            if (checkbox.checked) {
                item.classList.add('perm-active');
            } else {
                item.classList.remove('perm-active');
            }
        }

        function salvarUserRoles() {
            showToast('Roles do usuário atualizadas com sucesso!', 'success');
            closeModal('modal-gerenciar-user-roles');
        }

        // ==================== EXPORTAR MATRIZ ====================
        function exportarMatriz() {
            showToast('Exportando matriz de permissões...', 'info');
            setTimeout(() => {
                showToast('Matriz exportada com sucesso!', 'success');
            }, 1500);
        }

        // ==================== TOAST NOTIFICATIONS ====================
        // function showToast(message, type = 'info') {
        //     const container = document.getElementById('toast-container');
        //     const toast = document.createElement('div');

        //     const colors = {
        //         success: 'var(--success)',
        //         danger: 'var(--danger)',
        //         warning: 'var(--warning)',
        //         info: 'var(--primary)'
        //     };

        //     const bgColors = {
        //         success: 'var(--success-light)',
        //         danger: 'var(--danger-light)',
        //         warning: 'var(--warning-light)',
        //         info: 'rgba(0, 51, 102, 0.08)'
        //     };

        //     toast.style.cssText = `
    //         background: ${bgColors[type] || bgColors.info};
    //         color: ${colors[type] || colors.info};
    //         padding: var(--space-md) var(--space-lg);
    //         border-radius: var(--radius-md);
    //         font-size: var(--label-size);
    //         font-weight: 600;
    //         box-shadow: var(--shadow-lg);
    //         display: flex;
    //         align-items: center;
    //         gap: var(--space-sm);
    //         animation: slideIn 0.3s ease;
    //         border-left: 3px solid ${colors[type] || colors.info};
    //     `;

        //     const icons = {
        //         success: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>',
        //         danger: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>',
        //         warning: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>',
        //         info: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="16" y2="12"/><line x1="12" x2="12.01" y1="8" y2="8"/></svg>'
        //     };

        //     toast.innerHTML = `${icons[type] || icons.info}<span>${message}</span>`;
        //     container.appendChild(toast);

        //     setTimeout(() => {
        //         toast.style.animation = 'slideOut 0.3s ease forwards';
        //         setTimeout(() => toast.remove(), 300);
        //     }, 4000);
        // }

        // ==================== SIDEBAR TOGGLE (mobile) ====================
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }

        // ==================== ANIMAÇÕES CSS DINÂMICAS ====================
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        // ==================== INICIALIZAÇÃO ====================
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa os módulos collapsed no modal de nova role
            document.querySelectorAll('#modal-nova-role .perm-modulo-group').forEach((group, index) => {
                if (index > 0) group.classList.add('collapsed');
            });

            // Inicializa os módulos collapsed no modal de editar role
            document.querySelectorAll('#modal-editar-role .perm-modulo-group').forEach((group, index) => {
                if (index > 1) group.classList.add('collapsed');
            });
        });
    </script>
@endsection
