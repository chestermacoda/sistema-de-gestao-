 <div class="modal-overlay" id="modal-nova-permissao">
     <form class="modal modal-lg" wire:submit.prevent='save'>
         <div class="modal-header">
             <h3 class="modal-title">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                     <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                 </svg>
                 Nova Permissão
             </h3>
             <button class="modal-close" onclick="closeModal('modal-nova-permissao')">
                 <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M18 6 6 18" />
                     <path d="m6 6 12 12" />
                 </svg>
             </button>
         </div>
         <div class="modal-body">
             <div id="form-nova-permissao">
                 <div class="grid-2">
                     <div class="form-group">
                         <label class="form-label">Nome da Permissão *</label>
                         <input type="text" class="form-input" wire:model="name" placeholder="Ex: clientes.export"
                             required>
                         {{-- <span class="form-hint">Formato: modulo.acao (ex: clientes.view)</span> --}}
                         @error('name')
                             <small class="text-danger">
                                 {{ $message }}
                             </small>
                         @enderror
                     </div>
                     <div class="form-group">
                         <label class="form-label">Nome de Exibição</label>
                         <input type="text" class="form-input" wire:model="display_name"
                             placeholder="Ex: Exportar Clientes">
                     </div>
                 </div>

                 <div class="grid-2">
                     <div class="form-group">
                         <label class="form-label">Módulo *</label>
                         <select class="form-select" wire:model="module" required>
                             <option>Selecione...</option>
                             <option value="Dashboard">Dashboard</option>
                             <option value="Clientes">Clientes</option>
                             <option value="Medidores">Medidores</option>
                             <option value="Leituras">Leituras</option>
                             <option value="Faturas">Faturas</option>
                             <option value="Pagamentos">Pagamentos</option>
                             <option value="Usuarios">Usuários</option>
                             <option value="Configuracoes">Configurações</option>
                         </select>
                         @error('module')
                             <small class="text-danger">
                                 {{ $message }}
                             </small>
                         @enderror
                     </div>
                     <div class="form-group">
                         <label class="form-label">Guard *</label>
                         <select class="form-select" wire:model="guard_name" required>
                             <option value="web" selected>web</option>
                             <option value="api">api</option>
                         </select>
                         <span class="form-hint">Normalmente 'web' para aplicações web</span>
                     </div>
                 </div>

                 <div class="form-group">
                     <label class="form-label">Descrição</label>
                     <textarea class="form-textarea" rows="3" wire:model="description"
                         placeholder="Descreva o que esta permissão permite ao usuário..."></textarea>
                 </div>

                 <div class="form-group">
                     <label class="form-label" style="display: flex; align-items: center; gap: var(--space-sm);">
                         <label class="toggle" style="margin: 0;">
                             <input type="checkbox" wire:model="assign_to_super_admin">
                             <span class="toggle-slider"></span>
                         </label>
                         Atribuir automaticamente à role Super Admin
                     </label>
                 </div>
             </div>
         </div>
         <div class="modal-footer">
             <button class="btn btn-outline" onclick="closeModal('modal-nova-permissao')">Cancelar</button>
             <button type="submit" class="btn btn-primary">
                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M20 6 9 17l-5-5" />
                 </svg>
                 Criar Permissão
             </button>
         </div>
     </form>








 </div>
