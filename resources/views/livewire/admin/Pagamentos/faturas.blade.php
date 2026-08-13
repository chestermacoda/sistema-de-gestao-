 <div class="modal-overlay" id="modal-detalhes-pagamento">
     <div class="modal modal-lg" style="max-width: 700px;">
         <div class="modal-header">
             <div style="display: flex; align-items: center; gap: var(--space-md);">
                 <div
                     style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--success), var(--tertiary)); display: flex; align-items: center; justify-content: center; color: white;">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <line x1="12" x2="12" y1="2" y2="22" />
                         <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                     </svg>
                 </div>
                 <div>
                     <h3 class="modal-title">#TRX-7842</h3>
                     <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Pagamento
                         confirmado em 08/05/2026</p>
                 </div>
             </div>
             <div style="display: flex; gap: var(--space-sm); align-items: center;">
                 <span class="badge badge-success">Pago</span>
                 <button class="modal-close" onclick="closeModal('modal-detalhes-pagamento')">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M18 6 6 18" />
                         <path d="m6 6 12 12" />
                     </svg>
                 </button>
             </div>
         </div>
         <div class="modal-body">
             @if ($showmodal)
                 <iframe src="{{ asset('pdfs/' . $relatorio['filename']) }}" width="100%" height="600px">
                 </iframe>
             @endif
         </div>
         <div class="modal-footer">
             <button class="btn btn-outline" onclick="closeModal('modal-detalhes-pagamento')">Fechar</button>
             <button class="btn btn-secondary" onclick="alert('Comprovante enviado por e-mail!')">
                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" style="margin-right: 6px;">
                     <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                     <polyline points="22,6 12,13 2,6" />
                 </svg>
                 Enviar Comprovante
             </button>
             <button class="btn btn-primary" onclick="openModal('modal-estornar-pagamento')">
                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" style="margin-right: 6px;">
                     <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                     <path d="M3 3v5h5" />
                 </svg>
                 Estornar
             </button>
         </div>
     </div>
 </div>
