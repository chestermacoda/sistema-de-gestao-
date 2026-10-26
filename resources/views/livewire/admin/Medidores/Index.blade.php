@extends('admin.Layout.layouts')

@section('content')
    <div class="page-content">
        <!-- Page Header -->
        <div class="page-header">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <h1 class="page-title">Medidores</h1>
                    <p class="page-subtitle">Gestão e monitoramento de todos os hidrômetros do sistema</p>
                </div>
                <div style="display: flex; gap: var(--space-sm);">
             
                    <button class="btn btn-primary" onclick="openModal('modal-novo-medidor')">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                        Novo Medidor
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <livewire:admin.medidores.medidores-stats />
        <livewire:admin.medidores.show-medidores />
    </div>

    <!-- ============================================ -->
    <!-- MODAL: NOVO MEDIDOR                           -->
    <!-- ============================================ -->
    <livewire:admin.medidores.create />
    <!-- ============================================ -->
    <!-- MODAL: VER MEDIDOR (Detalhes Completos)       -->
    <!-- ============================================ -->
    <div class="modal-overlay" id="modal-ver-medidor">
        <div class="modal modal-lg" style="max-width: 900px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">H-4521-AB</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Bayard MN-15
                            — Unijato — 15mm</p>
                    </div>
                </div>
                <div style="display: flex; gap: var(--space-sm); align-items: center;">
                    <span class="status-medidor ativo">● Em Operação</span>
                    <button class="modal-close" onclick="closeModal('modal-ver-medidor')">
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
                    <button class="tab active" onclick="switchTabVerMed(this, 'tab-ver-info')">Informações</button>
                    <button class="tab" onclick="switchTabVerMed(this, 'tab-ver-leituras')">Histórico de
                        Leituras</button>
                    <button class="tab" onclick="switchTabVerMed(this, 'tab-ver-manutencao')">Manutenções</button>
                    <button class="tab" onclick="switchTabVerMed(this, 'tab-ver-docs')">Documentos</button>
                </div>

                <!-- Aba: Informações -->
                <div id="tab-ver-info" class="tab-content-ver-med" style="display: block;">
                    <div class="medidor-detail-grid">
                        <div class="medidor-detail-section">
                            <h4>Dados do Medidor</h4>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Número</span>
                                <span class="medidor-detail-value" style="font-family: monospace;">H-4521-AB</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Série Fabricante</span>
                                <span class="medidor-detail-value" style="font-family: monospace;">BY-2022-04521</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Marca / Modelo</span>
                                <span class="medidor-detail-value">Bayard MN-15</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Tipo</span>
                                <span class="medidor-detail-value">Unijato / Velocidade</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Diâmetro</span>
                                <span class="medidor-detail-value">15mm</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Classe Metrológica</span>
                                <span class="medidor-detail-value">Classe B</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Qn / Qmax / Qmin</span>
                                <span class="medidor-detail-value">1.5 / 3.0 / 0.03 m³/h</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Ano Fabricação</span>
                                <span class="medidor-detail-value">2022</span>
                            </div>
                        </div>
                        <div class="medidor-detail-section">
                            <h4>Cliente & Instalação</h4>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Cliente</span>
                                <span class="medidor-detail-value">João da Silva Santos</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Matrícula</span>
                                <span class="medidor-detail-value" style="font-family: monospace;">MAT-2024-004521</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Endereço</span>
                                <span class="medidor-detail-value">Rua das Flores, 123</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Bairro / Zona</span>
                                <span class="medidor-detail-value">Jardim Primavera — Norte</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Data Instalação</span>
                                <span class="medidor-detail-value">12/03/2022</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Local Instalação</span>
                                <span class="medidor-detail-value">Calçada / Passeio Público</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Nº do Lacre</span>
                                <span class="medidor-detail-value" style="font-family: monospace;">L-4521-2022</span>
                            </div>
                            <div class="medidor-detail-row">
                                <span class="medidor-detail-label">Técnico Instalador</span>
                                <span class="medidor-detail-value">Carlos M. — MAT-4521</span>
                            </div>
                        </div>
                    </div>
                    <div
                        style="margin-top: var(--space-lg); display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-md);">
                        <div
                            style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: var(--radius-md); padding: var(--space-lg); color: white; text-align: center;">
                            <div style="font-size: var(--small-size); opacity: 0.9;">Leitura Atual</div>
                            <div style="font-size: 1.75rem; font-weight: 700; margin-top: 4px; font-family: monospace;">
                                45.230 m³</div>
                        </div>
                        <div
                            style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                            <div style="font-size: var(--small-size); color: var(--text-muted);">Consumo Médio Mensal
                            </div>
                            <div
                                style="font-size: 1.75rem; font-weight: 700; margin-top: 4px; color: var(--text-primary); font-family: monospace;">
                                56 m³</div>
                        </div>
                        <div
                            style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                            <div style="font-size: var(--small-size); color: var(--text-muted);">Tempo em Operação</div>
                            <div
                                style="font-size: 1.75rem; font-weight: 700; margin-top: 4px; color: var(--text-primary);">
                                3 anos</div>
                        </div>
                    </div>
                </div>

                <!-- Aba: Histórico de Leituras -->
                <div id="tab-ver-leituras" class="tab-content-ver-med" style="display: none;">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mês/Ano</th>
                                    <th>Leitura Anterior</th>
                                    <th>Leitura Atual</th>
                                    <th>Consumo (m³)</th>
                                    <th>Leiturista</th>
                                    <th>Data Leitura</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-weight: 600;">Mai/2026</td>
                                    <td style="font-family: monospace;">45.180</td>
                                    <td style="font-family: monospace; color: var(--primary); font-weight: 600;">45.230
                                    </td>
                                    <td><span class="badge badge-info">50</span></td>
                                    <td>Carlos M.</td>
                                    <td style="font-size: var(--small-size); color: var(--text-muted);">07/05/2026</td>
                                    <td><span class="badge badge-success">OK</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Abr/2026</td>
                                    <td style="font-family: monospace;">45.125</td>
                                    <td style="font-family: monospace; color: var(--primary); font-weight: 600;">45.180
                                    </td>
                                    <td><span class="badge badge-info">55</span></td>
                                    <td>Carlos M.</td>
                                    <td style="font-size: var(--small-size); color: var(--text-muted);">07/04/2026</td>
                                    <td><span class="badge badge-success">OK</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Mar/2026</td>
                                    <td style="font-family: monospace;">45.070</td>
                                    <td style="font-family: monospace; color: var(--primary); font-weight: 600;">45.125
                                    </td>
                                    <td><span class="badge badge-info">55</span></td>
                                    <td>Ana P.</td>
                                    <td style="font-size: var(--small-size); color: var(--text-muted);">07/03/2026</td>
                                    <td><span class="badge badge-success">OK</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Fev/2026</td>
                                    <td style="font-family: monospace;">45.010</td>
                                    <td style="font-family: monospace; color: var(--primary); font-weight: 600;">45.070
                                    </td>
                                    <td><span class="badge badge-info">60</span></td>
                                    <td>Ana P.</td>
                                    <td style="font-size: var(--small-size); color: var(--text-muted);">07/02/2026</td>
                                    <td><span class="badge badge-success">OK</span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Jan/2026</td>
                                    <td style="font-family: monospace;">44.950</td>
                                    <td style="font-family: monospace; color: var(--primary); font-weight: 600;">45.010
                                    </td>
                                    <td><span class="badge badge-info">60</span></td>
                                    <td>Carlos M.</td>
                                    <td style="font-size: var(--small-size); color: var(--text-muted);">07/01/2026</td>
                                    <td><span class="badge badge-success">OK</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Aba: Manutenções -->
                <div id="tab-ver-manutencao" class="tab-content-ver-med" style="display: none;">
                    <div class="manutencao-timeline">
                        <div class="manutencao-item concluido">
                            <div class="manutencao-item-titulo">Calibração Preventiva</div>
                            <div class="manutencao-item-desc">Verificação metrológica completa. Medidor dentro dos
                                padrões INMETRO.</div>
                            <div class="manutencao-item-data">15/03/2026 — Técnico: Roberto S. — OS: OS-2026-00321</div>
                        </div>
                        <div class="manutencao-item concluido">
                            <div class="manutencao-item-titulo">Substituição do Lacre</div>
                            <div class="manutencao-item-desc">Troca do lacre de segurança por violação detectada na
                                vistoria.</div>
                            <div class="manutencao-item-data">10/09/2025 — Técnico: Ana P. — OS: OS-2025-00892</div>
                        </div>
                        <div class="manutencao-item concluido">
                            <div class="manutencao-item-titulo">Limpeza e Inspeção</div>
                            <div class="manutencao-item-desc">Limpeza interna do medidor. Sem obstruções. Funcionamento
                                normal.</div>
                            <div class="manutencao-item-data">20/03/2025 — Técnico: Carlos M. — OS: OS-2025-00234</div>
                        </div>
                        <div class="manutencao-item concluido">
                            <div class="manutencao-item-titulo">Instalação Inicial</div>
                            <div class="manutencao-item-desc">Instalação do hidrômetro novo. Leitura inicial: 0 m³.
                                Lacre aplicado.</div>
                            <div class="manutencao-item-data">12/03/2022 — Técnico: Carlos M. — OS: OS-2022-00152</div>
                        </div>
                    </div>
                </div>

                <!-- Aba: Documentos -->
                <div id="tab-ver-docs" class="tab-content-ver-med" style="display: none;">
                    <div style="display: flex; flex-direction: column; gap: var(--space-md);">
                        <div
                            style="display: flex; align-items: center; gap: var(--space-md); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                            <div
                                style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--danger-light); display: flex; align-items: center; justify-content: center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--danger)" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; font-size: var(--label-size);">Certificado de Calibração
                                </div>
                                <div style="font-size: var(--small-size); color: var(--text-muted);">PDF — 2.4MB —
                                    Validade: 15/03/2027</div>
                            </div>
                            <button class="btn btn-sm btn-ghost">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" x2="12" y1="15" y2="3" />
                                </svg>
                            </button>
                        </div>
                        <div
                            style="display: flex; align-items: center; gap: var(--space-md); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                            <div
                                style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--danger-light); display: flex; align-items: center; justify-content: center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--danger)" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; font-size: var(--label-size);">Laudo INMETRO</div>
                                <div style="font-size: var(--small-size); color: var(--text-muted);">PDF — 1.8MB — Nº:
                                    INM-2022-04521</div>
                            </div>
                            <button class="btn btn-sm btn-ghost">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" x2="12" y1="15" y2="3" />
                                </svg>
                            </button>
                        </div>
                        <div
                            style="display: flex; align-items: center; gap: var(--space-md); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                            <div
                                style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--primary-light); display: flex; align-items: center; justify-content: center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white"
                                    stroke-width="2">
                                    <rect width="18" height="18" x="3" y="3" rx="2" />
                                    <path d="M3 9h18" />
                                </svg>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; font-size: var(--label-size);">Foto da Instalação</div>
                                <div style="font-size: var(--small-size); color: var(--text-muted);">JPG — 3.2MB —
                                    12/03/2022</div>
                            </div>
                            <button class="btn btn-sm btn-ghost">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" x2="12" y1="15" y2="3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-ver-medidor')">Fechar</button>
                <button class="btn btn-secondary"
                    onclick="closeModal('modal-ver-medidor'); openModal('modal-leitura-medidor')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" x2="8" y1="13" y2="13" />
                    </svg>
                    Registrar Leitura
                </button>
                <button class="btn btn-primary"
                    onclick="closeModal('modal-ver-medidor'); openModal('modal-manutencao-medidor')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path
                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                    </svg>
                    Nova Manutenção
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MODAL: REGISTRAR LEITURA                      -->
    <!-- ============================================ -->
    <!-- Toast Container -->

    <style>
        .form-error {
            color: var(--danger);
        }
    </style>
    <div class="modal-overlay" id="modal-leitura-medidor" wire:ignore.self>
        <form wire:submit.prevent='salvarLeitura' class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--tertiary); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" x2="8" y1="13" y2="13" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Registrar Leitura</h3>
                        <!-- CORRIGIDO: propriedades com nomes corretos -->
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                            {{ $numero_medidor }} — {{ $nome }}
                        </p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-leitura-medidor')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <!-- Info da última leitura -->
                <div
                    style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-bottom: var(--space-lg);">
                    <div
                        style="display: flex; justify-content: space-between; font-size: var(--label-size); margin-bottom: var(--space-sm);">
                        <span style="color: var(--text-muted);">Leitura Anterior</span>
                        <!-- CORRIGIDO: $ultima_leitura (com 'i') -->
                        <span style="font-family: monospace; font-weight: 600;">
                            {{ number_format($ultima_leitura, 0, ',', '.') }} m³
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: var(--label-size);">
                        <span style="color: var(--text-muted);">Mês Referência</span>
                        <span style="font-weight: 600;">{{ $data_leitura }}</span>
                    </div>
                </div>

                <div>
                    <!-- Nova Leitura -->
                    <div class="form-group">
                        <label class="form-label">Nova Leitura (m³) *</label>
                        <div class="leitura-input-group">
                            <!-- CORRIGIDO: wire:model.live para calcular em tempo real -->
                            <input type="number" wire:model.live="metros_cubicos" wire:change="calcularConsumo"
                                class="form-input" placeholder="00000" min="{{ $ultima_leitura + 1 }}" step="0.001"
                                required>
                            <span>m³</span>
                        </div>
                        <!-- CORRIGIDO: mensagem dinâmica com valor real -->
                        <p class="form-hint">
                            A leitura deve ser maior que a anterior ({{ number_format($ultima_leitura, 0, ',', '.') }} m³)
                        </p>
                        @error('metros_cubicos')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data da Leitura -->
                    <div class="form-group">
                        <label class="form-label">Data da Leitura *</label>
                        <input type="date" wire:model="data_leitura_input" class="form-input" required>
                        @error('data_leitura_input')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Leiturista -->
                    <div class="form-group">
                        <label class="form-label">Leiturista *</label>
                        <select wire:model="leiturista_id" class="form-select" required>
                            <option value="">Selecione...</option>
                            <!-- CORRIGIDO: $leituristas (com 'i') -->
                            @foreach ($leituristas ?? [] as $leiturista)
                                <option value="{{ $leiturista->id }}">{{ $leiturista->name }}</option>
                            @endforeach
                        </select>
                        @error('leiturista_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Observações -->
                    <div class="form-group">
                        <label class="form-label">Observações / Anomalias</label>
                        <textarea wire:model="observacoes" class="form-textarea"
                            placeholder="Descreva qualquer anomalia observada no medidor ou na instalação"></textarea>
                    </div>

                    <!-- Confirmação local -->
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-top: var(--space-md);">
                        <label
                            style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                            <input type="checkbox" wire:model="confirmada_local"
                                style="accent-color: var(--primary); width: 18px; height: 18px;">
                            <span><strong>Leitura confirmada no local</strong> — Estou presente no endereço de
                                instalação</span>
                        </label>
                    </div>

                    <!-- Preview do Consumo -->
                    <div class="consumo-preview" style="margin-top: var(--space-lg);">
                        <div class="consumo-preview-label">Consumo Estimado</div>
                        <!-- CORRIGIDO: $consumo_estimado (minúsculo) -->
                        <div class="consumo-preview-valor">{{ $consumo_estimado }} m³</div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-leitura-medidor')">Cancelar</button>
                <!-- CORRIGIDO: wire:click para salvar via Livewire -->
                <button type="submit" class="btn btn-primary" wire:click="salvarLeitura" wire:loading.attr="disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    <span wire:loading.remove wire:target="salvarLeitura">Confirmar Leitura</span>
                    <span wire:loading wire:target="salvarLeitura">Salvando...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ============================================ -->
    <!-- MODAL: MANUTENÇÃO DO MEDIDOR                  -->
    <!-- ============================================ -->
    <div class="modal-overlay" id="modal-manutencao-medidor">
        <div class="modal modal-lg" style="max-width: 800px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--warning); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Ordem de Serviço — Manutenção</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">H-4521-AB —
                            João da Silva Santos</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-manutencao-medidor')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="tabs" style="margin-bottom: var(--space-lg);">
                    <button class="tab active" onclick="switchTabManut(this, 'tab-manut-dados')">Dados da OS</button>
                    <button class="tab" onclick="switchTabManut(this, 'tab-manut-acoes')">Ações Realizadas</button>
                </div>

                <!-- Aba: Dados da OS -->
                <div id="tab-manut-dados" class="tab-content-manut" style="display: block;">
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Número da OS *</label>
                            <input type="text" class="form-input" value="OS-2026-00457"
                                style="font-family: monospace;" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Data de Abertura *</label>
                            <input type="date" class="form-input" value="2026-05-08" required>
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Tipo de Serviço *</label>
                            <select class="form-select" required>
                                <option>Selecione...</option>
                                <option>Calibração Preventiva</option>
                                <option>Calibração Corretiva</option>
                                <option>Substituição de Hidrômetro</option>
                                <option>Reparo de Vazamento</option>
                                <option>Troca de Lacre</option>
                                <option>Limpeza e Inspeção</option>
                                <option>Verificação de Pressão</option>
                                <option>Outro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Prioridade *</label>
                            <select class="form-select" required>
                                <option>Baixa</option>
                                <option selected>Normal</option>
                                <option>Alta</option>
                                <option>Urgente</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Técnico Responsável *</label>
                            <select class="form-select" required>
                                <option>Selecione...</option>
                                <option>Carlos M. — MAT-4521</option>
                                <option>Ana P. — MAT-3890</option>
                                <option>Roberto S. — MAT-5678</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Data Prevista Execução</label>
                            <input type="date" class="form-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Motivo / Descrição do Problema</label>
                        <textarea class="form-textarea" placeholder="Descreva o motivo da manutenção ou problema relatado"></textarea>
                    </div>
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-top: var(--space-md);">
                        <label
                            style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                            <input type="checkbox" style="accent-color: var(--primary); width: 18px; height: 18px;">
                            <span><strong>Interromper leituras</strong> — Não registrar leituras até finalização da
                                OS</span>
                        </label>
                    </div>
                </div>

                <!-- Aba: Ações Realizadas -->
                <div id="tab-manut-acoes" class="tab-content-manut" style="display: none;">
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Data de Execução</label>
                            <input type="date" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status da OS</label>
                            <select class="form-select">
                                <option selected>Em Andamento</option>
                                <option>Aguardando Peças</option>
                                <option>Concluída</option>
                                <option>Cancelada</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Serviços Realizados</label>
                        <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
                            <label
                                style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size); padding: var(--space-sm); background: var(--neutral); border-radius: var(--radius-sm);">
                                <input type="checkbox" style="accent-color: var(--primary);">
                                <span>Verificação metrológica completa</span>
                            </label>
                            <label
                                style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size); padding: var(--space-sm); background: var(--neutral); border-radius: var(--radius-sm);">
                                <input type="checkbox" style="accent-color: var(--primary);">
                                <span>Limpeza interna do medidor</span>
                            </label>
                            <label
                                style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size); padding: var(--space-sm); background: var(--neutral); border-radius: var(--radius-sm);">
                                <input type="checkbox" style="accent-color: var(--primary);">
                                <span>Substituição de peças danificadas</span>
                            </label>
                            <label
                                style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size); padding: var(--space-sm); background: var(--neutral); border-radius: var(--radius-sm);">
                                <input type="checkbox" style="accent-color: var(--primary);">
                                <span>Troca do lacre de segurança</span>
                            </label>
                            <label
                                style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size); padding: var(--space-sm); background: var(--neutral); border-radius: var(--radius-sm);">
                                <input type="checkbox" style="accent-color: var(--primary);">
                                <span>Teste de vazamento na instalação</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Leitura Após Manutenção (m³)</label>
                        <input type="number" class="form-input" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Parecer Técnico / Conclusão</label>
                        <textarea class="form-textarea" placeholder="Descreva o resultado da manutenção e parecer técnico"></textarea>
                    </div>
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Foto Antes</label>
                            <div
                                style="border: 2px dashed var(--neutral-darker); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center; cursor: pointer;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--text-muted)" stroke-width="2" style="margin: 0 auto var(--space-sm);">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" x2="12" y1="3" y2="15" />
                                </svg>
                                <p style="font-size: var(--small-size); color: var(--text-muted);">Upload foto</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Foto Depois</label>
                            <div
                                style="border: 2px dashed var(--neutral-darker); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center; cursor: pointer;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="var(--text-muted)" stroke-width="2" style="margin: 0 auto var(--space-sm);">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" x2="12" y1="3" y2="15" />
                                </svg>
                                <p style="font-size: var(--small-size); color: var(--text-muted);">Upload foto</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-manutencao-medidor')">Cancelar</button>
                <button class="btn btn-secondary" onclick="salvarOS()">Salvar Rascunho</button>
                <button class="btn btn-primary" onclick="finalizarOS()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    Finalizar OS
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MODAL: ESTOQUE DE MEDIDORES                   -->
    <!-- ============================================ -->
    <div class="modal-overlay" id="modal-estoque">
        <div class="modal modal-lg" style="max-width: 900px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--secondary); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                            <path d="m3.3 7 8.7 5 8.7-5" />
                            <path d="M12 22V12" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Estoque de Medidores</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">1.488
                            unidades disponíveis no depósito central</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-estoque')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div
                    style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--space-md); margin-bottom: var(--space-xl);">
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                        <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">15mm
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">856</div>
                        <div style="font-size: var(--small-size); color: var(--text-muted);">unidades</div>
                    </div>
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                        <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">20mm
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">312</div>
                        <div style="font-size: var(--small-size); color: var(--text-muted);">unidades</div>
                    </div>
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                        <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">25mm
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">198</div>
                        <div style="font-size: var(--small-size); color: var(--text-muted);">unidades</div>
                    </div>
                    <div
                        style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-lg); text-align: center;">
                        <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: 4px;">32mm+
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">122</div>
                        <div style="font-size: var(--small-size); color: var(--text-muted);">unidades</div>
                    </div>
                </div>

                <div class="card" style="margin: 0; margin-bottom: var(--space-lg);">
                    <div class="card-header">
                        <h3 class="card-title">Últimas Movimentações</h3>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Hidrômetro</th>
                                    <th>Tipo</th>
                                    <th>Quantidade</th>
                                    <th>Destino / Origem</th>
                                    <th>Responsável</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: var(--label-size);">08/05/2026</td>
                                    <td style="font-family: monospace; font-weight: 600;">H-9991-XX</td>
                                    <td><span class="badge badge-success">Saída</span></td>
                                    <td style="font-weight: 600;">1</td>
                                    <td>Instalação — MAT-2026-009991</td>
                                    <td>Carlos M.</td>
                                </tr>
                                <tr>
                                    <td style="font-size: var(--label-size);">07/05/2026</td>
                                    <td style="font-family: monospace; font-weight: 600;">H-9992-XX</td>
                                    <td><span class="badge badge-success">Saída</span></td>
                                    <td style="font-weight: 600;">1</td>
                                    <td>Instalação — MAT-2026-009992</td>
                                    <td>Ana P.</td>
                                </tr>
                                <tr>
                                    <td style="font-size: var(--label-size);">05/05/2026</td>
                                    <td style="font-family: monospace; font-weight: 600;">Lote-2026-003</td>
                                    <td><span class="badge badge-info">Entrada</span></td>
                                    <td style="font-weight: 600;">50</td>
                                    <td>Compra — Bayard Brasil</td>
                                    <td>Admin Master</td>
                                </tr>
                                <tr>
                                    <td style="font-size: var(--label-size);">02/05/2026</td>
                                    <td style="font-family: monospace; font-weight: 600;">H-3456-MN</td>
                                    <td><span class="badge badge-warning">Retorno</span></td>
                                    <td style="font-weight: 600;">1</td>
                                    <td>Manutenção — OS-2026-00456</td>
                                    <td>Roberto S.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-estoque')">Fechar</button>
                <button class="btn btn-primary" onclick="alert('Relatório de estoque gerado!')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" x2="12" y1="15" y2="3" />
                    </svg>
                    Exportar Relatório
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MODAL: INSTALAR MEDIDOR (do estoque)          -->
    <!-- ============================================ -->
    <div class="modal-overlay" id="modal-instalar-medidor">
        <div class="modal" style="max-width: 600px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--success); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Instalar Medidor</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">H-7890-OP —
                            Coprel — 15mm</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-instalar-medidor')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Cliente *</label>
                    <select class="form-select" required>
                        <option>Selecione o cliente...</option>
                        <option>João da Silva Santos — MAT-2024-004521</option>
                        <option>Maria Antônia Pereira — MAT-2024-006789</option>
                        <option>Novo Cliente...</option>
                    </select>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Matrícula *</label>
                        <input type="text" class="form-input" placeholder="MAT-2026-XXXXXX"
                            style="font-family: monospace;" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Data de Instalação *</label>
                        <input type="date" class="form-input" value="2026-05-08" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Endereço de Instalação *</label>
                    <input type="text" class="form-input" placeholder="Logradouro, número, bairro..." required>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Local de Instalação *</label>
                        <select class="form-select" required>
                            <option>Selecione...</option>
                            <option>Calçada / Passeio Público</option>
                            <option>Muro / Fronteira</option>
                            <option>Interior do Imóvel</option>
                            <option>Caixa Subterrânea</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Leitura Inicial (m³) *</label>
                        <input type="number" class="form-input" value="0" min="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Número do Lacre *</label>
                    <input type="text" class="form-input" placeholder="L-XXXX-XXXX" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Técnico Instalador *</label>
                    <select class="form-select" required>
                        <option>Selecione...</option>
                        <option>Carlos M. — MAT-4521</option>
                        <option>Ana P. — MAT-3890</option>
                        <option>Roberto S. — MAT-5678</option>
                    </select>
                </div>
                <div
                    style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-top: var(--space-md);">
                    <label
                        style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                        <input type="checkbox" checked style="accent-color: var(--primary); width: 18px; height: 18px;">
                        <span><strong>Vistoria técnica realizada</strong> — Confirmo que a instalação foi
                            verificada</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-instalar-medidor')">Cancelar</button>
                <button class="btn btn-primary" onclick="instalarMedidor()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    Confirmar Instalação
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MODAL: RELIGAR MEDIDOR                        -->
    <!-- ============================================ -->
    <div class="modal-overlay" id="modal-religar-medidor">
        <div class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <div
                        style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--success); display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Solicitar Religação</h3>
                        <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">H-6789-GH —
                            Maria Antônia Pereira</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-religar-medidor')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div
                    style="background: var(--danger-light); border-radius: var(--radius-md); padding: var(--space-md); margin-bottom: var(--space-lg); border-left: 3px solid var(--danger);">
                    <div style="display: flex; align-items: flex-start; gap: var(--space-md);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--danger)"
                            stroke-width="2" style="flex-shrink: 0; margin-top: 2px;">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                        <div>
                            <div style="font-weight: 600; font-size: var(--label-size); color: var(--danger);">Ligação
                                Cortada em 02/04/2026</div>
                            <div style="font-size: var(--small-size); color: var(--text-secondary); margin-top: 2px;">
                                Motivo: Inadimplência — R$ 456,80 em aberto</div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Tipo de Religação *</label>
                    <select class="form-select" required>
                        <option>Selecione...</option>
                        <option>Regularização de Débito</option>
                        <option>Negociação de Dívida</option>
                        <option>Isenção Aprovada</option>
                        <option>Erro de Sistema</option>
                        <option>Outro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Valor Pago / Negociado</label>
                    <input type="text" class="form-input" placeholder="R$ 0,00">
                </div>

                <div class="form-group">
                    <label class="form-label">Data Prevista de Religação</label>
                    <input type="date" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Observações</label>
                    <textarea class="form-textarea" placeholder="Justificativa para a religação"></textarea>
                </div>

                <div style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md);">
                    <label
                        style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                        <input type="checkbox" style="accent-color: var(--primary); width: 18px; height: 18px;">
                        <span><strong>Confirmo que o débito foi quitado/negociado</strong></span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeModal('modal-religar-medidor')">Cancelar</button>
                <button class="btn btn-primary" onclick="solicitarReligacao()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-right: 6px;">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                    </svg>
                    Solicitar Religação
                </button>
            </div>
        </div>
    </div>

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

        // Tab switching - Novo Medidor
        // function switchTabNovoMed(btn, tabId) {
        //     document.querySelectorAll('#modal-novo-medidor .tab').forEach(t => t.classList.remove('active'));
        //     btn.classList.add('active');
        //     document.querySelectorAll('.tab-content-novo-med').forEach(c => c.style.display = 'none');
        //     document.getElementById(tabId).style.display = 'block';
        // }


        // Chave única para o localStorage
        const STORAGE_KEY = 'active_tab_novo_medidor';

        function switchTabNovoMed(btn, tabId) {
            // 1. Lógica Visual
            document.querySelectorAll('#modal-novo-medidor .tab').forEach(t => t.classList.remove('active'));

            // Se o btn não for passado (carregamento inicial), buscamos pelo seletor
            if (btn) {
                btn.classList.add('active');
            } else {
                document.querySelector(`#modal-novo-medidor .tab[onclick*="${tabId}"]`)?.classList.add('active');
            }

            document.querySelectorAll('.tab-content-novo-med').forEach(c => c.style.display = 'none');
            const targetContent = document.getElementById(tabId);
            if (targetContent) targetContent.style.display = 'block';

            // 2. Salvar no LocalStorage
            localStorage.setItem(STORAGE_KEY, tabId);
        }

        // 3. Recuperar ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            const savedTab = localStorage.getItem(STORAGE_KEY);
            if (savedTab) {
                // Aplica a aba salva
                switchTabNovoMed(null, savedTab);
            }
        });

        // 4. Limpar ao fazer Submit (Chame esta função no seu wire:submit ou evento de envio)
        function clearMedidorTab() {
            localStorage.removeItem(STORAGE_KEY);
        }


        document.addEventListener('livewire:initialized', () => {
            // Executa sempre que o Livewire terminar de atualizar o componente
            Livewire.hook('morph.updated', ({
                el,
                component
            }) => {
                const savedTab = localStorage.getItem('active_tab_novo_medidor');
                if (savedTab) {
                    // Re-aplica a aba sem salvar novamente (para evitar loop)
                    document.querySelectorAll('#modal-novo-medidor .tab').forEach(t => t.classList.remove(
                        'active'));
                    document.querySelector(`#modal-novo-medidor .tab[onclick*="${savedTab}"]`)?.classList
                        .add('active');

                    document.querySelectorAll('.tab-content-novo-med').forEach(c => c.style.display =
                        'none');
                    const targetContent = document.getElementById(savedTab);
                    if (targetContent) targetContent.style.display = 'block';
                }
            });
        });



        // Tab switching - Ver Medidor
        function switchTabVerMed(btn, tabId) {
            document.querySelectorAll('#modal-ver-medidor .tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.tab-content-ver-med').forEach(c => c.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }

        // Tab switching - Manutenção
        function switchTabManut(btn, tabId) {
            document.querySelectorAll('#modal-manutencao-medidor .tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.tab-content-manut').forEach(c => c.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }
    </script>
@endsection
