 <link rel="stylesheet" href="{{ asset('assets/css/clientesApp.css') }}">
 <div class="app-mobile">
     <style>
         /* ═══════════════════════════════════════════════════════════════
            DASHBOARD CLIENTE — APP MOBILE
            AquaNexus Water Utility Management System
            ═══════════════════════════════════════════════════════════════ */

         .cliente-dashboard {
             padding: 16px;
             background: var(--neutral, #f8fafc);
             min-height: 100vh;
         }

         /* ─── Header ─── */
         .dash-header {
             margin-bottom: 20px;
         }

         .dash-saudacao h1 {
             font-size: 1.5rem;
             font-weight: 700;
             color: var(--text-primary, #1e293b);
             margin-bottom: 4px;
         }

         .dash-saudacao p {
             font-size: 0.875rem;
             color: var(--text-muted, #94a3b8);
         }

         .dash-matricula {
             margin-top: 8px;
         }

         .dash-matricula span {
             font-size: 0.75rem;
             color: var(--text-secondary, #64748b);
             background: var(--white, #ffffff);
             padding: 4px 12px;
             border-radius: 999px;
             border: 1px solid var(--neutral-dark, #e2e8f0);
         }

         /* ─── Alertas ─── */
         .dash-alertas {
             margin-bottom: 20px;
         }

         .alerta-card {
             display: flex;
             align-items: flex-start;
             gap: 12px;
             padding: 16px;
             border-radius: 12px;
             margin-bottom: 12px;
             border-left: 4px solid;
         }

         .alerta-danger {
             background: var(--danger-light, #fee2e2);
             border-left-color: var(--danger, #dc2626);
         }

         .alerta-danger .alerta-icon {
             color: var(--danger, #dc2626);
         }

         .alerta-danger .alerta-titulo {
             color: var(--danger, #dc2626);
         }

         .alerta-warning {
             background: var(--warning-light, #fef3c7);
             border-left-color: var(--warning, #d97706);
         }

         .alerta-warning .alerta-icon {
             color: var(--warning, #d97706);
         }

         .alerta-warning .alerta-titulo {
             color: var(--warning, #d97706);
         }

         .alerta-info {
             background: rgba(0, 131, 143, 0.08);
             border-left-color: var(--tertiary, #00838f);
         }

         .alerta-info .alerta-icon {
             color: var(--tertiary, #00838f);
         }

         .alerta-info .alerta-titulo {
             color: var(--tertiary, #00838f);
         }

         .alerta-icon {
             flex-shrink: 0;
             margin-top: 2px;
         }

         .alerta-content {
             flex: 1;
             min-width: 0;
         }

         .alerta-titulo {
             font-size: 0.875rem;
             font-weight: 700;
             margin-bottom: 2px;
         }

         .alerta-mensagem {
             font-size: 0.75rem;
             color: var(--text-secondary, #64748b);
             line-height: 1.4;
         }

         .alerta-acao {
             margin-left: auto;
             background: none;
             border: none;
             font-size: 0.75rem;
             font-weight: 700;
             color: var(--primary, #003366);
             cursor: pointer;
             white-space: nowrap;
             padding: 4px 0;
         }

         .alerta-acao:hover {
             text-decoration: underline;
         }

         /* ─── Card Consumo Atual ─── */
         .cliente-dashboard-card {
             background: var(--white, #ffffff);
             border: 1px solid var(--neutral-dark, #e2e8f0);
             border-radius: 16px;
             padding: 20px;
             margin-bottom: 20px;
             box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
         }

         .cliente-dashboard-title {
             font-size: 0.875rem;
             font-weight: 600;
             color: var(--text-muted, #94a3b8);
             text-transform: uppercase;
             letter-spacing: 0.5px;
             margin-bottom: 16px;
         }

         .cliente-consumo-atual {
             display: flex;
             justify-content: space-between;
             align-items: center;
             margin-bottom: 16px;
         }

         .cliente-consumo-info h3 {
             font-size: 2.25rem;
             font-weight: 800;
             color: var(--primary, #003366);
             font-family: var(--font-headline, "Inter", sans-serif);
             margin-bottom: 4px;
             line-height: 1;
         }

         .cliente-consumo-info p {
             font-size: 0.75rem;
             color: var(--text-muted, #94a3b8);
         }

         .cliente-consumo-icon {
             width: 48px;
             height: 48px;
             background: linear-gradient(135deg, var(--tertiary, #00838f) 0%, var(--tertiary-light, #00acc1) 100%);
             border-radius: 12px;
             display: flex;
             align-items: center;
             justify-content: center;
             color: white;
             box-shadow: 0 4px 12px rgba(0, 131, 143, 0.25);
         }

         /* Barra de progresso */
         .cliente-consumo-barra {
             width: 100%;
             height: 8px;
             background: var(--neutral-dark, #e2e8f0);
             border-radius: 999px;
             overflow: hidden;
             margin-bottom: 10px;
         }

         .cliente-consumo-preenchimento {
             height: 100%;
             background: linear-gradient(90deg, var(--primary, #003366) 0%, var(--tertiary, #00838f) 100%);
             border-radius: 999px;
             transition: width 0.6s ease;
         }

         .cliente-consumo-meta {
             display: flex;
             justify-content: space-between;
             font-size: 0.75rem;
             color: var(--text-muted, #94a3b8);
             margin-bottom: 12px;
         }

         .cliente-consumo-aviso {
             display: flex;
             align-items: center;
             gap: 8px;
             padding: 10px 12px;
             background: var(--warning-light, #fef3c7);
             border: 1px solid rgba(217, 119, 6, 0.2);
             border-radius: 8px;
             font-size: 0.75rem;
             color: var(--warning, #d97706);
             font-weight: 500;
         }

         .cliente-consumo-aviso svg {
             flex-shrink: 0;
         }

         /* ─── Cards Grid ─── */
         .dash-cards-grid {
             display: grid;
             grid-template-columns: 1fr 1fr;
             gap: 12px;
             margin-bottom: 24px;
         }

         .dash-card {
             display: flex;
             align-items: flex-start;
             gap: 12px;
             padding: 16px;
             background: var(--white, #ffffff);
             border: 1px solid var(--neutral-dark, #e2e8f0);
             border-radius: 12px;
             text-decoration: none;
             color: inherit;
             transition: all 0.2s;
         }

         .dash-card:hover {
             border-color: var(--primary-lighter, #336699);
             box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
             transform: translateY(-2px);
         }

         .dash-card-icon {
             width: 40px;
             height: 40px;
             border-radius: 10px;
             display: flex;
             align-items: center;
             justify-content: center;
             flex-shrink: 0;
         }

         .dash-card-success .dash-card-icon {
             background: var(--success-light, #d1fae5);
             color: var(--success, #059669);
         }

         .dash-card-danger .dash-card-icon {
             background: var(--danger-light, #fee2e2);
             color: var(--danger, #dc2626);
         }

         .dash-card-warning .dash-card-icon {
             background: var(--warning-light, #fef3c7);
             color: var(--warning, #d97706);
         }

         .dash-card-tertiary .dash-card-icon {
             background: rgba(0, 131, 143, 0.1);
             color: var(--tertiary, #00838f);
         }

         .dash-card-content {
             flex: 1;
             min-width: 0;
         }

         .dash-card-valor {
             font-size: 1.125rem;
             font-weight: 700;
             color: var(--text-primary, #1e293b);
             font-family: var(--font-headline, "Inter", sans-serif);
             margin-bottom: 2px;
         }

         .dash-card-titulo {
             font-size: 0.75rem;
             font-weight: 600;
             color: var(--text-secondary, #64748b);
             margin-bottom: 2px;
         }

         .dash-card-subtitulo {
             font-size: 0.6875rem;
             color: var(--text-muted, #94a3b8);
         }

         /* ─── Seções ─── */
         .dash-section {
             margin-bottom: 24px;
         }

         .dash-section-header {
             display: flex;
             justify-content: space-between;
             align-items: center;
             margin-bottom: 12px;
         }

         .dash-section-header h3 {
             font-size: 1rem;
             font-weight: 700;
             color: var(--text-primary, #1e293b);
         }

         .dash-section-link {
             font-size: 0.875rem;
             font-weight: 600;
             color: var(--primary, #003366);
             text-decoration: none;
         }

         .dash-section-link:hover {
             text-decoration: underline;
         }

         /* ─── Lista de Faturas ─── */
         .dash-faturas-lista {
             display: flex;
             flex-direction: column;
             gap: 8px;
         }

         .dash-fatura-item {
             display: flex;
             justify-content: space-between;
             align-items: center;
             gap: 12px;
             padding: 14px 16px;
             background: var(--white, #ffffff);
             border: 1px solid var(--neutral-dark, #e2e8f0);
             border-radius: 12px;
             cursor: pointer;
             transition: all 0.2s;
         }

         .dash-fatura-item:hover {
             border-color: var(--primary-lighter, #336699);
             box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
         }

         .dash-fatura-main {
             display: flex;
             align-items: center;
             gap: 12px;
             flex: 1;
             min-width: 0;
         }

         .dash-fatura-status-icon {
             width: 36px;
             height: 36px;
             border-radius: 50%;
             display: flex;
             align-items: center;
             justify-content: center;
             flex-shrink: 0;
         }

         .dash-fatura-status-icon.status-pago {
             background: var(--success-light, #d1fae5);
             color: var(--success, #059669);
         }

         .dash-fatura-status-icon.status-pendente {
             background: var(--warning-light, #fef3c7);
             color: var(--warning, #d97706);
         }

         .dash-fatura-status-icon.status-vencida {
             background: var(--danger-light, #fee2e2);
             color: var(--danger, #dc2626);
         }

         .dash-fatura-status-icon.status-parcial {
             background: rgba(0, 131, 143, 0.1);
             color: var(--tertiary, #00838f);
         }

         .dash-fatura-info {
             flex: 1;
             min-width: 0;
         }

         .dash-fatura-mes {
             font-size: 0.875rem;
             font-weight: 600;
             color: var(--text-primary, #1e293b);
             margin-bottom: 2px;
         }

         .dash-fatura-codigo {
             font-size: 0.75rem;
             color: var(--text-muted, #94a3b8);
             font-family: monospace;
             margin-bottom: 2px;
         }

         .dash-fatura-vencimento {
             font-size: 0.6875rem;
             color: var(--text-muted, #94a3b8);
         }

         .vencimento-proximo {
             color: var(--warning, #d97706);
             font-weight: 600;
             margin-left: 4px;
         }

         .dash-fatura-valor-section {
             text-align: right;
             flex-shrink: 0;
         }

         .dash-fatura-valor {
             font-size: 0.875rem;
             font-weight: 700;
             color: var(--text-primary, #1e293b);
             font-family: var(--font-headline, "Inter", sans-serif);
         }

         .dash-fatura-saldo {
             font-size: 0.6875rem;
             color: var(--danger, #dc2626);
             font-weight: 600;
         }

         /* ─── Lista de Pagamentos ─── */
         .dash-pagamentos-lista {
             display: flex;
             flex-direction: column;
             gap: 8px;
         }

         .dash-pagamento-item {
             display: flex;
             align-items: center;
             gap: 12px;
             padding: 14px 16px;
             background: var(--white, #ffffff);
             border: 1px solid var(--neutral-dark, #e2e8f0);
             border-radius: 12px;
             cursor: pointer;
             transition: all 0.2s;
         }

         .dash-pagamento-item:hover {
             border-color: var(--primary-lighter, #336699);
             box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
         }

         .dash-pagamento-icon {
             width: 36px;
             height: 36px;
             border-radius: 50%;
             background: var(--success-light, #d1fae5);
             color: var(--success, #059669);
             display: flex;
             align-items: center;
             justify-content: center;
             flex-shrink: 0;
         }

         .dash-pagamento-info {
             flex: 1;
             min-width: 0;
         }

         .dash-pagamento-valor {
             font-size: 0.875rem;
             font-weight: 700;
             color: var(--text-primary, #1e293b);
             font-family: var(--font-headline, "Inter", sans-serif);
             margin-bottom: 2px;
         }

         .dash-pagamento-meta {
             font-size: 0.6875rem;
             color: var(--text-muted, #94a3b8);
         }

         .dash-pagamento-comprovante {
             width: 32px;
             height: 32px;
             border-radius: 8px;
             background: var(--neutral, #f8fafc);
             color: var(--text-muted, #94a3b8);
             display: flex;
             align-items: center;
             justify-content: center;
             flex-shrink: 0;
         }

         /* ─── Animações ─── */
         @keyframes fadeInUp {
             from {
                 opacity: 0;
                 transform: translateY(16px);
             }

             to {
                 opacity: 1;
                 transform: translateY(0);
             }
         }

         .cliente-dashboard-card,
         .dash-card,
         .dash-fatura-item,
         .dash-pagamento-item {
             animation: fadeInUp 0.3s ease backwards;
         }

         .cliente-dashboard-card {
             animation-delay: 0.05s;
         }

         .dash-card:nth-child(1) {
             animation-delay: 0.1s;
         }

         .dash-card:nth-child(2) {
             animation-delay: 0.15s;
         }

         .dash-card:nth-child(3) {
             animation-delay: 0.2s;
         }

         .dash-card:nth-child(4) {
             animation-delay: 0.25s;
         }
     </style>
     <!-- HEADER -->
     <header class="mobile-header">
         <div class="mobile-header-top">
             <div class="mobile-header-info">
                 <div class="mobile-avatar">MS</div>
                 <div class="mobile-user-info">
                     <h2>{{ Auth::guard('cliente')->user()->nome_completo }}</h2>
                     <p>Cliente • Matrícula: {{ Auth::guard('cliente')->user()->numero_matricula }}</p>
                 </div>
             </div>
             <div class="mobile-header-actions">
                 <button class="mobile-icon-btn" onclick="showToast('Sincronizando dados...', 'warning')">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                         <path d="M3 3v5h5" />
                         <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                         <path d="M16 21h5v-5" />
                     </svg>
                 </button>
                 <button class="mobile-icon-btn" onclick="showToast('2 notificações novas', 'warning')">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                         <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                     </svg>
                     <span class="badge">{{ count($alertas) ?? 0 }}</span>
                 </button>
             </div>
         </div>
         <div class="mobile-resumo">
             @if (!empty($consumoAtual))
                 <div class="mobile-resumo-card">
                     <div class="mobile-resumo-valor">{{ number_format($consumoAtual['consumo_m3'], 0, ',', '.') }}
                     </div>
                     <div class="mobile-resumo-label">m³ Este Mês</div>
                 </div>
                 <div class="mobile-resumo-card">
                     <div class="mobile-resumo-valor"> {{ number_format($consumoAtual['valor_total'], 2) }}MT</div>
                     <div class="mobile-resumo-label">VALOR Fatura Atual</div>
                 </div>
                 <div class="mobile-resumo-card">
                     <div class="mobile-resumo-valor">{{ $consumoAtual['diasRestantes'] }}</div>
                     <div class="mobile-resumo-label">Dias p/ Vencer</div>
                 </div>
             @endif
         </div>
     </header>

     <!-- NAVEGAÇÃO -->
     <nav class="mobile-nav-sections">
         <button class="mobile-nav-chip active" data-section="inicio" onclick="switchSection('inicio')">
             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                 <polyline points="9 22 9 12 15 12 15 22" />
             </svg>
             Início
         </button>
         <button class="mobile-nav-chip" data-section="faturas" onclick="switchSection('faturas')">
             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <rect width="20" height="14" x="2" y="5" rx="2" />
                 <line x1="2" x2="22" y1="10" y2="10" />
             </svg>
             Faturas
         </button>
         <button class="mobile-nav-chip" data-section="consumo" onclick="switchSection('consumo')">
             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <path d="M3 3v18h18" />
                 <path d="m19 9-5 5-4-4-3 3" />
             </svg>
             Consumo
         </button>
         <button class="mobile-nav-chip" data-section="perfil" onclick="switchSection('perfil')">
             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                 <circle cx="12" cy="7" r="4" />
             </svg>
             Perfil
         </button>
     </nav>

     <!-- SEÇÕES -->
     <div class="mobile-sections-container">
         <!-- SEÇÃO: INÍCIO -->
         <section class="mobile-section active" id="section-inicio">
             <!-- Consumo Atual -->
             {{-- <div class="cliente-dashboard-card">
                 <div class="cliente-dashboard-title">Consumo Atual — Maio/2026</div>
                 <div class="cliente-consumo-atual">
                     <div class="cliente-consumo-info">
                         <h3>45 m³</h3>
                         <p>Período: 01/05 — 08/05/2026</p>
                     </div>
                     <div class="cliente-consumo-icon">
                         <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                         </svg>
                     </div>
                 </div>
                 <div class="cliente-consumo-barra">
                     <div class="cliente-consumo-preenchimento" style="width: 60%"></div>
                 </div>
                 <div class="cliente-consumo-meta">
                     <span>60% da média mensal</span>
                     <span>Média: 75 m³/mês</span>
                 </div>
             </div> --}}

             <div class="cliente-dashboard">

                 <!-- ═══════════════════════════════════════════════════════════ -->
                 <!-- HEADER COM SAUDAÇÃO -->
                 <!-- ═══════════════════════════════════════════════════════════ -->
                 <div class="dash-header">
                     <div class="dash-saudacao">
                         <h1>Olá, {{ $cliente->nome_completo ?? 'Cliente' }}</h1>
                         <p>Bem-vindo ao seu painel AquaNexus</p>
                     </div>
                     <div class="dash-matricula">
                         <span>Matrícula: {{ $cliente->numero_matricula ?? '—' }}</span>
                     </div>
                 </div>

                 <!-- ═══════════════════════════════════════════════════════════ -->
                 <!-- ALERTAS -->
                 <!-- ═══════════════════════════════════════════════════════════ -->
                 @if (!empty($alertas))
                     <div class="dash-alertas">
                         @foreach ($alertas as $alerta)
                             <div class="alerta-card alerta-{{ $alerta['tipo'] }}">
                                 <div class="alerta-icon">
                                     @if ($alerta['tipo'] === 'danger')
                                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                             <circle cx="12" cy="12" r="10" />
                                             <line x1="12" y1="8" x2="12" y2="12" />
                                             <line x1="12" y1="16" x2="12.01" y2="16" />
                                         </svg>
                                     @elseif($alerta['tipo'] === 'warning')
                                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                             <path
                                                 d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                             <line x1="12" y1="9" x2="12" y2="13" />
                                             <line x1="12" y1="17" x2="12.01" y2="17" />
                                         </svg>
                                     @else
                                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                             <circle cx="12" cy="12" r="10" />
                                             <line x1="12" y1="16" x2="12" y2="12" />
                                             <line x1="12" y1="8" x2="12.01" y2="8" />
                                         </svg>
                                     @endif
                                 </div>
                                 <div class="alerta-content">
                                     <div class="alerta-titulo">{{ $alerta['titulo'] }}</div>
                                     <div class="alerta-mensagem">{{ $alerta['mensagem'] }}</div>
                                 </div>
                                 <button class="alerta-acao"
                                     wire:click="$dispatch('navigate', '{{ $alerta['rota'] }}')">
                                     {{ $alerta['acao'] }}
                                 </button>
                             </div>
                         @endforeach
                     </div>
                 @else
                     <!-- Última Fatura -->
                     <div class="cliente-dashboard-card">
                         <div class="cliente-dashboard-title">Última Fatura</div>
                         <div
                             style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-md);">
                             <div>
                                 <div
                                     style="font-size: 1.5rem; font-weight: 700; color: var(--primary); font-family: monospace;">
                                     MZN {{ number_format($consumoAtual['valorRestante'], 2) }}</div>
                                 <div style="font-size: var(--small-size); color: var(--text-muted);">Vencimento:
                                     {{ $consumoAtual['periodo_fim'] }}
                                 </div>
                             </div>
                             <span class="badge {{ $consumoAtual['badge'] }}">{{ $consumoAtual['status'] }}</span>
                         </div>
                         <button class="mobile-btn-primary" onclick="openPagamento()">
                             <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                 <rect width="20" height="14" x="2" y="5" rx="2" />
                                 <line x1="2" x2="22" y1="10" y2="10" />
                             </svg>
                             Pagar Agora
                         </button>
                     </div>
                 @endif

                 <!-- ═══════════════════════════════════════════════════════════ -->
                 <!-- CARD: CONSUMO ATUAL -->
                 <!-- ═══════════════════════════════════════════════════════════ -->
                 @if (!empty($consumoAtual))
                     <div class="cliente-dashboard-card">
                         <div class="cliente-dashboard-title">
                             Consumo Atual — {{ $consumoAtual['mes_ano'] }}
                         </div>
                         <div class="cliente-consumo-atual">
                             <div class="cliente-consumo-info">
                                 <h3>{{ number_format($consumoAtual['consumo_m3'], 0, ',', '.') }} m³</h3>
                                 <p>Período: {{ $consumoAtual['periodo_inicio'] }} —
                                     {{ $consumoAtual['periodo_fim'] }}</p>
                             </div>
                             <div class="cliente-consumo-icon">
                                 <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                 </svg>
                             </div>
                         </div>
                         <div class="cliente-consumo-barra">
                             <div class="cliente-consumo-preenchimento"
                                 style="width: {{ $consumoAtual['percentual_media'] }}%"></div>
                         </div>
                         <div class="cliente-consumo-meta">
                             <span>{{ $consumoAtual['percentual_media'] }}% da média mensal</span>
                             <span>Média: {{ number_format($consumoAtual['media_mensal'], 0, ',', '.') }} m³/mês</span>
                         </div>
                         @if ($consumoAtual['tendencia'] === 'acima' && $consumoAtual['percentual_media'] > 100)
                             <div class="cliente-consumo-aviso">
                                 <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path
                                         d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                     <line x1="12" y1="9" x2="12" y2="13" />
                                     <line x1="12" y1="17" x2="12.01" y2="17" />
                                 </svg>
                                 Consumo acima da média — verifique possíveis vazamentos
                             </div>
                         @endif
                     </div>
                 @endif

                 <!-- ═══════════════════════════════════════════════════════════ -->
                 <!-- CARDS DE RESUMO -->
                 <!-- ═══════════════════════════════════════════════════════════ -->
                 <div class="dash-cards-grid">
                     @foreach ($cards as $key => $card)
                         <a class="dash-card dash-card-{{ $card['cor'] }}">
                             <div class="dash-card-icon">
                                 @if ($card['icone'] === 'file-text')
                                     <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2">
                                         <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                         <polyline points="14 2 14 8 20 8" />
                                         <line x1="16" x2="8" y1="13" y2="13" />
                                         <line x1="16" x2="8" y1="17" y2="17" />
                                         <polyline points="10 9 9 9 8 9" />
                                     </svg>
                                 @elseif($card['icone'] === 'wallet')
                                     <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2">
                                         <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                                         <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                                         <path d="M18 12a2 2 0 0 0 0 4h4v-4Z" />
                                     </svg>
                                 @elseif($card['icone'] === 'check-circle')
                                     <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2">
                                         <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                         <polyline points="22 4 12 14.01 9 11.01" />
                                     </svg>
                                 @else
                                     <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2">
                                         <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                                     </svg>
                                 @endif
                             </div>
                             <div class="dash-card-content">
                                 <div class="dash-card-valor">{{ $card['valor'] }}</div>
                                 <div class="dash-card-titulo">{{ $card['titulo'] }}</div>
                                 <div class="dash-card-subtitulo">{{ $card['subtitulo'] }}</div>
                             </div>
                         </a>
                     @endforeach
                 </div>

                 <!-- ═══════════════════════════════════════════════════════════ -->
                 <!-- ÚLTIMAS FATURAS -->
                 <!-- ═══════════════════════════════════════════════════════════ -->
                 @if (!empty($ultimasFaturas))
                     <div class="dash-section">
                         <div class="dash-section-header">
                             <h3>Últimas Faturas</h3>
                             <a href="#" class="dash-section-link">Ver todas →</a>
                         </div>
                         <div class="dash-faturas-lista">
                             @foreach ($ultimasFaturas as $fatura)
                                 <div class="dash-fatura-item" wire:click="verFatura({{ $fatura['id'] }})">
                                     <div class="dash-fatura-main">
                                         <div class="dash-fatura-status-icon status-{{ $fatura['status_classe'] }}">
                                             @if ($fatura['status_classe'] === 'pago')
                                                 <svg width="16" height="16" viewBox="0 0 24 24"
                                                     fill="none" stroke="currentColor" stroke-width="3">
                                                     <path d="M20 6 9 17l-5-5" />
                                                 </svg>
                                             @elseif($fatura['status_classe'] === 'vencida')
                                                 <svg width="16" height="16" viewBox="0 0 24 24"
                                                     fill="none" stroke="currentColor" stroke-width="2">
                                                     <circle cx="12" cy="12" r="10" />
                                                     <line x1="12" y1="8" x2="12"
                                                         y2="12" />
                                                     <line x1="12" y1="16" x2="12.01"
                                                         y2="16" />
                                                 </svg>
                                             @else
                                                 <svg width="16" height="16" viewBox="0 0 24 24"
                                                     fill="none" stroke="currentColor" stroke-width="2">
                                                     <circle cx="12" cy="12" r="10" />
                                                     <polyline points="12 6 12 12 16 14" />
                                                 </svg>
                                             @endif
                                         </div>
                                         <div class="dash-fatura-info">
                                             <div class="dash-fatura-mes">{{ $fatura['mes_ano'] }}</div>
                                             <div class="dash-fatura-codigo">{{ $fatura['codigo'] }}</div>
                                             <div class="dash-fatura-vencimento">
                                                 Venc: {{ $fatura['data_vencimento'] }}
                                                 @if ($fatura['dias_ate_vencimento'] > 0 && $fatura['status_classe'] === 'pendente')
                                                     <span class="vencimento-proximo">em
                                                         {{ $fatura['dias_ate_vencimento'] }} dias</span>
                                                 @endif
                                             </div>
                                         </div>
                                     </div>
                                     <div class="dash-fatura-valor-section">
                                         <div class="dash-fatura-valor">MZN
                                             {{ number_format($fatura['valor_total'], 2, ',', '.') }}</div>
                                         @if ($fatura['saldo_restante'] > 0 && $fatura['status_classe'] !== 'pago')
                                             <div class="dash-fatura-saldo">Resta: MZN
                                                 {{ number_format($fatura['saldo_restante'], 2, ',', '.') }}</div>
                                         @endif
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     </div>
                 @endif

                 <!-- ═══════════════════════════════════════════════════════════ -->
                 <!-- ÚLTIMOS PAGAMENTOS -->
                 <!-- ═══════════════════════════════════════════════════════════ -->
                 @if (!empty($ultimosPagamentos))
                     <div class="dash-section">
                         <div class="dash-section-header">
                             <h3>Últimos Pagamentos</h3>
                             <a href="#" class="dash-section-link">Ver todos →</a>
                         </div>
                         <div class="dash-pagamentos-lista">
                             @foreach ($ultimosPagamentos as $pagamento)
                                 <div class="dash-pagamento-item"
                                     wire:click="verComprovante({{ $pagamento['id'] }})">
                                     <div class="dash-pagamento-icon">
                                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                             <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                             <polyline points="22 4 12 14.01 9 11.01" />
                                         </svg>
                                     </div>
                                     <div class="dash-pagamento-info">
                                         <div class="dash-pagamento-valor">MZN
                                             {{ number_format($pagamento['valor'], 2, ',', '.') }}</div>
                                         <div class="dash-pagamento-meta">
                                             {{ $pagamento['data'] }} • {{ $pagamento['metodo'] }} •
                                             {{ $pagamento['fatura_codigo'] }}
                                         </div>
                                     </div>
                                     <div class="dash-pagamento-comprovante"
                                         onclick="downloadFile({{ $pagamento['id'] }})">
                                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                             <polyline points="14 2 14 8 20 8" />
                                         </svg>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     </div>
                 @endif
             </div>



             <!-- Ações Rápidas -->
             {{-- <div class="cliente-acoes-grid">
                 <div class="cliente-acao-card" onclick="openPagamento()">
                     <div class="cliente-acao-icon pagar">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <rect width="20" height="14" x="2" y="5" rx="2" />
                             <line x1="2" x2="22" y1="10" y2="10" />
                         </svg>
                     </div>
                     <div class="cliente-acao-titulo">Pagar Água</div>
                     <div class="cliente-acao-desc">Fatura atual: €32,50</div>
                 </div>
                 <div class="cliente-acao-card" onclick="switchSection('faturas')">
                     <div class="cliente-acao-icon historico">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M3 3v5h5" />
                             <path d="M3.05 13A9 9 0 1 0 6 5.3L3 8" />
                             <path d="M12 7v5l4 2" />
                         </svg>
                     </div>
                     <div class="cliente-acao-titulo">Histórico</div>
                     <div class="cliente-acao-desc">Últimas faturas</div>
                 </div>
                 <div class="cliente-acao-card" onclick="switchSection('consumo')">
                     <div class="cliente-acao-icon leituras">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M3 3v18h18" />
                             <path d="m19 9-5 5-4-4-3 3" />
                         </svg>
                     </div>
                     <div class="cliente-acao-titulo">Evolução</div>
                     <div class="cliente-acao-desc">Gráfico de consumo</div>
                 </div>
                 <div class="cliente-acao-card" onclick="openSuporte()">
                     <div class="cliente-acao-icon suporte">
                         <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                         </svg>
                     </div>
                     <div class="cliente-acao-titulo">Suporte</div>
                     <div class="cliente-acao-desc">Falar connosco</div>
                 </div>
             </div> --}}


         </section>

         <!-- SEÇÃO: FATURAS -->
         {{-- <section class="mobile-section" id="section-faturas">
             <!-- Fatura Destaque -->
             <div class="fatura-card-destaque">
                 <div class="fatura-destaque-label">Próximo Vencimento</div>
                 <div class="fatura-destaque-valor">€32,50</div>
                 <div class="fatura-destaque-info">Fatura de Maio/2026 • Vence em 12 dias</div>
                 <div class="fatura-destaque-vencimento">
                     <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <circle cx="12" cy="12" r="10" />
                         <polyline points="12 6 12 12 16 14" />
                     </svg>
                     Vencimento: 20/05/2026
                 </div>
                 <button class="fatura-destaque-btn" onclick="openPagamento()">
                     <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <rect width="20" height="14" x="2" y="5" rx="2" />
                         <line x1="2" x2="22" y1="10" y2="10" />
                     </svg>
                     Efetuar Pagamento
                 </button>
             </div>

             <!-- Lista de Faturas -->
             <div class="fatura-lista-titulo">Histórico de Faturas</div>

             <div class="fatura-item">
                 <div class="fatura-item-header">
                     <span class="fatura-item-mes">Abril/2026</span>
                     <span class="fatura-item-status paga">✓ Paga</span>
                 </div>
                 <div class="fatura-item-valor">€28,75</div>
                 <div class="fatura-item-info">
                     <span>Vencimento: 20/04/2026</span>
                     <span>Paga em 18/04/2026</span>
                 </div>
                 <div class="fatura-item-consumo">
                     <span class="fatura-item-consumo-tag">
                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                         </svg>
                         38 m³
                     </span>
                     <span style="font-size: var(--small-size); color: var(--text-muted);">Referência:
                         FT-2026-0042</span>
                 </div>
             </div>

             <div class="fatura-item">
                 <div class="fatura-item-header">
                     <span class="fatura-item-mes">Março/2026</span>
                     <span class="fatura-item-status paga">✓ Paga</span>
                 </div>
                 <div class="fatura-item-valor">€31,20</div>
                 <div class="fatura-item-info">
                     <span>Vencimento: 20/03/2026</span>
                     <span>Paga em 15/03/2026</span>
                 </div>
                 <div class="fatura-item-consumo">
                     <span class="fatura-item-consumo-tag">
                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                         </svg>
                         42 m³
                     </span>
                     <span style="font-size: var(--small-size); color: var(--text-muted);">Referência:
                         FT-2026-0039</span>
                 </div>
             </div>

             <div class="fatura-item">
                 <div class="fatura-item-header">
                     <span class="fatura-item-mes">Fevereiro/2026</span>
                     <span class="fatura-item-status paga">✓ Paga</span>
                 </div>
                 <div class="fatura-item-valor">€35,00</div>
                 <div class="fatura-item-info">
                     <span>Vencimento: 20/02/2026</span>
                     <span>Paga em 19/02/2026</span>
                 </div>
                 <div class="fatura-item-consumo">
                     <span class="fatura-item-consumo-tag">
                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                         </svg>
                         48 m³
                     </span>
                     <span style="font-size: var(--small-size); color: var(--text-muted);">Referência:
                         FT-2026-0036</span>
                 </div>
             </div>
         </section> --}}
         <livewire:admin.mobile.clientes.historico />


         <!-- SEÇÃO: CONSUMO -->
         <section class="mobile-section" id="section-consumo">
             <div class="consumo-grafico-card">
                 <div class="consumo-grafico-titulo">Evolução do Consumo (últimos 6 meses)</div>
                 <div class="consumo-barras">
                     <div class="consumo-barra-item">
                         <div class="consumo-barra-valor">48</div>
                         <div class="consumo-barra" style="height: 80%"></div>
                         <div class="consumo-barra-mes">Fev</div>
                     </div>
                     <div class="consumo-barra-item">
                         <div class="consumo-barra-valor">42</div>
                         <div class="consumo-barra" style="height: 70%"></div>
                         <div class="consumo-barra-mes">Mar</div>
                     </div>
                     <div class="consumo-barra-item">
                         <div class="consumo-barra-valor">38</div>
                         <div class="consumo-barra" style="height: 63%"></div>
                         <div class="consumo-barra-mes">Abr</div>
                     </div>
                     <div class="consumo-barra-item">
                         <div class="consumo-barra-valor">45</div>
                         <div class="consumo-barra" style="height: 75%"></div>
                         <div class="consumo-barra-mes">Mai</div>
                     </div>
                     <div class="consumo-barra-item">
                         <div class="consumo-barra-valor">52</div>
                         <div class="consumo-barra" style="height: 87%"></div>
                         <div class="consumo-barra-mes">Jun</div>
                     </div>
                     <div class="consumo-barra-item">
                         <div class="consumo-barra-valor">40</div>
                         <div class="consumo-barra" style="height: 67%"></div>
                         <div class="consumo-barra-mes">Jul</div>
                     </div>
                 </div>
             </div>

             <div class="consumo-stats-grid">
                 <div class="consumo-stat-box">
                     <div class="consumo-stat-valor">44</div>
                     <div class="consumo-stat-label">m³ Média</div>
                 </div>
                 <div class="consumo-stat-box">
                     <div class="consumo-stat-valor">52</div>
                     <div class="consumo-stat-label">m³ Máximo</div>
                 </div>
                 <div class="consumo-stat-box">
                     <div class="consumo-stat-valor">38</div>
                     <div class="consumo-stat-label">m³ Mínimo</div>
                 </div>
             </div>

             <div class="cliente-dashboard-card">
                 <div class="cliente-dashboard-title">Detalhes da Leitura</div>
                 <div style="display: flex; flex-direction: column; gap: var(--space-md);">
                     <div
                         style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                         <span style="color: var(--text-muted); font-size: var(--label-size);">Medidor</span>
                         <span style="font-weight: 600; font-family: monospace;">M-2024-001234</span>
                     </div>
                     <div
                         style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                         <span style="color: var(--text-muted); font-size: var(--label-size);">Leitura Atual</span>
                         <span style="font-weight: 600; font-family: monospace;">1.890 m³</span>
                     </div>
                     <div
                         style="display: flex; justify-content: space-between; padding: var(--space-sm) 0; border-bottom: 1px solid var(--neutral-dark);">
                         <span style="color: var(--text-muted); font-size: var(--label-size);">Leitura
                             Anterior</span>
                         <span style="font-weight: 600; font-family: monospace;">1.845 m³</span>
                     </div>
                     <div style="display: flex; justify-content: space-between; padding: var(--space-sm) 0;">
                         <span style="color: var(--text-muted); font-size: var(--label-size);">Consumo</span>
                         <span style="font-weight: 700; color: var(--tertiary); font-family: monospace;">45 m³</span>
                     </div>
                 </div>
             </div>
         </section>

         <!-- SEÇÃO: PERFIL -->
         <section class="mobile-section" id="section-perfil">
             <div class="perfil-header">
                 <div class="perfil-avatar-lg">MS</div>
                 <div class="perfil-nome">{{ Auth::guard('cliente')->user()->nome_completo }}</div>
                 <div class="perfil-role">Cliente • {{ Auth::guard('cliente')->user()->zona_distribuicao }}</div>
                 <div class="perfil-stats">
                     <div class="perfil-stat">
                         <div class="perfil-stat-valor">1.890</div>
                         <div class="perfil-stat-label">m³ Total</div>
                     </div>
                     <div class="perfil-stat">
                         <div class="perfil-stat-valor">MZN156</div>
                         <div class="perfil-stat-label">Pago 2026</div>
                     </div>
                     <div class="perfil-stat">
                         <div class="perfil-stat-valor">100%</div>
                         <div class="perfil-stat-label">Regularizado</div>
                     </div>
                 </div>
             </div>

             <div class="perfil-menu">
                 <div class="perfil-menu-item" onclick="openDadosPessoais()">
                     <div class="perfil-menu-icon">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                             <circle cx="12" cy="7" r="4" />
                         </svg>
                     </div>
                     <div class="perfil-menu-info">
                         <div class="perfil-menu-title">Dados Pessoais</div>
                         <div class="perfil-menu-desc">Editar informações do perfil</div>
                     </div>
                     <svg class="perfil-menu-arrow" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2">
                         <polyline points="9 18 15 12 9 6" />
                     </svg>
                 </div>
                 <div class="perfil-menu-item" onclick="openConfiguracoes()">
                     <div class="perfil-menu-icon">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path
                                 d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1-1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                             <circle cx="12" cy="12" r="3" />
                         </svg>
                     </div>
                     <div class="perfil-menu-info">
                         <div class="perfil-menu-title">Configurações</div>
                         <div class="perfil-menu-desc">Preferências do aplicativo</div>
                     </div>
                     <svg class="perfil-menu-arrow" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2">
                         <polyline points="9 18 15 12 9 6" />
                     </svg>
                 </div>
                 <div class="perfil-menu-item" onclick="openSuporte()">
                     <div class="perfil-menu-icon">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                         </svg>
                     </div>
                     <div class="perfil-menu-info">
                         <div class="perfil-menu-title">Suporte</div>
                         <div class="perfil-menu-desc">Falar com o administrador</div>
                     </div>
                     <svg class="perfil-menu-arrow" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2">
                         <polyline points="9 18 15 12 9 6" />
                     </svg>
                 </div>
                 <div class="perfil-menu-item" onclick="openSair()">
                     <div class="perfil-menu-icon" style="background: var(--danger-light); color: var(--danger);">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                             <polyline points="16 17 21 12 16 7" />
                             <line x1="21" x2="9" y1="12" y2="12" />
                         </svg>
                     </div>
                     <div class="perfil-menu-info">
                         <div class="perfil-menu-title" style="color: var(--danger);">Sair da Conta</div>
                         <div class="perfil-menu-desc">Encerrar sessão atual</div>
                     </div>
                     <svg class="perfil-menu-arrow" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2">
                         <polyline points="9 18 15 12 9 6" />
                     </svg>
                 </div>
             </div>

             <div
                 style="text-align: center; padding: var(--space-lg); color: var(--text-muted); font-size: var(--small-size);">
                 AquaNexus Cliente v2.4.1<br>
                 Sincronizado: 08/05/2026 14:30
             </div>
         </section>
     </div>

     <!-- BOTTOM NAVIGATION -->
     <nav class="mobile-bottom-nav">
         <button class="mobile-nav-item active" data-nav="inicio" onclick="switchSection('inicio')">
             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                 <polyline points="9 22 9 12 15 12 15 22" />
             </svg>
             Início
         </button>
         <button class="mobile-nav-item" data-nav="faturas" onclick="switchSection('faturas')">
             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <rect width="20" height="14" x="2" y="5" rx="2" />
                 <line x1="2" x2="22" y1="10" y2="10" />
             </svg>
             Faturas
         </button>
         <button class="mobile-nav-item" data-nav="consumo" onclick="switchSection('consumo')">
             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <path d="M3 3v18h18" />
                 <path d="m19 9-5 5-4-4-3 3" />
             </svg>
             Consumo
         </button>
         <button class="mobile-nav-item" data-nav="perfil" onclick="switchSection('perfil')">
             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                 <circle cx="12" cy="7" r="4" />
             </svg>
             Perfil
         </button>
     </nav>

     <!-- ===== MODAL: PAGAMENTO ===== -->
     <div class="leitura-sheet-overlay" id="modalPagamentoOverlay" onclick="closeModal('modalPagamento')"></div>
     <div class="leitura-sheet" id="modalPagamento">
         <div class="leitura-sheet-handle"></div>
         <div class="leitura-sheet-header">
             <span class="leitura-sheet-title">Pagamento de Fatura</span>
             <button class="leitura-sheet-close" onclick="closeModal('modalPagamento')">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <line x1="18" x2="6" y1="6" y2="18" />
                     <line x1="6" x2="18" y1="6" y2="18" />
                 </svg>
             </button>
         </div>
         <div class="leitura-sheet-body">
             <div class="pagamento-valor-box">
                 <div class="pagamento-valor-label">Valor a Pagar</div>
                 <div class="pagamento-valor-amount">€32,50</div>
                 <div class="pagamento-valor-ref">Ref: FT-2026-0045</div>
             </div>

             <div style="margin-bottom: var(--space-md);">
                 <h4
                     style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                     Método de Pagamento</h4>

                 <div class="pagamento-metodos">
                     <div class="pagamento-metodo active" onclick="selectMetodoPagamento(this)">
                         <div class="pagamento-metodo-icon mbway">
                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                 <rect width="20" height="14" x="2" y="5" rx="2" />
                                 <line x1="2" x2="22" y1="10" y2="10" />
                             </svg>
                         </div>
                         <div class="pagamento-metodo-info">
                             <div class="pagamento-metodo-nome">MB WAY</div>
                             <div class="pagamento-metodo-desc">Pagamento instantâneo</div>
                         </div>
                         <div class="pagamento-metodo-check">✓</div>
                     </div>

                     <div class="pagamento-metodo" onclick="selectMetodoPagamento(this)">
                         <div class="pagamento-metodo-icon cartao">
                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                 <rect width="20" height="14" x="2" y="5" rx="2" />
                                 <line x1="2" x2="22" y1="10" y2="10" />
                                 <path d="M7 15h.01M11 15h2" />
                             </svg>
                         </div>
                         <div class="pagamento-metodo-info">
                             <div class="pagamento-metodo-nome">Cartão de Crédito</div>
                             <div class="pagamento-metodo-desc">Visa, Mastercard, Maestro</div>
                         </div>
                         <div class="pagamento-metodo-check"></div>
                     </div>

                     <div class="pagamento-metodo" onclick="selectMetodoPagamento(this)">
                         <div class="pagamento-metodo-icon multibanco">
                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                 <path d="M4 7V4h3M4 17v3h3M20 7V4h-3M20 17v3h-3M9 9h6v6H9z" />
                             </svg>
                         </div>
                         <div class="pagamento-metodo-info">
                             <div class="pagamento-metodo-nome">Referência Multibanco</div>
                             <div class="pagamento-metodo-desc">Pagamento em ATM ou homebanking</div>
                         </div>
                         <div class="pagamento-metodo-check"></div>
                     </div>
                 </div>
             </div>

             <div
                 style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-bottom: var(--space-lg);">
                 <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: var(--space-xs);">
                     Entidade: <strong style="color: var(--text-primary);">12345</strong></div>
                 <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: var(--space-xs);">
                     Referência: <strong style="color: var(--text-primary); font-family: monospace;">987 654
                         321</strong></div>
                 <div style="font-size: var(--small-size); color: var(--text-muted);">Montante: <strong
                         style="color: var(--text-primary);">€32,50</strong></div>
             </div>

             <button class="mobile-btn-primary" onclick="efetuarPagamento()">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <rect width="20" height="14" x="2" y="5" rx="2" />
                     <line x1="2" x2="22" y1="10" y2="10" />
                 </svg>
                 Confirmar Pagamento
             </button>
         </div>
     </div>

     <!-- ===== MODAL: EDITAR DADOS PESSOAIS ===== -->
     <div class="leitura-sheet-overlay" id="modalDadosOverlay" onclick="closeModal('modalDados')"></div>
     <div class="leitura-sheet" id="modalDados" style="max-height: 90vh;">
         <div class="leitura-sheet-handle"></div>
         <div class="leitura-sheet-header">
             <span class="leitura-sheet-title">Editar Dados Pessoais</span>
             <button class="leitura-sheet-close" onclick="closeModal('modalDados')">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <line x1="18" x2="6" y1="6" y2="18" />
                     <line x1="6" x2="18" y1="6" y2="18" />
                 </svg>
             </button>
         </div>
         <div class="leitura-sheet-body">
             <div style="text-align: center; margin-bottom: var(--space-lg);">
                 <div
                     style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--tertiary), var(--tertiary-light)); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md); color: var(--white); font-weight: 700; font-size: 1.75rem; border: 3px solid var(--neutral-dark);">
                     MS</div>
                 <button class="btn btn-sm btn-outline" style="margin: 0 auto; display: inline-flex;">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                         <circle cx="12" cy="13" r="4" />
                     </svg>
                     Alterar Foto
                 </button>
             </div>

             <div class="form-group">
                 <label class="form-label">Nome Completo</label>
                 <input type="text" class="form-input" value="Maria Silva" id="editNome">
             </div>

             <div class="form-group">
                 <label class="form-label">E-mail</label>
                 <input type="email" class="form-input" value="maria.silva@email.pt" id="editEmail">
             </div>

             <div class="form-group">
                 <label class="form-label">Telemóvel</label>
                 <input type="tel" class="form-input" value="+351 912 345 678" id="editTelemovel">
             </div>

             <div class="form-group">
                 <label class="form-label">NIF</label>
                 <input type="text" class="form-input" value="123 456 789" id="editNif">
             </div>

             <div class="form-group">
                 <label class="form-label">Morada de Instalação</label>
                 <input type="text" class="form-input" value="Rua das Flores, 123 - Apto 42" id="editMorada">
             </div>

             <div style="display: flex; gap: var(--space-sm); margin-top: var(--space-lg);">
                 <button class="btn btn-outline" style="flex: 1; justify-content: center;"
                     onclick="closeModal('modalDados')">Cancelar</button>
                 <button class="mobile-btn-primary" style="flex: 2;" onclick="salvarDadosPessoais()">
                     <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                         <polyline points="17 21 17 13 7 13 7 21" />
                         <polyline points="7 3 7 8 15 8" />
                     </svg>
                     Salvar Alterações
                 </button>
             </div>
         </div>
     </div>

     <!-- ===== MODAL: CONFIGURAÇÕES ===== -->
     <div class="leitura-sheet-overlay" id="modalConfigOverlay" onclick="closeModal('modalConfig')"></div>
     <div class="leitura-sheet" id="modalConfig" style="max-height: 90vh;">
         <div class="leitura-sheet-handle"></div>
         <div class="leitura-sheet-header">
             <span class="leitura-sheet-title">Configurações</span>
             <button class="leitura-sheet-close" onclick="closeModal('modalConfig')">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <line x1="18" x2="6" y1="6" y2="18" />
                     <line x1="6" x2="18" y1="6" y2="18" />
                 </svg>
             </button>
         </div>
         <div class="leitura-sheet-body">
             <div style="margin-bottom: var(--space-lg);">
                 <h4
                     style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                     Notificações</h4>

                 <div class="cfg-toggle-list">
                     <div class="cfg-toggle-item">
                         <div class="cfg-toggle-info">
                             <div class="cfg-toggle-title">Nova Fatura</div>
                             <div class="cfg-toggle-desc">Alerta quando emitir nova fatura</div>
                         </div>
                         <label class="cfg-toggle">
                             <input type="checkbox" checked>
                             <span class="cfg-toggle-slider"></span>
                         </label>
                     </div>
                     <div class="cfg-toggle-item">
                         <div class="cfg-toggle-info">
                             <div class="cfg-toggle-title">Vencimento Próximo</div>
                             <div class="cfg-toggle-desc">Lembrete 3 dias antes do vencimento</div>
                         </div>
                         <label class="cfg-toggle">
                             <input type="checkbox" checked>
                             <span class="cfg-toggle-slider"></span>
                         </label>
                     </div>
                     <div class="cfg-toggle-item">
                         <div class="cfg-toggle-info">
                             <div class="cfg-toggle-title">Consumo Anómalo</div>
                             <div class="cfg-toggle-desc">Aviso de consumo acima da média</div>
                         </div>
                         <label class="cfg-toggle">
                             <input type="checkbox" checked>
                             <span class="cfg-toggle-slider"></span>
                         </label>
                     </div>
                 </div>
             </div>

             <div style="margin-bottom: var(--space-lg);">
                 <h4
                     style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                     Aparência</h4>

                 <div class="cfg-theme-selector">
                     <div class="cfg-theme-option cfg-theme-active" onclick="selectTheme(this)">
                         <div class="cfg-theme-preview cfg-theme-light"></div>
                         <span>Claro</span>
                     </div>
                     <div class="cfg-theme-option" onclick="selectTheme(this)">
                         <div class="cfg-theme-preview cfg-theme-dark"></div>
                         <span>Escuro</span>
                     </div>
                     <div class="cfg-theme-option" onclick="selectTheme(this)">
                         <div class="cfg-theme-preview cfg-theme-auto"></div>
                         <span>Auto</span>
                     </div>
                 </div>
             </div>

             <div style="margin-bottom: var(--space-lg);">
                 <h4
                     style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                     Pagamento Automático</h4>

                 <div class="cfg-toggle-list">
                     <div class="cfg-toggle-item">
                         <div class="cfg-toggle-info">
                             <div class="cfg-toggle-title">Débito Direto</div>
                             <div class="cfg-toggle-desc">Pagamento automático no vencimento</div>
                         </div>
                         <label class="cfg-toggle">
                             <input type="checkbox">
                             <span class="cfg-toggle-slider"></span>
                         </label>
                     </div>
                 </div>
             </div>

             <button class="mobile-btn-primary" onclick="salvarConfiguracoes()">
                 <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                     <polyline points="17 21 17 13 7 13 7 21" />
                     <polyline points="7 3 7 8 15 8" />
                 </svg>
                 Salvar Configurações
             </button>
         </div>
     </div>

     <!-- ===== MODAL: SUPORTE ===== -->
     <div class="leitura-sheet-overlay" id="modalSuporteOverlay" onclick="closeModal('modalSuporte')"></div>
     <div class="leitura-sheet" id="modalSuporte" style="max-height: 90vh;">
         <div class="leitura-sheet-handle"></div>
         <div class="leitura-sheet-header">
             <span class="leitura-sheet-title">Suporte ao Cliente</span>
             <button class="leitura-sheet-close" onclick="closeModal('modalSuporte')">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <line x1="18" x2="6" y1="6" y2="18" />
                     <line x1="6" x2="18" y1="6" y2="18" />
                 </svg>
             </button>
         </div>
         <div class="leitura-sheet-body">
             <div
                 style="display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--space-md); margin-bottom: var(--space-lg);">
                 <button class="cfg-integration-item" onclick="showToast('Chat iniciado com Suporte', 'success')">
                     <div class="cfg-integration-icon" style="background: var(--tertiary); color: var(--white);">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                         </svg>
                     </div>
                     <div class="cfg-integration-info">
                         <div class="cfg-integration-name">Chat Direto</div>
                         <div class="cfg-integration-desc">Falar connosco</div>
                     </div>
                 </button>
                 <button class="cfg-integration-item" onclick="showToast('FAQ aberto', 'success')">
                     <div class="cfg-integration-icon" style="background: var(--primary); color: var(--white);">
                         <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <circle cx="12" cy="12" r="10" />
                             <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                             <line x1="12" x2="12.01" y1="17" y2="17" />
                         </svg>
                     </div>
                     <div class="cfg-integration-info">
                         <div class="cfg-integration-name">Perguntas FAQ</div>
                         <div class="cfg-integration-desc">Dúvidas comuns</div>
                     </div>
                 </button>
             </div>

             <div style="margin-bottom: var(--space-lg);">
                 <h4
                     style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                     Enviar Mensagem</h4>

                 <div class="form-group">
                     <label class="form-label">Assunto</label>
                     <select class="form-select" id="suporteAssunto">
                         <option value="">Selecione...</option>
                         <option value="fatura">Dúvida sobre Fatura</option>
                         <option value="consumo">Consumo Anómalo</option>
                         <option value="medidor">Problema no Medidor</option>
                         <option value="pagamento">Problema de Pagamento</option>
                         <option value="outro">Outro Assunto</option>
                     </select>
                 </div>

                 <div class="form-group">
                     <label class="form-label">Mensagem</label>
                     <textarea class="form-textarea" rows="4" placeholder="Descreva a sua dúvida ou problema..."
                         id="suporteMensagem"></textarea>
                 </div>

                 <div class="form-group">
                     <label class="form-label">Anexar Foto (opcional)</label>
                     <div class="cfg-upload-area" onclick="showToast('Galeria de fotos aberta', 'success')">
                         <div class="cfg-logo-preview-lg">
                             <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                 <path
                                     d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                                 <circle cx="12" cy="13" r="4" />
                             </svg>
                         </div>
                         <div class="cfg-upload-title">Toque para anexar</div>
                         <div class="cfg-upload-desc">Foto do medidor ou problema</div>
                     </div>
                 </div>
             </div>

             <button class="mobile-btn-primary" onclick="enviarSuporte()">
                 <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <line x1="22" x2="11" y1="2" y2="13" />
                     <polygon points="22 2 15 22 11 13 2 9 22 2" />
                 </svg>
                 Enviar Mensagem
             </button>

             <div
                 style="margin-top: var(--space-lg); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md); text-align: center;">
                 <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: var(--space-xs);">
                     Linha de Apoio ao Cliente</div>
                 <div style="font-size: var(--body-size); font-weight: 700; color: var(--tertiary);">+351 800 123 456
                 </div>
                 <div style="font-size: var(--small-size); color: var(--text-muted); margin-top: var(--space-xs);">
                     cliente@aquanexus.pt</div>
             </div>
         </div>
     </div>

     <!-- ===== MODAL: SAIR DO SISTEMA ===== -->
     <div class="leitura-sheet-overlay" id="modalSairOverlay" onclick="closeModal('modalSair')"></div>
     <div class="leitura-sheet" id="modalSair" style="max-height: 40vh; text-align: center;">
         <div class="leitura-sheet-handle"></div>
         <div class="leitura-sheet-body" style="padding-top: var(--space-xl);">
             <div
                 style="width: 64px; height: 64px; border-radius: 50%; background: var(--danger-light); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-lg); color: var(--danger);">
                 <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                     <polyline points="16 17 21 12 16 7" />
                     <line x1="21" x2="9" y1="12" y2="12" />
                 </svg>
             </div>

             <h3
                 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: var(--space-sm);">
                 Sair da Conta?</h3>
             <p style="font-size: var(--label-size); color: var(--text-muted); margin-bottom: var(--space-xl);">
                 Tem a certeza que deseja encerrar a sessão?<br>
                 As suas faturas ficam sempre disponíveis online.
             </p>

             <div style="display: flex; flex-direction: column; gap: var(--space-md);">
                 <form action="{{ route('cliente.logout') }}" method="POST">
                     @csrf
                     <button type="submit" class="mobile-btn-primary" style="background: var(--danger);"
                         onclick="confirmarSaida()">
                         <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                             <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                             <polyline points="16 17 21 12 16 7" />
                             <line x1="21" x2="9" y1="12" y2="12" />
                         </svg>
                         Sim, Sair da Conta
                     </button>
                 </form>
                 <button class="btn btn-outline" style="justify-content: center;" onclick="closeModal('modalSair')">
                     Cancelar, Ficar Logado
                 </button>
             </div>
         </div>
     </div>

     <!-- TOAST NOTIFICATION -->
     <div class="mobile-toast" id="mobileToast">
         <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" id="toastIcon">
             <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
             <polyline points="22 4 12 14.01 9 11.01" />
         </svg>
         <span id="toastMessage">Operação realizada com sucesso!</span>
     </div>
 </div>

 <script>
     function downloadFile(id) {
         const url = `/download-relatorio/${id}`;
         window.location.href = url;
     }

     // ===== NAVEGAÇÃO ENTRE SEÇÕES =====
     function switchSection(sectionName) {

         // Salva a aba atual
         localStorage.setItem('mobile_current_section', sectionName);

         // Chips superiores
         document.querySelectorAll('.mobile-nav-chip').forEach(chip => {
             chip.classList.remove('active');

             if (chip.dataset.section === sectionName) {
                 chip.classList.add('active');
             }
         });

         // Bottom navigation
         document.querySelectorAll('.mobile-nav-item').forEach(item => {
             item.classList.remove('active');

             if (item.dataset.nav === sectionName) {
                 item.classList.add('active');
             }
         });

         // Seções
         document.querySelectorAll('.mobile-section').forEach(section => {
             section.classList.remove('active');
         });

         const targetSection = document.getElementById('section-' + sectionName);

         if (targetSection) {
             targetSection.classList.add('active');
         }

         window.scrollTo({
             top: 0,
             behavior: 'smooth'
         });
     }

     // ===== INIT =====
     document.addEventListener('DOMContentLoaded', () => {

         // Recupera última aba salva
         const savedSection = localStorage.getItem('mobile_current_section') || 'inicio';

         switchSection(savedSection);

         showToast(
             'Bem-vinda, Maria! Sua fatura está disponível.',
             'success'
         );
     });




     // ===== MODAL SYSTEM =====
     function openModal(modalId) {
         document.getElementById(modalId + 'Overlay').classList.add('open');
         document.getElementById(modalId).classList.add('open');
     }

     function closeModal(modalId) {
         document.getElementById(modalId + 'Overlay').classList.remove('open');
         document.getElementById(modalId).classList.remove('open');
     }

     // ===== PERFIL MENU ACTIONS =====
     function openDadosPessoais() {
         openModal('modalDados');
     }

     function openConfiguracoes() {
         openModal('modalConfig');
     }

     function openSuporte() {
         openModal('modalSuporte');
     }

     function openSair() {
         openModal('modalSair');
     }

     function openPagamento() {
         openModal('modalPagamento');
     }

     // ===== PAGAMENTO =====
     function selectMetodoPagamento(element) {
         document.querySelectorAll('.pagamento-metodo').forEach(m => {
             m.classList.remove('active');
             m.querySelector('.pagamento-metodo-check').textContent = '';
         });
         element.classList.add('active');
         element.querySelector('.pagamento-metodo-check').textContent = '✓';
     }

     function efetuarPagamento() {
         const btn = document.querySelector('#modalPagamento .mobile-btn-primary');
         btn.disabled = true;
         btn.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                Processando...
            `;

         setTimeout(() => {
             closeModal('modalPagamento');
             showToast('Pagamento efetuado com sucesso! ✓', 'success');
             btn.disabled = false;
             btn.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="20" height="14" x="2" y="5" rx="2"/>
                        <line x1="2" x2="22" y1="10" y2="10"/>
                    </svg>
                    Confirmar Pagamento
                `;
         }, 2000);
     }

     // ===== SALVAR DADOS PESSOAIS =====
     function salvarDadosPessoais() {
         const nome = document.getElementById('editNome').value;
         if (!nome) {
             showToast('Preencha o nome!', 'error');
             return;
         }

         document.querySelector('.perfil-nome').textContent = nome;
         document.querySelector('.mobile-user-info h2').textContent = nome;
         const iniciais = nome.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
         document.querySelector('.mobile-avatar').textContent = iniciais;
         document.querySelector('.perfil-avatar-lg').textContent = iniciais;

         closeModal('modalDados');
         showToast('Dados atualizados com sucesso!', 'success');
     }

     // ===== CONFIGURAÇÕES =====
     function salvarConfiguracoes() {
         closeModal('modalConfig');
         showToast('Configurações salvas!', 'success');
     }

     function selectTheme(element) {
         document.querySelectorAll('.cfg-theme-option').forEach(opt => opt.classList.remove('cfg-theme-active'));
         element.classList.add('cfg-theme-active');
     }

     // ===== SUPORTE =====
     function enviarSuporte() {
         const assunto = document.getElementById('suporteAssunto').value;
         const mensagem = document.getElementById('suporteMensagem').value;

         if (!assunto) {
             showToast('Selecione um assunto!', 'warning');
             return;
         }
         if (!mensagem.trim()) {
             showToast('Escreva uma mensagem!', 'warning');
             return;
         }

         closeModal('modalSuporte');
         showToast('Mensagem enviada! Resposta em até 24h.', 'success');
         document.getElementById('suporteAssunto').value = '';
         document.getElementById('suporteMensagem').value = '';
     }

     // ===== SAIR =====
     function confirmarSaida() {
         showToast('Encerrando sessão...', 'warning');
         setTimeout(() => {
             closeModal('modalSair');
             document.body.innerHTML = `
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; background: var(--neutral); padding: var(--space-xl);">
                        <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--tertiary), var(--tertiary-light)); display: flex; align-items: center; justify-content: center; margin-bottom: var(--space-lg); color: var(--white);">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                            </svg>
                        </div>
                        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: var(--space-sm);">AquaNexus</h2>
                        <p style="color: var(--text-muted); text-align: center; margin-bottom: var(--space-xl);">Sessão encerrada.<br>Obrigado por usar AquaNexus!</p>
                        <div style="width: 40px; height: 40px; border: 3px solid var(--neutral-dark); border-top-color: var(--tertiary); border-radius: 50%; animation: spin 1s linear infinite;"></div>
                    </div>
                    <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
                `;
         }, 1500);
     }

     // ===== TOAST =====
     let toastTimeout;

     function showToast(message, type = 'success') {
         const toast = document.getElementById('mobileToast');
         const toastMessage = document.getElementById('toastMessage');
         const toastIcon = document.getElementById('toastIcon');

         toastMessage.textContent = message;
         toast.className = 'mobile-toast show ' + type;

         const icons = {
             success: `<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>`,
             error: `<circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/>`,
             warning: `<path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/>`
         };

         toastIcon.innerHTML = icons[type] || icons.success;

         clearTimeout(toastTimeout);
         toastTimeout = setTimeout(() => toast.classList.remove('show'), 3000);
     }

     // ===== INIT =====
     document.addEventListener('DOMContentLoaded', () => {
         showToast(
             'Bem-vindo (a), {{ Auth::guard('cliente')->user()->nome_completo }} ! Suas faturas estão disponíveis.',
             'success');
     });
 </script>
