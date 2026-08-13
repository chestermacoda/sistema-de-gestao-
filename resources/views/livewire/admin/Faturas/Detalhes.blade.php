<div class="modal-overlay" id="modal-ver-fatura">
    @if ($detalhe)
        <div class="modal modal-lg" style="max-width: 900px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect width="20" height="14" x="2" y="5" rx="2" />
                            <line x1="2" x2="22" y1="10" y2="10" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">{{ $fatura['codigo'] }}</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Mai/2026 —
                            {{ $cliente['nome'] }}</p>
                    </div>
                </div>
                <div style="display: flex; gap: var(--space-sm); align-items: center;">
                    <span class="fatura-status-badge {{ $fatura['statusClass'] }}">● {{ $fatura['status'] }}</span>
                    <button class="modal-close" onclick="closeModal('modal-ver-fatura')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="tabs" style="margin-bottom: var(--space-lg);">
                    <button class="tab active" onclick="switchTabVerFat(this, 'tab-fat-info')">Informações</button>
                    <button class="tab" onclick="switchTabVerFat(this, 'tab-fat-composicao')">Composição do
                        Valor</button>
                    <button class="tab" onclick="switchTabVerFat(this, 'tab-fat-historico')">Histórico</button>
                    <button class="tab" onclick="switchTabVerFat(this, 'tab-fat-pagamentos')">Pagamentos</button>
                </div>

                <!-- Aba: Informações -->
                <div id="tab-fat-info" class="tab-content-ver-fat" style="display: block;">
                    <div class="fatura-detail-grid">
                        <div class="fatura-cliente-box">
                            <div class="fatura-cliente-title">Dados do Cliente</div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Nome</span>
                                <span class="fatura-cliente-value">{{ $cliente['nome'] }}</span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Matrícula</span>
                                <span class="fatura-cliente-value"
                                    style="font-family: monospace;">{{ $cliente['matricula'] }}</span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">BI/Nuit</span>
                                <span class="fatura-cliente-value">{{ $cliente['bi'] }}</span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Endereço</span>
                                <span class="fatura-cliente-value"> {{ $cliente['endereco'] }} </span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Cidade / Bairro</span>
                                <span class="fatura-cliente-value">{{ $cliente['bairrozona'] }}</span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Telefone</span>
                                <span class="fatura-cliente-value">{{ $cliente['telefone'] }}</span>
                            </div>
                        </div>
                        <div class="fatura-cliente-box">
                            <div class="fatura-cliente-title">Dados da Fatura</div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Número</span>
                                <span class="fatura-cliente-value"
                                    style="font-family: monospace;">{{ $fatura['codigo'] }}</span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Mês Referência</span>
                                <span class="fatura-cliente-value">{{ $fatura['mes_referente'] }}</span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Período</span>
                                <span class="fatura-cliente-value">{{ $fatura['periodo'] }}</span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Data de Emissão</span>
                                <span class="fatura-cliente-value">{{ $fatura['data_emissao'] }}</span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Vencimento</span>
                                <span class="fatura-cliente-value">{{ $fatura['data_vencimento'] }}</span>
                            </div>
                            <div class="fatura-cliente-row">
                                <span class="fatura-cliente-label">Data de Pagamento</span>
                                <span class="fatura-cliente-value">08/05/2026</span>
                            </div>
                        </div>
                    </div>
                    <div
                        style="margin-top: var(--space-lg); display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-md);">
                        <div
                            style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: var(--radius-md); padding: var(--space-lg); color: white; text-align: center;">
                            <div style="font-size: var(--small-size); opacity: 0.9;">Valor Total</div>
                            <div style="font-size: 1.75rem; font-weight: 700; margin-top: 4px; font-family: monospace;">
                                MT {{ number_format($fatura['valor_consumo'], 2 ?? 0) }}</div>
                        </div>
                        <div
                            style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                            <div style="font-size: var(--small-size); color: var(--text-muted);">Consumo Faturado</div>
                            <div
                                style="font-size: 1.75rem; font-weight: 700; margin-top: 4px; color: var(--text-primary); font-family: monospace;">
                                {{ $fatura['metrocubicos_Consumo'] }} m³</div>
                        </div>
                        <div
                            style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                            <div style="font-size: var(--small-size); color: var(--text-muted);">Leitura do Medidor
                            </div>

                            <div
                                style="font-size: 1.75rem; font-weight: 700; margin-top: 4px; color: var(--text-primary); font-family: monospace;">
                                {{ $fatura['leitura_atual'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- Aba: Composição do Valor -->
                <div id="tab-fat-composicao" class="tab-content-ver-fat" style="display: none;">
                    <div class="fatura-composicao">
                        <div class="fatura-composicao-title">Composição do Valor da Fatura</div>
                        <div class="fatura-composicao-row">
                            <span class="fatura-composicao-label">Consumo de Água
                                ({{ $fatura['metrocubicos_Consumo'] }} m³ × MT {{ $fatura['tarifa'] }} )</span>
                            <span class="fatura-composicao-value">MT
                                {{ number_format($fatura['valor_consumo'], 2 ?? 0) }}</span>
                        </div>
                        <div class="fatura-composicao-row">
                            <span class="fatura-composicao-label">Taxa de Esgoto (50% do consumo)</span>
                            <span class="fatura-composicao-value">R$ 30,00</span>
                        </div>
                        <div class="fatura-composicao-row">
                            <span class="fatura-composicao-label">Taxa de Disponibilidade / Ligação</span>
                            <span class="fatura-composicao-value">R$ 12,50</span>
                        </div>
                        <div class="fatura-composicao-row">
                            <span class="fatura-composicao-label">Taxa de Manutenção do Medidor</span>
                            <span class="fatura-composicao-value">R$ 5,00</span>
                        </div>
                        <div class="fatura-composicao-row">
                            <span class="fatura-composicao-label">Desconto por Pagamento em Dia (5%)</span>
                            <span class="fatura-composicao-value" style="color: var(--success);">- R$ 5,38</span>
                        </div>
                        <div class="fatura-composicao-row">
                            <span class="fatura-composicao-label">Juros / Multas</span>
                            <span class="fatura-composicao-value" style="color: var(--danger);">R$ 0,00</span>
                        </div>
                        <div class="fatura-composicao-row">
                            <span class="fatura-composicao-label"
                                style="font-weight: 700; color: var(--text-primary);">TOTAL DA FATURA</span>
                            <span class="fatura-composicao-total">R$ 89,50</span>
                        </div>
                    </div>
                    <div
                        style="margin-top: var(--space-lg); background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg);">
                        <div
                            style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-md);">
                            Detalhamento do Consumo</div>
                        <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
                            <div style="display: flex; justify-content: space-between; font-size: var(--label-size);">
                                <span style="color: var(--text-secondary);">Leitura Anterior </span>
                                <span
                                    style="font-family: monospace; font-weight: 600;">{{ number_format($fatura['leitura_anterior'], 2 ?? 0) }}
                                    m³</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: var(--label-size);">
                                <span style="color: var(--text-secondary);">Leitura Atual </span>
                                <span
                                    style="font-family: monospace; font-weight: 600; color: var(--primary);">{{ number_format($fatura['leitura_atual'], 2 ?? 0) }}
                                    m³</span>
                            </div>
                            <div
                                style="display: flex; justify-content: space-between; font-size: var(--label-size); border-top: 1px solid var(--neutral-dark); padding-top: var(--space-sm); margin-top: var(--space-xs);">
                                <span style="font-weight: 700; color: var(--text-primary);">Consumo no Período</span>
                                <span
                                    style="font-weight: 700; color: var(--primary); font-family: monospace;">{{ number_format($fatura['consumo_m3'], 2 ?? 0) }}
                                    m³</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aba: Histórico -->
                <div id="tab-fat-historico" class="tab-content-ver-fat" style="display: none;">
                    <div class="fatura-timeline">
                        <div class="fatura-timeline-item pago">
                            <div class="fatura-timeline-title">Pagamento Confirmado</div>
                            <div class="fatura-timeline-desc">Pagamento de R$ 89,50 confirmado via PIX. Fatura quitada.
                            </div>
                            <div class="fatura-timeline-date">08/05/2026 às 14:32 — Transação #TRX-7842</div>
                        </div>
                        <div class="fatura-timeline-item pago">
                            <div class="fatura-timeline-title">Fatura Emitida</div>
                            <div class="fatura-timeline-desc">Fatura gerada automaticamente com base na leitura de
                                45.230 m³.</div>
                            <div class="fatura-timeline-date">08/05/2026 às 06:00 — Sistema Auto</div>
                        </div>
                        <div class="fatura-timeline-item pago">
                            <div class="fatura-timeline-title">Leitura Registrada</div>
                            <div class="fatura-timeline-desc">Leitura atual registrada: 45.230 m³. Consumo: 50 m³.
                            </div>
                            <div class="fatura-timeline-date">07/05/2026 às 14:32 — Leiturista: Carlos M.</div>
                        </div>
                        <div class="fatura-timeline-item pago">
                            <div class="fatura-timeline-title">Fatura do Mês Anterior Paga</div>
                            <div class="fatura-timeline-desc">Fatura FAT-2026-004521-04 quitada com pagamento de R$
                                92,10.</div>
                            <div class="fatura-timeline-date">10/04/2026 — Transação #TRX-7789</div>
                        </div>
                    </div>
                </div>

                <!-- Aba: Pagamentos -->
                <div id="tab-fat-pagamentos" class="tab-content-ver-fat" style="display: none;">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Transação</th>
                                    <th>Método</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: var(--label-size);">08/05/2026<br><span
                                            style="font-size: var(--small-size); color: var(--text-muted);">14:32:18</span>
                                    </td>
                                    <td style="font-family: monospace; font-weight: 600;">#TRX-7842</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: var(--space-xs);">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="var(--tertiary)" stroke-width="2">
                                                <rect width="20" height="12" x="2" y="6" rx="2" />
                                                <path d="M12 12h.01" />
                                            </svg>
                                            <span>PIX</span>
                                        </div>
                                    </td>
                                    <td style="font-weight: 700;">R$ 89,50</td>
                                    <td><span class="badge badge-success">Confirmado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-ghost"
                                            onclick="openModal('modal-comprovante-fat')" title="Comprovante">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                <polyline points="14 2 14 8 20 8" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-ver-fatura')">Fechar</button>
                <button class="btn btn-secondary" onclick="alert('Fatura enviada por e-mail!')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    Enviar por E-mail
                </button>
                <button class="btn btn-primary" onclick="alert('PDF da fatura gerado!')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" x2="12" y1="15" y2="3" />
                    </svg>
                    Baixar PDF
                </button>
            </div>
        </div>
    @endif
</div>
