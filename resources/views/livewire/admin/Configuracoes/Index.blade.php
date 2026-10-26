  @extends('admin.Layout.layouts')

  @section('content')
      <form wire:submit.prevent='salvar' class="page-content">
          <!-- Page Header -->
          <div class="page-header">
              <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                  <div>
                      <h1 class="page-title">Configurações do Sistema</h1>
                      <p class="page-subtitle">Gerencie parâmetros, integrações e preferências da plataforma</p>
                  </div>
                  <div style="display: flex; gap: var(--space-sm);">
                      <button type="button" class="btn btn-outline" onclick="openModal('modal-backup')">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                              <polyline points="7 10 12 15 17 10" />
                              <line x1="12" x2="12" y1="15" y2="3" />
                          </svg>
                          Backup
                      </button>
                      <button type="submit" class="btn btn-primary">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2">
                              <path d="M20 6 9 17l-5-5" />
                          </svg>
                          Salvar Alterações
                      </button>
                  </div>
              </div>
          </div>

          <!-- Settings Grid -->
          <div class="cfg-grid">
              <!-- Coluna Esquerda -->
              <div class="cfg-col">
                  <!-- Empresa -->
                  @include('admin.Configuracoes.empresa')

                  <!-- Tarifas -->
                  @include('admin.Configuracoes.tarifas')

                  <!-- Notificações -->
                  @include('admin.Configuracoes.notificacoes')
              </div>

              <!-- Coluna Direita -->
              <div class="cfg-col">
                  <!-- Sistema -->
                 
                   @include('admin.Configuracoes.zonas_distribuicao')

                  <!-- Integrações -->
                  <div class="cfg-card">
                      <div class="cfg-card-header">
                          <div class="cfg-card-icon cfg-icon-orange">
                              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                  <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                              </svg>
                          </div>
                          <div>
                              <h3 class="cfg-card-title">Integrações</h3>
                              <p class="cfg-card-desc">Serviços externos conectados</p>
                          </div>
                      </div>
                      <div class="cfg-card-body">
                          <div class="cfg-integration-list">
                              <div class="cfg-integration-item cfg-integration-active">
                                  <div class="cfg-integration-icon">
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <rect x="1" y="4" width="22" height="16" rx="2" />
                                          <path d="M1 10h22" />
                                      </svg>
                                  </div>
                                  <div class="cfg-integration-info">
                                      <span class="cfg-integration-name">Asaas Pagamentos</span>
                                      <span class="cfg-integration-desc">Cobrança e recebimento via API</span>
                                      <span class="cfg-integration-status">● Conectado</span>
                                  </div>
                                  <button class="cfg-btn-text" onclick="openModal('modal-asaas')">Configurar</button>
                              </div>
                              <div class="cfg-integration-item cfg-integration-active">
                                  <div class="cfg-integration-icon">
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <path
                                              d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                          <polyline points="22,6 12,13 2,6" />
                                      </svg>
                                  </div>
                                  <div class="cfg-integration-info">
                                      <span class="cfg-integration-name">SMTP E-mail</span>
                                      <span class="cfg-integration-desc">Envio de notificações por e-mail</span>
                                      <span class="cfg-integration-status">● Conectado</span>
                                  </div>
                                  <button class="cfg-btn-text" onclick="openModal('modal-smtp')">Configurar</button>
                              </div>
                              <div class="cfg-integration-item">
                                  <div class="cfg-integration-icon">
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <path
                                              d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                                      </svg>
                                  </div>
                                  <div class="cfg-integration-info">
                                      <span class="cfg-integration-name">Twilio SMS</span>
                                      <span class="cfg-integration-desc">Envio de alertas por SMS</span>
                                      <span class="cfg-integration-status cfg-status-off">● Desconectado</span>
                                  </div>
                                  <button class="cfg-btn-text" onclick="openModal('modal-twilio')">Configurar</button>
                              </div>
                              <div class="cfg-integration-item">
                                  <div class="cfg-integration-icon">
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                      </svg>
                                  </div>
                                  <div class="cfg-integration-info">
                                      <span class="cfg-integration-name">Google Maps API</span>
                                      <span class="cfg-integration-desc">Geolocalização de medidores</span>
                                      <span class="cfg-integration-status cfg-status-off">● Desconectado</span>
                                  </div>
                                  <button class="cfg-btn-text" onclick="openModal('modal-maps')">Configurar</button>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- API -->
                  <div class="cfg-card">
                      <div class="cfg-card-header">
                          <div class="cfg-card-icon cfg-icon-red">
                              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <polyline points="16 18 22 12 16 6" />
                                  <polyline points="8 6 2 12 8 18" />
                              </svg>
                          </div>
                          <div>
                              <h3 class="cfg-card-title">API e Webhooks</h3>
                              <p class="cfg-card-desc">Acesso programático ao sistema</p>
                          </div>
                      </div>
                      <div class="cfg-card-body">
                          <div class="cfg-form-group">
                              <label class="cfg-label">Chave de API</label>
                              <div class="cfg-api-key">
                                  <input type="password" class="cfg-input" value="ak_live_51H8m...9x2L" readonly
                                      id="api-key-input">
                                  <button class="cfg-btn-icon" onclick="toggleApiKey()" title="Mostrar/Ocultar">
                                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                          <circle cx="12" cy="12" r="3" />
                                      </svg>
                                  </button>
                                  <button class="cfg-btn-icon" onclick="copiarApiKey()" title="Copiar">
                                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <rect x="9" y="9" width="13" height="13" rx="2"
                                              ry="2" />
                                          <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                      </svg>
                                  </button>
                                  <button class="cfg-btn-icon" onclick="gerarNovaApiKey()" title="Regenerar">
                                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                          <path d="M3 3v5h5" />
                                          <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                                          <path d="M16 21h5v-5" />
                                      </svg>
                                  </button>
                              </div>
                              <span class="cfg-hint">Última regeneração: 15/03/2026</span>
                          </div>
                          <div class="cfg-form-group">
                              <label class="cfg-label">URL de Webhook</label>
                              <input type="url" class="cfg-input"
                                  placeholder="https://sua-api.com/webhook/aquanexus">
                              <span class="cfg-hint">Receba eventos em tempo real (pagamentos, cadastros)</span>
                          </div>
                          <div class="cfg-toggle-list" style="margin-top: var(--space-md);">
                              <div class="cfg-toggle-item">
                                  <div class="cfg-toggle-info">
                                      <span class="cfg-toggle-title">Webhook Ativo</span>
                                      <span class="cfg-toggle-desc">Enviar eventos para URL configurada</span>
                                  </div>
                                  <label class="cfg-toggle">
                                      <input type="checkbox">
                                      <span class="cfg-toggle-slider"></span>
                                  </label>
                              </div>
                              <div class="cfg-toggle-item">
                                  <div class="cfg-toggle-info">
                                      <span class="cfg-toggle-title">Modo Sandbox</span>
                                      <span class="cfg-toggle-desc">Ambiente de testes para integrações</span>
                                  </div>
                                  <label class="cfg-toggle">
                                      <input type="checkbox">
                                      <span class="cfg-toggle-slider"></span>
                                  </label>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Manutenção -->
                  <div class="cfg-card">
                      <div class="cfg-card-header">
                          <div class="cfg-card-icon cfg-icon-yellow">
                              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <path
                                      d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                              </svg>
                          </div>
                          <div>
                              <h3 class="cfg-card-title">Manutenção</h3>
                              <p class="cfg-card-desc">Operações de rotina e limpeza</p>
                          </div>
                      </div>
                      <div class="cfg-card-body">
                          <div class="cfg-maintenance-grid">
                              <div class="cfg-maintenance-item">
                                  <div class="cfg-maintenance-info">
                                      <span class="cfg-maintenance-title">Limpar Cache</span>
                                      <span class="cfg-maintenance-desc">Remover dados temporários do
                                          navegador</span>
                                  </div>
                                  <button class="btn btn-sm btn-outline" onclick="limparCache()">Executar</button>
                              </div>
                              <div class="cfg-maintenance-item">
                                  <div class="cfg-maintenance-info">
                                      <span class="cfg-maintenance-title">Otimizar Banco</span>
                                      <span class="cfg-maintenance-desc">Reindexar tabelas e remover
                                          duplicatas</span>
                                  </div>
                                  <button class="btn btn-sm btn-outline" onclick="otimizarBanco()">Executar</button>
                              </div>
                              <div class="cfg-maintenance-item">
                                  <div class="cfg-maintenance-info">
                                      <span class="cfg-maintenance-title">Exportar Dados</span>
                                      <span class="cfg-maintenance-desc">Backup completo em formato SQL</span>
                                  </div>
                                  <button class="btn btn-sm btn-outline" onclick="exportarDados()">Executar</button>
                              </div>
                              <div class="cfg-maintenance-item">
                                  <div class="cfg-maintenance-info">
                                      <span class="cfg-maintenance-title">Verificar Integridade</span>
                                      <span class="cfg-maintenance-desc">Scan de consistência dos dados</span>
                                  </div>
                                  <button class="btn btn-sm btn-outline"
                                      onclick="verificarIntegridade()">Executar</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </form>


      <!-- ==================== MODAIS ==================== -->

      <!-- Modal: Editar Tarifa -->
      <div class="modal-overlay" id="modal-tarifa" wire:ignore.self>
          <form class="modal" wire:submit.prevent='saveupdate'>
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                      </svg>
                      Editar Tarifa
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-tarifa')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="cfg-form-group">
                      <label class="cfg-label">Categoria</label>
                      <input type="text" class="cfg-input" value="Residencial" readonly
                          style="background: var(--neutral);" wire:model='categoria'>
                      @error('categoria')
                          <small style="color: var(--danger)">{{ $message }}</small>
                      @enderror
                  </div>
                  <div class="cfg-form-row">
                      <div class="cfg-form-group">
                          <label class="cfg-label">Valor por m³ (MT)</label>
                          <input type="number" class="cfg-input" value="3.50" step="0.01" wire:model='valor_m3'>
                          @error('valor_m3')
                              <small style="color: var(--danger)">{{ $message }}</small>
                          @enderror
                      </div>
                      <div class="cfg-form-group">
                          <label class="cfg-label">Taxa Mínima (MT)</label>
                          <input type="number" class="cfg-input" value="25.00" step="0.01"
                              wire:model='tarifa_min'>
                          @error('tarifa_min')
                              <small style="color: var(--danger)">{{ $message }}</small>
                          @enderror
                      </div>
                  </div>
                  {{-- <div class="cfg-form-group">
                      <label class="cfg-label">Faixa de Consumo (m³)</label>
                      <div class="cfg-range-row">
                          <input type="number" class="cfg-input" value="0" placeholder="De">
                          <span>até</span>
                          <input type="number" class="cfg-input" value="10" placeholder="Até">
                          <span>→ R$ 3,50/m³</span>
                      </div>
                      <div class="cfg-range-row">
                          <input type="number" class="cfg-input" value="11" placeholder="De">
                          <span>até</span>
                          <input type="number" class="cfg-input" value="20" placeholder="Até">
                          <span>→ R$ 4,20/m³</span>
                      </div>
                      <div class="cfg-range-row">
                          <input type="number" class="cfg-input" value="21" placeholder="De">
                          <span>até</span>
                          <input type="number" class="cfg-input" value="999" placeholder="Até">
                          <span>→ R$ 5,80/m³</span>
                      </div>
                      <button class="cfg-btn-text" onclick="adicionarFaixa()">+ Adicionar Faixa</button>
                  </div> --}}
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-tarifa')">Cancelar</button>
                  <button class="btn btn-primary" type="submit">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Salvar Tarifa
                  </button>
              </div>
          </form>
      </div>


      <!-- Modal: Editar Tarifa -->
      <div class="modal-overlay" id="modal-zona_distribuicao" wire:ignore.self>
          <form class="modal" wire:submit.prevent='savezona' >
              <div class="modal-header">
                  <h3 class="modal-title">
                       @if($modalTipo)
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                 
                        Editar Zona
                      @else
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                        Adicionar Zona
                      @endif
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-zona_distribuicao')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="cfg-form-group">
                      <label class="cfg-label">Nome da Zona</label>
                      <input type="text" class="cfg-input"   
                          wire:model='nomezona'>
                      @error('nomezona')
                          <small style="color: var(--danger)">{{ $message }}</small>
                      @enderror
                  </div>
                  
                      <div class="cfg-form-group">
                          <label class="cfg-label">Descrição da Zona</label>
                          <input type="text" class="cfg-input"  wire:model='descricaozona'>
                          @error('descricaozona')
                              <small style="color: var(--danger)">{{ $message }}</small>
                          @enderror
                      </div>
               
                      <div class="cfg-form-group">
                          <label class="cfg-label">Status</label>
                           <select class="cfg-input" wire:model='statuszona'>
                                <option value="">Escolher status</option>
                                <option value="activo">Activo</option>
                                <option value="inativo">Inativo</option>
                           </select>
                          @error('statuszona')
                              <small style="color: var(--danger)">{{ $message }}</small>
                          @enderror
                      </div>
                 
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-zona_distribuicao')">Cancelar</button>
                  <button class="btn btn-primary" type="submit">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Salvar
                  </button>
              </div>
          </form>
      </div>

      <!-- Modal: Configurar Asaas -->
      <div class="modal-overlay" id="modal-asaas">
          <div class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <rect x="1" y="4" width="22" height="16" rx="2" />
                          <path d="M1 10h22" />
                      </svg>
                      Configurar Asaas
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-asaas')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="cfg-form-group">
                      <label class="cfg-label">API Key Asaas</label>
                      <input type="password" class="cfg-input" value="$aact_..."
                          placeholder="Sua chave de API do Asaas">
                  </div>
                  <div class="cfg-form-group">
                      <label class="cfg-label">Ambiente</label>
                      <select class="cfg-select">
                          <option value="sandbox">Sandbox (Testes)</option>
                          <option value="production" selected>Produção</option>
                      </select>
                  </div>
                  <div class="cfg-form-group">
                      <label class="cfg-label">Dias antes do Vencimento</label>
                      <input type="number" class="cfg-input" value="3" min="1" max="30">
                  </div>
                  <div class="cfg-toggle-item" style="margin-top: var(--space-md);">
                      <div class="cfg-toggle-info">
                          <span class="cfg-toggle-title">Cobrança Automática</span>
                          <span class="cfg-toggle-desc">Gerar cobrança automaticamente ao emitir fatura</span>
                      </div>
                      <label class="cfg-toggle">
                          <input type="checkbox" checked>
                          <span class="cfg-toggle-slider"></span>
                      </label>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-asaas')">Cancelar</button>
                  <button class="btn btn-danger" onclick="desconectarAsaas()">Desconectar</button>
                  <button class="btn btn-primary" onclick="salvarAsaas()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Salvar
                  </button>
              </div>
          </div>
      </div>

      <!-- Modal: Configurar SMTP -->
      <div class="modal-overlay" id="modal-smtp">
          <div class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                          <polyline points="22,6 12,13 2,6" />
                      </svg>
                      Configurar SMTP
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-smtp')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="cfg-form-row">
                      <div class="cfg-form-group">
                          <label class="cfg-label">Servidor SMTP</label>
                          <input type="text" class="cfg-input" value="smtp.gmail.com">
                      </div>
                      <div class="cfg-form-group">
                          <label class="cfg-label">Porta</label>
                          <input type="number" class="cfg-input" value="587">
                      </div>
                  </div>
                  <div class="cfg-form-group">
                      <label class="cfg-label">E-mail Remetente</label>
                      <input type="email" class="cfg-input" value="noreply@aquanexus.com.br">
                  </div>
                  <div class="cfg-form-row">
                      <div class="cfg-form-group">
                          <label class="cfg-label">Usuário</label>
                          <input type="text" class="cfg-input" value="noreply@aquanexus.com.br">
                      </div>
                      <div class="cfg-form-group">
                          <label class="cfg-label">Senha</label>
                          <input type="password" class="cfg-input" value="********">
                      </div>
                  </div>
                  <div class="cfg-form-group">
                      <label class="cfg-label">Criptografia</label>
                      <select class="cfg-select">
                          <option value="tls" selected>TLS</option>
                          <option value="ssl">SSL</option>
                          <option value="none">Nenhuma</option>
                      </select>
                  </div>
                  <button class="btn btn-outline btn-sm" onclick="testarSMTP()" style="margin-top: var(--space-sm);">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                          <polyline points="22 4 12 14.01 9 11.01" />
                      </svg>
                      Testar Conexão
                  </button>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-smtp')">Cancelar</button>
                  <button class="btn btn-primary" onclick="salvarSMTP()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Salvar
                  </button>
              </div>
          </div>
      </div>

      <!-- Modal: Configurar Twilio -->
      <div class="modal-overlay" id="modal-twilio">
          <div class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <path
                              d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                      </svg>
                      Configurar Twilio
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-twilio')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="cfg-form-row">
                      <div class="cfg-form-group">
                          <label class="cfg-label">Account SID</label>
                          <input type="text" class="cfg-input" placeholder="AC...">
                      </div>
                      <div class="cfg-form-group">
                          <label class="cfg-label">Auth Token</label>
                          <input type="password" class="cfg-input" placeholder="...">
                      </div>
                  </div>
                  <div class="cfg-form-group">
                      <label class="cfg-label">Número de Origem</label>
                      <input type="tel" class="cfg-input" placeholder="+5511999999999">
                  </div>
                  <button class="btn btn-outline btn-sm" onclick="testarTwilio()" style="margin-top: var(--space-sm);">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                          <polyline points="22 4 12 14.01 9 11.01" />
                      </svg>
                      Testar Envio
                  </button>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-twilio')">Cancelar</button>
                  <button class="btn btn-primary" onclick="salvarTwilio()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Conectar
                  </button>
              </div>
          </div>
      </div>

      <!-- Modal: Configurar Google Maps -->
      <div class="modal-overlay" id="modal-maps">
          <div class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                      </svg>
                      Configurar Google Maps
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-maps')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="cfg-form-group">
                      <label class="cfg-label">API Key Google Maps</label>
                      <input type="text" class="cfg-input" placeholder="AIza...">
                      <span class="cfg-hint">Obtenha em console.cloud.google.com</span>
                  </div>
                  <div class="cfg-form-group">
                      <label class="cfg-label">Centro do Mapa (Lat, Lng)</label>
                      <div class="cfg-form-row">
                          <input type="text" class="cfg-input" placeholder="-23.5505" value="-23.5505">
                          <input type="text" class="cfg-input" placeholder="-46.6333" value="-46.6333">
                      </div>
                  </div>
                  <div class="cfg-form-group">
                      <label class="cfg-label">Zoom Padrão</label>
                      <input type="number" class="cfg-input" value="12" min="1" max="20">
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-maps')">Cancelar</button>
                  <button class="btn btn-primary" onclick="salvarMaps()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Conectar
                  </button>
              </div>
          </div>
      </div>

      <!-- Modal: Backup -->
      <livewire:admin.configuracoes.backup-manager />
      <!-- Modal: Alterar Logo -->
      <div class="modal-overlay" id="modal-logo" wire:ignore.self>
          <form wire:submit.prevent='saveLogo' class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                          <circle cx="8.5" cy="8.5" r="1.5" />
                          <polyline points="21 15 16 10 5 21" />
                      </svg>
                      Alterar Logo
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-logo')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="cfg-upload-area" id="cfg-upload-area">
                      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)"
                          stroke-width="1.5">
                          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                          <polyline points="17 8 12 3 7 8" />
                          <line x1="12" x2="12" y1="3" y2="15" />
                      </svg>
                      <span class="cfg-upload-title">Arraste uma imagem ou clique para selecionar</span>
                      <span class="cfg-upload-desc">SVG, PNG ou JPG • Máx. 2 MB • Fundo transparente recomendado</span>
                      <input type="file" id="cfg-logo-input" accept=".svg,.png,.jpg,.jpeg" style="display: none;"
                          wire:model="logo">
                  </div>
                  <div class="cfg-form-group" style="margin-top: var(--space-lg);">
                      <label class="cfg-label">Preview</label>
                      <div class="cfg-logo-preview-lg">
                          @if ($logo)
                              <img src="{{ $logo->temporaryUrl() }}" width="120">
                          @elseif ($logo_atual)
                              <img src="{{ asset('storage/' . $logo_atual) }}" width="120">
                          @else
                              <svg width="80" height="80" viewBox="0 0 24 24" fill="none"
                                  stroke="var(--primary)" stroke-width="2">
                                  <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                              </svg>
                          @endif

                          {{-- <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="var(--primary)"
                              stroke-width="2">
                              <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                          </svg> --}}
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-logo')">Cancelar</button>
                  <button class="btn btn-primary" onclick="salvarLogo()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Salvar Logo
                  </button>
              </div>
          </form>
      </div>

      <div id="toast-container"
          style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: var(--space-sm);">
      </div>

      <!-- ==================== SCRIPTS ==================== -->
      <script>
          // ======== TEMA ========
          function selectTheme(el, theme) {
              document.querySelectorAll('.cfg-theme-option').forEach(opt => {
                  opt.classList.remove('cfg-theme-active');
              });

              el.classList.add('cfg-theme-active');

              const themeName =
                  theme === 'light' ?
                  'Claro' :
                  theme === 'dark' ?
                  'Escuro' :
                  'Automático';

              showToast(
                  `Tema "${themeName}" selecionado. Recarregue a página para aplicar.`,
                  'success'
              );
          }

          // ======== API KEY ========
          function toggleApiKey() {
              const input = document.getElementById('api-key-input');

              input.type = input.type === 'password' ?
                  'text' :
                  'password';
          }

          function copiarApiKey() {
              const input = document.getElementById('api-key-input');

              navigator.clipboard.writeText(input.value).then(() => {
                  showToast(
                      'API Key copiada para a área de transferência!',
                      'success'
                  );
              });
          }

          function gerarNovaApiKey() {
              confirmDelete(
                  'Tem certeza? Todas as integrações atuais serão interrompidas.',
                  function() {

                      const chars =
                          'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

                      let key = 'ak_live_';

                      for (let i = 0; i < 24; i++) {
                          key += chars.charAt(
                              Math.floor(Math.random() * chars.length)
                          );
                      }

                      document.getElementById('api-key-input').value = key;

                      showToast(
                          'Nova API Key gerada com sucesso!',
                          'success'
                      );
                  }
              );
          }

          // ======== TARIFA ========
          function adicionarFaixa() {
              const container =
                  document.querySelector('.cfg-range-row').parentElement;

              const div = document.createElement('div');

              div.className = 'cfg-range-row';

              div.innerHTML = `
            <input type="number" class="cfg-input" placeholder="De">

            <span>até</span>

            <input type="number" class="cfg-input" placeholder="Até">

            <span>
                → R$
                <input
                    type="number"
                    class="cfg-input"
                    style="width:80px; display:inline;"
                    step="0.01"
                >/m³
            </span>
        `;

              container.insertBefore(
                  div,
                  container.querySelector('.cfg-btn-text')
              );
          }

          function salvarTarifa() {
              closeModal('modal-tarifa');

              showToast(
                  'Tarifa atualizada com sucesso!',
                  'success'
              );
          }

          // ======== INTEGRAÇÕES ========
          function salvarAsaas() {
              closeModal('modal-asaas');

              showToast(
                  'Configuração Asaas salva!',
                  'success'
              );
          }

          function desconectarAsaas() {
              confirmDelete(
                  'Desconectar Asaas? As cobranças automáticas serão desativadas.',
                  function() {
                      closeModal('modal-asaas');

                      showToast(
                          'Asaas desconectado.',
                          'warning'
                      );
                  }
              );
          }

          function salvarSMTP() {
              closeModal('modal-smtp');

              showToast(
                  'Configuração SMTP salva!',
                  'success'
              );
          }

          function testarSMTP() {
              showToast(
                  'Testando conexão SMTP...',
                  'success'
              );

              setTimeout(() => {
                  showToast(
                      'Conexão SMTP OK! E-mail de teste enviado.',
                      'success'
                  );
              }, 2000);
          }

          function salvarTwilio() {
              closeModal('modal-twilio');

              showToast(
                  'Twilio conectado com sucesso!',
                  'success'
              );
          }

          function testarTwilio() {
              showToast(
                  'Enviando SMS de teste...',
                  'success'
              );

              setTimeout(() => {
                  showToast(
                      'SMS de teste enviado! Verifique o celular.',
                      'success'
                  );
              }, 2000);
          }

          function salvarMaps() {
              closeModal('modal-maps');

              showToast(
                  'Google Maps configurado!',
                  'success'
              );
          }

          // ======== BACKUP ========
          function exportarBackup(format) {
              showToast(
                  `Preparando exportação em ${format.toUpperCase()}...`,
                  'success'
              );

              setTimeout(() => {

                  const date = new Date()
                      .toISOString()
                      .slice(0, 10)
                      .replace(/-/g, '');

                  showToast(
                      `Download iniciado: backup_${date}_020000.${format}`,
                      'success'
                  );

              }, 1500);
          }

          function restaurarBackup(btn) {
              const item = btn.closest('.cfg-backup-item');

              const name = item.querySelector('.cfg-backup-name').textContent;

              confirmDelete(
                  `Restaurar backup ${name}?\n\nTodos os dados atuais serão substituídos.`,
                  function() {

                      showToast(
                          'Restauração iniciada... Aguarde.',
                          'warning'
                      );

                      setTimeout(() => {
                          showToast(
                              'Backup restaurado com sucesso! Recarregue a página.',
                              'success'
                          );
                      }, 3000);
                  }
              );
          }

          // ======== MANUTENÇÃO ========
          function limparCache() {
              showToast(
                  'Limpando cache...',
                  'success'
              );

              setTimeout(() => {
                  showToast(
                      'Cache limpo! 12 MB liberados.',
                      'success'
                  );
              }, 1500);
          }

          function otimizarBanco() {
              showToast(
                  'Otimizando banco de dados...',
                  'success'
              );

              setTimeout(() => {
                  showToast(
                      'Banco otimizado! 3 índices recriados.',
                      'success'
                  );
              }, 2000);
          }

          function exportarDados() {
              showToast(
                  'Exportando dados completos...',
                  'success'
              );

              setTimeout(() => {
                  showToast(
                      'Exportação concluída: aqua_dump_20260508.sql (28.4 MB)',
                      'success'
                  );
              }, 2500);
          }

          function verificarIntegridade() {
              showToast(
                  'Verificando integridade dos dados...',
                  'success'
              );

              setTimeout(() => {
                  showToast(
                      'Verificação concluída! Nenhuma inconsistência encontrada.',
                      'success'
                  );
              }, 3000);
          }

          // ======== LOGO ========
          const uploadArea = document.getElementById('cfg-upload-area');
          const logoInput = document.getElementById('cfg-logo-input');

          if (uploadArea && logoInput) {

              uploadArea.addEventListener('click', function() {
                  logoInput.click();
              });

              logoInput.addEventListener('change', function(e) {

                  if (e.target.files.length > 0) {

                      showToast(
                          `Arquivo "${e.target.files[0].name}" selecionado.`,
                          'success'
                      );
                  }
              });

              // Drag and Drop
              uploadArea.addEventListener('dragover', function(e) {
                  e.preventDefault();

                  uploadArea.classList.add('cfg-upload-dragover');
              });

              uploadArea.addEventListener('dragleave', function() {
                  uploadArea.classList.remove('cfg-upload-dragover');
              });

              uploadArea.addEventListener('drop', function(e) {
                  e.preventDefault();

                  uploadArea.classList.remove('cfg-upload-dragover');

                  if (e.dataTransfer.files.length > 0) {

                      showToast(
                          `Arquivo "${e.dataTransfer.files[0].name}" recebido.`,
                          'success'
                      );
                  }
              });
          }

          function salvarLogo() {
              closeModal('modal-logo');

              showToast(
                  'Logo atualizada com sucesso!',
                  'success'
              );
          }

          // ======== GERAL ========
          function salvarTodasConfiguracoes() {
              showToast(
                  'Salvando todas as configurações...',
                  'success'
              );

              setTimeout(() => {
                  showToast(
                      'Configurações salvas com sucesso!',
                      'success'
                  );
              }, 1500);
          }
      </script>
  @endsection
