  <div class="modal-overlay" id="modal-importar-leituras" wire:ignore.self>
      <div class="modal modal-lg" style="max-width: 700px;">
          <div class="modal-header">
              <div style="display: flex; align-items: center; gap: var(--space-md);">
                  <div
                      style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--success); display: flex; align-items: center; justify-content: center; color: white;">
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2">
                          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                          <polyline points="17 8 12 3 7 8" />
                          <line x1="12" x2="12" y1="3" y2="15" />
                      </svg>
                  </div>
                  <div>
                      <h3 class="modal-title">Importar Leituras</h3>
                      <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                          Upload em lote via Excel
                      </p>
                  </div>
              </div>
              <button type="button" class="modal-close" onclick="closeModal('modal-importar-leituras')">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2">
                      <path d="M18 6 6 18" />
                      <path d="m6 6 12 12" />
                  </svg>
              </button>
          </div>

          <div class="modal-body">
              <!-- Botão Baixar Modelo -->
              <div
                  style="background: linear-gradient(135deg, var(--primary-light), var(--neutral)); border-radius: var(--radius-md); padding: var(--space-lg); margin-bottom: var(--space-lg); border: 1px dashed var(--primary);">
                  <div
                      style="display: flex; align-items: center; justify-content: space-between; gap: var(--space-md);">
                      <div>
                          <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">📥 Baixar
                              Modelo
                              de Importação</div>
                          <div style="font-size: var(--small-size); color: var(--text-muted);">
                              Planilha Excel com colunas: Nº Hidrômetro, Leitura Atual, Data, Hora
                          </div>
                      </div>
                      <button type="button" wire:click="baixarModelo" wire:loading.attr="disabled"
                          class="btn btn-primary" style="white-space: nowrap;">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                              stroke-width="2" style="margin-right: 6px;">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                              <polyline points="7 10 12 15 17 10" />
                              <line x1="12" x2="12" y1="15" y2="3" />
                          </svg>
                          <span wire:loading.remove wire:target="baixarModelo">Baixar .xlsx</span>
                          <span wire:loading wire:target="baixarModelo">Gerando...</span>
                      </button>
                  </div>
              </div>

              <!-- Formulário de Importação -->
              @if (!$processando && !$concluido)
                  <form wire:submit.prevent="importar">
                      <!-- Mês de Referência -->
                      <div class="form-group">
                          <label class="form-label">Mês de Referência *</label>
                          <input type="month" class="form-input @error('mes_referencia') is-invalid @enderror"
                              wire:model="mes_referencia" required>
                          @error('mes_referencia')
                              <small
                                  style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                          @enderror
                      </div>

                      <!-- Leiturista -->
                      <div class="form-group">
                          <label class="form-label">Leiturista Responsável *</label>
                          <select class="form-select @error('user_id') is-invalid @enderror" wire:model="user_id"
                              required>
                              <option value="">Selecione...</option>
                              @foreach ($leituristas as $user)
                                  <option value="{{ $user->id }}">
                                      {{ $user->name }}
                                  </option>
                              @endforeach

                          </select>
                          @error('user_id')
                              <small
                                  style="color: var(--danger); display: block; margin-top: 4px;">{{ $message }}</small>
                          @enderror
                      </div>

                      <!-- Upload do Arquivo -->
                      <div class="form-group">
                          <label class="form-label">Arquivo Excel *</label>
                          <div style="border: 2px dashed var(--border); border-radius: var(--radius-md); padding: var(--space-xl); text-align: center; transition: all 0.2s;"
                              ondragover="this.style.borderColor='var(--primary)';this.style.background='var(--primary-light)'"
                              ondragleave="this.style.borderColor='var(--border)';this.style.background='transparent'">

                              <input type="file" wire:model="arquivo" accept=".xlsx,.xls" style="display: none;"
                                  id="input-excel" onchange="mostrarNomeArquivo(this)">

                              <div onclick="document.getElementById('input-excel').click()" style="cursor: pointer;">
                                  <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                      stroke="var(--primary)" stroke-width="1.5" style="margin: 0 auto 12px;">
                                      <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                      <polyline points="14 2 14 8 20 8" />
                                  </svg>
                                  <div style="font-weight: 500; color: var(--text-primary); margin-bottom: 4px;">
                                      Clique ou arraste o arquivo aqui
                                  </div>
                                  <div style="font-size: var(--small-size); color: var(--text-muted);">
                                      .xlsx ou .xls até 5MB
                                  </div>
                              </div>

                              <div id="nome-arquivo" style="margin-top: 12px; font-weight: 600; color: var(--primary);">
                              </div>

                              @error('arquivo')
                                  <small
                                      style="color: var(--danger); display: block; margin-top: 8px;">{{ $message }}</small>
                              @enderror
                          </div>
                      </div>

                      <!-- Opções -->
                      <div
                          style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-md); margin-bottom: var(--space-lg);">
                          <label
                              style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                              <input type="checkbox" wire:model="validar_anomalias"
                                  style="accent-color: var(--primary); width: 18px; height: 18px;">
                              <span><strong>Validar anomalias</strong><br><small
                                      style="color: var(--text-muted);">Detecta
                                      consumo fora da média</small></span>
                          </label>
                          <label
                              style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md);">
                              <input type="checkbox" wire:model="ignorar_duplicados"
                                  style="accent-color: var(--primary); width: 18px; height: 18px;">
                              <span><strong>Ignorar duplicados</strong><br><small
                                      style="color: var(--text-muted);">Pula
                                      leituras já existentes</small></span>
                          </label>
                      </div>

                      <button type="submit" class="btn btn-primary btn-block" wire:loading.attr="disabled"
                          style="width: 100%;">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                              <polyline points="17 8 12 3 7 8" />
                              <line x1="12" x2="12" y1="3" y2="15" />
                          </svg>
                          <span wire:loading.remove wire:target="importar">Iniciar Importação</span>
                          <span wire:loading wire:target="importar">Processando...</span>
                      </button>
                  </form>
              @endif

              <!-- Barra de Progresso -->
              @if ($processando || $concluido)
                  <div style="margin-bottom: var(--space-lg);">
                      <div style="display: flex; justify-content: space-between; margin-bottom: var(--space-sm);">
                          <span style="font-weight: 600; color: var(--text-primary);">
                              @if ($concluido)
                                  ✅ Importação Concluída
                              @else
                                  ⏳ Processando...
                              @endif
                          </span>
                          <span style="font-weight: 700; color: var(--primary);">{{ $percentual }}%</span>
                      </div>

                      <div style="background: var(--neutral); border-radius: 999px; height: 12px; overflow: hidden;">
                          <div
                              style="background: linear-gradient(90deg, var(--primary), var(--success)); height: 100%; border-radius: 999px; transition: width 0.3s ease; width: {{ $percentual }}%;">
                          </div>
                      </div>

                      <div
                          style="display: flex; justify-content: space-between; margin-top: var(--space-sm); font-size: var(--small-size); color: var(--text-muted);">
                          <span>{{ $processadas }} / {{ $total_linhas }} registros</span>
                          <span>{{ $sucessos }} OK | {{ $anomalias }} ⚠️ | {{ $erros }} ❌</span>
                      </div>
                  </div>

                  <!-- Cards de Resumo -->
                  <div
                      style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--space-md); margin-bottom: var(--space-lg);">
                      <div
                          style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); text-align: center;">
                          <div style="font-size: var(--small-size); color: var(--text-muted);">Total</div>
                          <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                              {{ $total_linhas }}
                          </div>
                      </div>
                      <div
                          style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); text-align: center;">
                          <div style="font-size: var(--small-size); color: var(--text-muted);">Sucessos</div>
                          <div style="font-size: 1.25rem; font-weight: 700; color: var(--success);">
                              {{ $sucessos }}
                          </div>
                      </div>
                      <div
                          style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); text-align: center;">
                          <div style="font-size: var(--small-size); color: var(--text-muted);">Anomalias</div>
                          <div style="font-size: 1.25rem; font-weight: 700; color: var(--warning);">
                              {{ $anomalias }}
                          </div>
                      </div>
                      <div
                          style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); text-align: center;">
                          <div style="font-size: var(--small-size); color: var(--text-muted);">Erros</div>
                          <div style="font-size: 1.25rem; font-weight: 700; color: var(--danger);">{{ $erros }}
                          </div>
                      </div>
                  </div>
              @endif

              <!-- Log de Anomalias -->
              @if (count($log_anomalias) > 0 && $concluido)
                  <div style="margin-bottom: var(--space-lg);">
                      <div
                          style="font-size: var(--label-size); font-weight: 600; color: var(--warning); margin-bottom: var(--space-md); display: flex; align-items: center; gap: 6px;">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2">
                              <path
                                  d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                              <line x1="12" x2="12" y1="9" y2="13" />
                              <line x1="12" x2="12.01" y1="17" y2="17" />
                          </svg>
                          Anomalias Detectadas ({{ count($log_anomalias) }})
                      </div>
                      <div
                          style="max-height: 200px; overflow-y: auto; border-radius: var(--radius-md); border: 1px solid var(--warning);">
                          @foreach ($log_anomalias as $anomalia)
                              <div
                                  style="padding: var(--space-sm) var(--space-md); border-bottom: 1px solid var(--border); font-size: var(--small-size);">
                                  <strong style="color: var(--text-primary);">Linha {{ $anomalia['linha'] }}</strong>
                                  —
                                  {{ $anomalia['hidrometro'] }} — {{ $anomalia['cliente'] }}<br>
                                  <span style="color: var(--warning);">{{ $anomalia['tipo'] }}</span>:
                                  {{ $anomalia['descricao'] }}
                              </div>
                          @endforeach
                      </div>
                  </div>
              @endif

              <!-- Log de Erros -->
              @if (count($log_erros) > 0 && $concluido)
                  <div style="margin-bottom: var(--space-lg);">
                      <div
                          style="font-size: var(--label-size); font-weight: 600; color: var(--danger); margin-bottom: var(--space-md); display: flex; align-items: center; gap: 6px;">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                              stroke="currentColor" stroke-width="2">
                              <circle cx="12" cy="12" r="10" />
                              <line x1="15" x2="9" y1="9" y2="15" />
                              <line x1="9" x2="15" y1="9" y2="15" />
                          </svg>
                          Erros ({{ count($log_erros) }})
                      </div>
                      <div
                          style="max-height: 200px; overflow-y: auto; border-radius: var(--radius-md); border: 1px solid var(--danger);">
                          @foreach ($log_erros as $erro)
                              <div
                                  style="padding: var(--space-sm) var(--space-md); border-bottom: 1px solid var(--border); font-size: var(--small-size);">
                                  <strong style="color: var(--text-primary);">Linha {{ $erro['linha'] }}</strong> —
                                  {{ $erro['hidrometro'] }}<br>
                                  <span style="color: var(--danger);">{{ $erro['erro'] }}</span>
                              </div>
                          @endforeach
                      </div>
                  </div>
              @endif

              <!-- Botão Nova Importação -->
              @if ($concluido)
                  <button type="button" wire:click="$set('concluido', false)" class="btn btn-outline btn-block"
                      style="width: 100%;">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" style="margin-right: 6px;">
                          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                          <polyline points="7 10 12 15 17 10" />
                          <line x1="12" x2="12" y1="15" y2="3" />
                      </svg>
                      Nova Importação
                  </button>
              @endif
          </div>

          <div class="modal-footer">
              <button type="button" class="btn btn-outline" onclick="closeModal('modal-importar-leituras')">
                  {{ $concluido ? 'Fechar' : 'Cancelar' }}
              </button>
          </div>
      </div>
  </div>

  <script>
      function mostrarNomeArquivo(input) {
          const nome = input.files[0]?.name || '';
          document.getElementById('nome-arquivo').textContent = nome ? '📄 ' + nome : '';
      }
  </script>
