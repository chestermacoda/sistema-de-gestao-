 <div class="modal-overlay" id="modal-backup" wire:ignore.self>
     <form wire:submit.prevent='saveConfig' class="modal modal-lg">
         <div class="modal-header">
             <h3 class="modal-title">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                     <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                     <polyline points="7 10 12 15 17 10" />
                     <line x1="12" x2="12" y1="15" y2="3" />
                 </svg>
                 Backup e Restauração
             </h3>
             <button class="modal-close" onclick="closeModal('modal-backup')">
                 <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M18 6 6 18" />
                     <path d="m6 6 12 12" />
                 </svg>
             </button>
         </div>
         <div class="modal-body">
             <div class="cfg-backup-section">
                 <h4 class="cfg-backup-title">Backup Manual</h4>
                 <p class="cfg-backup-desc">Exporte todos os dados do sistema em formato SQL ou JSON</p>
                 <div class="cfg-backup-actions">
                     {{-- onclick="exportarBackup('sql')" --}}
                     <button type="button" class="btn btn-outline" wire:click="export('sql')">
                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                             <polyline points="14 2 14 8 20 8" />
                         </svg>
                         Exportar SQL
                     </button>
                     {{-- onclick="exportarBackup('json')" --}}
                     <button type="button" wire:click="export('json')" class="btn btn-outline">
                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                             <polyline points="14 2 14 8 20 8" />
                         </svg>
                         Exportar JSON
                     </button>
                 </div>
             </div>
             <div class="cfg-backup-section">
                 <h4 class="cfg-backup-title">Backup Automático</h4>
                 <p class="cfg-backup-desc">Agende backups periódicos para nuvem ou servidor local</p>
                 <div class="cfg-form-row">
                     <div class="cfg-form-group">
                         <label class="cfg-label">Frequência</label>
                         <select class="cfg-select" wire:model="frequencia">
                             <option>Escolhe a Frequencia</option>
                             <option value="diario">Diário</option>
                             <option value="semanal">Semanal</option>
                             <option value="mensal">Mensal</option>
                         </select>
                         @error('frequencia')
                             <small style="color: var(--danger)">{{ $message }}</small>
                         @enderror
                     </div>
                     <div class="cfg-form-group">
                         <label class="cfg-label">Horário</label>
                         <input type="time" class="cfg-input" value="02:00" wire:model="horario">
                         @error('horario')
                             <small style="color: var(--danger)">{{ $message }}</small>
                         @enderror
                     </div>
                     <div class="cfg-form-group">
                         <label class="cfg-label">Retenção (dias)</label>
                         <input type="number" class="cfg-input" value="30" min="1"
                             wire:model="retencao_dias">
                         @error('retencao_dias')
                             <small style="color: var(--danger)">{{ $message }}</small>
                         @enderror
                     </div>
                 </div>
                 <div class="cfg-toggle-item" style="margin-top: var(--space-md);">
                     <div class="cfg-toggle-info">
                         <span class="cfg-toggle-title">Backup Automático Ativo</span>
                         <span class="cfg-toggle-desc">Executar backups conforme agendamento</span>
                     </div>
                     <label class="cfg-toggle">
                         <input type="checkbox" wire:model="ativo">
                         <span class="cfg-toggle-slider"></span>
                     </label>
                 </div>
             </div>
             <div class="cfg-backup-section">
                 <h4 class="cfg-backup-title">Histórico de Backups</h4>
                 <div class="cfg-backup-list">
                     @foreach ($backups as $back)
                         <div class="cfg-backup-item">
                             <div class="cfg-backup-info">
                                 <span class="cfg-backup-name">{{ $back->arquivo }}</span>
                                 <span class="cfg-backup-meta">{{ $back->created_at }} • 24.5 MB •
                                     {{ $back->origem }}</span>
                             </div>
                             <div class="cfg-backup-actions-sm">
                                 <button type="button" wire:click='download({{ $back->id }})' class="cfg-btn-icon"
                                     title="Download">
                                     <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2">
                                         <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                         <polyline points="7 10 12 15 17 10" />
                                         <line x1="12" x2="12" y1="15" y2="3" />
                                     </svg>
                                 </button>
                                 <button class="cfg-btn-icon" title="Restaurar" onclick="restaurarBackup(this)">
                                     <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2">
                                         <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                         <path d="M3 3v5h5" />
                                     </svg>
                                 </button>
                             </div>
                         </div>
                     @endforeach
                     <!-- Paginação -->


                     {{-- <div class="cfg-backup-item">
                         <div class="cfg-backup-info">
                             <span class="cfg-backup-name">backup_20260501_020000.sql</span>
                             <span class="cfg-backup-meta">01/05/2026 02:00 • 24.1 MB • Automático</span>
                         </div>
                         <div class="cfg-backup-actions-sm">
                             <button class="cfg-btn-icon" title="Download">
                                 <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                     <polyline points="7 10 12 15 17 10" />
                                     <line x1="12" x2="12" y1="15" y2="3" />
                                 </svg>
                             </button>
                             <button class="cfg-btn-icon" title="Restaurar" onclick="restaurarBackup(this)">
                                 </svg>
                             </button>
                         </div>
                     </div>
                     <div class="cfg-backup-item">
                         <div class="cfg-backup-info">
                             <span class="cfg-backup-name">backup_20260424_020000.sql</span>
                             <span class="cfg-backup-meta">24/04/2026 02:00 • 23.8 MB • Automático</span>
                         </div>
                         <div class="cfg-backup-actions-sm">
                             <button class="cfg-btn-icon" title="Download">
                                 <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                     <polyline points="7 10 12 15 17 10" />
                                     <line x1="12" x2="12" y1="15" y2="3" />
                                 </svg>
                             </button>
                             <button class="cfg-btn-icon" title="Restaurar" onclick="restaurarBackup(this)">
                                 <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                     <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                     <path d="M3 3v5h5" />
                                 </svg>
                             </button>
                         </div>
                     </div> --}}
                 </div>
             </div>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-outline" onclick="closeModal('modal-backup')">Fechar</button>
             <button type="button" class="btn btn-primary" wire:click="export('sql')">
                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                     <polyline points="7 10 12 15 17 10" />
                     <line x1="12" x2="12" y1="15" y2="3" />
                 </svg>
                 Exportar Agora
             </button>
             <button type="submit" class="btn btn-primary" wire:click="saveConfig" wire:click="saveConfig">
                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                     <polyline points="7 10 12 15 17 10" />
                     <line x1="12" x2="12" y1="15" y2="3" />
                 </svg>
                 Salvar Configuração
             </button>
         </div>
     </form>
 </div>
