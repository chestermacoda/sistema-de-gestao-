<div class="modal-overlay" id="modal-ver-leitura" wire:ignore.self>
    <div class="modal modal-lg" style="max-width: 900px;">
        <div class="modal-header">
            <div style="display: flex; align-items: center; gap: var(--space-md);">
                <div
                    style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: white;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" x2="8" y1="13" y2="13" />
                        <line x1="16" x2="8" y1="17" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </div>
                <div>
                    <h3 class="modal-title">
                        @if ($data['leitura']['mes_referencia'] ?? false)
                            Leitura {{ $data['leitura']['mes_referencia'] }}
                        @else
                            Detalhes da Leitura
                        @endif
                    </h3>
                    <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                        {{ $data['medidor']['identificacao']['hidrometro'] ?? 'N/A' }} —
                        {{ $data['cliente']['nome_completo'] ?? 'Cliente não encontrado' }}
                    </p>
                </div>
            </div>
            <div style="display: flex; gap: var(--space-sm); align-items: center;">
                @if (($data['leitura']['status'] ?? '') === 'Normal')
                    <span class="leit-status-badge leit-ok">● OK</span>
                @elseif(($data['leitura']['status'] ?? '') === 'Anomalia')
                    <span class="leit-status-badge leit-anomalia">● Anomalia</span>
                @elseif(($data['leitura']['status'] ?? '') === 'Revisar')
                    <span class="leit-status-badge leit-revisar">● Revisar</span>
                @elseif(($data['leitura']['status'] ?? '') === 'Editada')
                    <span class="leit-status-badge leit-editada">● Editada</span>
                @else
                    <span class="leit-status-badge leit-ok">● OK</span>
                @endif
                <button class="modal-close" onclick="closeModal('modal-ver-leitura')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="modal-body">
            <!-- Card de Consumo do Mês -->
            <div
                style="text-align:center;padding:1.5rem;background:var(--neutral);border-radius:12px;margin-bottom:1.5rem;">
                <div style="font-size:0.875rem;color:var(--text-secondary);">Consumo do Mês</div>
                <div style="font-size:2rem;font-weight:700;color:var(--primary);">
                    {{ $data['leitura']['consumo'] ?? '0' }} m³
                </div>
                <div style="margin-top:0.5rem;">
                    @php
                        $consumo = (float) ($data['leitura']['consumo'] ?? 0);
                        $media = (float) ($data['leitura']['consumo_medio'] ?? 0);
                    @endphp
                    @if ($media > 0 && $consumo <= $media * 1.2)
                        <span class="badge badge-success">Dentro da média</span>
                    @elseif($media > 0 && $consumo > $media * 1.5)
                        <span class="badge badge-danger">Consumo elevado</span>
                    @elseif($media > 0)
                        <span class="badge badge-warning">Acima da média</span>
                    @else
                        <span class="badge badge-secondary">Sem média definida</span>
                    @endif
                </div>
            </div>

            <!-- Comparativo de Leituras -->
            <div class="leit-comparativo" style="margin-bottom: var(--space-lg);">
                <div class="leit-comparativo-item">
                    <div class="leit-comparativo-label">Leitura Anterior</div>
                    <div class="leit-comparativo-valor">
                        {{ number_format($data['leitura']['leitura_anterior'] ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="leit-comparativo-variacao">
                        @if (isset($data['historicoConsumo']) && count($data['historicoConsumo']) > 0)
                            {{-- @if (count($historicoConsumo) > 1) --}}

                            {{-- {{ $historicoConsumo[count($historicoConsumo) - 2]['mes_completo'] ?? 'Mês anterior' }} --}}
                            {{ $data['historicoConsumo'][count($data['historicoConsumo']) - 2]['mes_completo'] ?? 'Mês anterior' }}
                        @else
                            Mês anterior
                        @endif
                    </div>
                </div>
                <div class="leit-comparativo-item">
                    <div class="leit-comparativo-label">Leitura Atual</div>
                    <div class="leit-comparativo-valor" style="color: var(--primary);">
                        {{ number_format($data['leitura']['leitura_atual'] ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="leit-comparativo-variacao positiva">
                        {{ $data['leitura']['mes_referencia'] ?? 'Mês atual' }}
                    </div>
                </div>
                <div class="leit-comparativo-item">
                    <div class="leit-comparativo-label">Consumo Médio</div>
                    <div class="leit-comparativo-valor">
                        {{ number_format($data['leitura']['consumo_medio'] ?? 0, 0, ',', '.') }} m³
                    </div>
                    <div class="leit-comparativo-variacao">Últimos 12 meses</div>
                </div>
            </div>

            <!-- Grid de Detalhes -->
            <div class="leit-detail-grid">
                <!-- Dados da Leitura -->
                <div class="leit-detail-section">
                    <h4>Dados da Leitura</h4>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Mês Referência</span>
                        <span class="leit-detail-value">{{ $data['leitura']['mes_referencia'] ?? 'N/A' }}</span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Leitura Anterior</span>
                        <span class="leit-detail-value" style="font-family: monospace;">
                            {{ number_format($data['leitura']['leitura_anterior'] ?? 0, 0, ',', '.') }} m³
                        </span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Leitura Atual</span>
                        <span class="leit-detail-value"
                            style="font-family: monospace; font-weight: 700; color: var(--primary);">
                            {{ number_format($data['leitura']['leitura_atual'] ?? 0, 0, ',', '.') }} m³
                        </span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Consumo</span>
                        <span class="leit-detail-value" style="font-weight: 700;">
                            {{ $data['leitura']['consumo'] ?? '0' }} m³
                        </span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Data da Leitura</span>
                        <span class="leit-detail-value">{{ $data['leitura']['data_leitura'] ?? 'N/A' }}</span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Hora da Leitura</span>
                        <span class="leit-detail-value">{{ $data['leitura']['hora_leitura'] ?? 'N/A' }}</span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Leiturista</span>
                        <span class="leit-detail-value">
                            {{ $data['leiturista']['nome'] ?? 'N/A' }} —
                            {{ $data['leiturista']['zona'] ?? 'N/A' }}
                        </span>
                    </div>
                    @if ($data['leitura']['origem'] ?? false)
                        <div class="leit-detail-row">
                            <span class="leit-detail-label">Origem</span>
                            <span class="leit-detail-value">
                                <span class="badge badge-info">{{ $data['leitura']['origem'] }}</span>
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Cliente & Medidor -->
                <div class="leit-detail-section">
                    <h4>Cliente & Medidor</h4>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Cliente</span>
                        <span class="leit-detail-value">{{ $data['cliente']['nome_completo'] ?? 'N/A' }}</span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Matrícula</span>
                        <span class="leit-detail-value" style="font-family: monospace;">
                            {{ $data['cliente']['numero_matricula'] ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Hidrômetro</span>
                        <span class="leit-detail-value" style="font-family: monospace;">
                            {{ $data['medidor']['identificacao']['hidrometro'] ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Marca / Modelo</span>
                        <span class="leit-detail-value">
                            {{ $data['medidor']['especificacoes']['marca'] ?? 'N/A' }} /
                            {{ $data['medidor']['especificacoes']['modelo'] ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Diâmetro</span>
                        <span
                            class="leit-detail-value">{{ $data['medidor']['especificacoes']['vazao'] ?? 'N/A' }}</span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Endereço</span>
                        <span class="leit-detail-value">
                            {{ ($data['cliente']['endereco'] ?? '') . ', ' . ($data['cliente']['bairro'] ?? '') . ', ' . ($data['cliente']['cidade'] ?? '') }}
                        </span>
                    </div>
                    <div class="leit-detail-row">
                        <span class="leit-detail-label">Status do Cliente</span>
                        <span class="leit-detail-value">
                            @php
                                $statusCliente = $data['cliente']['status'] ?? 'Ativo';
                                $badgeClass = match ($statusCliente) {
                                    'Ativo' => 'badge-success',
                                    'Inadimplente' => 'badge-warning',
                                    'Cortada' => 'badge-danger',
                                    'Desativado' => 'badge-secondary',
                                    default => 'badge-success',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $statusCliente }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Dados da Instalação (se existir) -->
            @if ($data['instalacao'] ?? false)
                <div class="leit-detail-grid" style="margin-top: var(--space-lg);">
                    <div class="leit-detail-section">
                        <h4>Dados da Instalação</h4>
                        <div class="leit-detail-row">
                            <span class="leit-detail-label">Data Instalação</span>
                            <span class="leit-detail-value">{{ $data['instalacao']['data_inicio'] ?? 'N/A' }}</span>
                        </div>
                        <div class="leit-detail-row">
                            <span class="leit-detail-label">Leitura Inicial</span>
                            <span class="leit-detail-value" style="font-family: monospace;">
                                {{ number_format($data['instalacao']['leitura_base'] ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="leit-detail-row">
                            <span class="leit-detail-label">Local</span>
                            <span class="leit-detail-value">{{ $data['instalacao']['local'] ?? 'N/A' }}</span>
                        </div>
                        <div class="leit-detail-row">
                            <span class="leit-detail-label">Nº Lacre</span>
                            <span class="leit-detail-value" style="font-family: monospace;">
                                {{ $data['instalacao']['lacre'] ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Anomalias (se houver) -->
            @if ($data['leitura']['tem_anomalia'] ?? false)
                <div
                    style="margin-top: var(--space-lg); padding: 1rem; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                    <div style="font-weight: 600; color: #856404; margin-bottom: 0.5rem;">
                        ⚠️ Anomalia Detectada: {{ $data['leitura']['tipo_anomalia'] ?? 'Não especificada' }}
                    </div>
                    <div style="color: #856404; font-size: 0.875rem;">
                        {{ $data['leitura']['descricao_anomalia'] ?? 'Sem descrição detalhada.' }}
                    </div>
                </div>
            @endif

            <!-- Histórico Gráfico -->
            @if (isset($data['historicoConsumo']) && count($data['historicoConsumo']) > 0)



                <div style="margin-top: var(--space-lg);">
                    <div
                        style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-md);">
                        Histórico de Consumo (Últimos {{ count($data['historicoConsumo']) }} Meses)
                    </div>
                    <div class="leit-grafico-container">
                        @php
                            $maxConsumo = max(array_column($data['historicoConsumo'], 'consumo')) ?: 1;
                        @endphp
                        @foreach ($data['historicoConsumo'] as $item)
                            @php
                                $altura = $maxConsumo > 0 ? ($item['consumo'] / $maxConsumo) * 100 : 0;
                                $altura = max($altura, 5); // Mínimo 5% para visualização
                            @endphp
                            <div class="leit-grafico-bar" style="height: {{ $altura }}%;">
                                <div class="leit-grafico-valor">{{ number_format($item['consumo'], 0) }}</div>
                                <div class="leit-grafico-label">{{ $item['mes'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endif
            <!-- Timeline -->
            @if (isset($data['timeline']) && count($data['timeline']) > 0)
                <div style="margin-top: var(--space-lg);">
                    <div
                        style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-md);">
                        Timeline da Leitura
                    </div>
                    <div class="leit-timeline">
                        @foreach ($data['timeline'] as $evento)
                            <div class="leit-timeline-item {{ $evento['status_class'] }}">
                                <div class="leit-timeline-title">{{ $evento['titulo'] }}</div>
                                <div class="leit-timeline-desc">{{ $evento['descricao'] }}</div>
                                <div class="leit-timeline-date">{{ $evento['data'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endif
        </div>

        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('modal-ver-leitura')">Fechar</button>
            <button class="btn btn-secondary"
                onclick="closeModal('modal-ver-leitura'); openModal('modal-editar-leitura')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="margin-right: 6px;">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                </svg>
                Editar Leitura
            </button>
            <button class="btn btn-primary" wire:click="gerarFatura" wire:loading.attr="disabled">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" style="margin-right: 6px;">
                    <rect width="20" height="14" x="2" y="5" rx="2" />
                    <line x1="2" x2="22" y1="10" y2="10" />
                </svg>
                <span wire:loading.remove wire:target="gerarFatura">Gerar Fatura</span>
                <span wire:loading wire:target="gerarFatura">Gerando...</span>
            </button>
        </div>
    </div>
</div>
