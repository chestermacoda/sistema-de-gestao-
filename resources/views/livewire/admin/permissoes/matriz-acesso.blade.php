 {{-- <div id="tab-matriz" class="perm-tab-content ">
     <div class="card" style="padding: 0; overflow: hidden;">
         <div
             style="padding: var(--space-lg); border-bottom: 1px solid var(--neutral-dark); display: flex; justify-content: space-between; align-items: center;">
             <div>
                 <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary);">Matriz de
                     Acesso</h3>
                 <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                     Visualize e gerencie permissões por role em uma única tela</p>
             </div>
             <div style="display: flex; gap: var(--space-sm);">
                 <select class="form-select" style="width: auto; min-width: 160px;">
                     <option>Todos os Módulos</option>
                     <option>Dashboard</option>
                     <option>Clientes</option>
                     <option>Medidores</option>
                     <option>Leituras</option>
                     <option>Faturas</option>
                     <option>Pagamentos</option>
                     <option>Usuários</option>
                     <option>Configurações</option>
                 </select>
                 <button class="btn btn-outline btn-sm" onclick="exportarMatriz()">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                         <polyline points="7 10 12 15 17 10" />
                         <line x1="12" x2="12" y1="15" y2="3" />
                     </svg>
                     Exportar
                 </button>
             </div>
         </div>
         <div style="overflow-x: auto;">
             <table class="perm-matriz-table">
                 <thead>
                     <tr>
                         <th style="min-width: 220px;">Permissão / Role</th>
                         <th>
                             <div class="perm-role-header">
                                 <div class="perm-role-badge perm-superadmin">Super Admin</div>
                                 <span class="perm-role-count">1 user</span>
                             </div>
                         </th>
                         <th>
                             <div class="perm-role-header">
                                 <div class="perm-role-badge perm-admin">Admin</div>
                                 <span class="perm-role-count">3 users</span>
                             </div>
                         </th>
                         <th>
                             <div class="perm-role-header">
                                 <div class="perm-role-badge perm-leiturista">Leiturista</div>
                                 <span class="perm-role-count">8 users</span>
                             </div>
                         </th>
                         <th>
                             <div class="perm-role-header">
                                 <div class="perm-role-badge perm-financeiro">Financeiro</div>
                                 <span class="perm-role-count">4 users</span>
                             </div>
                         </th>
                         <th>
                             <div class="perm-role-header">
                                 <div class="perm-role-badge perm-operador">Operador</div>
                                 <span class="perm-role-count">6 users</span>
                             </div>
                         </th>
                         <th>
                             <div class="perm-role-header">
                                 <div class="perm-role-badge perm-gerente">Gerente Zona</div>
                                 <span class="perm-role-count">2 users</span>
                             </div>
                         </th>
                         <th>
                             <div class="perm-role-header">
                                 <div class="perm-role-badge perm-viewer">Viewer</div>
                                 <span class="perm-role-count">0 users</span>
                             </div>
                         </th>
                     </tr>
                 </thead>
                 <tbody>
                     <!-- Dashboard -->
                     <tr class="perm-modulo-row">
                         <td colspan="8">
                             <div class="perm-modulo-title">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                     <polyline points="9 22 9 12 15 12 15 22" />
                                 </svg>
                                 Dashboard
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="perm-nome">dashboard.view</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">dashboard.export</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>

                     <!-- Clientes -->
                     <tr class="perm-modulo-row">
                         <td colspan="8">
                             <div class="perm-modulo-title">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                     <circle cx="9" cy="7" r="4" />
                                     <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                     <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                 </svg>
                                 Clientes
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="perm-nome">clientes.view</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">clientes.create</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">clientes.edit</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">clientes.delete</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>

                     <!-- Medidores -->
                     <tr class="perm-modulo-row">
                         <td colspan="8">
                             <div class="perm-modulo-title">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <circle cx="12" cy="12" r="10" />
                                     <path d="M12 6v6l4 2" />
                                 </svg>
                                 Medidores
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="perm-nome">medidores.view</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">medidores.create</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">medidores.manutencao</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>

                     <!-- Leituras -->
                     <tr class="perm-modulo-row">
                         <td colspan="8">
                             <div class="perm-modulo-title">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                     <polyline points="14 2 14 8 20 8" />
                                     <line x1="16" x2="8" y1="13" y2="13" />
                                     <line x1="16" x2="8" y1="17" y2="17" />
                                     <polyline points="10 9 9 9 8 9" />
                                 </svg>
                                 Leituras
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="perm-nome">leituras.view</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">leituras.create</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">leituras.import</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">leituras.validate</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>

                     <!-- Faturas -->
                     <tr class="perm-modulo-row">
                         <td colspan="8">
                             <div class="perm-modulo-title">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <rect width="20" height="14" x="2" y="5" rx="2" />
                                     <line x1="2" x2="22" y1="10" y2="10" />
                                 </svg>
                                 Faturas
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="perm-nome">faturas.view</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">faturas.create</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">faturas.cancel</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>

                     <!-- Pagamentos -->
                     <tr class="perm-modulo-row">
                         <td colspan="8">
                             <div class="perm-modulo-title">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <line x1="12" x2="12" y1="2" y2="22" />
                                     <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                 </svg>
                                 Pagamentos
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="perm-nome">pagamentos.view</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">pagamentos.create</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">pagamentos.confirm</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>

                     <!-- Usuários -->
                     <tr class="perm-modulo-row">
                         <td colspan="8">
                             <div class="perm-modulo-title">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                     <circle cx="9" cy="7" r="4" />
                                     <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                 </svg>
                                 Usuários
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="perm-nome">usuarios.view</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">usuarios.create</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">usuarios.permissoes</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>

                     <!-- Configurações -->
                     <tr class="perm-modulo-row">
                         <td colspan="8">
                             <div class="perm-modulo-title">
                                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path
                                         d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                     <circle cx="12" cy="12" r="3" />
                                 </svg>
                                 Configurações
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td class="perm-nome">config.view</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">config.edit</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                     <tr>
                         <td class="perm-nome">config.api</td>
                         <td><label class="perm-toggle"><input type="checkbox" checked disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                         <td><label class="perm-toggle"><input type="checkbox" disabled><span
                                     class="perm-toggle-slider"></span></label></td>
                     </tr>
                 </tbody>
             </table>
         </div>
         <div
             style="padding: var(--space-md) var(--space-lg); border-top: 1px solid var(--neutral-dark); display: flex; justify-content: space-between; align-items: center; background: var(--neutral);">
             <span style="font-size: var(--small-size); color: var(--text-muted);">Mostrando 42
                 permissões em 8 módulos</span>
             <div style="display: flex; gap: var(--space-sm);">
                 <button class="btn btn-sm btn-ghost" disabled>
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="m15 18-6-6 6-6" />
                     </svg>
                 </button>
                 <button class="btn btn-sm btn-primary" style="min-width: 32px; justify-content: center;">1</button>
                 <button class="btn btn-sm btn-ghost" style="min-width: 32px; justify-content: center;">2</button>
                 <button class="btn btn-sm btn-ghost">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="m9 18 6-6-6-6" />
                     </svg>
                 </button>
             </div>
         </div>
     </div>
 </div> --}}
 <div id="tab-matriz" class="perm-tab-content">
     <div class="card" style="padding: 0; overflow: hidden;">
         <div
             style="padding: var(--space-lg); border-bottom: 1px solid var(--neutral-dark); display: flex; justify-content: space-between; align-items: center;">
             <div>
                 <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary);">Matriz de Acesso</h3>
                 <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">Visualize e gerencie
                     permissões por role em uma única tela</p>
             </div>
             <div style="display: flex; gap: var(--space-sm);">
                 <select wire:model.live="searchModulo" class="form-select" style="width: auto; min-width: 180px;">
                     <option value="">Todos os Módulos</option>
                     @foreach (array_keys($modulosInfo ?? []) as $modulo)
                         <option value="{{ strtolower($modulo) }}">{{ $modulo }}</option>
                     @endforeach
                 </select>
             </div>
         </div>

         <div style="overflow-x: auto;">
             <table class="perm-matriz-table">
                 <thead>
                     <tr>
                         <th style="min-width: 220px;">Permissão / Role</th>
                         @foreach ($roles as $role)
                             <th>
                                 <div class="perm-role-header">
                                     <div class="perm-role-badge perm-{{ strtolower($role->slug) }}">{{ $role->name }}
                                     </div>
                                     <span class="perm-role-count">{{ $role->users_count }} users</span>
                                 </div>
                             </th>
                         @endforeach
                     </tr>
                 </thead>
                 <tbody>
                     {{-- @if ($groupedPermissions->isEmpty()) --}}
                     @if (empty($groupedPermissions) || $groupedPermissions->isEmpty())
                         <tr>
                             <td colspan="{{ $roles->count() + 1 }}" style="text-align: center; padding: 60px 20px;">
                                 <p style="color: var(--text-muted); font-size: 1rem;">
                                     Nenhuma permissão encontrada para este módulo.
                                 </p>
                             </td>
                         </tr>
                     @else
                         @foreach ($groupedPermissions as $modulo => $perms)
                             <!-- Título do Módulo -->
                             <tr class="perm-modulo-row">
                                 <td colspan="{{ $roles->count() + 1 }}">
                                     <div class="perm-modulo-title">
                                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                             {!! $modulosInfo[$modulo] ?? '' !!}
                                         </svg>
                                         {{ $modulo }}
                                     </div>
                                 </td>
                             </tr>

                             <!-- Permissões do Módulo -->
                             @foreach ($perms as $permission)
                                 <tr>
                                     <td class="perm-nome">{{ $permission->name }}</td>
                                     @foreach ($roles as $role)
                                         <td>
                                             <label class="perm-toggle">
                                                 <input type="checkbox"
                                                     wire:click="togglePermission({{ $role->id }}, '{{ $permission->name }}')"
                                                     wire:loading.attr="disabled"
                                                     {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                     {{ $role->name === 'Super Admin' ? 'disabled' : '' }}>
                                                 <span class="perm-toggle-slider"></span>
                                             </label>
                                         </td>
                                     @endforeach
                                 </tr>
                             @endforeach
                         @endforeach
                     @endif
                 </tbody>
             </table>
         </div>

         <!-- Paginação -->


         {{-- Inicio da Paginação Direta --}}
         @if ($permissions->hasPages())
             <div
                 style="padding: var(--space-md) var(--space-lg); border-top: 1px solid var(--neutral-dark); display: flex; justify-content: space-between; align-items: center; background: var(--neutral);">

                 <span style="font-size: var(--small-size); color: var(--text-muted);">
                     Mostrando {{ $permissions->firstItem() }} até {{ $permissions->lastItem() }} de
                     {{ $permissions->total() }} permissões
                 </span>

                 <div style="display: flex; gap: var(--space-sm);">
                     {{-- Botão Anterior --}}
                     @if ($permissions->onFirstPage())
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
                     @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $page => $url)
                         <button wire:click="gotoPage({{ $page }})" wire:key="page-{{ $page }}"
                             class="btn btn-sm {{ $page == $permissions->currentPage() ? 'btn-primary' : 'btn-ghost' }}"
                             style="min-width: 32px; justify-content: center;">
                             {{ $page }}
                         </button>
                     @endforeach

                     {{-- Botão Próximo --}}
                     @if ($permissions->hasMorePages())
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
 </div>
