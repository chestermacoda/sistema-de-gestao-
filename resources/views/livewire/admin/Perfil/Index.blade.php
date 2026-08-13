  @extends('admin.Layout.layouts')

  @section('content')
      <link rel="stylesheet" href="{{ asset('assets/css/perfil.css') }}">
      <div class="page-content">
          <!-- Header do Perfil -->
          <div class="prf-header">
              <div class="prf-cover"></div>
              <div class="prf-header-content">
                  <div class="prf-avatar-wrap">
                      <div class="prf-avatar">{{ strtoupper(substr(Auth()->user()->name, 0, 2)) }}</div>
                      <button class="prf-avatar-edit" onclick="openModal('modal-foto')" title="Alterar foto">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2">
                              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                          </svg>
                      </button>
                  </div>
                  <div class="prf-header-info">
                      <h1 class="prf-name">{{ Auth()->user()->roles['0']['name'] }}</h1>
                      <p class="prf-role">{{ Auth()->user()->roles['0']['name'] }} • USR-001</p>
                      <div class="prf-header-meta">
                          <span class="prf-meta-item">
                              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  stroke-width="2">
                                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                  <polyline points="22,6 12,13 2,6" />
                              </svg>
                              {{ Auth()->user()->email }}
                          </span>
                          <span class="prf-meta-item">
                              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  stroke-width="2">
                                  <path
                                      d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                              </svg>
                              {{ Auth()->user()->telefone }}
                          </span>
                          <span class="prf-meta-item">
                              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  stroke-width="2">
                                  <circle cx="12" cy="12" r="10" />
                                  <polyline points="12 6 12 12 16 14" />
                              </svg>
                              Último acesso: -
                          </span>
                      </div>
                  </div>
                  <div class="prf-header-actions">
                      <button class="btn btn-outline" onclick="openModal('modal-editar-perfil')">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2">
                              <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                          </svg>
                          Editar Perfil
                      </button>
                  </div>
              </div>
          </div>

          <!-- Grid do Perfil -->
          <div class="prf-grid">
              <!-- Coluna Esquerda -->
              <div class="prf-col">
                  <!-- Informações Pessoais -->
                  <div class="prf-card">
                      <div class="prf-card-header">
                          <h3 class="prf-card-title">Informações Pessoais</h3>
                          <button class="prf-btn-icon" onclick="openModal('modal-editar-perfil')" title="Editar">
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                  stroke-width="2">
                                  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                              </svg>
                          </button>
                      </div>
                      <div class="prf-card-body">
                          <div class="prf-info-list">
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Nome Completo</span>
                                  <span class="prf-info-value">{{ Auth()->user()->name }}</span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">E-mail</span>
                                  <span class="prf-info-value">{{ Auth()->user()->email }}</span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Telefone</span>
                                  <span class="prf-info-value">{{ Auth()->user()->telefone }}</span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Matrícula</span>
                                  <span class="prf-info-value" style="font-family: monospace;">USR-001</span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Perfil</span>
                                  <span class="prf-info-value">
                                      <span
                                          class="prf-badge prf-badge-admin">{{ Auth()->user()->roles['0']['name'] }}</span>
                                  </span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Zona de Atuação</span>
                                  <span class="prf-info-value">{{ Auth()->user()->zona }}</span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Cadastrado em</span>
                                  <span class="prf-info-value">{{ Auth()->user()->created_at->format('d/m/Y') }}</span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Status</span>
                                  <span class="prf-info-value">
                                      <span class="prf-status-dot prf-status-ativo"></span> {{ Auth()->user()->status }}
                                  </span>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Endereço -->
                  <div class="prf-card">
                      <div class="prf-card-header">
                          <h3 class="prf-card-title">Endereço</h3>
                          <button class="prf-btn-icon" onclick="openModal('modal-endereco')" title="Editar">
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                              </svg>
                          </button>
                      </div>
                      <div class="prf-card-body">
                          <div class="prf-info-list">
                              <div class="prf-info-item">
                                  <span class="prf-info-label">CEP</span>
                                  <span class="prf-info-value">01000-000</span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Logradouro</span>
                                  <span class="prf-info-value">Av. das Águas, 1000</span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Bairro</span>
                                  <span class="prf-info-value">Centro</span>
                              </div>
                              <div class="prf-info-item">
                                  <span class="prf-info-label">Cidade/UF</span>
                                  <span class="prf-info-value">São Paulo - SP</span>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Preferências -->
                  <div class="prf-card">
                      <div class="prf-card-header">
                          <h3 class="prf-card-title">Preferências</h3>
                      </div>
                      <div class="prf-card-body">
                          <div class="prf-toggle-list">
                              <div class="prf-toggle-item">
                                  <div class="prf-toggle-info">
                                      <span class="prf-toggle-title">Notificações por E-mail</span>
                                      <span class="prf-toggle-desc">Receber alertas e atualizações</span>
                                  </div>
                                  <label class="prf-toggle">
                                      <input type="checkbox" checked>
                                      <span class="prf-toggle-slider"></span>
                                  </label>
                              </div>
                              <div class="prf-toggle-item">
                                  <div class="prf-toggle-info">
                                      <span class="prf-toggle-title">Notificações por SMS</span>
                                      <span class="prf-toggle-desc">Alertas urgentes no celular</span>
                                  </div>
                                  <label class="prf-toggle">
                                      <input type="checkbox">
                                      <span class="prf-toggle-slider"></span>
                                  </label>
                              </div>
                              <div class="prf-toggle-item">
                                  <div class="prf-toggle-info">
                                      <span class="prf-toggle-title">Modo Noturno Automático</span>
                                      <span class="prf-toggle-desc">Ativar tema escuro após 18h</span>
                                  </div>
                                  <label class="prf-toggle">
                                      <input type="checkbox">
                                      <span class="prf-toggle-slider"></span>
                                  </label>
                              </div>
                              <div class="prf-toggle-item">
                                  <div class="prf-toggle-info">
                                      <span class="prf-toggle-title">Som de Notificação</span>
                                      <span class="prf-toggle-desc">Alerta sonoro para novos eventos</span>
                                  </div>
                                  <label class="prf-toggle">
                                      <input type="checkbox" checked>
                                      <span class="prf-toggle-slider"></span>
                                  </label>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Coluna Direita -->
              <div class="prf-col">
                  <!-- Segurança -->
                  <div class="prf-card">
                      <div class="prf-card-header">
                          <h3 class="prf-card-title">Segurança</h3>
                          <button class="prf-btn-icon" onclick="openModal('modal-seguranca')" title="Gerenciar">
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                              </svg>
                          </button>
                      </div>
                      <div class="prf-card-body">
                          <div class="prf-security-item">
                              <div class="prf-security-info">
                                  <span class="prf-security-title">Senha</span>
                                  <span class="prf-security-desc">Última alteração: 15/03/2026</span>
                              </div>
                              <button class="btn btn-sm btn-outline" onclick="openModal('modal-senha')">Alterar</button>
                          </div>
                          <div class="prf-security-item">
                              <div class="prf-security-info">
                                  <span class="prf-security-title">Autenticação em 2 Fatores (2FA)</span>
                                  <span class="prf-security-desc">Proteção extra via app autenticador</span>
                              </div>
                              <button class="btn btn-sm btn-outline" onclick="openModal('modal-2fa')">Ativar</button>
                          </div>
                          <div class="prf-security-item">
                              <div class="prf-security-info">
                                  <span class="prf-security-title">Sessões Ativas</span>
                                  <span class="prf-security-desc">2 dispositivos conectados</span>
                              </div>
                              <button class="btn btn-sm btn-outline"
                                  onclick="openModal('modal-sessoes')">Gerenciar</button>
                          </div>
                          <div class="prf-security-item">
                              <div class="prf-security-info">
                                  <span class="prf-security-title">Histórico de Acesso</span>
                                  <span class="prf-security-desc">Últimos 30 dias de logins</span>
                              </div>
                              <button class="btn btn-sm btn-outline"
                                  onclick="openModal('modal-historico')">Visualizar</button>
                          </div>
                      </div>
                  </div>

                  <!-- Estatísticas -->
                  <div class="prf-card">
                      <div class="prf-card-header">
                          <h3 class="prf-card-title">Minhas Estatísticas</h3>
                      </div>
                      <div class="prf-card-body">
                          <div class="prf-stats-grid">
                              <div class="prf-stat-item">
                                  <span class="prf-stat-value">1.247</span>
                                  <span class="prf-stat-label">Total de Acessos</span>
                              </div>
                              <div class="prf-stat-item">
                                  <span class="prf-stat-value">45m</span>
                                  <span class="prf-stat-label">Tempo Médio Sessão</span>
                              </div>
                              <div class="prf-stat-item">
                                  <span class="prf-stat-value">3.892</span>
                                  <span class="prf-stat-label">Ações Realizadas</span>
                              </div>
                              <div class="prf-stat-item">
                                  <span class="prf-stat-value">98.5%</span>
                                  <span class="prf-stat-label">Taxa de Atividade</span>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Atividade Recente -->
                  <div class="prf-card">
                      <div class="prf-card-header">
                          <h3 class="prf-card-title">Atividade Recente</h3>
                          <a href="#" class="prf-link" onclick="openModal('modal-historico')">Ver tudo</a>
                      </div>
                      <div class="prf-card-body">
                          <div class="prf-activity-list">
                              <div class="prf-activity-item">
                                  <div class="prf-activity-icon prf-activity-login">
                                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                          <polyline points="10 17 15 12 10 7" />
                                          <line x1="15" x2="3" y1="12" y2="12" />
                                      </svg>
                                  </div>
                                  <div class="prf-activity-info">
                                      <span class="prf-activity-title">Login realizado</span>
                                      <span class="prf-activity-desc">Chrome 124 • Windows 11</span>
                                  </div>
                                  <span class="prf-activity-time">Hoje, 12:30</span>
                              </div>
                              <div class="prf-activity-item">
                                  <div class="prf-activity-icon prf-activity-edit">
                                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                      </svg>
                                  </div>
                                  <div class="prf-activity-info">
                                      <span class="prf-activity-title">Usuário editado</span>
                                      <span class="prf-activity-desc">Fernando Silva (USR-002)</span>
                                  </div>
                                  <span class="prf-activity-time">Hoje, 11:15</span>
                              </div>
                              <div class="prf-activity-item">
                                  <div class="prf-activity-icon prf-activity-create">
                                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <path d="M5 12h14" />
                                          <path d="M12 5v14" />
                                      </svg>
                                  </div>
                                  <div class="prf-activity-info">
                                      <span class="prf-activity-title">Novo usuário criado</span>
                                      <span class="prf-activity-desc">Roberto Santos (USR-005)</span>
                                  </div>
                                  <span class="prf-activity-time">Ontem, 14:32</span>
                              </div>
                              <div class="prf-activity-item">
                                  <div class="prf-activity-icon prf-activity-config">
                                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                          stroke="currentColor" stroke-width="2">
                                          <path d="M12 20h9" />
                                          <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                      </svg>
                                  </div>
                                  <div class="prf-activity-info">
                                      <span class="prf-activity-title">Configuração alterada</span>
                                      <span class="prf-activity-desc">Tarifa Residencial atualizada</span>
                                  </div>
                                  <span class="prf-activity-time">Ontem, 09:20</span>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <!-- ==================== MODAIS ==================== -->

      <!-- Modal: Editar Perfil -->
      <div class="modal-overlay" id="modal-editar-perfil">
          <form wire:submit.prevent='update' class="modal modal-lg">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                      </svg>
                      Editar Perfil
                  </h3>
                  <button type="button" class="modal-close" onclick="closeModal('modal-editar-perfil')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="prf-form-row">
                      <div class="prf-form-group">
                          <label class="prf-label">Nome Completo *</label>
                          <input type="text" class="prf-input" wire:model='nome_completo'
                              value="Administrador Master" required>
                      </div>
                      <div class="prf-form-group">
                          <label class="prf-label">E-mail *</label>
                          <input type="email" class="prf-input" wire:model='email' value="admin@aquanexus.com.br"
                              required>
                      </div>
                  </div>
                  <div class="prf-form-row">
                      <div class="prf-form-group">
                          <label class="prf-label">Telefone</label>
                          <input type="tel" class="prf-input" wire:model='telefone' value="(11) 99999-9999">
                      </div>
                      <div class="prf-form-group">
                          <label class="prf-label">Matrícula</label>
                          <input type="text" class="prf-input" disabled value="USR-001" readonly
                              style="background: var(--neutral); font-family: monospace;">
                      </div>
                  </div>
                  <div class="prf-form-row">
                      <div class="prf-form-group">
                          <label class="prf-label">Perfil</label>
                          <input type="text" class="prf-input" wire:model='perfil' value="Super Administrador"
                              readonly style="background: var(--neutral);">
                          <span class="prf-hint">O perfil só pode ser alterado por outro Super Admin</span>
                      </div>
                      <div class="prf-form-group">
                          <label class="prf-label">Zona de Atuação</label>
                          <select class="prf-select" wire:model='zona'>
                              <option value="Todas as Zonas">Todas as Zonas</option>
                              <option value="Zona Norte">Zona Norte</option>
                              <option value="Zona Sul">Zona Sul</option>
                              <option value="Zona Leste">Zona Leste</option>
                              <option value="Zona Oeste">Zona Oeste</option>
                              <option value="Centro">Centro</option>
                          </select>
                      </div>
                  </div>
                  <div class="prf-form-group">
                      <label class="prf-label">Biografia / Observações</label>
                      <textarea wire:model='bibliografia' class="prf-textarea" rows="3"
                          placeholder="Informações adicionais sobre você...">Administrador responsável pela gestão geral do sistema AquaNexus desde janeiro de 2026.</textarea>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline"
                      onclick="closeModal('modal-editar-perfil')">Cancelar</button>
                  <button type="submit" class="btn btn-primary">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Salvar Alterações
                  </button>
              </div>
          </form>
      </div>

      <!-- Modal: Alterar Foto -->
      <div class="modal-overlay" id="modal-foto">
          <div class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                          <circle cx="8.5" cy="8.5" r="1.5" />
                          <polyline points="21 15 16 10 5 21" />
                      </svg>
                      Alterar Foto de Perfil
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-foto')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="prf-upload-area" id="prf-upload-area">
                      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)"
                          stroke-width="1.5">
                          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                          <polyline points="17 8 12 3 7 8" />
                          <line x1="12" x2="12" y1="3" y2="15" />
                      </svg>
                      <span class="prf-upload-title">Arraste uma foto ou clique para selecionar</span>
                      <span class="prf-upload-desc">JPG, PNG • Máx. 2 MB • Recomendado: 400x400px</span>
                      <input type="file" id="prf-foto-input" accept=".jpg,.jpeg,.png" style="display: none;">
                  </div>
                  <div class="prf-avatar-preview-wrap">
                      <div class="prf-avatar-preview">AD</div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-foto')">Cancelar</button>
                  <button class="btn btn-danger" onclick="removerFoto()">Remover Foto</button>
                  <button class="btn btn-primary" onclick="salvarFoto()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Salvar Foto
                  </button>
              </div>
          </div>
      </div>

      <!-- Modal: Alterar Senha -->
      <div class="modal-overlay" id="modal-senha" wire:ignore.self>
          <form wire:submit.prevent='senha' class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                          <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                      </svg>
                      Alterar Senha
                  </h3>
                  <button type="button" class="modal-close" onclick="closeModal('modal-senha')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="prf-form-group">
                      <label class="prf-label">Senha Atual *</label>
                      <input type="password" wire:model='senha_antiga' class="prf-input"
                          placeholder="Digite sua senha atual" required>
                  </div>
                  <div class="prf-form-group">
                      <label class="prf-label">Nova Senha *</label>
                      <input type="password" wire:model='password' class="prf-input" placeholder="Mínimo 8 caracteres"
                          required id="prf-nova-senha">
                      <div class="prf-strength-bar">
                          <div class="prf-strength-fill" id="prf-strength-fill"></div>
                      </div>
                      <span class="prf-hint" id="prf-strength-text">Força da senha</span>
                  </div>
                  <div class="prf-form-group">
                      <label class="prf-label">Confirmar Nova Senha *</label>
                      <input type="password" class="prf-input" placeholder="Repita a nova senha" required>
                  </div>
                  <div class="prf-senha-requisitos">
                      <span class="prf-req-item" id="prf-req-min">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2">
                              <circle cx="12" cy="12" r="10" />
                          </svg>
                          Mínimo 8 caracteres
                      </span>
                      <span class="prf-req-item" id="prf-req-maius">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2">
                              <circle cx="12" cy="12" r="10" />
                          </svg>
                          Letra maiúscula
                      </span>
                      <span class="prf-req-item" id="prf-req-num">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2">
                              <circle cx="12" cy="12" r="10" />
                          </svg>
                          Número
                      </span>
                      <span class="prf-req-item" id="prf-req-esp">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2">
                              <circle cx="12" cy="12" r="10" />
                          </svg>
                          Caractere especial
                      </span>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline" onclick="closeModal('modal-senha')">Cancelar</button>
                  <button type="submit" class="btn btn-primary">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Alterar Senha
                  </button>
              </div>
          </form>
      </div>

      <!-- Modal: Ativar 2FA -->
      <div class="modal-overlay" id="modal-2fa">
          <div class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                      </svg>
                      Autenticação em 2 Fatores
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-2fa')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="prf-2fa-steps">
                      <div class="prf-2fa-step">
                          <div class="prf-2fa-step-num">1</div>
                          <div class="prf-2fa-step-content">
                              <span class="prf-2fa-step-title">Instale um app autenticador</span>
                              <span class="prf-2fa-step-desc">Google Authenticator, Authy ou Microsoft
                                  Authenticator</span>
                          </div>
                      </div>
                      <div class="prf-2fa-step">
                          <div class="prf-2fa-step-num">2</div>
                          <div class="prf-2fa-step-content">
                              <span class="prf-2fa-step-title">Escaneie o QR Code</span>
                              <div class="prf-qr-code">
                                  <svg width="160" height="160" viewBox="0 0 160 160">
                                      <rect width="160" height="160" fill="white" />
                                      <rect x="10" y="10" width="50" height="50" fill="#003366" />
                                      <rect x="15" y="15" width="40" height="40" fill="white" />
                                      <rect x="20" y="20" width="30" height="30" fill="#003366" />
                                      <rect x="100" y="10" width="50" height="50" fill="#003366" />
                                      <rect x="105" y="15" width="40" height="40" fill="white" />
                                      <rect x="110" y="20" width="30" height="30" fill="#003366" />
                                      <rect x="10" y="100" width="50" height="50" fill="#003366" />
                                      <rect x="15" y="105" width="40" height="40" fill="white" />
                                      <rect x="20" y="110" width="30" height="30" fill="#003366" />
                                      <rect x="70" y="10" width="20" height="20" fill="#003366" />
                                      <rect x="70" y="40" width="20" height="20" fill="#003366" />
                                      <rect x="70" y="70" width="20" height="20" fill="#003366" />
                                      <rect x="100" y="70" width="20" height="20" fill="#003366" />
                                      <rect x="130" y="70" width="20" height="20" fill="#003366" />
                                      <rect x="100" y="100" width="50" height="10" fill="#003366" />
                                      <rect x="100" y="120" width="30" height="10" fill="#003366" />
                                      <rect x="140" y="120" width="10" height="30" fill="#003366" />
                                      <rect x="70" y="100" width="20" height="50" fill="#003366" />
                                      <rect x="10" y="70" width="50" height="10" fill="#003366" />
                                      <rect x="40" y="85" width="10" height="10" fill="#003366" />
                                  </svg>
                              </div>
                              <span class="prf-hint" style="text-align: center; display: block;">Ou digite manualmente:
                                  <code
                                      style="background: var(--neutral); padding: 2px 6px; border-radius: 4px; font-family: monospace;">JBSW
                                      Y3DP EHPK 3PXP</code></span>
                          </div>
                      </div>
                      <div class="prf-2fa-step">
                          <div class="prf-2fa-step-num">3</div>
                          <div class="prf-2fa-step-content">
                              <span class="prf-2fa-step-title">Digite o código de verificação</span>
                              <div class="prf-2fa-code-input">
                                  <input type="text" class="prf-input" maxlength="6" placeholder="000000"
                                      style="text-align: center; letter-spacing: 0.5em; font-size: 1.25rem; width: 140px;">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-2fa')">Cancelar</button>
                  <button class="btn btn-primary" onclick="ativar2FA()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Ativar 2FA
                  </button>
              </div>
          </div>
      </div>

      <!-- Modal: Gerenciar Sessões -->
      <div class="modal-overlay" id="modal-sessoes">
          <div class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                          <line x1="8" x2="16" y1="21" y2="21" />
                          <line x1="12" x2="12" y1="17" y2="21" />
                      </svg>
                      Sessões Ativas
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-sessoes')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="prf-sessao-list">
                      <div class="prf-sessao-item prf-sessao-atual">
                          <div class="prf-sessao-info">
                              <div class="prf-sessao-device">
                                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                      stroke="currentColor" stroke-width="2">
                                      <rect width="18" height="12" x="3" y="4" rx="2" ry="2" />
                                      <line x1="2" x2="22" y1="20" y2="20" />
                                  </svg>
                              </div>
                              <div class="prf-sessao-details">
                                  <div class="prf-sessao-name">Chrome 124 • Windows 11</div>
                                  <div class="prf-sessao-meta">IP: 192.168.1.105 • Iniciada: 08/05/2026 08:30</div>
                              </div>
                          </div>
                          <span class="prf-sessao-tag">Atual</span>
                      </div>
                      <div class="prf-sessao-item">
                          <div class="prf-sessao-info">
                              <div class="prf-sessao-device">
                                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                      stroke="currentColor" stroke-width="2">
                                      <rect width="14" height="20" x="5" y="2" rx="2" ry="2" />
                                      <path d="M12 18h.01" />
                                  </svg>
                              </div>
                              <div class="prf-sessao-details">
                                  <div class="prf-sessao-name">Safari • iPhone 15 Pro</div>
                                  <div class="prf-sessao-meta">IP: 201.45.78.92 • Iniciada: 07/05/2026 14:15</div>
                              </div>
                          </div>
                          <button class="btn btn-sm btn-danger" onclick="encerrarSessao(this)">
                              <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <path d="M18 6 6 18" />
                                  <path d="m6 6 12 12" />
                              </svg>
                              Encerrar
                          </button>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-sessoes')">Fechar</button>
                  <button class="btn btn-danger" onclick="encerrarTodasSessoes()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                      Encerrar Todas (exceto atual)
                  </button>
              </div>
          </div>
      </div>

      <!-- Modal: Histórico de Acesso -->
      <div class="modal-overlay" id="modal-historico">
          <div class="modal modal-lg">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <circle cx="12" cy="12" r="10" />
                          <polyline points="12 6 12 12 16 14" />
                      </svg>
                      Histórico de Acesso
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-historico')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="prf-historico-list">
                      <div class="prf-historico-item">
                          <div class="prf-historico-icon prf-historico-success">
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                  <polyline points="22 4 12 14.01 9 11.01" />
                              </svg>
                          </div>
                          <div class="prf-historico-info">
                              <span class="prf-historico-title">Login bem-sucedido</span>
                              <span class="prf-historico-desc">Chrome 124 • Windows 11 • IP: 192.168.1.105</span>
                          </div>
                          <span class="prf-historico-time">08/05/2026 12:30</span>
                      </div>
                      <div class="prf-historico-item">
                          <div class="prf-historico-icon prf-historico-success">
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                  <polyline points="22 4 12 14.01 9 11.01" />
                              </svg>
                          </div>
                          <div class="prf-historico-info">
                              <span class="prf-historico-title">Login bem-sucedido</span>
                              <span class="prf-historico-desc">Safari • iPhone 15 Pro • IP: 201.45.78.92</span>
                          </div>
                          <span class="prf-historico-time">07/05/2026 14:15</span>
                      </div>
                      <div class="prf-historico-item">
                          <div class="prf-historico-icon prf-historico-fail">
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <circle cx="12" cy="12" r="10" />
                                  <line x1="15" x2="9" y1="9" y2="15" />
                                  <line x1="9" x2="15" y1="9" y2="15" />
                              </svg>
                          </div>
                          <div class="prf-historico-info">
                              <span class="prf-historico-title">Tentativa de login falhou</span>
                              <span class="prf-historico-desc">Firefox • Windows 10 • IP: 45.67.89.12</span>
                          </div>
                          <span class="prf-historico-time">06/05/2026 22:40</span>
                      </div>
                      <div class="prf-historico-item">
                          <div class="prf-historico-icon prf-historico-success">
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                  <polyline points="22 4 12 14.01 9 11.01" />
                              </svg>
                          </div>
                          <div class="prf-historico-info">
                              <span class="prf-historico-title">Login bem-sucedido</span>
                              <span class="prf-historico-desc">Chrome 124 • Windows 11 • IP: 192.168.1.105</span>
                          </div>
                          <span class="prf-historico-time">06/05/2026 08:15</span>
                      </div>
                      <div class="prf-historico-item">
                          <div class="prf-historico-icon prf-historico-logout">
                              <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2">
                                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                  <polyline points="16 17 21 12 16 7" />
                                  <line x1="21" x2="9" y1="12" y2="12" />
                              </svg>
                          </div>
                          <div class="prf-historico-info">
                              <span class="prf-historico-title">Logout</span>
                              <span class="prf-historico-desc">Chrome 124 • Windows 11 • IP: 192.168.1.105</span>
                          </div>
                          <span class="prf-historico-time">05/05/2026 18:30</span>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-historico')">Fechar</button>
                  <button class="btn btn-primary" onclick="exportarHistorico()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                          <polyline points="7 10 12 15 17 10" />
                          <line x1="12" x2="12" y1="15" y2="3" />
                      </svg>
                      Exportar CSV
                  </button>
              </div>
          </div>
      </div>

      <!-- Modal: Editar Endereço -->
      <div class="modal-overlay" id="modal-endereco">
          <div class="modal">
              <div class="modal-header">
                  <h3 class="modal-title">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                          <circle cx="12" cy="10" r="3" />
                      </svg>
                      Editar Endereço
                  </h3>
                  <button class="modal-close" onclick="closeModal('modal-endereco')">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M18 6 6 18" />
                          <path d="m6 6 12 12" />
                      </svg>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="prf-form-row">
                      <div class="prf-form-group">
                          <label class="prf-label">CEP</label>
                          <input type="text" class="prf-input" value="01000-000" id="prf-cep" maxlength="9">
                      </div>
                      <div class="prf-form-group">
                          <label class="prf-label">Cidade/UF</label>
                          <input type="text" class="prf-input" value="São Paulo - SP">
                      </div>
                  </div>
                  <div class="prf-form-group">
                      <label class="prf-label">Logradouro</label>
                      <input type="text" class="prf-input" value="Av. das Águas, 1000">
                  </div>
                  <div class="prf-form-row">
                      <div class="prf-form-group">
                          <label class="prf-label">Bairro</label>
                          <input type="text" class="prf-input" value="Centro">
                      </div>
                      <div class="prf-form-group">
                          <label class="prf-label">Complemento</label>
                          <input type="text" class="prf-input" placeholder="Apto, Sala, etc.">
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline" onclick="closeModal('modal-endereco')">Cancelar</button>
                  <button class="btn btn-primary" onclick="salvarEndereco()">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M20 6 9 17l-5-5" />
                      </svg>
                      Salvar Endereço
                  </button>
              </div>
          </div>
      </div>

      <!-- Toast Container -->
      <div id="toast-container"
          style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: var(--space-sm);">
      </div>
      <script>
          // ======== PERFIL ========
          function salvarPerfil() {
              closeModal('modal-editar-perfil');
              showToast('Perfil atualizado com sucesso!', 'success');
          }

          // ======== FOTO ========
          document.getElementById('prf-upload-area').addEventListener('click', function() {
              document.getElementById('prf-foto-input').click();
          });

          document.getElementById('prf-foto-input').addEventListener('change', function(e) {
              if (e.target.files.length > 0) {
                  showToast('Foto "' + e.target.files[0].name + '" selecionada.', 'success');
              }
          });

          function salvarFoto() {
              closeModal('modal-foto');
              showToast('Foto de perfil atualizada!', 'success');
          }

          function removerFoto() {
              confirmDelete('Remover foto de perfil? Será usado o avatar com as iniciais.', function() {
                  closeModal('modal-foto');
                  showToast('Foto removida.', 'warning');
              });
          }

          // Drag and drop foto
          const fotoArea = document.getElementById('prf-upload-area');
          if (fotoArea) {
              fotoArea.addEventListener('dragover', (e) => {
                  e.preventDefault();
                  fotoArea.classList.add('prf-upload-dragover');
              });
              fotoArea.addEventListener('dragleave', () => {
                  fotoArea.classList.remove('prf-upload-dragover');
              });
              fotoArea.addEventListener('drop', (e) => {
                  e.preventDefault();
                  fotoArea.classList.remove('prf-upload-dragover');
                  if (e.dataTransfer.files.length > 0) {
                      showToast('Foto "' + e.dataTransfer.files[0].name + '" recebida.', 'success');
                  }
              });
          }

          // ======== SENHA ========
          document.getElementById('prf-nova-senha').addEventListener('input', function() {
              const val = this.value;
              const fill = document.getElementById('prf-strength-fill');
              const text = document.getElementById('prf-strength-text');

              let score = 0;
              if (val.length >= 8) score++;
              if (/[A-Z]/.test(val)) score++;
              if (/[0-9]/.test(val)) score++;
              if (/[^A-Za-z0-9]/.test(val)) score++;

              const widths = ['0%', '25%', '50%', '75%', '100%'];
              const colors = ['var(--neutral-darker)', 'var(--danger)', 'var(--warning)', '#2563eb',
                  'var(--success)'
              ];
              const labels = ['Muito fraca', 'Fraca', 'Média', 'Boa', 'Excelente'];

              fill.style.width = widths[score];
              fill.style.background = colors[score];
              text.textContent = 'Força: ' + labels[score];
              text.style.color = colors[score];

              // Check requisitos
              document.getElementById('prf-req-min').classList.toggle('prf-req-ok', val.length >= 8);
              document.getElementById('prf-req-maius').classList.toggle('prf-req-ok', /[A-Z]/.test(val));
              document.getElementById('prf-req-num').classList.toggle('prf-req-ok', /[0-9]/.test(val));
              document.getElementById('prf-req-esp').classList.toggle('prf-req-ok', /[^A-Za-z0-9]/.test(val));
          });

          function salvarSenha() {
              closeModal('modal-senha');
              showToast('Senha alterada com sucesso! Use a nova senha no próximo login.', 'success');
          }

          // ======== 2FA ========
          function ativar2FA() {
              closeModal('modal-2fa');
              showToast('2FA ativado com sucesso! Escaneie o QR code no próximo login.', 'success');
          }

          // ======== SESSÕES ========
          function encerrarSessao(btn) {
              const item = btn.closest('.prf-sessao-item');
              item.style.opacity = '0.5';
              btn.disabled = true;
              btn.innerHTML =
                  '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Encerrado';
              showToast('Sessão encerrada com sucesso.', 'success');
          }

          function encerrarTodasSessoes() {
              confirmDelete('Encerrar todas as outras sessões? Você permanecerá logado apenas neste dispositivo.',
                  function() {
                      document.querySelectorAll('.prf-sessao-item:not(.prf-sessao-atual)').forEach(item => {
                          item.style.transition = 'all 0.3s';
                          item.style.opacity = '0';
                          item.style.transform = 'translateX(20px)';
                          setTimeout(() => item.remove(), 300);
                      });
                      closeModal('modal-sessoes');
                      showToast('Todas as outras sessões foram encerradas.', 'success');
                  });
          }

          // ======== HISTÓRICO ========
          function exportarHistorico() {
              showToast('Exportando histórico de acesso...', 'success');
              setTimeout(() => showToast('Download iniciado: historico_acesso_20260508.csv', 'success'), 1500);
          }

          // ======== ENDEREÇO ========
          document.getElementById('prf-cep').addEventListener('input', function(e) {
              let value = e.target.value.replace(/\D/g, '');
              if (value.length > 8) value = value.slice(0, 8);
              if (value.length > 5) value = value.slice(0, 5) + '-' + value.slice(5);
              e.target.value = value;
          });

          function salvarEndereco() {
              closeModal('modal-endereco');
              showToast('Endereço atualizado com sucesso!', 'success');
          }
      </script>
  @endsection
