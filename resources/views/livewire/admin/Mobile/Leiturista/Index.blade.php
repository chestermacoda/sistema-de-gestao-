  <link rel="stylesheet" href="{{ asset('assets/css/leituristaApp.css') }}">
  <div class="app-mobile">
      <!-- HEADER -->
      <header class="mobile-header">
          <div class="mobile-header-top">
              <div class="mobile-header-info">
                  <div class="mobile-avatar">JL</div>
                  <div class="mobile-user-info">
                      <h2>{{ Auth()->user()->zona }}</h2>
                      <p>Leiturista • {{ Auth()->user()->zona }}</p>
                  </div>
              </div>
              <div class="mobile-header-actions">
                  <button class="mobile-icon-btn" onclick="showToast('Sincronizando...', 'warning')">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                          <path d="M3 3v5h5" />
                          <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                          <path d="M16 21h5v-5" />
                      </svg>
                  </button>
                  <button class="mobile-icon-btn" onclick="showToast('3 notificações pendentes', 'warning')">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                          <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                      </svg>
                      <span class="badge">{{ $pendente }}</span>
                  </button>
              </div>
          </div>
          <div class="mobile-resumo">
              <div class="mobile-resumo-card">
                  <div class="mobile-resumo-valor">{{ $pendente }}</div>
                  <div class="mobile-resumo-label">Pendentes</div>
              </div>
              <div class="mobile-resumo-card">
                  <div class="mobile-resumo-valor">{{ $concluidos }}</div>
                  <div class="mobile-resumo-label">Concluídas</div>
              </div>
              <div class="mobile-resumo-card">
                  <div class="mobile-resumo-valor">{{ $total }}</div>
                  <div class="mobile-resumo-label">Total</div>
              </div>
          </div>
      </header>

      <!-- NAVEGAÇÃO POR SEÇÕES (Chips) -->
      <nav class="mobile-nav-sections">
          <button class="mobile-nav-chip active" data-section="roteiro" onclick="switchSection('roteiro')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
                  <rect x="9" y="3" width="6" height="4" rx="2" />
                  <path d="m9 14 2 2 4-4" />
              </svg>
              Roteiro
          </button>
          <button class="mobile-nav-chip" data-section="historico" onclick="switchSection('historico')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M3 3v5h5" />
                  <path d="M3.05 13A9 9 0 1 0 6 5.3L3 8" />
                  <path d="M12 7v5l4 2" />
              </svg>
              Histórico
          </button>
          <button class="mobile-nav-chip" data-section="mapa" onclick="switchSection('mapa')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6" />
                  <line x1="8" x2="8" y1="2" y2="18" />
                  <line x1="16" x2="16" y1="6" y2="22" />
              </svg>
              Mapa
          </button>
          <button class="mobile-nav-chip" data-section="perfil" onclick="switchSection('perfil')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
              </svg>
              Perfil
          </button>
      </nav>

      <!-- CONTEÚDO DAS SEÇÕES -->
      <div class="mobile-sections-container">

          <!-- SEÇÃO: ROTEIRO -->

          <livewire:admin.mobile.leiturista.lroteiro />


          <!-- SEÇÃO: HISTÓRICO -->

          <livewire:admin.mobile.leiturista.historico />
          <!-- SEÇÃO: MAPA -->
          <section class="mobile-section" id="section-mapa">
              <div class="mapa-container">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                      <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6" />
                      <line x1="8" x2="8" y1="2" y2="18" />
                      <line x1="16" x2="16" y1="6" y2="22" />
                  </svg>
                  <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary);">Mapa do Roteiro</h3>
                  <p
                      style="font-size: var(--label-size); color: var(--text-muted); text-align: center; padding: 0 var(--space-lg);">
                      Visualize os medidores próximos à sua localização atual</p>
                  <button class="mobile-btn-primary"
                      style="width: auto; padding: var(--space-sm) var(--space-lg); margin-top: var(--space-md);">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <circle cx="12" cy="12" r="10" />
                          <path d="M12 16v-4" />
                          <path d="M12 8h.01" />
                      </svg>
                      Ativar Localização
                  </button>
              </div>

              <div class="mapa-lista-proximos">
                  <h3 class="mapa-lista-title">Próximos a Você</h3>

                  <div class="roteiro-card"
                      onclick="openLeituraSheet('Rua das Flores, 123', 'Maria Silva', 'M-2024-001234', 1250)">
                      <div class="roteiro-card-header">
                          <div class="roteiro-numero" style="background: var(--tertiary);">1</div>
                          <div class="roteiro-endereco-info">
                              <div class="roteiro-endereco">Rua das Flores, 123</div>
                              <div class="roteiro-cliente">Maria Silva • 150m</div>
                          </div>
                      </div>
                      <div class="roteiro-card-footer">
                          <span class="roteiro-status pendente">
                              <span class="roteiro-status-dot"></span>
                              Pendente
                          </span>
                          <span style="font-size: var(--small-size); color: var(--tertiary); font-weight: 600;">📍
                              150m</span>
                      </div>
                  </div>

                  <div class="roteiro-card"
                      onclick="openLeituraSheet('Av. Principal, 456', 'João Santos', 'M-2024-001235', 3420)">
                      <div class="roteiro-card-header">
                          <div class="roteiro-numero" style="background: var(--tertiary);">2</div>
                          <div class="roteiro-endereco-info">
                              <div class="roteiro-endereco">Av. Principal, 456</div>
                              <div class="roteiro-cliente">João Santos • 320m</div>
                          </div>
                      </div>
                      <div class="roteiro-card-footer">
                          <span class="roteiro-status pendente">
                              <span class="roteiro-status-dot"></span>
                              Pendente
                          </span>
                          <span style="font-size: var(--small-size); color: var(--tertiary); font-weight: 600;">📍
                              320m</span>
                      </div>
                  </div>
              </div>
          </section>

          <!-- SEÇÃO: PERFIL -->
          <section class="mobile-section" id="section-perfil">
              <div class="perfil-header">
                  <div class="perfil-avatar-lg">{{ strtoupper(substr(Auth()->user()->name, 0, 2)) }}</div>
                  <div class="perfil-nome">{{ Auth()->user()->name }}</div>
                  <div class="perfil-role">Leiturista • {{ Auth()->user()->zona }}</div>
                  <div class="perfil-stats">
                      <div class="perfil-stat">
                          <div class="perfil-stat-valor">{{ $total }}</div>
                          <div class="perfil-stat-label">Leituras</div>
                      </div>
                      <div class="perfil-stat">
                          <div class="perfil-stat-valor">98.5%</div>
                          <div class="perfil-stat-label">Precisão</div>
                      </div>
                      <div class="perfil-stat">
                          <div class="perfil-stat-valor">4.8</div>
                          <div class="perfil-stat-label">Rating</div>
                      </div>
                  </div>
              </div>

              <div class="perfil-menu">
                  <div class="perfil-menu-item" onclick="openDadosPessoais()">
                      <div class="perfil-menu-icon">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2">
                              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                              <circle cx="12" cy="7" r="4" />
                          </svg>
                      </div>
                      <div class="perfil-menu-info">
                          <div class="perfil-menu-title">Dados Pessoais</div>
                          <div class="perfil-menu-desc">Editar informações do perfil</div>
                      </div>
                      <svg class="perfil-menu-arrow" width="18" height="18" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2">
                          <polyline points="9 18 15 12 9 6" />
                      </svg>
                  </div>
                  {{-- onclick="openConfiguracoes()" --}}
                  <div class="perfil-menu-item">
                      <div class="perfil-menu-icon">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2">
                              <path
                                  d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                              <circle cx="12" cy="12" r="3" />
                          </svg>
                      </div>
                      <div class="perfil-menu-info">
                          <div class="perfil-menu-title">Configurações</div>
                          <div class="perfil-menu-desc">Preferências do aplicativo</div>
                      </div>
                      <svg class="perfil-menu-arrow" width="18" height="18" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2">
                          <polyline points="9 18 15 12 9 6" />
                      </svg>
                  </div>
                  {{-- onclick="openSuporte()" --}}
                  <div class="perfil-menu-item">
                      <div class="perfil-menu-icon">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2">
                              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                          </svg>
                      </div>
                      <div class="perfil-menu-info">
                          <div class="perfil-menu-title">Suporte</div>
                          <div class="perfil-menu-desc">Falar com o administrador</div>
                      </div>
                      <svg class="perfil-menu-arrow" width="18" height="18" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2">
                          <polyline points="9 18 15 12 9 6" />
                      </svg>
                  </div>
                  <div class="perfil-menu-item" onclick="openSair()">
                      <div class="perfil-menu-icon" style="background: var(--danger-light); color: var(--danger);">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2">
                              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                              <polyline points="16 17 21 12 16 7" />
                              <line x1="21" x2="9" y1="12" y2="12" />
                          </svg>
                      </div>
                      <div class="perfil-menu-info">
                          <div class="perfil-menu-title" style="color: var(--danger);">Sair da Conta</div>
                          <div class="perfil-menu-desc">Encerrar sessão atual</div>
                      </div>
                      <svg class="perfil-menu-arrow" width="18" height="18" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2">
                          <polyline points="9 18 15 12 9 6" />
                      </svg>
                  </div>
              </div>

              <div
                  style="text-align: center; padding: var(--space-lg); color: var(--text-muted); font-size: var(--small-size);">
                  AquaNexus v2.4.1<br>
                  Sincronizado: 08/05/2026 14:30
              </div>
          </section>


      </div>

      <!-- BOTTOM NAVIGATION -->
      <nav class="mobile-bottom-nav">
          <button class="mobile-nav-item active" data-nav="roteiro" onclick="switchSection('roteiro')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 20-2h-2" />
                  <rect x="9" y="3" width="6" height="4" rx="2" />
                  <path d="m9 14 2 2 4-4" />
              </svg>
              Roteiro
          </button>
          <button class="mobile-nav-item" data-nav="historico" onclick="switchSection('historico')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M3 3v5h5" />
                  <path d="M3.05 13A9 9 0 1 0 6 5.3L3 8" />
                  <path d="M12 7v5l4 2" />
              </svg>
              Histórico
          </button>
          <button class="mobile-nav-item" data-nav="mapa" onclick="switchSection('mapa')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6" />
                  <line x1="8" x2="8" y1="2" y2="18" />
                  <line x1="16" x2="16" y1="6" y2="22" />
              </svg>
              Mapa
          </button>
          <button class="mobile-nav-item" data-nav="perfil" onclick="switchSection('perfil')">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
              </svg>
              Perfil
          </button>
      </nav>

      <!-- FLOATING ACTION BUTTON -->
      <button class="mobile-fab" id="fabBtn" onclick="showToast('Câmera do medidor', 'success')">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2">
              <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
              <circle cx="12" cy="13" r="4" />
          </svg>
      </button>


      <!-- TOAST NOTIFICATION -->
      <div class="mobile-toast" id="mobileToast">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" id="toastIcon">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
              <polyline points="22 4 12 14.01 9 11.01" />
          </svg>
          <span id="toastMessage">Operação realizada com sucesso!</span>
      </div>






      <!-- ===== MODAL: CONFIGURAÇÕES ===== -->
      <div class="leitura-sheet-overlay" id="modalConfigOverlay" onclick="closeModal('modalConfig')"></div>
      <div class="leitura-sheet" id="modalConfig" style="max-height: 90vh;">
          <div class="leitura-sheet-handle"></div>
          <div class="leitura-sheet-header">
              <span class="leitura-sheet-title">Configurações</span>
              <button class="leitura-sheet-close" onclick="closeModal('modalConfig')">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2">
                      <line x1="18" x2="6" y1="6" y2="18" />
                      <line x1="6" x2="18" y1="6" y2="18" />
                  </svg>
              </button>
          </div>
          <div class="leitura-sheet-body">
              <!-- Notificações -->
              <div style="margin-bottom: var(--space-lg);">
                  <h4
                      style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                      Notificações</h4>

                  <div class="cfg-toggle-list">
                      <div class="cfg-toggle-item">
                          <div class="cfg-toggle-info">
                              <div class="cfg-toggle-title">Novas Leituras</div>
                              <div class="cfg-toggle-desc">Alerta quando houver novas leituras no roteiro</div>
                          </div>
                          <label class="cfg-toggle">
                              <input type="checkbox" checked>
                              <span class="cfg-toggle-slider"></span>
                          </label>
                      </div>
                      <div class="cfg-toggle-item">
                          <div class="cfg-toggle-info">
                              <div class="cfg-toggle-title">Anomalias</div>
                              <div class="cfg-toggle-desc">Notificar consumos fora da média</div>
                          </div>
                          <label class="cfg-toggle">
                              <input type="checkbox" checked>
                              <span class="cfg-toggle-slider"></span>
                          </label>
                      </div>
                      <div class="cfg-toggle-item">
                          <div class="cfg-toggle-info">
                              <div class="cfg-toggle-title">Sincronização</div>
                              <div class="cfg-toggle-desc">Aviso quando sincronizar com o servidor</div>
                          </div>
                          <label class="cfg-toggle">
                              <input type="checkbox">
                              <span class="cfg-toggle-slider"></span>
                          </label>
                      </div>
                  </div>
              </div>

              <!-- Aparência -->
              <div style="margin-bottom: var(--space-lg);">
                  <h4
                      style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                      Aparência</h4>

                  <div class="cfg-theme-selector">
                      <div class="cfg-theme-option cfg-theme-active" onclick="selectTheme(this)">
                          <div class="cfg-theme-preview cfg-theme-light"></div>
                          <span>Claro</span>
                      </div>
                      <div class="cfg-theme-option" onclick="selectTheme(this)">
                          <div class="cfg-theme-preview cfg-theme-dark"></div>
                          <span>Escuro</span>
                      </div>
                      <div class="cfg-theme-option" onclick="selectTheme(this)">
                          <div class="cfg-theme-preview cfg-theme-auto"></div>
                          <span>Auto</span>
                      </div>
                  </div>
              </div>

              <!-- Dados -->
              <div style="margin-bottom: var(--space-lg);">
                  <h4
                      style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                      Dados e Armazenamento</h4>

                  <div class="cfg-toggle-list">
                      <div class="cfg-toggle-item">
                          <div class="cfg-toggle-info">
                              <div class="cfg-toggle-title">Modo Offline</div>
                              <div class="cfg-toggle-desc">Guardar leituras localmente sem internet</div>
                          </div>
                          <label class="cfg-toggle">
                              <input type="checkbox" checked>
                              <span class="cfg-toggle-slider"></span>
                          </label>
                      </div>
                      <div class="cfg-toggle-item">
                          <div class="cfg-toggle-info">
                              <div class="cfg-toggle-title">Fotos em Alta Resolução</div>
                              <div class="cfg-toggle-desc">Qualidade máxima para fotos dos medidores</div>
                          </div>
                          <label class="cfg-toggle">
                              <input type="checkbox">
                              <span class="cfg-toggle-slider"></span>
                          </label>
                      </div>
                  </div>

                  <div
                      style="margin-top: var(--space-md); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md); display: flex; justify-content: space-between; align-items: center;">
                      <div>
                          <div style="font-size: var(--label-size); font-weight: 600; color: var(--text-primary);">
                              Cache
                              do Aplicativo</div>
                          <div style="font-size: var(--small-size); color: var(--text-muted);">245 MB utilizados</div>
                      </div>
                      <button class="cfg-btn-text"
                          onclick="showToast('Cache limpo com sucesso!', 'success')">Limpar</button>
                  </div>
              </div>

              <button class="mobile-btn-primary" onclick="salvarConfiguracoes()">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2">
                      <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                      <polyline points="17 21 17 13 7 13 7 21" />
                      <polyline points="7 3 7 8 15 8" />
                  </svg>
                  Salvar Configurações
              </button>
          </div>
      </div>

      <!-- ===== MODAL: SUPORTE ===== -->
      <div class="leitura-sheet-overlay" id="modalSuporteOverlay" onclick="closeModal('modalSuporte')"></div>
      <div class="leitura-sheet" id="modalSuporte" style="max-height: 90vh;">
          <div class="leitura-sheet-handle"></div>
          <div class="leitura-sheet-header">
              <span class="leitura-sheet-title">Suporte Técnico</span>
              <button class="leitura-sheet-close" onclick="closeModal('modalSuporte')">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2">
                      <line x1="18" x2="6" y1="6" y2="18" />
                      <line x1="6" x2="18" y1="6" y2="18" />
                  </svg>
              </button>
          </div>
          <div class="leitura-sheet-body">
              <!-- Opções Rápidas -->
              <div
                  style="display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--space-md); margin-bottom: var(--space-lg);">
                  <button class="cfg-integration-item"
                      onclick="showToast('Chat iniciado com Administrador', 'success')">
                      <div class="cfg-integration-icon" style="background: var(--primary); color: var(--white);">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2">
                              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                          </svg>
                      </div>
                      <div class="cfg-integration-info">
                          <div class="cfg-integration-name">Chat Direto</div>
                          <div class="cfg-integration-desc">Falar com admin</div>
                      </div>
                  </button>
                  <button class="cfg-integration-item" onclick="showToast('Guia de uso aberto', 'success')">
                      <div class="cfg-integration-icon" style="background: var(--tertiary); color: var(--white);">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2">
                              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                          </svg>
                      </div>
                      <div class="cfg-integration-info">
                          <div class="cfg-integration-name">Manual</div>
                          <div class="cfg-integration-desc">Guia do leiturista</div>
                      </div>
                  </button>
              </div>

              <!-- Formulário de Contato -->
              <div style="margin-bottom: var(--space-lg);">
                  <h4
                      style="font-size: var(--label-size); font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-md);">
                      Enviar Mensagem</h4>

                  <div class="form-group">
                      <label class="form-label">Assunto</label>
                      <select class="form-select" id="suporteAssunto">
                          <option value="">Selecione...</option>
                          <option value="medidor">Problema com Medidor</option>
                          <option value="app">Erro no Aplicativo</option>
                          <option value="roteiro">Roteiro Incorreto</option>
                          <option value="outro">Outro Assunto</option>
                      </select>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Mensagem</label>
                      <textarea class="form-textarea" rows="4" placeholder="Descreva o problema ou dúvida..." id="suporteMensagem"></textarea>
                  </div>

                  <div class="form-group">
                      <label class="form-label">Anexar Foto (opcional)</label>
                      <div class="cfg-upload-area" onclick="showToast('Galeria de fotos aberta', 'success')">
                          <div class="cfg-logo-preview-lg">
                              <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                  stroke="currentColor" stroke-width="2" style="color: var(--text-muted);">
                                  <path
                                      d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                                  <circle cx="12" cy="13" r="4" />
                              </svg>
                          </div>
                          <div class="cfg-upload-title">Toque para anexar</div>
                          <div class="cfg-upload-desc">Fotos do medidor ou problema</div>
                      </div>
                  </div>
              </div>

              <button class="mobile-btn-primary" onclick="enviarSuporte()">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2">
                      <line x1="22" x2="11" y1="2" y2="13" />
                      <polygon points="22 2 15 22 11 13 2 9 22 2" />
                  </svg>
                  Enviar para Suporte
              </button>

              <!-- Info de Contato -->
              <div
                  style="margin-top: var(--space-lg); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md); text-align: center;">
                  <div style="font-size: var(--small-size); color: var(--text-muted); margin-bottom: var(--space-xs);">
                      Suporte Emergencial</div>
                  <div style="font-size: var(--body-size); font-weight: 700; color: var(--primary);">+351 800 123 456
                  </div>
                  <div style="font-size: var(--small-size); color: var(--text-muted); margin-top: var(--space-xs);">
                      suporte@aquanexus.pt</div>
              </div>
          </div>
      </div>

      <!-- ===== MODAL: SAIR DO SISTEMA ===== -->
      <div class="leitura-sheet-overlay" id="modalSairOverlay" onclick="closeModal('modalSair')"></div>
      <div class="leitura-sheet" id="modalSair" style="max-height: 40vh; text-align: center;">
          <div class="leitura-sheet-handle"></div>
          <div class="leitura-sheet-body" style="padding-top: var(--space-xl);">
              <div
                  style="width: 64px; height: 64px; border-radius: 50%; background: var(--danger-light); display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-lg); color: var(--danger);">
                  <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2">
                      <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                      <polyline points="16 17 21 12 16 7" />
                      <line x1="21" x2="9" y1="12" y2="12" />
                  </svg>
              </div>

              <h3
                  style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: var(--space-sm);">
                  Sair da Conta?</h3>
              <p style="font-size: var(--label-size); color: var(--text-muted); margin-bottom: var(--space-xl);">
                  Tem a certeza que deseja encerrar a sessão?<br>
                  <strong style="color: var(--text-primary);">12 leituras pendentes</strong> serão sincronizadas
                  primeiro.
              </p>

              <div style="display: flex; flex-direction: column; gap: var(--space-md);">
                  <form action="{{ route('logout') }}" method="POST">
                      @csrf
                      <button class="mobile-btn-primary" style="background: var(--danger);"
                          onclick="confirmarSaida()">
                          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2">
                              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                              <polyline points="16 17 21 12 16 7" />
                              <line x1="21" x2="9" y1="12" y2="12" />
                          </svg>
                          Sim, Sair da Conta
                      </button>
                  </form>
                  <button class="btn btn-outline" style="justify-content: center;" onclick="closeModal('modalSair')">
                      Cancelar, Ficar Logado
                  </button>
              </div>
          </div>
      </div>
  </div>

  <script>
      // ===== VARIÁVEIS GLOBAIS =====
      let ultimaLeituraAtual = 0;
      let leituraAtual = 0;

      // ===== NAVEGAÇÃO ENTRE SEÇÕES =====
      function switchSection(sectionName) {

          // salvar seção atual
          localStorage.setItem('mobile_section', sectionName);

          // atualizar chips
          document.querySelectorAll('.mobile-nav-chip').forEach(chip => {
              chip.classList.remove('active');

              if (chip.dataset.section === sectionName) {
                  chip.classList.add('active');
              }
          });

          // atualizar bottom nav
          document.querySelectorAll('.mobile-nav-item').forEach(item => {
              item.classList.remove('active');

              if (item.dataset.nav === sectionName) {
                  item.classList.add('active');
              }
          });

          // esconder todas seções
          document.querySelectorAll('.mobile-section').forEach(section => {
              section.classList.remove('active');
          });

          // mostrar seção correta
          const activeSection = document.querySelector(
              `.mobile-section[id="section-${sectionName}"]`
          );

          if (activeSection) {
              activeSection.classList.add('active');
          }

          // FAB
          const fab = document.getElementById('fabBtn');

          if (fab) {
              if (sectionName === 'roteiro' || sectionName === 'mapa') {
                  fab.classList.remove('hidden');
              } else {
                  fab.classList.add('hidden');
              }
          }

          // topo
          window.scrollTo({
              top: 0,
              behavior: 'smooth'
          });
      }

      // ===== INIT =====
      document.addEventListener('DOMContentLoaded', () => {

          // recuperar última seção
          const savedSection =
              localStorage.getItem('mobile_section') || 'roteiro';

          switchSection(savedSection);


          //   showToast('Bem-vindo, @php echo Auth::user()->name; @endphp! Roteiro carregado.', 'success');
      });

      document.addEventListener('DOMContentLoaded', () => {
          showToast('Bem-vindo, @php echo Auth::user()->name; @endphp! Roteiro carregado.', 'success');
      });


      // ===== BOTTOM SHEET - LANÇAR LEITURA =====
      function openLeituraSheet(endereco, cliente, medidor, ultimaLeitura) {
          document.getElementById('leituraOverlay').classList.add('open');
          document.getElementById('leituraSheet').classList.add('open');

          setTimeout(() => {
              document.getElementById('inputLeitura').focus();
          }, 300);
      }

      document.addEventListener('livewire:init', () => {
          console.log('Livewire pronto');
          Livewire.on('showToast', (event) => {
              const data = event[0] ?? event;
              showToast(data.message, data.type);
          });

          Livewire.on('closeModal', (event) => {
              const id = event[0] ?? event;
              closeLeituraSheet();
          });

          Livewire.on('openModal', (event) => {
              const id = event[0] ?? event;
              openModal(id);
          });




          Livewire.on('confirm-action', (data) => {

              const message = data.message ?? 'Tens a certeza?';

              if (!confirm(message)) {
                  return;
              }

              // chama o backend Livewire action
              Livewire.dispatch(data.action, data.payload);
          });
      });




      // A função de fechar continua simples e local
      function closeLeituraSheet() {
          document.getElementById('leituraOverlay').classList.remove('active');
          document.getElementById('leituraSheet').classList.remove('active');
      }

      function closeLeituraSheet() {
          document.getElementById('leituraOverlay').classList.remove('open');
          document.getElementById('leituraSheet').classList.remove('open');
      }

      // ===== CALCULAR CONSUMO =====
      function calcularConsumo() {
          const input = document.getElementById('inputLeitura');
          const valor = parseFloat(input.value);

          if (isNaN(valor) || valor <= 0) {
              document.getElementById('consumoPreview').style.display = 'none';
              document.getElementById('anomaliaAlert').classList.remove('show');
              return;
          }

          leituraAtual = valor;
          const consumo = valor - ultimaLeituraAtual;

          const preview = document.getElementById('consumoPreview');
          const consumoValor = document.getElementById('consumoValor');
          const variacao = document.getElementById('consumoVariacao');
          const anomalia = document.getElementById('anomaliaAlert');

          preview.style.display = 'block';
          consumoValor.textContent = consumo > 0 ? consumo.toLocaleString('pt-BR') : '0';

          // Verificar anomalia (consumo > 200% da média ou negativo)
          const mediaHistorica = 50; // m³ médio mensal
          const percentual = (consumo / mediaHistorica) * 100;

          if (consumo < 0) {
              variacao.textContent = '⚠ Valor menor que a leitura anterior!';
              variacao.className = 'leitura-consumo-variacao alta';
              anomalia.classList.add('show');
          } else if (percentual > 200) {
              variacao.textContent = '⚠ Consumo muito acima da média!';
              variacao.className = 'leitura-consumo-variacao alta';
              anomalia.classList.add('show');
          } else if (percentual < 20) {
              variacao.textContent = 'ℹ Consumo abaixo da média';
              variacao.className = 'leitura-consumo-variacao normal';
              anomalia.classList.remove('show');
          } else {
              variacao.textContent = '✓ Consumo dentro da média';
              variacao.className = 'leitura-consumo-variacao normal';
              anomalia.classList.remove('show');
          }
      }

      // ===== SALVAR LEITURA =====
      function salvarLeitura() {
          const input = document.getElementById('inputLeitura');
          const valor = parseFloat(input.value);

          if (isNaN(valor) || valor <= 0) {
              showToast('Digite um valor válido!', 'error');
              input.focus();
              return;
          }

          if (valor < ultimaLeituraAtual) {
              showToast('Valor menor que a leitura anterior!', 'error');
              return;
          }

          // Simular salvamento
          const btn = document.getElementById('btnSalvarLeitura');
          btn.disabled = true;
          btn.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                Salvando...
            `;

          setTimeout(() => {
              closeLeituraSheet();
              showToast('Leitura salva com sucesso!', 'success');
              btn.disabled = false;
              btn.innerHTML = `
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Salvar Leitura
                `;
          }, 1500);
      }

      // ===== TOAST NOTIFICATION =====
      let toastTimeout;

      function showToast(message, type = 'success') {
          const toast = document.getElementById('mobileToast');
          const toastMessage = document.getElementById('toastMessage');
          const toastIcon = document.getElementById('toastIcon');

          toastMessage.textContent = message;
          toast.className = 'mobile-toast show ' + type;

          // Ícones por tipo
          const icons = {
              success: `<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>`,
              error: `<circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/>`,
              warning: `<path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/>`
          };

          toastIcon.innerHTML = icons[type] || icons.success;

          clearTimeout(toastTimeout);
          toastTimeout = setTimeout(() => {
              toast.classList.remove('show');
          }, 3000);
      }

      // ===== FILTROS DO HISTÓRICO =====
      document.querySelectorAll('.historico-filtro-chip').forEach(chip => {
          chip.addEventListener('click', function() {
              document.querySelectorAll('.historico-filtro-chip').forEach(c => c.classList.remove(
                  'active'));
              this.classList.add('active');
              showToast('Filtro: ' + this.textContent, 'success');
          });
      });

      // ===== PULL TO REFRESH SIMULATION =====
      let touchStartY = 0;
      let touchEndY = 0;

      document.addEventListener('touchstart', e => {
          touchStartY = e.changedTouches[0].screenY;
      }, {
          passive: true
      });

      document.addEventListener('touchend', e => {
          touchEndY = e.changedTouches[0].screenY;
          if (touchEndY > touchStartY + 150 && window.scrollY === 0) {
              showToast('Roteiro atualizado!', 'success');
          }
      }, {
          passive: true
      });

      // ===== KEYBOARD SUPPORT =====
      document.addEventListener('keydown', e => {
          if (e.key === 'Escape') {
              closeLeituraSheet();
          }
      });

      // ===== INIT =====



      // ===== MODAL SYSTEM =====
      function openModal(modalId) {
          document.getElementById(modalId + 'Overlay').classList.add('open');
          document.getElementById(modalId).classList.add('open');
      }

      function closeModal(modalId) {
          document.getElementById(modalId + 'Overlay').classList.remove('open');
          document.getElementById(modalId).classList.remove('open');
      }

      // ===== PERFIL MENU ACTIONS =====


      function openSenhaPessoal() {
          openModal('modalsenha');
      }

      function openDadosPessoais() {
          openModal('modalDados');
      }

      function openConfiguracoes() {
          openModal('modalConfig');
      }

      function openSuporte() {
          openModal('modalSuporte');
      }

      function openSair() {
          openModal('modalSair');
      }

      // ===== SALVAR DADOS PESSOAIS =====
      function salvarDadosPessoais() {
          const nome = document.getElementById('editNome').value;
          const email = document.getElementById('editEmail').value;
          const telemovel = document.getElementById('editTelemovel').value;

          if (!nome || !email) {
              showToast('Preencha nome e e-mail!', 'error');
              return;
          }

          // Update UI
          document.querySelector('.perfil-nome').textContent = nome;
          document.querySelector('.mobile-user-info h2').textContent = nome;
          document.querySelector('.mobile-avatar').textContent = nome.split(' ').map(n => n[0]).join('').substring(0, 2)
              .toUpperCase();
          document.querySelector('.perfil-avatar-lg').textContent = nome.split(' ').map(n => n[0]).join('').substring(0,
              2).toUpperCase();

          closeModal('modalDados');
          showToast('Dados pessoais atualizados!', 'success');
      }

      // ===== SALVAR CONFIGURAÇÕES =====
      function salvarConfiguracoes() {
          closeModal('modalConfig');
          showToast('Configurações salvas com sucesso!', 'success');
      }

      function selectTheme(element) {
          document.querySelectorAll('.cfg-theme-option').forEach(opt => opt.classList.remove('cfg-theme-active'));
          element.classList.add('cfg-theme-active');
      }

      // ===== SUPORTE =====
      function enviarSuporte() {
          const assunto = document.getElementById('suporteAssunto').value;
          const mensagem = document.getElementById('suporteMensagem').value;

          if (!assunto) {
              showToast('Selecione um assunto!', 'warning');
              return;
          }
          if (!mensagem.trim()) {
              showToast('Escreva uma mensagem!', 'warning');
              return;
          }

          closeModal('modalSuporte');
          showToast('Mensagem enviada ao suporte!', 'success');
          document.getElementById('suporteAssunto').value = '';
          document.getElementById('suporteMensagem').value = '';
      }

      // ===== SAIR DO SISTEMA =====
      function confirmarSaida() {
          showToast('Sincronizando leituras pendentes...', 'warning');

          setTimeout(() => {
              closeModal('modalSair');
              showToast('Sessão encerrada. Até breve!', 'success');

              // Simulate redirect to login
              setTimeout(() => {
                  document.body.innerHTML = `
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; background: var(--neutral); padding: var(--space-xl);">
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; margin-bottom: var(--space-lg); color: var(--white);">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                                </svg>
                            </div>
                            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: var(--space-sm);">AquaNexus</h2>
                            <p style="color: var(--text-muted); text-align: center; margin-bottom: var(--space-xl);">Sessão encerrada com sucesso.<br>Redirecionando para o login...</p>
                            <div style="width: 40px; height: 40px; border: 3px solid var(--neutral-dark); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite;"></div>
                        </div>
                        <style>
                            @keyframes spin { to { transform: rotate(360deg); } }
                        </style>
                    `;
              }, 2000);
          }, 1500);
      }
  </script>
