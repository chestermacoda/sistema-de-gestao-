 <div class="modal-overlay" id="modal-audits" wire:ignore.self>
     <div class="modal modal-lg">
         <div class="modal-header">
             <h3 class="modal-title">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     style="vertical-align: middle; margin-right: 8px;">
                     <path d="M12 20h9" />
                     <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                 </svg>
                 Detalhes

             </h3>
             <button class="modal-close" onclick="closeModal('modal-audits')">
                 <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M18 6 6 18" />
                     <path d="m6 6 12 12" />
                 </svg>
             </button>
         </div>


         <div class="modal-body">
             <div class="usr-log-detalhes">

                 <div class="usr-log-detalhe-row">
                     <span class="usr-log-label">ID:</span>
                     <span class="usr-log-value">#{{ $idLog }}</span>
                 </div>

                 <div class="usr-log-detalhe-row">
                     <span class="usr-log-label">Data/Hora:</span>
                     <span class="usr-log-value">{{ $dataHora }}</span>
                 </div>

                 <div class="usr-log-detalhe-row">
                     <span class="usr-log-label">Usuário:</span>
                     <span class="usr-log-value">{{ $usuario ?? 'Sistema' }}</span>
                 </div>

                 <div class="usr-log-detalhe-row">
                     <span class="usr-log-label">Ação:</span>
                     <span class="usr-log-value">{{ $acao }}</span>
                 </div>

                 <div class="usr-log-detalhe-row">
                     <span class="usr-log-label">Descrição:</span>
                     <span class="usr-log-value">{{ $descricao }}</span>
                 </div>

                 {{-- ALTERAÇÕES --}}
                 @if (!empty($new) || !empty($old))
                     <div class="usr-log-alteracoes">
                         <h4>Alterações Realizadas</h4>

                         <table class="usr-log-tabela">
                             <thead>
                                 <tr>
                                     <th>Campo</th>
                                     <th>Valor Anterior</th>
                                     <th>Valor Novo</th>
                                 </tr>
                             </thead>

                             <tbody>
                                 @foreach ($new as $key => $value)
                                     @php
                                         $oldValue = $old[$key] ?? '(vazio)';
                                         $newValue = $value ?? '(vazio)';
                                         $changed = $oldValue !== $newValue;
                                     @endphp

                                     <tr class="{{ $changed ? 'usr-log-changed' : '' }}">
                                         <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                         <td class="usr-log-old">{{ $oldValue }}</td>
                                         <td class="usr-log-new">{{ $newValue }}</td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 @endif

                 {{-- PROPRIEDADES GERAIS --}}
                 @if (!empty($properties) && empty($old))
                     <div class="usr-log-propriedades">
                         <h4>Propriedades</h4>

                         <pre>
{{ json_encode($properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                </pre>
                     </div>
                 @endif

             </div>
         </div>


         <div class="modal-footer">
             <button class="btn btn-outline" onclick="fecharModalAudit()">Fechar</button>
             <button class="btn btn-primary" wire:click="exportarCsv" wire:loading.attr="disabled">
                 <span wire:loading.remove wire:target="exportarExcel">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                         <polyline points="7 10 12 15 17 10" />
                         <line x1="12" x2="12" y1="15" y2="3" />
                     </svg>
                     Exportar Excel
                 </span>
                 <span wire:loading wire:target="exportarExcel">Exportando...</span>
             </button>
         </div>
     </div>
 </div>
