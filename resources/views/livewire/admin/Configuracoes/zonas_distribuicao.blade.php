<div class="cfg-card">
    <div class="cfg-card-header">
        <div class="cfg-card-icon cfg-icon-green">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" x2="12" y1="2" y2="22" />
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
            </svg>
        </div>
        <div>
            <h3 class="cfg-card-title">Zonas de Distribuição</h3>
            <p class="cfg-card-desc">-</p>
        </div>
    </div>
    <div class="cfg-card-body">
        <div class="cfg-tarifa-table">
            <div class="cfg-tarifa-row">
                <button class="cfg-btn-icon" onclick="openModal('modal-zona_distribuicao')" title="Adicionar Zona">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                </button>
            </div>
            <div class="cfg-tarifa-header">
                <span>Nome Zona</span>
                <span>Status</span>
       
                <span>Ações</span>
            </div>

            @if ($zona)
                @foreach ($zona as $z)
                    <div class="cfg-tarifa-row">
                        <span class="cfg-tarifa-cat">{{ $z->nome }}</span>
                        <span class="cfg-tarifa-val">{{ $z->status }}</span>
                        <button type="button" class="cfg-btn-icon" wire:click='editZona({{ $z->id }})'
                            onclick="openModal('modal-zona_distribuicao')" title="Editar">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            @endif
            
            
        </div>
   
    </div>
</div>
