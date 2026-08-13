   @extends('admin.Layout.layouts')

   @section('content')
       <link rel="stylesheet" href="{{ asset('assets/css/roteiro.css') }}">
       <div class="page-content">
           <!-- Page Header -->
           <div class="page-header">
               <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                   <div>
                       <h1 class="page-title">Roteiro de Leituristas</h1>
                       <p class="page-subtitle">Gerencie, atribua e acompanhe os roteiros de leitura dos
                           hidrômetros</p>
                   </div>
                   <div style="display: flex; gap: var(--space-sm);">
                       <button class="btn btn-outline" onclick="openModal('modal-rastrear')">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                               <circle cx="12" cy="10" r="3" />
                           </svg>
                           Rastrear Roteiro
                       </button>
                       <button class="btn btn-primary" onclick="openModal('modal-atribuir')">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <path d="M5 12h14" />
                               <path d="M12 5v14" />
                           </svg>
                           Atribuir Roteiro
                       </button>
                   </div>
               </div>
           </div>

           <!-- Stats Cards -->


           <div class="stats-grid"
               style="margin-bottom: var(--space-xl); display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: var(--space-lg);">

               <!-- 1. Leituristas Ativos -->
               <div class="stat-card">
                   <div class="stat-icon primary">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                           <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                           <circle cx="9" cy="7" r="4" />
                           <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                           <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                       </svg>
                   </div>
                   <div class="stat-content">
                       <div class="stat-value">{{ $stats['leituristas_ativos'] ?? 0 }}</div>
                       <div class="stat-label">Leituristas Ativos</div>
                       <div class="stat-change positive">
                           {{ $stats['leituristas_hoje'] ?? 0 }} trabalhando hoje
                       </div>
                   </div>
               </div>

               <!-- 2. Progresso Geral do Mês -->
               <div class="stat-card">
                   <div class="stat-icon success">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                           <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                           <polyline points="22 4 12 14.01 9 11.01" />
                       </svg>
                   </div>
                   <div class="stat-content">
                       <div class="stat-value">{{ $stats['concluido_percent'] }}%</div>
                       <div class="stat-label">Roteiros Concluídos</div>
                       <div class="stat-change positive">
                           {{ $stats['concluido'] ?? 0 }} de {{ $stats['total_roteiros'] ?? 0 }} medidores
                       </div>
                   </div>
               </div>

               <!-- 3. Pendentes -->
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
                       <div class="stat-value">{{ $stats['pendentes'] ?? 0 }}</div>
                       <div class="stat-label">Medidores Pendentes</div>
                       <div class="stat-change {{ $stats['pendentes'] > 0 ? 'negative' : 'positive' }}">
                           {{ $stats['pendentes_percent'] ?? 0 }}% do total
                       </div>
                   </div>
               </div>

               <!-- 4. Em Andamento -->
               <div class="stat-card">
                   <div class="stat-icon tertiary">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                           <path d="M12 20h9" />
                           <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                       </svg>
                   </div>
                   <div class="stat-content">
                       <div class="stat-value">{{ $stats['em_andamento'] ?? 0 }}</div>
                       <div class="stat-label">Em Andamento</div>
                       <div class="stat-change neutral">
                           {{ $stats['roteiros_hoje'] ?? 0 }} roteiros ativos
                       </div>
                   </div>
               </div>
           </div>

           <livewire:admin.roteiro.gestao-roteiro />
       </div>


       <!-- ============================================ -->
       <!-- MODAL: ATRIBUIR ROTEIRO                     -->
       <!-- ============================================ -->
       <livewire:admin.roteiro.create />
       <!-- ============================================ -->
       <!-- MODAL: PRÉ-VISUALIZAR ROTEIRO               -->
       <!-- ============================================ -->

       <livewire:admin.roteiro.preview-roteiro />
       <!-- ============================================ -->
       <!-- MODAL: RASTREAR ROTEIRO                     -->
       <!-- ============================================ -->
       <div class="modal-overlay" id="modal-rastrear">
           <div class="modal modal-lg" style="max-width: 900px;">
               <div class="modal-header">
                   <div style="display: flex; align-items: center; gap: var(--space-md);">
                       <div
                           style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--tertiary); display: flex; align-items: center; justify-content: center; color: white;">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                               <circle cx="12" cy="10" r="3" />
                           </svg>
                       </div>
                       <div>
                           <h3 class="modal-title">Rastreamento de Roteiro</h3>
                           <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Acompanhe a
                               localização e progresso do leiturista em tempo real</p>
                       </div>
                   </div>
                   <button class="modal-close" onclick="closeModal('modal-rastrear')">
                       <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                           <path d="M18 6 6 18" />
                           <path d="m6 6 12 12" />
                       </svg>
                   </button>
               </div>
               <div class="modal-body">
                   <div class="rot-rastreamento-grid">
                       <div class="rot-rastreamento-info">
                           <div class="rot-rastreamento-card">
                               <div class="rot-rastreamento-header">
                                   <div class="rot-leiturista-avatar"
                                       style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); width: 48px; height: 48px; font-size: 1.125rem;">
                                       CM</div>
                                   <div>
                                       <div style="font-weight: 700; font-size: var(--label-size);">Carlos Mendes</div>
                                       <div style="font-size: var(--small-size); color: var(--text-muted);">MAT-4521 —
                                           Zona Norte</div>
                                   </div>
                               </div>
                               <div class="rot-rastreamento-stats">
                                   <div class="rot-rastreamento-stat">
                                       <div class="rot-rastreamento-stat-valor">187</div>
                                       <div class="rot-rastreamento-stat-label">Concluídas</div>
                                   </div>
                                   <div class="rot-rastreamento-stat">
                                       <div class="rot-rastreamento-stat-valor">58</div>
                                       <div class="rot-rastreamento-stat-label">Restantes</div>
                                   </div>
                                   <div class="rot-rastreamento-stat">
                                       <div class="rot-rastreamento-stat-valor">4h32m</div>
                                       <div class="rot-rastreamento-stat-label">Tempo Ativo</div>
                                   </div>
                               </div>
                           </div>

                           <div style="margin-top: var(--space-lg);">
                               <div
                                   style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-md);">
                                   Últimas Atividades</div>
                               <div class="rot-atividades-lista">
                                   <div class="rot-atividade-item">
                                       <div class="rot-atividade-hora">14:32</div>
                                       <div class="rot-atividade-conteudo">
                                           <div class="rot-atividade-titulo">Leitura Registrada</div>
                                           <div class="rot-atividade-desc">H-4521-AB — 45.230 m³ — João da Silva Santos
                                           </div>
                                       </div>
                                       <span class="badge badge-success">OK</span>
                                   </div>
                                   <div class="rot-atividade-item">
                                       <div class="rot-atividade-hora">14:15</div>
                                       <div class="rot-atividade-conteudo">
                                           <div class="rot-atividade-titulo">Leitura Registrada</div>
                                           <div class="rot-atividade-desc">H-8932-CD — 128.450 m³ — Mercado Central Ltda
                                           </div>
                                       </div>
                                       <span class="badge badge-success">OK</span>
                                   </div>
                                   <div class="rot-atividade-item">
                                       <div class="rot-atividade-hora">13:50</div>
                                       <div class="rot-atividade-conteudo">
                                           <div class="rot-atividade-titulo">Anomalia Detectada</div>
                                           <div class="rot-atividade-desc">H-5678-IJ — Consumo excessivo — Hospital
                                               Regional</div>
                                       </div>
                                       <span class="badge badge-danger">Anomalia</span>
                                   </div>
                                   <div class="rot-atividade-item">
                                       <div class="rot-atividade-hora">13:20</div>
                                       <div class="rot-atividade-conteudo">
                                           <div class="rot-atividade-titulo">Pausa para Almoço</div>
                                           <div class="rot-atividade-desc">Leiturista em pausa — 45 minutos</div>
                                       </div>
                                       <span class="badge badge-neutral">Pausa</span>
                                   </div>
                                   <div class="rot-atividade-item">
                                       <div class="rot-atividade-hora">11:45</div>
                                       <div class="rot-atividade-conteudo">
                                           <div class="rot-atividade-titulo">Leitura Registrada</div>
                                           <div class="rot-atividade-desc">H-3456-MN — 89.450 m³ — Condomínio Solar
                                           </div>
                                       </div>
                                       <span class="badge badge-success">OK</span>
                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="rot-rastreamento-mapa">
                           <div
                               style="background: linear-gradient(135deg, var(--neutral-dark), var(--neutral)); border-radius: var(--radius-lg); height: 100%; min-height: 400px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: var(--space-md); border: 2px dashed var(--neutral-darker);">
                               <div
                                   style="width: 80px; height: 80px; border-radius: 50%; background: var(--primary-light); display: flex; align-items: center; justify-content: center;">
                                   <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white"
                                       stroke-width="2">
                                       <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                       <circle cx="12" cy="10" r="3" />
                                   </svg>
                               </div>
                               <div style="text-align: center;">
                                   <div
                                       style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">
                                       Mapa de Rastreamento</div>
                                   <div style="font-size: var(--label-size); color: var(--text-muted);">Localização em
                                       tempo real do leiturista</div>
                               </div>
                               <div
                                   style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-sm) var(--space-md); background: var(--white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm);">
                                   <div
                                       style="width: 8px; height: 8px; border-radius: 50%; background: var(--success); animation: pulse 2s infinite;">
                                   </div>
                                   <span style="font-size: var(--small-size); color: var(--text-secondary);">Online —
                                       Atualizado há 2 min</span>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="modal-footer">
                   <button class="btn btn-outline" onclick="closeModal('modal-rastrear')">Fechar</button>
                   <button class="btn btn-secondary" onclick="alert('Histórico de rastreamento exportado!')">
                       <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" style="margin-right: 6px;">
                           <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                           <polyline points="7 10 12 15 17 10" />
                           <line x1="12" x2="12" y1="15" y2="3" />
                       </svg>
                       Exportar Histórico
                   </button>
                   <button class="btn btn-primary" onclick="alert('Enviando mensagem ao leiturista...')">
                       <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" style="margin-right: 6px;">
                           <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                       </svg>
                       Contatar Leiturista
                   </button>
               </div>
           </div>
       </div>

       <!-- ============================================ -->
       <!-- MODAL: EDITAR ROTEIRO                       -->
       <!-- ============================================ -->
       <div class="modal-overlay" id="modal-editar-roteiro">
           <div class="modal" style="max-width: 600px;">
               <div class="modal-header">
                   <div style="display: flex; align-items: center; gap: var(--space-md);">
                       <div
                           style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--warning); display: flex; align-items: center; justify-content: center; color: white;">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                               stroke-width="2">
                               <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                           </svg>
                       </div>
                       <div>
                           <h3 class="modal-title">Editar Roteiro</h3>
                           <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Zona Norte
                               — Maio/2026</p>
                       </div>
                   </div>
                   <button class="modal-close" onclick="closeModal('modal-editar-roteiro')">
                       <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                           <path d="M18 6 6 18" />
                           <path d="m6 6 12 12" />
                       </svg>
                   </button>
               </div>
               <div class="modal-body">
                   <div class="form-group">
                       <label class="form-label">Leiturista *</label>
                       <select class="form-select" required>
                           <option selected>Carlos M. — MAT-4521</option>
                           <option>Ana P. — MAT-3890</option>
                           <option>Roberto S. — MAT-5678</option>
                           <option>Maria L. — MAT-7823</option>
                       </select>
                   </div>

                   <div class="grid-2">
                       <div class="form-group">
                           <label class="form-label">Data Início *</label>
                           <input type="date" class="form-input" value="2026-05-01" required>
                       </div>
                       <div class="form-group">
                           <label class="form-label">Data Fim *</label>
                           <input type="date" class="form-input" value="2026-05-10" required>
                       </div>
                   </div>

                   <div class="form-group">
                       <label class="form-label">Status do Roteiro</label>
                       <select class="form-select">
                           <option selected>Em Andamento</option>
                           <option>Pendente</option>
                           <option>Concluído</option>
                           <option>Cancelado</option>
                       </select>
                   </div>

                   <div class="form-group">
                       <label class="form-label">Observações</label>
                       <textarea class="form-textarea" placeholder="Observações sobre o roteiro...">Roteiro priorizado devido à grande concentração de medidores comerciais na região.</textarea>
                   </div>

                   <div
                       style="background: var(--warning-light); border-radius: var(--radius-md); padding: var(--space-md); border-left: 3px solid var(--warning);">
                       <div style="display: flex; align-items: flex-start; gap: var(--space-md);">
                           <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                               stroke="var(--warning)" stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                               <circle cx="12" cy="12" r="10" />
                               <line x1="12" x2="12" y1="8" y2="12" />
                               <line x1="12" x2="12.01" y1="16" y2="16" />
                           </svg>
                           <div>
                               <div style="font-weight: 600; font-size: var(--label-size); color: var(--warning);">Atenção
                               </div>
                               <div style="font-size: var(--small-size); color: var(--text-secondary); margin-top: 2px;">
                                   Alterar o leiturista irá reatribuir todas as leituras pendentes. As leituras já
                                   concluídas permanecerão com o leiturista original.</div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="modal-footer">
                   <button class="btn btn-outline" onclick="closeModal('modal-editar-roteiro')">Cancelar</button>
                   <button class="btn btn-danger" onclick="cancelarRoteiro()">
                       <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" style="margin-right: 6px;">
                           <circle cx="12" cy="12" r="10" />
                           <line x1="15" x2="9" y1="9" y2="15" />
                           <line x1="9" x2="15" y1="9" y2="15" />
                       </svg>
                       Cancelar Roteiro
                   </button>
                   <button class="btn btn-primary" onclick="salvarEdicaoRoteiro()">
                       <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" style="margin-right: 6px;">
                           <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                       </svg>
                       Salvar Alterações
                   </button>
               </div>
           </div>
       </div>

       <livewire:admin.roteiro.visualizar-zona />



       <livewire:admin.roteiro.atribuir-roteiro />


       <!-- Toast Container -->
       <div id="toast-container"
           style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: var(--space-sm);">
       </div>


       <script>
           window.switchTabRoteiro = function(btn, tabId) {

               // remove active
               document.querySelectorAll('.tabs .tab')
                   .forEach(tab => tab.classList.remove('active'));

               // ativa botão
               btn.classList.add('active');

               // esconde conteúdos
               document.querySelectorAll('.tab-content-roteiro')
                   .forEach(content => content.style.display = 'none');

               // mostra atual
               const currentTab = document.getElementById(tabId);

               if (currentTab) {
                   currentTab.style.display = 'block';
               }

               // salva
               localStorage.setItem('roteiro_tab_ativa', tabId);
           };

           document.addEventListener('DOMContentLoaded', function() {

               const savedTab = localStorage.getItem('roteiro_tab_ativa');

               // esconde tudo
               document.querySelectorAll('.tab-content-roteiro')
                   .forEach(content => content.style.display = 'none');

               if (savedTab) {

                   const tab = document.getElementById(savedTab);

                   if (tab) {
                       tab.style.display = 'block';
                   }

                   document.querySelectorAll('.tabs .tab')
                       .forEach(btn => {

                           btn.classList.remove('active');

                           if (
                               btn.getAttribute('onclick')
                               ?.includes(savedTab)
                           ) {
                               btn.classList.add('active');
                           }
                       });

               } else {

                   // padrão
                   document.getElementById('tab-ativos').style.display = 'block';

                   document.querySelector('.tabs .tab')
                       ?.classList.add('active');
               }
           });

           document.addEventListener('DOMContentLoaded', function() {

               const savedTab = localStorage.getItem('roteiro_tab_ativa');

               if (savedTab) {

                   // esconde todas
                   document.querySelectorAll('.tab-content-roteiro')
                       .forEach(content => content.style.display = 'none');

                   // mostra salva
                   const tab = document.getElementById(savedTab);

                   if (tab) {
                       tab.style.display = 'block';
                   }

                   // ativa botão correspondente
                   document.querySelectorAll('.tabs .tab')
                       .forEach(btn => {

                           btn.classList.remove('active');

                           if (
                               btn.getAttribute('onclick')
                               ?.includes(savedTab)
                           ) {
                               btn.classList.add('active');
                           }
                       });

               } else {

                   // padrão
                   document.getElementById('tab-ativos').style.display = 'block';
               }
           });
           // Modal functions
           function openModal(id) {
               document.getElementById(id).classList.add('active');
               document.body.style.overflow = 'hidden';
           }

           function closeModal(id) {
               document.getElementById(id).classList.remove('active');
               document.body.style.overflow = '';
           }

           Close modal on overlay click
           document.addEventListener('click', function(e) {
               if (e.target.classList.contains('modal-overlay')) {
                   e.target.classList.remove('active');
                   document.body.style.overflow = '';
               }
           });

           // Close modal on escape key
           document.addEventListener('keydown', function(e) {
               if (e.key === 'Escape') {
                   document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                       modal.classList.remove('active');
                   });
                   document.body.style.overflow = '';
               }
           });

           // Toggle sidebar on mobile
           function toggleSidebar() {
               document.querySelector('.sidebar').classList.toggle('open');
           }
       </script>
   @endsection
