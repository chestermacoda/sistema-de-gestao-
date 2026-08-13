 <!-- ============================================ -->
 <!-- MODAL: NOVA LEITURA                         -->
 <!-- ============================================ -->
 <div class="modal-overlay" id="modal-nova-leitura" wire:ignore.self>
     <form wire:submit.prevent='salvar' class="modal modal-lg" style="max-width: 700px;">
         <div class="modal-header">
             <div style="display: flex; align-items: center; gap: var(--space-md);">
                 <div
                     style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--primary); display: flex; align-items: center; justify-content: center; color: white;">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M5 12h14" />
                         <path d="M12 5v14" />
                     </svg>
                 </div>
                 <div>
                     <h3 class="modal-title">Registrar Nova Leitura</h3>
                     <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">Mês
                         referência: Maio/2026</p>
                 </div>
             </div>
             <button class="modal-close" onclick="closeModal('modal-nova-leitura')">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M18 6 6 18" />
                     <path d="m6 6 12 12" />
                 </svg>
             </button>
         </div>
         <div class="modal-body">
             <div class="form-group">
                 <label class="form-label">Cliente / Medidor *</label>
                 <select class="form-select" wire:model.live="medidores_id">
                     <option value="">Selecione o medidor...</option>
                     @foreach ($medidores as $medidor)
                         <option value="{{ $medidor->id }}">

                             {{ $medidor->numero_hidrometro }}
                             —
                             {{ $medidor->cliente?->nome_completo }}
                             —
                             {{ $medidor->cliente?->numero_matricula }}

                         </option>
                     @endforeach

                 </select>
                 @error('medidores_id')
                     <small style="color: var(--danger)">{{ $message }}</small>
                 @enderror
             </div>

             <div
                 style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-bottom: var(--space-lg);">
                 <div
                     style="display: flex; justify-content: space-between; font-size: var(--label-size); margin-bottom: var(--space-sm);">
                     <span style="color: var(--text-muted);">Leitura Anterior</span>
                     <span
                         style="font-family: monospace; font-weight: 600;">{{ number_format($leitura_anterior, 0, ',', '.') }}
                         m³</span>
                 </div>
                 <div style="display: flex; justify-content: space-between; font-size: var(--label-size);">
                     <span style="color: var(--text-muted);">Data Leitura Anterior</span>
                     <span style="font-weight: 600;">{{ $ultima_leitura_data }}</span>
                 </div>
             </div>

             <div class="form-group">
                 <label class="form-label">Nova Leitura (m³) *</label>
                 <div class="leit-input-group">
                     <input type="number" class="form-input" wire:model.live="leitura_atual" placeholder="00000"
                         min="{{ number_format($leitura_anterior, 0, ',', '.') }}" required>
                     <span>m³</span>
                     @error('leitura_atual')
                         <small style="color: var(--danger)">{{ $message }}</small>
                     @enderror
                 </div>
                 <p class="form-hint">A leitura deve ser maior que a anterior
                     ({{ number_format($leitura_anterior, 0, ',', '.') }} m³)</p>
             </div>

             <div class="grid-2">
                 <div class="form-group">
                     <label class="form-label">Data da Leitura *</label>
                     <input type="date" class="form-input" wire:model.live="data_leitura" value="2026-05-08"
                         required>
                     @error('data_leitura')
                         <small style="color: var(--danger)">{{ $message }}</small>
                     @enderror
                 </div>
                 <div class="form-group">
                     <label class="form-label">Hora da Leitura *</label>
                     <input type="time" class="form-input" wire:model.live="hora_leitura" value="14:30" required>
                     @error('hora_leitura')
                         <small style="color: var(--danger)">{{ $message }}</small>
                     @enderror
                 </div>
             </div>

             <div class="form-group">
                 <label class="form-label">Leiturista *</label>
                 <select class="form-select" wire:model.live="user_id" required>
                     <option value="">Selecione...</option>
                     @foreach ($leituristas as $user)
                         <option value="{{ $user->id }}">
                             {{ $user->name }}
                         </option>
                     @endforeach
                 </select>
             </div>

             <div class="form-group">
                 <label class="form-label">Observações / Anomalias</label>
                 <textarea class="form-textarea" wire:model.live="observacoes"
                     placeholder="Descreva qualquer anomalia observada no medidor ou na instalação"></textarea>
             </div>

             <div
                 style="background: var(--neutral); border-radius: var(--radius-md); padding: var(--space-md); margin-top: var(--space-md);">
                 <label
                     style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; font-size: var(--label-size);">
                     <input type="checkbox" wire:model.live="confirmada_local"
                         style="accent-color: var(--primary); width: 18px; height: 18px;">
                     <span><strong>Leitura confirmada no local</strong> — Estou presente no endereço de
                         instalação</span>
                 </label>
             </div>

             <div class="leit-consumo-preview" style="margin-top: var(--space-lg);">
                 <div class="leit-consumo-preview-label">Consumo Estimado</div>
                 <div class="leit-consumo-preview-valor">{{ number_format($consumo, 0, ',', '.') }} m³</div>
             </div>
         </div>
         <div class="modal-footer">
             <button class="btn btn-outline" onclick="closeModal('modal-nova-leitura')">Cancelar</button>
             <button class="btn btn-primary" type="submit">
                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" style="margin-right: 6px;">
                     <path d="M20 6 9 17l-5-5" />
                 </svg>
                 Confirmar Leitura
             </button>
         </div>
     </form>
 </div>
