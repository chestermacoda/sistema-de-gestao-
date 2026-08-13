 <div class="modal-overlay" id="modal-roteiro">
     <div class="modal modal-lg" style="max-width: 900px;">
         <div class="modal-header">
             <div style="display: flex; align-items: center; gap: var(--space-md);">
                 <div
                     style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--secondary); display: flex; align-items: center; justify-content: center; color: white;">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M12 20h9" />
                         <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                     </svg>
                 </div>
                 <div>
                     <h3 class="modal-title">Roteiro de Leitura — Maio/2026</h3>
                     <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Zona Norte —
                         Carlos M.</p>
                 </div>
             </div>
             <button class="modal-close" onclick="closeModal('modal-roteiro')">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M18 6 6 18" />
                     <path d="m6 6 12 12" />
                 </svg>
             </button>
         </div>
         <div class="modal-body">
             <div
                 style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-md); margin-bottom: var(--space-xl);">
                 <div
                     style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                     <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">Total
                         no Roteiro</div>
                     <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">245</div>
                 </div>
                 <div
                     style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                     <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                         Concluídas</div>
                     <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">187</div>
                 </div>
                 <div
                     style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                     <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                         Pendentes</div>
                     <div style="font-size: 1.5rem; font-weight: 700; color: var(--warning);">58</div>
                 </div>
             </div>

             <div class="leit-roteiro-card">
                 <div class="leit-roteiro-header">
                     <div class="leit-roteiro-title">Progresso do Roteiro</div>
                     <span style="font-size: var(--small-size); color: var(--text-muted);">76.3% concluído</span>
                 </div>
                 <div class="leit-roteiro-progress">
                     <div class="leit-roteiro-progress-bar">
                         <div class="leit-roteiro-progress-fill" style="width: 76.3%;"></div>
                     </div>
                     <div class="leit-roteiro-progress-text">187 / 245</div>
                 </div>
             </div>

             <div
                 style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-md);">
                 Próximas Leituras</div>
             <div class="leit-roteiro-list">
                 <div class="leit-roteiro-item">
                     <div class="leit-roteiro-numero">188</div>
                     <div class="leit-roteiro-info">
                         <div class="leit-roteiro-endereco">Rua das Palmeiras, 456 — Jardim Primavera</div>
                         <div class="leit-roteiro-medidor">H-4522-AC — MAT-2024-004522</div>
                     </div>
                     <span class="leit-roteiro-status leit-pendente">Pendente</span>
                 </div>
                 <div class="leit-roteiro-item">
                     <div class="leit-roteiro-numero">189</div>
                     <div class="leit-roteiro-info">
                         <div class="leit-roteiro-endereco">Av. Brasil, 789 — Centro</div>
                         <div class="leit-roteiro-medidor">H-4523-AD — MAT-2024-004523</div>
                     </div>
                     <span class="leit-roteiro-status leit-pendente">Pendente</span>
                 </div>
                 <div class="leit-roteiro-item leit-concluido">
                     <div class="leit-roteiro-numero">187</div>
                     <div class="leit-roteiro-info">
                         <div class="leit-roteiro-endereco">Rua das Flores, 123 — Jardim Primavera</div>
                         <div class="leit-roteiro-medidor">H-4521-AB — MAT-2024-004521</div>
                     </div>
                     <span class="leit-roteiro-status leit-ok">OK</span>
                 </div>
                 <div class="leit-roteiro-item leit-concluido">
                     <div class="leit-roteiro-numero">186</div>
                     <div class="leit-roteiro-info">
                         <div class="leit-roteiro-endereco">Rua do Comércio, 100 — Centro</div>
                         <div class="leit-roteiro-medidor">H-8932-CD — MAT-2023-008932</div>
                     </div>
                     <span class="leit-roteiro-status leit-ok">OK</span>
                 </div>
             </div>
         </div>
         <div class="modal-footer">
             <button class="btn btn-outline" onclick="closeModal('modal-roteiro')">Fechar</button>
             <button class="btn btn-secondary" onclick="alert('Roteiro exportado para o app mobile!')">
                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" style="margin-right: 6px;">
                     <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                     <polyline points="7 10 12 15 17 10" />
                     <line x1="12" x2="12" y1="15" y2="3" />
                 </svg>
                 Exportar para App
             </button>
             <button class="btn btn-primary" onclick="alert('Nova leitura iniciada no roteiro!')">
                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" style="margin-right: 6px;">
                     <path d="M5 12h14" />
                     <path d="M12 5v14" />
                 </svg>
                 Iniciar Próxima
             </button>
         </div>
     </div>
 </div>
