<div class="cfg-card">
    <div class="cfg-card-header">
        <div class="cfg-card-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
        </div>
        <div>
            <h3 class="cfg-card-title">Dados da Empresa</h3>
            <p class="cfg-card-desc">Informações cadastrais e de contato</p>
        </div>
    </div>
    <div class="cfg-card-body">
        <div class="cfg-form-row">
            <div class="cfg-form-group">
                <label class="cfg-label">Razão Social</label>
                <input type="text" class="cfg-input" value="AquaNexus Saneamento S.A." wire:model="razao_social">
            </div>
            <div class="cfg-form-group">
                <label class="cfg-label">Nome Fantasia</label>
                <input type="text" class="cfg-input" value="AquaNexus" wire:model="nome_fantasia">
            </div>
        </div>
        <div class="cfg-form-row">
            <div class="cfg-form-group">
                <label class="cfg-label">CNPJ</label>
                <input type="text" class="cfg-input" value="12.345.678/0001-90" wire:model="cnpj">
            </div>
            <div class="cfg-form-group">
                <label class="cfg-label">Inscrição Estadual</label>
                <input type="text" class="cfg-input" value="123.456.789.012" wire:model="inscricao_estadual">
            </div>
        </div>
        <div class="cfg-form-row">
            <div class="cfg-form-group">
                <label class="cfg-label">E-mail Institucional</label>
                <input type="email" class="cfg-input" value="contato@aquanexus.com.br" wire:model="email">
            </div>
            <div class="cfg-form-group">
                <label class="cfg-label">Telefone</label>
                <input type="tel" class="cfg-input" value="(11) 3000-0000" wire:model="telefone">
            </div>
        </div>
        <div class="cfg-form-group">
            <label class="cfg-label">Endereço Completo</label>
            <input type="text" class="cfg-input" value="Av. das Águas, 1000 - Centro, São Paulo - SP, 01000-000"
                wire:model="endereco_completo">
        </div>
        <div class="cfg-logo-area">
            {{-- <div class="cfg-logo-preview"> --}}
            {{-- <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--primary)"
                    stroke-width="2">
                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                </svg> --}}
            @if ($logo_atual)
                <img src="{{ asset('storage/' . $logo_atual) }}" class="cfg-logo-preview" width="120">
            @endif
            {{-- </div> --}}
            <div class="cfg-logo-actions">
                <span class="cfg-logo-name">logo-aquanexus.png</span>
                {{-- <span class="cfg-logo-size">12 KB • SVG</span> --}}
                {{-- onclick="openModal('modal-logo')" --}}
                <button type="button" class="cfg-btn-text" wire:click='editarLogo'>Alterar
                    Logo</button>
            </div>
        </div>
    </div>
</div>
