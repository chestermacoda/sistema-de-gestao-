<div class="stats-grid" style="margin-bottom: var(--space-xl);">
    <!-- Total de Clientes -->
    <div class="stat-card">
        <div class="stat-icon primary">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->totalClientes, 0, ',', '.') }}</div>
            <div class="stat-label">Total de Clientes</div>
            <div class="stat-change {{ $this->clientesNesteMes > 0 ? 'positive' : 'neutral' }}">
                @if ($this->clientesNesteMes > 0)
                    +{{ number_format($this->clientesNesteMes, 0, ',', '.') }} novos este mês
                @else
                    Nenhum novo este mês
                @endif
            </div>
        </div>
    </div>

    <!-- Ligações Ativas -->
    <div class="stat-card">
        <div class="stat-icon success">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->ligacoesAtivas, 0, ',', '.') }}</div>
            <div class="stat-label">Ligações Ativas</div>
            <div class="stat-change positive">
                {{ $this->percentualLigacoesAtivas }}% do total
            </div>
        </div>
    </div>

    <!-- Inadimplentes -->
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
            <div class="stat-value">{{ number_format($this->inadimplentes, 0, ',', '.') }}</div>
            <div class="stat-label">Inadimplentes</div>
            <div class="stat-change {{ $this->percentualInadimplentes > 10 ? 'negative' : 'warning' }}">
                {{ $this->percentualInadimplentes }}% do total
            </div>
        </div>
    </div>

    <!-- Consumo Médio -->
    <div class="stat-card">
        <div class="stat-icon tertiary">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->consumoMedioMes, 1, ',', '.') }}m³</div>
            <div class="stat-label">Consumo Médio/Mês</div>
            <div class="stat-change {{ $this->variacaoConsumo >= 0 ? 'positive' : 'negative' }}">
                @if ($this->variacaoConsumo > 0)
                    +{{ number_format($this->variacaoConsumo, 1, ',', '.') }}% vs mês anterior
                @elseif($this->variacaoConsumo < 0)
                    {{ number_format($this->variacaoConsumo, 1, ',', '.') }}% vs mês anterior
                @else
                    Sem variação
                @endif
            </div>
        </div>
    </div>

    <!-- Cortes no Mês (Card Extra Útil) -->
    <div class="stat-card">
        <div class="stat-icon danger">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M18.36 6.64a9 9 0 1 1-12.73 0" />
                <line x1="12" y1="2" x2="12" y2="12" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->cortesMes, 0, ',', '.') }}</div>
            <div class="stat-label">Cortes no Mês</div>
            <div class="stat-change negative">
                Ligações suspensas
            </div>
        </div>
    </div>

    <!-- Leituras Pendentes (Card Extra Útil) -->
    <div class="stat-card">
        <div class="stat-icon info">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
                <polyline points="10 9 9 9 8 9" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->leiturasPendentes, 0, ',', '.') }}</div>
            <div class="stat-label">Leituras Pendentes</div>
            <div class="stat-change warning">
                Mês atual
            </div>
        </div>
    </div>

</div>
