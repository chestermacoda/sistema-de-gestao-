<div class="cfg-card">
    <div class="cfg-card-header">
        <div class="cfg-card-icon cfg-icon-purple">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
            </svg>
        </div>
        <div>
            <h3 class="cfg-card-title">Notificações</h3>
            <p class="cfg-card-desc">Canais e eventos de alerta</p>
        </div>
    </div>
    <div class="cfg-card-body">
        <div class="cfg-toggle-list">
            <div class="cfg-toggle-item">
                <div class="cfg-toggle-info">
                    <span class="cfg-toggle-title">E-mail de Vencimento</span>
                    <span class="cfg-toggle-desc">Enviar lembrete 3 dias antes do
                        vencimento</span>
                </div>
                <label class="cfg-toggle">
                    <input type="checkbox" wire:model="email_vencimento">
                    <span class="cfg-toggle-slider"></span>
                </label>
            </div>
            <div class="cfg-toggle-item">
                <div class="cfg-toggle-info">
                    <span class="cfg-toggle-title">SMS de Atraso</span>
                    <span class="cfg-toggle-desc">Alertar cliente após 5 dias de atraso</span>
                </div>
                <label class="cfg-toggle">
                    <input type="checkbox" wire:model="sms_atraso">
                    <span class="cfg-toggle-slider"></span>
                </label>
            </div>
            <div class="cfg-toggle-item">
                <div class="cfg-toggle-info">
                    <span class="cfg-toggle-title">Consumo Anômalo</span>
                    <span class="cfg-toggle-desc">Alertar quando consumo ultrapassar 150% da
                        média</span>
                </div>
                <label class="cfg-toggle">
                    <input type="checkbox" wire:model="consumo_anomalo">
                    <span class="cfg-toggle-slider"></span>
                </label>
            </div>
            <div class="cfg-toggle-item">
                <div class="cfg-toggle-info">
                    <span class="cfg-toggle-title">Novo Cadastro</span>
                    <span class="cfg-toggle-desc">Notificar administradores sobre novos
                        clientes</span>
                </div>
                <label class="cfg-toggle">
                    <input type="checkbox" wire:model="novo_cadastro">
                    <span class="cfg-toggle-slider"></span>
                </label>
            </div>
            <div class="cfg-toggle-item">
                <div class="cfg-toggle-info">
                    <span class="cfg-toggle-title">Relatório Semanal</span>
                    <span class="cfg-toggle-desc">Envio automático de resumo toda
                        segunda-feira</span>
                </div>
                <label class="cfg-toggle">
                    <input type="checkbox" wire:model="relatorio_semanal">
                    <span class="cfg-toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>
</div>
