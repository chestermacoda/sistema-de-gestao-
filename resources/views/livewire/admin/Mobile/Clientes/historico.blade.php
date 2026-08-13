<style>
    /* ═══════════════════════════════════════════════════════════════
   HISTÓRICO DE PAGAMENTOS — APP CLIENTE (Mobile-First)
   AquaNexus Water Utility Management System
   ═══════════════════════════════════════════════════════════════ */

    .cliente-historico-pagamentos {
        padding: var(--space-md);
        background: var(--neutral);
        min-height: 100vh;
    }

    /* ─── Header ─── */
    .hist-header {
        margin-bottom: var(--space-lg);
    }

    .hist-titulo {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--space-md);
    }

    .hist-resumo-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-md);
        margin-bottom: var(--space-md);
    }

    .hist-resumo-item {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: var(--space-md);
        text-align: center;
        border: 1px solid var(--neutral-dark);
    }

    .hist-resumo-valor {
        display: block;
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--primary);
        font-family: var(--font-headline);
        margin-bottom: 2px;
    }

    .hist-resumo-pendente .hist-resumo-valor {
        color: var(--danger);
    }

    .hist-resumo-label {
        font-size: var(--small-size);
        color: var(--text-muted);
    }

    .hist-ultimo-pagamento {
        display: inline-flex;
        /* Alinha bem em qualquer parte do topo ou grid */
        width: 100%;
        max-width: max-content;
        /* Não estica desnecessariamente na tela */
        background-color: rgba(16, 185, 129, 0.08);
        /* Um verde de sucesso translúcido e suave */
        border: 1px solid rgba(16, 185, 129, 0.15);
        /* Borda fina para dar acabamento */
        padding: 8px 14px;
        border-radius: var(--radius-md, 8px);
        margin-bottom: var(--space-md, 16px);
    }

    .hist-pagamento-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .hist-pagamento-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #10b981;
        /* Verde sólido para o círculo do ícone */
        color: #ffffff;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }

    .hist-pagamento-text {
        font-size: var(--small-size, 13px);
        color: #1f2937;
        /* Cor escura neutra para o texto base */
        font-weight: 500;
        line-height: 1.4;
        display: flex;
        flex-wrap: wrap;
        /* Garante que se a tela for pequena (mobile), quebre com elegância */
        align-items: center;
        column-gap: 6px;
        row-gap: 2px;
    }

    .hist-pagamento-text .label {
        color: #4b5563;
        /* Texto secundário ligeiramente cinza */
    }

    .hist-pagamento-text .amount {
        color: #065f46;
        /* Tom verde escuro e profissional para o valor */
        font-weight: 600;
    }

    .hist-pagamento-text .meta {
        color: #6b7280;
        /* Dados de auditoria em cinza muted */
        font-weight: 400;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .hist-pagamento-text .dot {
        color: #d1d5db;
        /* Ponto separador discreto */
        font-weight: bold;
    }

    .hist-pagamento-text .code {
        font-family: monospace;
        /* Código de fatura fica excelente em monospace */
        background-color: rgba(0, 0, 0, 0.04);
        padding: 1px 4px;
        border-radius: 4px;
        font-size: 11px;
    }

    /* ─── Filtros ─── */
    .hist-filtros {
        margin-bottom: var(--space-lg);
    }

    .filtro-grupo {
        display: flex;
        gap: var(--space-sm);
        margin-bottom: var(--space-md);
        overflow-x: auto;
        padding-bottom: var(--space-sm);
        -webkit-overflow-scrolling: touch;
    }

    .filtro-grupo::-webkit-scrollbar {
        display: none;
    }

    .filtro-btn {
        padding: 8px 16px;
        background: var(--white);
        border: 1px solid var(--neutral-dark);
        border-radius: var(--radius-full);
        font-size: var(--small-size);
        font-weight: 600;
        color: var(--text-secondary);
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s;
    }

    .filtro-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .filtro-btn:hover:not(.active) {
        border-color: var(--primary-lighter);
        color: var(--primary);
    }

    .filtro-linha2 {
        display: flex;
        gap: var(--space-sm);
    }

    .filtro-busca {
        position: relative;
        flex: 1;
    }

    .filtro-busca svg {
        position: absolute;
        left: var(--space-md);
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
    }

    .filtro-input {
        width: 100%;
        padding: 12px 16px 12px 40px;
        border: 1px solid var(--neutral-dark);
        border-radius: var(--radius-lg);
        font-size: var(--label-size);
        font-family: var(--font-body);
        background: var(--white);
        transition: all 0.2s;
    }

    .filtro-input:focus {
        outline: none;
        border-color: var(--primary-lighter);
        box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.08);
    }

    .filtro-ordenacao {
        padding: 12px 16px;
        border: 1px solid var(--neutral-dark);
        border-radius: var(--radius-lg);
        font-size: var(--label-size);
        font-family: var(--font-body);
        background: var(--white);
        color: var(--text-primary);
        cursor: pointer;
        min-width: 140px;
    }

    /* ─── Lista de Faturas Contentora ─── */
    .fatura-lista {
        display: flex;
        flex-direction: column;
        gap: var(--space-md, 16px);
        margin-bottom: var(--space-lg, 24px);
    }

    /* ─── Card Principal ─── */
    .fatura-item {
        background: var(--white, #ffffff);
        border-radius: var(--radius-lg, 12px);
        border: 1px solid var(--neutral-dark, #e5e7eb);
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }

    .fatura-item:hover {
        border-color: var(--primary-lighter, #93c5fd);
        box-shadow: var(--shadow-sm, 0 2px 4px rgba(0, 0, 0, 0.05));
        transform: translateY(-1px);
    }

    /* Bordas Laterais de Status */
    .fatura-item-paga {
        border-left: 4px solid var(--success, #10b981);
    }

    .fatura-item-parcial {
        border-left: 4px solid var(--tertiary, #00838f);
    }

    .fatura-item-pendente {
        border-left: 4px solid var(--warning, #f59e0b);
    }

    .fatura-item-vencida {
        border-left: 4px solid var(--danger, #ef4444);
    }

    /* ─── Linha Superior: Mês + Status ─── */
    .fatura-linha-superior {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-md, 16px) var(--space-md, 16px) 8px;
        gap: 12px;
    }

    .fatura-mes-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }

    .fatura-mes {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary, #111827);
        text-transform: capitalize;
    }

    .fatura-status-badge {
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: var(--radius-full, 9999px);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .status-paga {
        background: var(--success-light, rgba(16, 185, 129, 0.12));
        color: var(--success, #10b981);
    }

    .status-parcial {
        background: rgba(0, 131, 143, 0.12);
        color: var(--tertiary, #00838f);
    }

    .status-pendente {
        background: var(--warning-light, rgba(245, 158, 11, 0.12));
        color: var(--warning, #f59e0b);
    }

    .status-vencida {
        background: var(--danger-light, rgba(239, 68, 68, 0.12));
        color: var(--danger, #ef4444);
    }

    .parcelas-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 600;
        color: var(--primary, #003366);
        background: rgba(0, 51, 102, 0.06);
        padding: 4px 10px;
        border-radius: var(--radius-full, 9999px);
        white-space: nowrap;
    }

    /* ─── Linhas de Dados Intermédias ─── */
    .fatura-linha-info,
    .fatura-linha-consumo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 var(--space-md, 16px) 8px;
        font-size: 13px;
        color: var(--text-muted, #6b7280);
    }

    .fatura-codigo {
        font-family: monospace;
        font-weight: 600;
        background: #f3f4f6;
        padding: 1px 6px;
        border-radius: 4px;
    }

    .consumo-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 600;
        color: var(--tertiary, #00838f);
        background: rgba(0, 131, 143, 0.08);
        padding: 2px 8px;
        border-radius: 6px;
    }

    /* ─── Caixa de Progresso (Parciais) ─── */
    .fatura-progresso {
        margin: 4px var(--space-md, 16px) var(--space-md, 16px);
        padding: 10px;
        background: var(--neutral, #f9fafb);
        border-radius: var(--radius-md, 8px);
        border: 1px solid #f3f4f6;
    }

    .fatura-progresso-header {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary, #4b5563);
        margin-bottom: 6px;
    }

    .fatura-progresso-barra-bg {
        width: 100%;
        height: 6px;
        background: #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 6px;
    }

    .fatura-progresso-barra-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--tertiary, #00838f) 0%, var(--success, #10b981) 100%);
        border-radius: 10px;
    }

    .fatura-progresso-valores {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        font-weight: 500;
    }

    .valor-pago {
        color: var(--success, #10b981);
    }

    .valor-resta {
        color: var(--danger, #ef4444);
    }

    /* ─── Linha Inferior de Ações (Layout Vertical no Mobile) ─── */
    .fatura-linha-acoes {
        display: flex;
        flex-direction: column;
        /* Força o valor para cima e os botões para baixo */
        align-items: stretch;
        /* Faz os botões ocuparem a largura total no mobile */
        padding: var(--space-md, 16px);
        border-top: 1px solid var(--neutral-dark, #e5e7eb);
        background: var(--neutral, #f9fafb);
        gap: 14px;
        /* Espaço entre o bloco do valor e o bloco dos botões */
    }

    .fatura-valor-box {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .fatura-valor-label {
        font-size: 11px;
        color: var(--text-muted, #6b7280);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .fatura-valor {
        font-size: 1.4rem;
        /* Um pouco maior para dar mais destaque */
        font-weight: 800;
        color: var(--text-primary, #111827);
    }

    /* Grupo de Botões (Mobile: Um debaixo do outro) */
    .fatura-botoes-grupo {
        display: flex;
        flex-direction: column;
        gap: 8px;
        /* Espaço entre os botões */
        width: 100%;
    }

    /* Ajuste dos botões individuais para Mobile */
    .btn-fatura {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        /* Padding ligeiramente maior para facilitar o toque no telemóvel */
        border: 1px solid transparent;
        border-radius: var(--radius-md, 8px);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        /* Ocupa tudo no mobile */
    }

    .btn-fatura:active {
        transform: scale(0.99);
    }

    /* Cores dos Botões (Mantidas) */
    .btn-fatura-primary {
        background: var(--primary, #003366);
        color: #ffffff;
    }

    .btn-fatura-primary:hover {
        background: #002244;
    }

    .btn-fatura-tertiary {
        background: var(--tertiary, #00838f);
        color: #ffffff;
    }

    .btn-fatura-tertiary:hover {
        background: #00606a;
    }

    .btn-fatura-secondary {
        background: #ffffff;
        border: 1px solid var(--neutral-dark, #d1d5db);
        color: var(--text-secondary, #4b5563);
    }

    .btn-fatura-secondary:hover {
        background: #f3f4f6;
        border-color: var(--primary-lighter, #93c5fd);
        color: var(--primary, #003366);
    }

    /* ─── Responsividade para Telas Maiores (Tablets/Desktop) ─── */


    /* Estado de Lista Vazia */
    .fatura-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 32px 16px;
        text-align: center;
        background: #ffffff;
        border-radius: var(--radius-lg, 12px);
        border: 1px dashed #d1d5db;
    }

    .fatura-empty p {
        font-weight: 600;
        margin: 8px 0 4px;
        color: #374151;
    }

    .fatura-empty span {
        font-size: 13px;
        color: #6b7280;
    }

    /* Desktop Responsive Layout Adjustments */
    @media (min-width: 768px) {
        .fatura-linha-acoes {
            padding: 14px var(--space-md, 16px);
        }

        .btn-fatura {
            padding: 8px 18px;
        }
    }


    /* ─── Animações ─── */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fatura-item {
        animation: fadeInUp 0.3s ease backwards;
    }

    .fatura-item:nth-child(1) {
        animation-delay: 0.05s;
    }

    .fatura-item:nth-child(2) {
        animation-delay: 0.1s;
    }

    .fatura-item:nth-child(3) {
        animation-delay: 0.15s;
    }

    .fatura-item:nth-child(4) {
        animation-delay: 0.2s;
    }

    .fatura-item:nth-child(5) {
        animation-delay: 0.25s;
    }
</style>
<section class="mobile-section" id="section-faturas">
    <div class="cliente-historico-pagamentos" x-data="{ modalParcelas: $wire.entangle('mostrarModalParcelas') }">

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- HEADER COM RESUMO FINANCEIRO -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="hist-header">
            <h2 class="hist-titulo">Meus Pagamentos</h2>
            <div class="hist-resumo-cards">
                <div class="hist-resumo-item">
                    <span class="hist-resumo-valor">MZN
                        {{ number_format($resumo['total_pago'] ?? 0, 2, ',', '.') }}</span>
                    <span class="hist-resumo-label">Total Pago</span>
                </div>
                <div class="hist-resumo-item hist-resumo-pendente">
                    <span class="hist-resumo-valor">MZN
                        {{ number_format($resumo['total_pendente'] ?? 0, 2, ',', '.') }}</span>
                    <span class="hist-resumo-label">Em Aberto</span>
                </div>
            </div>


            @if ($resumo['ultimo_pagamento'])
                <div class="hist-ultimo-pagamento">
                    <div class="hist-pagamento-content">
                        <div class="hist-pagamento-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5" />
                            </svg>
                        </div>
                        <div class="hist-pagamento-text">
                            <span class="label">Último pagamento:</span>
                            <strong class="amount">MZN
                                {{ number_format($resumo['ultimo_pagamento']['valor'], 2, ',', '.') }}</strong>
                            <span class="meta">
                                <span class="dot">•</span>
                                {{ $resumo['ultimo_pagamento']['data'] }}
                                <span class="dot">•</span>
                                <span class="code">{{ $resumo['ultimo_pagamento']['fatura_codigo'] }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- FILTROS E ORDENAÇÃO -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="hist-filtros">
            <div class="filtro-grupo">
                <button class="filtro-btn {{ $filtroStatus === 'todas' ? 'active' : '' }}"
                    wire:click="$set('filtroStatus', 'todas')">
                    Todas
                </button>
                <button class="filtro-btn {{ $filtroStatus === 'paga' ? 'active' : '' }}"
                    wire:click="$set('filtroStatus', 'paga')">
                    Pagas
                </button>
                <button class="filtro-btn {{ $filtroStatus === 'pendente' ? 'active' : '' }}"
                    wire:click="$set('filtroStatus', 'pendente')">
                    Pendentes
                </button>
                <button class="filtro-btn {{ $filtroStatus === 'parcial' ? 'active' : '' }}"
                    wire:click="$set('filtroStatus', 'parcial')">
                    Parciais
                </button>
            </div>
            <div class="filtro-linha2">
                <div class="filtro-busca">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="busca" placeholder="Buscar fatura..."
                        class="filtro-input">
                </div>
                <select wire:model.live="ordenacao" class="filtro-ordenacao">
                    <option value="recente">Mais recente</option>
                    <option value="antiga">Mais antiga</option>
                    <option value="maior_valor">Maior valor</option>
                    <option value="menor_valor">Menor valor</option>
                </select>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- LISTA DE FATURAS COM PAGAMENTOS -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="fatura-lista">
            @forelse($this->faturas as $fatura)
                @php
                    $statusClasse = strtolower($fatura->status);
                    $vencimento = \Carbon\Carbon::parse($fatura->data_vencimento);
                    $periodoFim = \Carbon\Carbon::parse($fatura->periodo_fim);
                    $totalPago = $fatura->pagamentos->sum('valor_pago');

                    $saldoRestante = (float) $fatura->valor_total - $totalPago;
                    $temParcelas = $fatura->pagamentos_count > 1;
                @endphp

                <div class="fatura-item fatura-item-{{ $statusClasse }}">

                    <div class="fatura-linha-superior">
                        <div class="fatura-mes-badge">
                            <span class="fatura-mes">{{ $periodoFim->translatedFormat('F/Y') }}</span>
                            <span class="fatura-status-badge status-{{ $statusClasse }}">
                                {{ $this->getStatusLabel($fatura->status) }}
                            </span>
                        </div>
                        @if ($temParcelas)
                            <span class="parcelas-badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <rect width="20" height="14" x="2" y="5" rx="2" />
                                    <line x1="2" x2="22" y1="10" y2="10" />
                                </svg>
                                {{ $fatura->pagamentos_count }} parcelas
                            </span>
                        @endif
                    </div>

                    <div class="fatura-linha-info">
                        <span class="fatura-codigo">{{ $fatura->codigo_fatura }}</span>
                        <span class="fatura-vencimento">Venc: {{ $vencimento->format('d/m/Y') }}</span>
                    </div>

                    <div class="fatura-linha-consumo">
                        <span class="consumo-tag">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                            </svg>
                            {{ number_format($fatura->consumo_m3 ?? 0, 0, ',', '.') }} m³
                        </span>
                    </div>

                    @if ($statusClasse === 'parcial')
                        <div class="fatura-progresso">
                            <div class="fatura-progresso-header">
                                <span>{{ $fatura->pagamentos_count }}
                                    {{ $fatura->pagamentos_count == 1 ? 'pagamento' : 'parcelas' }}</span>
                                <span
                                    class="progresso-pct">{{ round(($totalPago / $fatura->valor_total) * 100, 1) }}%</span>
                            </div>
                            <div class="fatura-progresso-barra-bg">
                                <div class="fatura-progresso-barra-fill"
                                    style="width: {{ min(($totalPago / $fatura->valor_total) * 100, 100) }}%;"></div>
                            </div>
                            <div class="fatura-progresso-valores">
                                <span class="valor-pago">Pago: MZN {{ number_format($totalPago, 2, ',', '.') }}</span>
                                @if ($saldoRestante > 0)
                                    <span class="valor-resta">Resta: MZN
                                        {{ number_format($saldoRestante, 2, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="fatura-linha-acoes">
                        <div class="fatura-valor-box">
                            <span class="fatura-valor-label">Valor Total</span>
                            <span class="fatura-valor">MZN
                                {{ number_format($fatura->valor_consumo, 2, ',', '.') }}</span>
                        </div>

                        <div class="fatura-botoes-grupo">
                            @if ($statusClasse === 'pendente' || $statusClasse === 'vencida')
                                <button class="btn-fatura btn-fatura-primary" onclick="openPagamento()">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect width="20" height="14" x="2" y="5" rx="2" />
                                        <line x1="2" x2="22" y1="10" y2="10" />
                                    </svg>
                                    Efetuar Pagamento
                                </button>
                            @elseif($statusClasse === 'parcial')
                                <button class="btn-fatura btn-fatura-tertiary" onclick="openPagamento()">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect width="20" height="14" x="2" y="5" rx="2" />
                                        <line x1="2" x2="22" y1="10" y2="10" />
                                    </svg>
                                    Pagar Restante
                                </button>
                            @endif

                            {{-- {{ dd($fatura->pagamentos) }} --}}
                            @foreach ($fatura->pagamentos as $pagamento)
                                <button class="btn-fatura btn-fatura-secondary"
                                    onclick="downloadFile({{ $pagamento->id }})">

                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" y1="15" x2="12" y2="3" />
                                    </svg>
                                    Baixar Fatura
                                </button>
                            @endforeach

                        </div>
                    </div>

                </div>
            @empty
                <div class="fatura-empty">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="var(--text-muted, #6b7280)" stroke-width="1.5">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <line x1="2" x2="22" y1="10" y2="10" />
                    </svg>
                    <p>Nenhuma fatura encontrada</p>
                    <span>Tente ajustar os filtros ou buscar por outro termo.</span>
                </div>
            @endforelse
        </div>

        <!-- Paginação -->
        <div class="fatura-paginacao">
            {{ $this->faturas->links() }}
        </div>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- MODAL DE PARCELAS (Bottom Sheet) -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <div class="modal-overlay" x-show="modalParcelas" x-transition.opacity style="display: none;"
            id="modal-parcelas" wire:ignore.self>
            <div class="modal modal-bottom-sheet" x-show="modalParcelas"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full"
                x-transition:enter-end="translate-y-0" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full">

                @if ($faturaSelecionada)
                    <div class="modal-header">
                        <div>
                            <h3 class="modal-title">{{ $faturaSelecionada['codigo'] }}</h3>
                            <p class="modal-subtitle">{{ $faturaSelecionada['mes_ano'] }} —
                                {{ $faturaSelecionada['quantidade_parcelas'] }} parcelas</p>
                        </div>
                        <button type="button" class="modal-close" wire:click="fecharModalParcelas"
                            x-on:click="modalParcelas = false">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="modal-body" style="padding: 0;">
                        <!-- Resumo da fatura -->
                        <div class="parcela-resumo">
                            <div class="parcela-resumo-item">
                                <span>Valor Total</span>
                                <span>MZN {{ number_format($faturaSelecionada['valor_total'], 2, ',', '.') }}</span>
                            </div>
                            <div class="parcela-resumo-item">
                                <span>Total Pago</span>
                                <span class="valor-positivo">MZN
                                    {{ number_format($faturaSelecionada['total_pago'], 2, ',', '.') }}</span>
                            </div>
                            @if ($faturaSelecionada['saldo_restante'] > 0)
                                <div class="parcela-resumo-item">
                                    <span>Saldo Restante</span>
                                    <span class="valor-negativo">MZN
                                        {{ number_format($faturaSelecionada['saldo_restante'], 2, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="parcela-resumo-progresso">
                                <div class="parcela-progresso-barra-bg">
                                    <div class="parcela-progresso-barra-fill"
                                        style="width: {{ min(($faturaSelecionada['total_pago'] / $faturaSelecionada['valor_total']) * 100, 100) }}%;">
                                    </div>
                                </div>
                                <span>{{ round(($faturaSelecionada['total_pago'] / $faturaSelecionada['valor_total']) * 100, 1) }}%
                                    quitado</span>
                            </div>
                        </div>

                        <!-- Lista de parcelas -->
                        <div class="parcelas-lista">
                            <h5>Histórico de Pagamentos</h5>
                            @foreach ($faturaSelecionada['parcelas'] as $index => $parcela)
                                <div class="parcela-item">
                                    <div class="parcela-numero">#{{ $index + 1 }}</div>
                                    <div class="parcela-info">
                                        <div class="parcela-valor">MZN
                                            {{ number_format($parcela['valor'], 2, ',', '.') }}
                                        </div>
                                        <div class="parcela-meta">
                                            <span>{{ $parcela['data'] }}
                                                {{ $parcela['hora'] !== '—' ? 'às ' . $parcela['hora'] : '' }}</span>
                                            <span class="parcela-metodo">{{ $parcela['metodo'] }}</span>
                                        </div>
                                        @if ($parcela['comprovante'])
                                            <div class="parcela-comprovante">
                                                Comprovante: {{ $parcela['comprovante'] }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="parcela-status">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="#059669" stroke-width="2.5">
                                            <path d="M20 6 9 17l-5-5" />
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer" style="flex-direction: column; gap: var(--space-sm);">
                        @if ($faturaSelecionada['saldo_restante'] > 0)
                            <button type="button" class="btn btn-primary" style="width: 100%;"
                                wire:click="pagarFatura({{ $faturaSelecionada['id'] }})">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <rect width="20" height="14" x="2" y="5" rx="2" />
                                    <line x1="2" x2="22" y1="10" y2="10" />
                                </svg>
                                Pagar Saldo Restante (MZN
                                {{ number_format($faturaSelecionada['saldo_restante'], 2, ',', '.') }})
                            </button>
                        @endif
                        <button type="button" class="btn btn-outline" style="width: 100%;"
                            wire:click="baixarFatura({{ $faturaSelecionada['id'] }})">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            Baixar Fatura PDF
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
