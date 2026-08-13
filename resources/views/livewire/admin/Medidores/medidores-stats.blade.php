<div class="stats-grid" style="margin-bottom: var(--space-xl);">

    <!-- Total de Medidores -->
    <div class="stat-card">
        <div class="stat-icon primary">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 6v6l4 2" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->totalMedidores, 0, ',', '.') }}</div>
            <div class="stat-label">Total de Medidores</div>
            <div class="stat-change {{ $this->medidoresNesteMes > 0 ? 'positive' : 'neutral' }}">
                @if ($this->medidoresNesteMes > 0)
                    +{{ number_format($this->medidoresNesteMes, 0, ',', '.') }} este mês
                @else
                    Sem novos este mês
                @endif
            </div>
        </div>
    </div>

    <!-- Em Operação -->
    <div class="stat-card">
        <div class="stat-icon success">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->emOperacao, 0, ',', '.') }}</div>
            <div class="stat-label">Em Operação</div>
            <div class="stat-change positive">
                {{ $this->percentualEmOperacao }}% do total
            </div>
        </div>
    </div>

    <!-- Em Manutenção -->
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
            <div class="stat-value">{{ number_format($this->emManutencao, 0, ',', '.') }}</div>
            <div class="stat-label">Em Manutenção</div>
            <div class="stat-change {{ $this->percentualManutencao > 5 ? 'negative' : 'warning' }}">
                {{ $this->percentualManutencao }}% do total
            </div>
        </div>
    </div>

    <!-- Em Estoque -->
    <div class="stat-card">
        <div class="stat-icon tertiary">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path
                    d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                <path d="m3.3 7 8.7 5 8.7-5" />
                <path d="M12 22V12" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->emEstoque, 0, ',', '.') }}</div>
            <div class="stat-label">Em Estoque</div>
            <div class="stat-change positive">
                Disponíveis para instalação
            </div>
        </div>
    </div>

    <!-- Descartados/Danificados -->
    <div class="stat-card">
        <div class="stat-icon danger">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path d="M3 6h18" />
                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->medidoresDescartados, 0, ',', '.') }}</div>
            <div class="stat-label">Descartados</div>
            <div class="stat-change negative">
                Fora de uso
            </div>
        </div>
    </div>

    <!-- Calibração Vencendo -->
    <div class="stat-card">
        <div class="stat-icon info">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->vencendoCalibracao, 0, ',', '.') }}</div>
            <div class="stat-label">Calibração Vencendo</div>
            <div class="stat-change {{ $this->vencendoCalibracao > 0 ? 'warning' : 'positive' }}">
                @if ($this->vencendoCalibracao > 0)
                    Próximos 30 dias
                @else
                    Todos em dia
                @endif
            </div>
        </div>
    </div>

    <!-- Descartados/Danificados -->
    <div class="stat-card">
        <div class="stat-icon danger">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <circle cx="6" cy="6" r="3" />
                <circle cx="6" cy="18" r="3" />
                <line x1="20" y1="4" x2="8.12" y2="15.88" />
                <line x1="14.47" y1="14.48" x2="20" y2="20" />
                <line x1="8.12" y1="8.12" x2="12" y2="12" />
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ number_format($this->medidoresCorte, 0, ',', '.') }}</div>
            <div class="stat-label">Ligação Cortada</div>
            <div class="stat-change negative">
                Fora de uso
            </div>
        </div>
    </div>
</div>
