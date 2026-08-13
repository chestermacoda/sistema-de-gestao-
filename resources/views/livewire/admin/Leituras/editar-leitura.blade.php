<div>
    <div class="modal-overlay" id="modal-editar-leitura" wire:ignore.self>
        <form wire:submit.prevent="update" class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--warning); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Editar Leitura</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                            {{ $mes_referencia ?: 'Referência não definida' }}
                        </p>
                    </div>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('modal-editar-leitura')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <!-- Alerta de atenção -->
                <div class="leit-anomalia-alert" style="margin-bottom: var(--space-lg);">
                    <div style="display: flex; align-items: flex-start; gap: var(--space-md);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--danger)"
                            stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                        <div>
                            <div class="leit-anomalia-alert-title">Atenção: Edição de Leitura</div>
                            <div class="leit-anomalia-alert-desc">
                                A alteração irá recalcular o consumo e pode afetar a fatura já gerada.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dados atuais -->
                <div
                    style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-bottom: var(--space-lg);">
                    <div
                        style="display: flex; justify-content: space-between; font-size: var(--label-size); margin-bottom: var(--space-sm);">
                        <span style="color: var(--text-muted);">Leitura Atual Registrada</span>
                        <span style="font-family: monospace; font-weight: 600;">
                            {{ number_format($leitura_atual, 3, ',', '.') }} m³
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: var(--label-size);">
                        <span style="color: var(--text-muted);">Consumo Calculado</span>
                        <span style="font-weight: 600;">
                            {{ number_format($consumo_presente, 3, ',', '.') }} m³
                        </span>
                    </div>
                </div>

                <!-- Nova Leitura -->
                <div class="form-group">
                    <label class="form-label">Nova Leitura (m³) *</label>
                    <div class="leit-input-group">
                        <input type="number" step="0.001"
                            class="form-input @error('nova_leitura') is-invalid @enderror"
                            wire:model.live="nova_leitura"
                            placeholder="{{ number_format($leitura_atual, 3, ',', '.') }}" required>
                        <span>m³</span>
                    </div>
                    @error('nova_leitura')
                        <small style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                    <p class="form-hint">
                        Leitura anterior: {{ number_format($leitura_anterior, 3, ',', '.') }} m³
                    </p>
                </div>

                <!-- Preview do novo consumo -->
                @if ($nova_leitura != $leitura_atual)
                    <div
                        style="background: var(--primary-light); border-radius: var(--radius-md); padding: var(--space-md); margin-bottom: var(--space-lg); border-left: 3px solid var(--primary);">
                        <div style="font-size: var(--label-size); color: var(--text-secondary);">Novo Consumo Calculado
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                            {{ number_format(max(0, $nova_leitura - $leitura_anterior), 3, ',', '.') }} m³
                        </div>
                    </div>
                @endif

                <!-- Motivo da Edição -->
                <div class="form-group">
                    <label class="form-label">Motivo da Edição *</label>
                    <select class="form-select @error('motivo_edicao') is-invalid @enderror" wire:model="motivo_edicao"
                        required>
                        <option value="">Selecione...</option>
                        <option value="Erro de Digitação">Erro de Digitação</option>
                        <option value="Leitura Não Conferida">Leitura Não Conferida</option>
                        <option value="Troca de Medidor">Troca de Medidor</option>
                        <option value="Medidor Substituído">Medidor Substituído</option>
                        <option value="Revisão Técnica">Revisão Técnica</option>
                        <option value="Outro">Outro</option>
                    </select>
                    @error('motivo_edicao')
                        <small style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Justificativa -->
                <div class="form-group">
                    <label class="form-label">Justificativa Detalhada</label>
                    <textarea class="form-textarea @error('observacoes') is-invalid @enderror" wire:model="observacoes" rows="3"
                        placeholder="Descreva o motivo completo da edição..."></textarea>
                    @error('observacoes')
                        <small style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Recalcular Fatura -->
                <div style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md);">
                    <label
                        style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                        <input type="checkbox" wire:model="recalcular_fatura"
                            style="accent-color: var(--primary); width: 18px; height: 18px;">
                        <span>
                            <strong>Recalcular fatura</strong> — Atualizar o valor da fatura já gerada com base na nova
                            leitura
                        </span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-editar-leitura')">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                    </svg>
                    <span wire:loading.remove wire:target="update">Salvar Alteração</span>
                    <span wire:loading wire:target="update">Salvando...</span>
                </button>
            </div>
        </form>
    </div>


    <div class="modal-overlay" id="modal-anomalia" wire:ignore.self>
        <form wire:submit.prevent="resolverAnomalia" class="modal modal-lg" style="max-width: 700px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--danger); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                            <line x1="12" x2="12" y1="9" y2="13" />
                            <line x1="12" x2="12.01" y1="17" y2="17" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Tratar Anomalia de Leitura</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                            {{ $medidores_id ? 'Medidor #' . $medidores_id : 'Carregando...' }} —
                            {{ $mes_referencia ?: 'Referência não definida' }}
                        </p>
                    </div>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('modal-anomalia')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <!-- Alerta de Anomalia -->
                <div class="leit-anomalia-alert" style="margin-bottom: var(--space-lg);">
                    <div style="display: flex; align-items: flex-start; gap: var(--space-md);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="var(--danger)" stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                        <div>
                            <div class="leit-anomalia-alert-title">
                                {{ $tipo_anomalia ? $tipo_anomalia : 'Anomalia Detectada' }}
                            </div>
                            <div class="leit-anomalia-alert-desc">
                                Consumo de {{ number_format($consumo_presente, 2, ',', '.') }} m³.
                                Leitura atual: {{ number_format($leitura_atual, 3, ',', '.') }} m³ —
                                Anterior: {{ number_format($leitura_anterior, 3, ',', '.') }} m³
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comparativo -->
                <div class="leit-comparativo" style="margin-bottom: var(--space-lg);">
                    <div class="leit-comparativo-item">
                        <div class="leit-comparativo-label">Leitura Anterior</div>
                        <div class="leit-comparativo-valor">
                            {{ number_format($leitura_anterior, 3, ',', '.') }}
                        </div>
                        <div class="leit-comparativo-variacao">Mês anterior</div>
                    </div>
                    <div class="leit-comparativo-item">
                        <div class="leit-comparativo-label">Leitura Atual</div>
                        <div class="leit-comparativo-valor" style="color: var(--danger);">
                            {{ number_format($leitura_atual, 3, ',', '.') }}
                        </div>
                        <div class="leit-comparativo-variacao negativa">{{ $mes_referencia }}</div>
                    </div>
                    <div class="leit-comparativo-item">
                        <div class="leit-comparativo-label">Consumo Médio</div>
                        <div class="leit-comparativo-valor">
                            @if ($medidores_id)
                                {{ number_format(app(App\Services\Leituristas::class)->ConsumoMedio($medidores_id), 2, ',', '.') }}
                            @endif
                            m³
                        </div>
                        <div class="leit-comparativo-variacao">Últimos 3 meses</div>
                    </div>
                </div>

                <!-- Tipo de Anomalia -->
                <div class="form-group">
                    <label class="form-label">Tipo de Anomalia *</label>
                    <select class="form-select @error('tipo_anomalia') is-invalid @enderror"
                        wire:model="tipo_anomalia" required>
                        <option value="">Selecione...</option>
                        <option value="Consumo Excessivo">Consumo Excessivo</option>
                        <option value="Consumo Muito Baixo">Consumo Muito Baixo</option>
                        <option value="Leitura Estagnada">Leitura Estagnada</option>
                        <option value="Medidor Invertido">Medidor Invertido</option>
                        <option value="Vazamento Identificado">Vazamento Identificado</option>
                        <option value="Medidor com Defeito">Medidor com Defeito</option>
                        <option value="Outro">Outro</option>
                    </select>
                    @error('tipo_anomalia')
                        <small style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Ação Corretiva -->
                <div class="form-group">
                    <label class="form-label">Ação Corretiva *</label>
                    <select class="form-select @error('acao_corretiva') is-invalid @enderror"
                        wire:model="acao_corretiva" required>
                        <option value="">Selecione...</option>
                        <option value="Confirmar Leitura">Confirmar Leitura (Correta)</option>
                        <option value="Refazer Leitura">Refazer Leitura</option>
                        <option value="Aplicar Média de Consumo">Aplicar Média de Consumo</option>
                        <option value="Substituir Medidor">Substituir Medidor</option>
                        <option value="Registrar Vazamento">Registrar Vazamento</option>
                        <option value="Enviar para Verificação Técnica">Enviar para Verificação Técnica</option>
                    </select>
                    @error('acao_corretiva')
                        <small style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Leitura Corrigida + Consumo Aplicado -->
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Leitura Corrigida (m³)</label>
                        <div class="leit-input-group">
                            <input type="number" step="0.001"
                                class="form-input @error('leitura_corrigida') is-invalid @enderror"
                                wire:model.live="leitura_corrigida"
                                placeholder="{{ number_format($leitura_atual, 3, ',', '.') }}">
                            <span>m³</span>
                        </div>
                        @error('leitura_corrigida')
                            <small
                                style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Consumo Aplicado (m³)</label>
                        <div class="leit-input-group">
                            <input type="number" step="0.001"
                                class="form-input @error('consumo_aplicado') is-invalid @enderror"
                                wire:model="consumo_aplicado" placeholder="Auto">
                            <span>m³</span>
                        </div>
                        <button type="button" wire:click="aplicarMedia"
                            style="margin-top: 6px; font-size: 0.75rem; color: var(--primary); background: none; border: none; cursor: pointer;">
                            ↻ Usar média
                            @if ($medidores_id)
                                ({{ number_format(app(App\Services\Leituristas::class)->ConsumoMedio($medidores_id), 2, ',', '.') }}
                                m³)
                            @endif
                        </button>
                    </div>
                </div>

                <!-- Preview do novo consumo -->
                @if ($leitura_corrigida && $leitura_corrigida > $leitura_anterior)
                    <div
                        style="background: var(--warning-light, #fff3cd); border-radius: var(--radius-md); padding: var(--space-md); margin-bottom: var(--space-lg); border-left: 3px solid var(--warning);">
                        <div style="font-size: var(--label-size); color: var(--text-secondary);">Novo Consumo Calculado
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--warning);">
                            {{ number_format(max(0, $leitura_corrigida - $leitura_anterior), 3, ',', '.') }} m³
                        </div>
                    </div>
                @endif

                <!-- Motivo da Edição -->
                <div class="form-group">
                    <label class="form-label">Motivo da Edição *</label>
                    <select class="form-select @error('motivo_edicao') is-invalid @enderror"
                        wire:model="motivo_edicao" required>
                        <option value="">Selecione...</option>
                        <option value="Correção de Anomalia">Correção de Anomalia</option>
                        <option value="Erro de Digitação">Erro de Digitação</option>
                        <option value="Revisão Técnica">Revisão Técnica</option>
                        <option value="Outro">Outro</option>
                    </select>
                    @error('motivo_edicao')
                        <small style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Observações -->
                <div class="form-group">
                    <label class="form-label">Parecer Técnico / Observações</label>
                    <textarea class="form-textarea @error('observacoes') is-invalid @enderror" wire:model="observacoes" rows="3"
                        placeholder="Descreva a análise técnica e ação tomada..."></textarea>
                    @error('observacoes')
                        <small style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Gerar OS -->
                <div style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md);">
                    <label
                        style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                        <input type="checkbox" wire:model="gerar_os"
                            style="accent-color: var(--primary); width: 18px; height: 18px;">
                        <span><strong>Gerar ordem de serviço</strong> — Criar OS para verificação técnica no
                            local</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-anomalia')">
                    Cancelar
                </button>
                <button type="button" class="btn btn-secondary" wire:click="enviarParaTecnico"
                    wire:loading.attr="disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path
                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                    </svg>
                    <span wire:loading.remove wire:target="enviarParaTecnico">Enviar para Técnico</span>
                    <span wire:loading wire:target="enviarParaTecnico">Enviando...</span>
                </button>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    <span wire:loading.remove wire:target="resolverAnomalia">Resolver Anomalia</span>
                    <span wire:loading wire:target="resolverAnomalia">Resolvendo...</span>
                </button>
            </div>
        </form>
    </div>
</div>
