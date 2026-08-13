<div class="cfg-card">
    <div class="cfg-card-header">
        <div class="cfg-card-icon cfg-icon-green">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" x2="12" y1="2" y2="22" />
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
            </svg>
        </div>
        <div>
            <h3 class="cfg-card-title">Tarifas e Tributos</h3>
            <p class="cfg-card-desc">Valores e regras de cobrança</p>
        </div>
    </div>
    <div class="cfg-card-body">
        <div class="cfg-tarifa-table">
            <div class="cfg-tarifa-header">
                <span>Categoria</span>
                <span>Valor/m³</span>
                <span>Taxa Mínima</span>
                <span>Ações</span>
            </div>

            @if ($tarifass)
                @foreach ($tarifass as $tar)
                    <div class="cfg-tarifa-row">
                        <span class="cfg-tarifa-cat">{{ $tar->categoria }}</span>
                        <span class="cfg-tarifa-val">MT {{ $tar->valor_m3 }}</span>
                        <span class="cfg-tarifa-val">MT {{ $tar->taxa_minima }}</span>
                        <button type="button" class="cfg-btn-icon" wire:click='editTarifas({{ $tar->id }})'
                            onclick="openModal('modal-tarifa')" title="Editar">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            @endif
            {{-- <div class="cfg-tarifa-row">
                <span class="cfg-tarifa-cat">Industrial</span>
                <span class="cfg-tarifa-val">R$ 7,80</span>
                <span class="cfg-tarifa-val">R$ 120,00</span>
                <button class="cfg-btn-icon" onclick="openModal('modal-tarifa')" title="Editar">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                    </svg>
                </button>
            </div>
            <div class="cfg-tarifa-row">
                <span class="cfg-tarifa-cat">Pública</span>
                <span class="cfg-tarifa-val">R$ 2,10</span>
                <span class="cfg-tarifa-val">R$ 15,00</span>
                <button class="cfg-btn-icon" onclick="openModal('modal-tarifa')" title="Editar">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                    </svg>
                </button>
            </div> --}}
        </div>
        <div class="cfg-form-row" style="margin-top: var(--space-md);">
            <div class="cfg-form-group">
                <label class="cfg-label">Multa por Atraso (%)</label>
                <input type="number" class="cfg-input" value="2.00" step="0.01" wire:model="multa_atraso">
            </div>
            <div class="cfg-form-group">
                <label class="cfg-label">Juros ao Mês (%)</label>
                <input type="number" class="cfg-input" value="1.00" step="0.01" wire:model="juros_mes">
            </div>
            <div class="cfg-form-group">
                <label class="cfg-label">Dias de Tolerância</label>
                <input type="number" class="cfg-input" value="5" wire:model="dias_tolerancia">
            </div>
            <div class="cfg-form-group">
                <label class="cfg-label">Dias de Geração Fatura</label>
                <input type="number" class="cfg-input" wire:model="dias_geracao">
            </div>
        </div>
    </div>
</div>
