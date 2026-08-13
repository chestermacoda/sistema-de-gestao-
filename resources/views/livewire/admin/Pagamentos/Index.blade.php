 @extends('admin.Layout.layouts')

 @section('content')
     <div class="page-content">
         <!-- Page Header -->
         <div class="page-header">
             <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                 <div>
                     <h1 class="page-title">Pagamentos</h1>
                     <p class="page-subtitle">Controle financeiro e receitas do sistema de abastecimento</p>
                 </div>
                 <div style="display: flex; gap: var(--space-sm);">
                     <button class="btn btn-outline" onclick="openModal('modal-conciliacao')">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                             <polyline points="7 10 12 15 17 10" />
                             <line x1="12" x2="12" y1="15" y2="3" />
                         </svg>
                         Conciliação
                     </button>
                     <button class="btn btn-primary" onclick="openModal('modal-novo-pagamento')">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M5 12h14" />
                             <path d="M12 5v14" />
                         </svg>
                         Registrar Pagamento
                     </button>
                 </div>
             </div>
         </div>

         <!-- Stats Cards -->
         <div class="stats-grid" style="margin-bottom: var(--space-xl);">
             <div class="stat-card">
                 <div class="stat-icon success">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <line x1="12" x2="12" y1="2" y2="22" />
                         <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                     </svg>
                 </div>
                 <div class="stat-content">
                     <div class="stat-value">MZN {{ number_format($states['ReceitaTotal'], 2) }}</div>
                     <div class="stat-label">Receita Total (Mês)</div>
                     <div class="stat-change positive">+23% vs mês anterior</div>
                 </div>
             </div>
             <div class="stat-card">
                 <div class="stat-icon primary">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <rect width="20" height="14" x="2" y="5" rx="2" />
                         <line x1="2" x2="22" y1="10" y2="10" />
                     </svg>
                 </div>
                 <div class="stat-content">
                     <div class="stat-value">1.847</div>
                     <div class="stat-label">Transações</div>
                     <div class="stat-change positive">+15% vs mês anterior</div>
                 </div>
             </div>
             <div class="stat-card">
                 <div class="stat-icon warning">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                         <path d="M12 9v4" />
                         <path d="M12 17h.01" />
                     </svg>
                 </div>
                 <div class="stat-content">
                     <div class="stat-value">MZN {{ number_format($states['Pendente'], 2) }}</div>
                     <div class="stat-label">Pendente</div>
                     <div class="stat-change negative">{{ $states['Count_Pendente'] }} faturas em aberto</div>
                 </div>
             </div>
             <div class="stat-card">
                 <div class="stat-icon danger">
                     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <circle cx="12" cy="12" r="10" />
                         <path d="m15 9-6 6" />
                         <path d="m9 9 6 6" />
                     </svg>
                 </div>
                 <div class="stat-content">
                     <div class="stat-value">MZN {{ number_format($states['Estornos'], 2) }}</div>
                     <div class="stat-label">Estornos</div>
                     <div class="stat-change negative">{{ $states['Count_estorno'] }} transações</div>
                 </div>
             </div>
         </div>

         <!-- Filters Bar -->
         <livewire:admin.pagamentos.show-pagamentos />
     </div>


     <!-- ============================================ -->
     <!-- MODAL: DETALHES DO PAGAMENTO                -->
     <!-- ============================================ -->
     <livewire:admin.pagamentos.faturas />

     <!-- ============================================ -->
     <!-- MODAL: ESTORNAR PAGAMENTO                   -->
     <!-- ============================================ -->
     <div class="modal-overlay" id="modal-estornar-pagamento">
         <div class="modal" style="max-width: 500px;">
             <div class="modal-header">
                 <div style="display: flex; align-items: center; gap: var(--space-md);">
                     <div
                         style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--danger); display: flex; align-items: center; justify-content: center; color: white;">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                             <path d="M3 3v5h5" />
                         </svg>
                     </div>
                     <div>
                         <h3 class="modal-title">Estornar Pagamento</h3>
                         <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">#TRX-7842 —
                             R$ 89,50</p>
                     </div>
                 </div>
                 <button class="modal-close" onclick="closeModal('modal-estornar-pagamento')">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M18 6 6 18" />
                         <path d="m6 6 12 12" />
                     </svg>
                 </button>
             </div>
             <div class="modal-body">
                 <div
                     style="background: var(--danger-light); border-radius: var(--radius-md); padding: var(--space-md); margin-bottom: var(--space-lg); border-left: 3px solid var(--danger);">
                     <div style="display: flex; align-items: flex-start; gap: var(--space-md);">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--danger)"
                             stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                             <circle cx="12" cy="12" r="10" />
                             <line x1="12" x2="12" y1="8" y2="12" />
                             <line x1="12" x2="12.01" y1="16" y2="16" />
                         </svg>
                         <div>
                             <div style="font-weight: 600; font-size: var(--label-size); color: var(--danger);">Atenção:
                                 Ação Irreversível</div>
                             <div style="font-size: var(--small-size); color: var(--text-secondary); margin-top: 2px;">O
                                 estorno irá reabrir a fatura e creditar o valor ao cliente.</div>
                         </div>
                     </div>
                 </div>

                 <div class="form-group">
                     <label class="form-label">Motivo do Estorno *</label>
                     <select class="form-select" required>
                         <option>Selecione...</option>
                         <option>Pagamento Duplicado</option>
                         <option>Erro no Valor Cobrado</option>
                         <option>Fatura Cancelada</option>
                         <option>Cliente Solicitou Cancelamento</option>
                         <option>Problema Técnico no Medidor</option>
                         <option>Negociação de Dívida</option>
                         <option>Outro</option>
                     </select>
                 </div>

                 <div class="form-group">
                     <label class="form-label">Valor a Estornar *</label>
                     <input type="text" class="form-input" value="R$ 89,50" readonly
                         style="font-family: monospace; font-weight: 600;">
                 </div>

                 <div class="form-group">
                     <label class="form-label">Justificativa Detalhada</label>
                     <textarea class="form-textarea" placeholder="Descreva o motivo completo do estorno..."></textarea>
                 </div>

                 <div style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md);">
                     <label
                         style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                         <input type="checkbox" style="accent-color: var(--primary); width: 18px; height: 18px;">
                         <span><strong>Confirmo que verifiquei a fatura</strong> — O estorno está de acordo com as
                             políticas da empresa</span>
                     </label>
                 </div>
             </div>
             <div class="modal-footer">
                 <button class="btn btn-outline" onclick="closeModal('modal-estornar-pagamento')">Cancelar</button>
                 <button class="btn btn-danger"
                     onclick="if(confirm('Tem certeza que deseja estornar este pagamento? A fatura será reaberta.')) { alert('Pagamento estornado com sucesso! Fatura reaberta.'); closeModal('modal-estornar-pagamento'); closeModal('modal-detalhes-pagamento'); }">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" style="margin-right: 6px;">
                         <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                         <path d="M3 3v5h5" />
                     </svg>
                     Confirmar Estorno
                 </button>
             </div>
         </div>
     </div>

     <!-- ============================================ -->
     <!-- MODAL: NOVO PAGAMENTO (Registro Manual)     -->
     <!-- ============================================ -->

     <livewire:admin.pagamentos.registrar-pagamento />

     <!-- ============================================ -->
     <!-- MODAL: CONFIRMAR PAGAMENTO (Pendente → Pago) -->
     <!-- ============================================ -->
     <div class="modal-overlay" id="modal-confirmar-pagamento">
         <div class="modal" style="max-width: 500px;">
             <div class="modal-header">
                 <div style="display: flex; align-items: center; gap: var(--space-md);">
                     <div
                         style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--success); display: flex; align-items: center; justify-content: center; color: white;">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M20 6 9 17l-5-5" />
                         </svg>
                     </div>
                     <div>
                         <h3 class="modal-title">Confirmar Pagamento</h3>
                         <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">#TRX-7840 —
                             Condomínio Solar</p>
                     </div>
                 </div>
                 <button class="modal-close" onclick="closeModal('modal-confirmar-pagamento')">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M18 6 6 18" />
                         <path d="m6 6 12 12" />
                     </svg>
                 </button>
             </div>
             <div class="modal-body">
                 <div
                     style="text-align:center;padding:1.5rem;background:var(--neutral);border-radius:12px;margin-bottom:1.5rem;">
                     <div style="font-size:0.875rem;color:var(--text-secondary);">Valor a Confirmar</div>
                     <div style="font-size:2rem;font-weight:700;color:var(--primary);">R$ 3.890,00</div>
                     <div style="margin-top:0.5rem;"><span class="badge badge-warning">Pendente → Pago</span></div>
                 </div>

                 <div class="form-group">
                     <label class="form-label">Data do Recebimento *</label>
                     <input type="date" class="form-input" value="2026-05-08" required>
                 </div>

                 <div class="form-group">
                     <label class="form-label">Método Confirmado *</label>
                     <select class="form-select" required>
                         <option>Selecione...</option>
                         <option selected>Débito em Conta</option>
                         <option>PIX</option>
                         <option>Boleto</option>
                         <option>Cartão de Crédito</option>
                         <option>Dinheiro</option>
                     </select>
                 </div>

                 <div class="form-group">
                     <label class="form-label">Número do Comprovante / Autenticação</label>
                     <input type="text" class="form-input" placeholder="Nº de autenticação bancária">
                 </div>

                 <div style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md);">
                     <label
                         style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                         <input type="checkbox" checked style="accent-color: var(--primary); width: 18px; height: 18px;">
                         <span><strong>Confirmo o recebimento</strong> — O valor foi creditado na conta da empresa</span>
                     </label>
                 </div>
             </div>
             <div class="modal-footer">
                 <button class="btn btn-outline" onclick="closeModal('modal-confirmar-pagamento')">Cancelar</button>
                 <button class="btn btn-primary" onclick="confirmarPagamento()">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" style="margin-right: 6px;">
                         <path d="M20 6 9 17l-5-5" />
                     </svg>
                     Confirmar Recebimento
                 </button>
             </div>
         </div>
     </div>

     <!-- ============================================ -->
     <!-- MODAL: CONCILIAÇÃO BANCÁRIA                 -->
     <!-- ============================================ -->
     <div class="modal-overlay" id="modal-conciliacao">
         <div class="modal modal-lg" style="max-width: 900px;">
             <div class="modal-header">
                 <div style="display: flex; align-items: center; gap: var(--space-md);">
                     <div
                         style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--secondary); display: flex; align-items: center; justify-content: center; color: white;">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                             <polyline points="7 10 12 15 17 10" />
                             <line x1="12" x2="12" y1="15" y2="3" />
                         </svg>
                     </div>
                     <div>
                         <h3 class="modal-title">Conciliação Bancária</h3>
                         <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Sincronize
                             pagamentos com extrato bancário</p>
                     </div>
                 </div>
                 <button class="modal-close" onclick="closeModal('modal-conciliacao')">
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
                         <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                             Transações no Extrato</div>
                         <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">1.847</div>
                     </div>
                     <div
                         style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                         <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                             Conciliadas</div>
                         <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">1.836</div>
                     </div>
                     <div
                         style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                         <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                             Pendentes</div>
                         <div style="font-size: 1.5rem; font-weight: 700; color: var(--warning);">11</div>
                     </div>
                 </div>

                 <div class="card" style="margin: 0; margin-bottom: var(--space-lg);">
                     <div class="card-header">
                         <h3 class="card-title">Transações Pendentes de Conciliação</h3>
                     </div>
                     <div class="table-container">
                         <table>
                             <thead>
                                 <tr>
                                     <th>Data</th>
                                     <th>Descrição no Extrato</th>
                                     <th>Valor</th>
                                     <th>Cliente Sugerido</th>
                                     <th>Fatura</th>
                                     <th>Ação</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr>
                                     <td style="font-size: var(--label-size);">08/05/2026</td>
                                     <td>PIX RECEBIDO - JOAO SILVA</td>
                                     <td style="font-weight: 600;">R$ 89,50</td>
                                     <td>João da Silva Santos</td>
                                     <td style="font-family: monospace;">FAT-2026-004521-05</td>
                                     <td>
                                         <button class="btn btn-sm btn-primary" onclick="conciliarPagamento()">
                                             <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                                                 <path d="M20 6 9 17l-5-5" />
                                             </svg>
                                             Conciliar
                                         </button>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td style="font-size: var(--label-size);">07/05/2026</td>
                                     <td>BOLETO PAGO - MERCADO CENTRAL</td>
                                     <td style="font-weight: 600;">R$ 1.245,80</td>
                                     <td>Mercado Central Ltda</td>
                                     <td style="font-family: monospace;">FAT-2026-008932-05</td>
                                     <td>
                                         <button class="btn btn-sm btn-primary" onclick="conciliarPagamento()">
                                             <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                                                 <path d="M20 6 9 17l-5-5" />
                                             </svg>
                                             Conciliar
                                         </button>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td style="font-size: var(--label-size);">06/05/2026</td>
                                     <td>PIX RECEBIDO - IND PETROQUIMICA</td>
                                     <td style="font-weight: 600;">R$ 8.750,00</td>
                                     <td>Indústria Petroquímica S.A.</td>
                                     <td style="font-family: monospace;">FAT-2026-001234-05</td>
                                     <td>
                                         <button class="btn btn-sm btn-primary" onclick="conciliarPagamento()">
                                             <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" style="margin-right: 4px;">
                                                 <path d="M20 6 9 17l-5-5" />
                                             </svg>
                                             Conciliar
                                         </button>
                                     </td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="modal-footer">
                 <button class="btn btn-outline" onclick="closeModal('modal-conciliacao')">Fechar</button>
                 <button class="btn btn-secondary" onclick="alert('Importando extrato bancário...')">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" style="margin-right: 6px;">
                         <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                         <polyline points="7 10 12 15 17 10" />
                         <line x1="12" x2="12" y1="15" y2="3" />
                     </svg>
                     Importar Extrato OFX
                 </button>
                 <button class="btn btn-primary"
                     onclick="alert('Conciliação automática iniciada! 11 transações processadas.')">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" style="margin-right: 6px;">
                         <path d="M20 6 9 17l-5-5" />
                     </svg>
                     Conciliação Automática
                 </button>
             </div>
         </div>
     </div>

     <!-- ============================================ -->
     <!-- MODAL: COMPROVANTE                          -->
     <!-- ============================================ -->
     <div class="modal-overlay" id="modal-comprovante">
         <div class="modal modal-lg" style="max-width: 900px;">
             <div class="modal-header">
                 <div style="display: flex; align-items: center; gap: var(--space-md);">
                     <div
                         style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--primary); display: flex; align-items: center; justify-content: center; color: white;">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                             <polyline points="14 2 14 8 20 8" />
                         </svg>
                     </div>
                     <div>
                         <h3 class="modal-title">Detalhe de Pagamento</h3>
                         <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                         </p>
                     </div>
                 </div>
                 <button class="modal-close" onclick="closeModal('modal-comprovante')">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M18 6 6 18" />
                         <path d="m6 6 12 12" />
                     </svg>
                 </button>
             </div>
             @if ($modal)
                 <div class="modal-body">
                     <!-- Aba: Informações -->
                     <div id="tab-ver-info" class="tab-content-ver-med" style="display: block;">
                         <div class="medidor-detail-grid">
                             <div class="medidor-detail-section">
                                 <h4>Dados da Fatura</h4>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Número Fatura</span>
                                     <span class="medidor-detail-value"
                                         style="font-family: monospace;">{{ $dados['codigo_fatura'] }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Mes Referente</span>
                                     <span class="medidor-detail-value"
                                         style="font-family: monospace;">{{ $dados['mes_referencia'] }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Consumo m3</span>
                                     <span class="medidor-detail-value">{{ number_format($dados['consumo_m3'], 2) }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Valor Consumo</span>
                                     <span
                                         class="medidor-detail-value">{{ number_format($dados['valor_consumo'], 2) }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Multa</span>
                                     <span class="medidor-detail-value">{{ $dados['multa'] }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Juros</span>
                                     <span class="medidor-detail-value">{{ $dados['juros'] }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Valor Consumo</span>
                                     <span
                                         class="medidor-detail-value">{{ number_format($dados['valor_pago'], 2) }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Valor Total</span>
                                     <span class="medidor-detail-value">{{ number_format($dados['valor_total'], 2) }}
                                         MT</span>
                                 </div>

                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Status</span>
                                     <span class="medidor-detail-value">{{ $dados['status'] }}</span>
                                 </div>
                                 {{-- <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Ano Fabricação</span>
                                     <span class="medidor-detail-value">2022</span>
                                 </div> --}}
                             </div>
                             <div class="medidor-detail-section">
                                 <h4>Cliente & Instalação</h4>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Cliente</span>
                                     <span class="medidor-detail-value">{{ $dados['nome'] }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Matrícula</span>
                                     <span class="medidor-detail-value"
                                         style="font-family: monospace;">{{ $dados['numero_matricula'] }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Endereço</span>
                                     <span class="medidor-detail-value">{{ $dados['endereco'] }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Bairro / Zona</span>
                                     <span class="medidor-detail-value">{{ $dados['bairro'] }} -
                                         {{ $dados['zona_distribuicao'] }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Data Instalação</span>
                                     <span class="medidor-detail-value">{{ $dados['data_solicitacao'] }}</span>
                                 </div>
                                 <div class="medidor-detail-row">
                                     <span class="medidor-detail-label">Local Instalação</span>
                                     <span class="medidor-detail-value">{{ $dados['tipo_imovel'] }}</span>
                                 </div>
                             </div>
                         </div>
                         {{-- <div
                             style="margin-top: var(--space-lg); display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-md);">
                             <div
                                 style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: var(--radius-md); padding: var(--space-lg); color: white; text-align: center;">
                                 <div style="font-size: var(--small-size); opacity: 0.9;">Leitura Atual</div>
                                 <div
                                     style="font-size: 1.75rem; font-weight: 700; margin-top: 4px; font-family: monospace;">
                                     45.230 m³</div>
                             </div>
                             <div
                                 style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                 <div style="font-size: var(--small-size); color: var(--text-muted);">Consumo Médio Mensal
                                 </div>
                                 <div
                                     style="font-size: 1.75rem; font-weight: 700; margin-top: 4px; color: var(--text-primary); font-family: monospace;">
                                     56 m³</div>
                             </div>
                             <div
                                 style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                                 <div style="font-size: var(--small-size); color: var(--text-muted);">Tempo em Operação
                                 </div>
                                 <div
                                     style="font-size: 1.75rem; font-weight: 700; margin-top: 4px; color: var(--text-primary);">
                                     3 anos</div>
                             </div>
                         </div> --}}
                     </div>


                 </div>
             @endif
             <div class="modal-footer">
                 <button class="btn btn-outline" onclick="closeModal('modal-comprovante')">Fechar</button>

             </div>
         </div>
     </div>


     <!-- Toast Container -->
     <div id="toast-container"
         style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: var(--space-sm);">
     </div>


     <script>
         // Close modal on overlay click
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

         // Tab switching - Pagamentos
         function switchTabPag(btn, tabId) {
             document.querySelectorAll('.tabs .tab').forEach(t => t.classList.remove('active'));
             btn.classList.add('active');
             // In a real app, this would filter the table content
             // For demo purposes, we just switch the active tab style
         }
     </script>
 @endsection
