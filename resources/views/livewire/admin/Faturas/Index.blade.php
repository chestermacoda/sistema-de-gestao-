@extends('admin.Layout.layouts')

@section('content')
    <div class="page-content">
        <!-- Page Header -->
        <div class="page-header">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <h1 class="page-title">Faturas</h1>
                    <p class="page-subtitle">Gestão de faturamento e cobrança do sistema de abastecimento</p>
                </div>
                <div style="display: flex; gap: var(--space-sm);">
                    <button class="btn btn-outline" onclick="openModal('modal-gerar-lote')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" x2="12" y1="15" y2="3" />
                        </svg>
                        Gerar Lote
                    </button>
                    <button class="btn btn-primary" onclick="openModal('modal-nova-fatura')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                        Nova Fatura
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div>
            <!-- Stats Cards -->
            <div class="stats-grid" style="margin-bottom: var(--space-xl);">

                {{-- Card 1: Emitidas --}}
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect width="20" height="14" x="2" y="5" rx="2" />
                            <line x1="2" x2="22" y1="10" y2="10" />
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $stats['emitidas']['valor'] ?? '0' }}</div>
                        <div class="stat-label">Faturas Emitidas (Mês)</div>
                        <div class="stat-change {{ $stats['emitidas']['tendencia'] ?? 'positive' }}">
                            {{ $stats['emitidas']['texto'] ?? '+0% vs mês anterior' }}
                        </div>
                    </div>
                </div>

                {{-- Card 2: Pagas --}}
                <div class="stat-card">
                    <div class="stat-icon success">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $stats['pagas']['valor'] ?? '0' }}</div>
                        <div class="stat-label">Faturas Pagas</div>
                        <div class="stat-change positive">
                            {{ $stats['pagas']['texto'] ?? '0% de quitação' }}
                        </div>
                    </div>
                </div>

                {{-- Card 3: Pendentes --}}
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
                        <div class="stat-value">{{ $stats['pendentes']['valor'] ?? '0' }}</div>
                        <div class="stat-label">Faturas Pendentes (Mês)</div>
                        <div class="stat-change negative">
                            {{ $stats['pendentes']['texto'] ?? '0% do total' }}
                        </div>
                    </div>
                </div>

                {{-- Card 4: Atrasadas --}}
                <div class="stat-card">
                    <div class="stat-icon danger">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m15 9-6 6" />
                            <path d="m9 9 6 6" />
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $stats['atrasadas']['valor'] ?? '0' }}</div>
                        <div class="stat-label">Faturas em Atraso</div>
                        <div class="stat-change negative">
                            {{ $stats['atrasadas']['texto'] ?? '0% do total' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <livewire:admin.faturas.show-faturas />
    </div>
    <!-- ============================================ -->
    <!-- MODAL: VER FATURA (Detalhes Completos)      -->
    <!-- ============================================ -->
    <livewire:admin.faturas.Detalhes />
    <!-- ============================================ -->
    <!-- MODAL: NOVA FATURA                          -->
    <!-- ============================================ -->
    <livewire:admin.faturas.nova-fatura />
    <!-- ============================================ -->
    <!-- MODAL: GERAR LOTE DE FATURAS                -->
    <!-- ============================================ -->
    <div class="modal-overlay" id="modal-gerar-lote">
        <div class="modal modal-lg" style="max-width: 800px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--secondary); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" x2="12" y1="15" y2="3" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Gerar Lote de Faturas</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Gere faturas
                            em massa para o período selecionado</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-gerar-lote')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div
                    style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-md); margin-bottom: var(--space-xl);">
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                        <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                            Clientes Ativos</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">2.156</div>
                    </div>
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                        <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">
                            Leituras Pendentes</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--warning);">23</div>
                    </div>
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                        <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">Faturas
                            Previstas</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">2.133</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Mês de Referência *</label>
                    <select class="form-select" required>
                        <option>Selecione...</option>
                        <option selected>Maio/2026</option>
                        <option>Abril/2026</option>
                        <option>Março/2026</option>
                    </select>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Data de Vencimento *</label>
                        <input type="date" class="form-input" value="2026-05-10" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Data de Emissão *</label>
                        <input type="date" class="form-input" value="2026-05-08" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Zonas / Setores</label>
                    <div style="display: flex; flex-wrap: wrap; gap: var(--space-sm); margin-top: var(--space-sm);">
                        <label
                            style="display: flex; align-items: center; gap: var(--space-xs); cursor: pointer; padding: var(--space-sm) var(--space-md); background: var(--neutral); border-radius: var(--radius-md); font-size: var(--label-size);">
                            <input type="checkbox" checked style="accent-color: var(--primary);">
                            <span>Zona Norte</span>
                        </label>
                        <label
                            style="display: flex; align-items: center; gap: var(--space-xs); cursor: pointer; padding: var(--space-sm) var(--space-md); background: var(--neutral); border-radius: var(--radius-md); font-size: var(--label-size);">
                            <input type="checkbox" checked style="accent-color: var(--primary);">
                            <span>Zona Sul</span>
                        </label>
                        <label
                            style="display: flex; align-items: center; gap: var(--space-xs); cursor: pointer; padding: var(--space-sm) var(--space-md); background: var(--neutral); border-radius: var(--radius-md); font-size: var(--label-size);">
                            <input type="checkbox" checked style="accent-color: var(--primary);">
                            <span>Zona Leste</span>
                        </label>
                        <label
                            style="display: flex; align-items: center; gap: var(--space-xs); cursor: pointer; padding: var(--space-sm) var(--space-md); background: var(--neutral); border-radius: var(--radius-md); font-size: var(--label-size);">
                            <input type="checkbox" checked style="accent-color: var(--primary);">
                            <span>Zona Oeste</span>
                        </label>
                        <label
                            style="display: flex; align-items: center; gap: var(--space-xs); cursor: pointer; padding: var(--space-sm) var(--space-md); background: var(--neutral); border-radius: var(--radius-md); font-size: var(--label-size);">
                            <input type="checkbox" checked style="accent-color: var(--primary);">
                            <span>Centro</span>
                        </label>
                    </div>
                </div>
                <div
                    style="background: var(--warning-light); border-radius: var(--radius-md); padding: var(--space-md); margin-top: var(--space-md); border-left: 3px solid var(--warning);">
                    <div style="display: flex; align-items: flex-start; gap: var(--space-md);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--warning)"
                            stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                        <div>
                            <div style="font-weight: 600; font-size: var(--label-size); color: var(--warning);">Atenção
                            </div>
                            <div style="font-size: var(--small-size); color: var(--text-secondary); margin-top: 2px;">23
                                clientes ainda não possuem leitura registrada para este período. Deseja continuar?</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-gerar-lote')">Cancelar</button>
                <button class="btn btn-primary" onclick="gerarLote()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    Gerar 2.133 Faturas
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MODAL: BOLETO / 2ª VIA                      -->
    <!-- ============================================ -->
    <div class="modal-overlay" id="modal-boleto-fatura">
        <div class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--primary); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect width="20" height="14" x="2" y="5" rx="2" />
                            <line x1="2" x2="22" y1="10" y2="10" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">2ª Via de Boleto</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                            FAT-2026-004521-05</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-boleto-fatura')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div
                    style="border: 2px solid var(--neutral-dark); border-radius: var(--radius-lg); padding: var(--space-xl); background: var(--white); text-align: center;">
                    <div
                        style="font-size: var(--label-size); color: var(--text-secondary); margin-bottom: var(--space-sm);">
                        Boleto Bancário</div>
                    <div
                        style="font-size: 1.5rem; font-weight: 700; color: var(--primary); margin-bottom: var(--space-md);">
                        R$ 89,50</div>
                    <div
                        style="font-family: monospace; font-size: var(--label-size); color: var(--text-primary); background: var(--neutral); padding: var(--space-md); border-radius: var(--radius-md); margin-bottom: var(--space-md);">
                        10491.11121 22222.333344 44444.555556 6 77770000008950
                    </div>
                    <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: var(--space-lg);">
                        Vencimento: 10/05/2026<br>
                        Beneficiário: AquaNexus - Sistema de Água<br>
                        CNPJ: 12.345.678/0001-90
                    </div>
                    <svg width="280" height="60" viewBox="0 0 280 60" style="margin: 0 auto;">
                        <rect x="0" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="8" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="14" y="0" width="6" height="50" fill="var(--text-primary)" />
                        <rect x="24" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="30" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="38" y="0" width="6" height="50" fill="var(--text-primary)" />
                        <rect x="48" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="54" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="62" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="68" y="0" width="6" height="50" fill="var(--text-primary)" />
                        <rect x="78" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="86" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="92" y="0" width="6" height="50" fill="var(--text-primary)" />
                        <rect x="102" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="110" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="116" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="124" y="0" width="6" height="50" fill="var(--text-primary)" />
                        <rect x="134" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="140" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="148" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="154" y="0" width="6" height="50" fill="var(--text-primary)" />
                        <rect x="164" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="172" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="178" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="186" y="0" width="6" height="50" fill="var(--text-primary)" />
                        <rect x="196" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="202" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="210" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="216" y="0" width="6" height="50" fill="var(--text-primary)" />
                        <rect x="226" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="234" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="240" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="248" y="0" width="6" height="50" fill="var(--text-primary)" />
                        <rect x="258" y="0" width="2" height="50" fill="var(--text-primary)" />
                        <rect x="264" y="0" width="4" height="50" fill="var(--text-primary)" />
                        <rect x="272" y="0" width="2" height="50" fill="var(--text-primary)" />
                    </svg>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-boleto-fatura')">Fechar</button>
                <button class="btn btn-secondary" onclick="alert('Boleto enviado por e-mail!')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    Enviar por E-mail
                </button>
                <button class="btn btn-primary" onclick="alert('Boleto baixado!')">
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
    </div>

    <!-- ============================================ -->
    <!-- MODAL: NEGOCIAR FATURA                      -->
    <!-- ============================================ -->
    <livewire:admin.faturas.negociar-fatura />

    <!-- ============================================ -->
    <!-- MODAL: COMPROVANTE DA FATURA                -->
    <!-- ============================================ -->
    <div class="modal-overlay" id="modal-comprovante-fat">
        <div class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--success); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Comprovante de Pagamento</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">#TRX-7842
                        </p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-comprovante-fat')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div
                    style="border: 2px solid var(--neutral-dark); border-radius: var(--radius-lg); padding: var(--space-xl); background: var(--white); text-align: center;">
                    <div
                        style="width: 64px; height: 64px; border-radius: 50%; background: var(--success-light); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-md);">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--success)"
                            stroke-width="2">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                    </div>
                    <div style="font-size: var(--label-size); color: var(--text-secondary);">Pagamento Confirmado</div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--primary); margin-top: var(--space-xs);">
                        R$ 89,50</div>
                    <div
                        style="margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px dashed var(--neutral-dark); display: flex; flex-direction: column; gap: var(--space-sm); font-size: var(--label-size); text-align: left;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Transação</span>
                            <span style="font-family: monospace; font-weight: 600;">#TRX-7842</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Data</span>
                            <span>08/05/2026 às 14:32</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Fatura</span>
                            <span style="font-family: monospace;">FAT-2026-004521-05</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Método</span>
                            <span>PIX</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">TxID</span>
                            <span style="font-family: monospace; font-size: var(--small-size);">1234567890ABCDEF</span>
                        </div>
                    </div>
                    <div
                        style="margin-top: var(--space-lg); padding-top: var(--space-lg); border-top: 1px dashed var(--neutral-dark); text-align: center;">
                        <div style="font-size: var(--small-size); color: var(--text-muted);">AquaNexus - Sistema de
                            Gestão de Água</div>
                        <div style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">CNPJ:
                            12.345.678/0001-90</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-comprovante-fat')">Fechar</button>
                <button class="btn btn-secondary" onclick="alert('Comprovante enviado por e-mail!')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    Enviar por E-mail
                </button>
                <button class="btn btn-primary" onclick="alert('Comprovante baixado!')">
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
    </div>
    <!-- ============================================ -->
    <!-- MODAL: COMPROVANTE DA FATURA                -->
    <!-- ============================================ -->
    <livewire:admin.pagamentos.registrar-pagamento />
    <div id="toast-container"
        style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: var(--space-sm);">
    </div>
    <script>
        // Close modal on overlay click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                    modal.classList.remove('active');
                });
                document.body.style.overflow = '';
            }
        });

        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }

        // Tab switching - Faturas main tabs
        function switchTabFat(btn, tabId) {
            document.querySelectorAll('.tabs .tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
        }

        // Tab switching - Ver Fatura modal
        function switchTabVerFat(btn, tabId) {
            document.querySelectorAll('#modal-ver-fatura .tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.tab-content-ver-fat').forEach(c => c.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }
    </script>
@endsection
