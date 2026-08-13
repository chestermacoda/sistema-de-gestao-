 <div class="modal-overlay" id="modal-historico-cliente" wire:ignore.self>
     <div class="modal modal-lg" style="max-width: 800px;">
         <!-- Header -->
         <div class="modal-header">
             <div style="display: flex; align-items: center; gap: var(--space-md);">
                 <div
                     style="width: 40px; height: 40px; border-radius: var(--radius-md); background: var(--secondary); display: flex; align-items: center; justify-content: center; color: white;">
                     <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2">
                         <circle cx="12" cy="12" r="10" />
                         <polyline points="12 6 12 12 16 14" />
                     </svg>
                 </div>
                 <div>
                     <h3 class="modal-title">Histórico do Cliente</h3>
                     <p style="font-size: var(--small-size); color: var(--text-muted); margin-top: 2px;">
                         {{ $numeroMatricula }} — {{ $nomeCliente }}
                     </p>
                 </div>
             </div>
             <button class="modal-close" onclick="closeModal('modal-historico-cliente')" type="button">
                 <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2">
                     <path d="M18 6 6 18" />
                     <path d="m6 6 12 12" />
                 </svg>
             </button>
         </div>

         <!-- Body -->
         <div class="modal-body">
             <!-- Tabs -->
             <div class="tabs" style="margin-bottom: var(--space-lg);">
                 <button class="tab {{ $abaAtiva === 'tab-hist-leituras' ? 'active' : '' }}"
                     wire:click="switchTab('tab-hist-leituras')" type="button">
                     Leituras
                 </button>
                 <button class="tab {{ $abaAtiva === 'tab-hist-faturas' ? 'active' : '' }}"
                     wire:click="switchTab('tab-hist-faturas')" type="button">
                     Faturas
                 </button>
                 <button class="tab {{ $abaAtiva === 'tab-hist-pagamentos' ? 'active' : '' }}"
                     wire:click="switchTab('tab-hist-pagamentos')" type="button">
                     Pagamentos
                 </button>
                 <button class="tab {{ $abaAtiva === 'tab-hist-ocorrencias' ? 'active' : '' }}"
                     wire:click="switchTab('tab-hist-ocorrencias')" type="button">
                     Ocorrências
                 </button>
             </div>

             <!-- Aba: Leituras -->
             <div id="tab-hist-leituras" class="tab-content-hist"
                 style="display: {{ $abaAtiva === 'tab-hist-leituras' ? 'block' : 'none' }};">
                 @if (count($leituras) > 0)
                     <div class="table-container">
                         <table>
                             <thead>
                                 <tr>
                                     <th>Mês/Ano</th>
                                     <th>Leitura Anterior</th>
                                     <th>Leitura Atual</th>
                                     <th>Consumo (m³)</th>
                                     <th>Leiturista</th>
                                     <th>Data</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($leituras as $leitura)
                                     <tr>
                                         <td style="font-weight: 600;">{{ $leitura['mes_ano'] }}</td>
                                         <td style="font-family: monospace;">{{ $leitura['leitura_anterior'] }}</td>
                                         <td style="font-family: monospace; color: var(--primary); font-weight: 600;">
                                             {{ $leitura['leitura_atual'] }}</td>
                                         <td><span class="badge badge-info">{{ $leitura['consumo'] }} m³</span></td>
                                         <td>{{ $leitura['leiturista']['name'] }}</td>
                                         <td style="font-size: var(--small-size); color: var(--text-muted);">
                                             {{ $leitura['data'] }}</td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>


                     <div
                         style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--space-md);">
                         <span style="font-size: var(--small-size); color: var(--text-muted);">
                             Média de consumo: <strong>{{ $mediaConsumo }} m³/mês</strong>
                         </span>
                         <button class="btn btn-sm btn-outline" wire:click="verTodasLeituras" type="button">Ver Todas
                             as Leituras</button>
                     </div>
                 @else
                     <div style="text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                         <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.5" style="margin-bottom: var(--space-md); opacity: 0.5;">
                             <circle cx="12" cy="12" r="10" />
                             <polyline points="12 6 12 12 16 14" />
                         </svg>
                         <p>Nenhuma leitura registrada para este cliente.</p>
                     </div>
                 @endif
             </div>

             <!-- Aba: Faturas -->
             <div id="tab-hist-faturas" class="tab-content-hist"
                 style="display: {{ $abaAtiva === 'tab-hist-faturas' ? 'block' : 'none' }};">
                 @if (count($faturas) > 0)
                     <div class="table-container">
                         <table>
                             <thead>
                                 <tr>
                                     <th>Nº Fatura</th>
                                     <th>Mês Referência</th>
                                     <th>Vencimento</th>
                                     <th>Valor</th>
                                     <th>Consumo</th>
                                     <th>Status</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($faturas as $fatura)
                                     <tr>
                                         <td style="font-family: monospace; font-weight: 600;">{{ $fatura['numero'] }}
                                         </td>
                                         <td>{{ $fatura['mes_referencia'] }}</td>
                                         <td>{{ $fatura['vencimento'] }}</td>
                                         <td style="font-weight: 600;">Kz
                                             {{ number_format($fatura['valor'], 2, ',', '.') }}</td>
                                         <td>{{ $fatura['consumo'] }} m³</td>
                                         <td><span
                                                 class="badge badge-{{ $fatura['status_classe'] }}">{{ $fatura['status_label'] }}</span>
                                         </td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 @else
                     <div style="text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                         <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.5" style="margin-bottom: var(--space-md); opacity: 0.5;">
                             <rect width="20" height="14" x="2" y="5" rx="2" />
                             <line x1="2" x2="22" y1="10" y2="10" />
                         </svg>
                         <p>Nenhuma fatura encontrada para este cliente.</p>
                     </div>
                 @endif
             </div>

             <!-- Aba: Pagamentos -->
             <div id="tab-hist-pagamentos" class="tab-content-hist"
                 style="display: {{ $abaAtiva === 'tab-hist-pagamentos' ? 'block' : 'none' }};">
                 @if (count($pagamentos) > 0)
                     <div class="table-container">
                         <table>
                             <thead>
                                 <tr>
                                     <th>Data</th>
                                     <th>Fatura</th>
                                     <th>Valor</th>
                                     <th>Metodo Pagamento</th>
                                     <th>Autenticação</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach ($pagamentos as $pagamento)
                                     <tr>
                                         <td>{{ $pagamento['data'] }}</td>
                                         <td style="font-family: monospace;">{{ $pagamento['Fatura'] }}</td>
                                         <td style="font-weight: 600; color: var(--success);">MT
                                             {{ number_format($pagamento['valor'], 2, ',', '.') }}</td>
                                         <td><span class="badge badge-neutral">{{ $pagamento['metodo'] }}</span>
                                         </td>
                                         <td style="font-family: monospace; font-size: var(--small-size);">
                                             {{ $pagamento['usuario'] }}</td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                     {{-- @include('admin.components.pagination', ['paginator' => $faturas]) --}}
                 @else
                     <div style="text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                         <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.5" style="margin-bottom: var(--space-md); opacity: 0.5;">
                             <line x1="12" x2="12" y1="2" y2="22" />
                             <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                         </svg>
                         <p>Nenhum pagamento registrado para este cliente.</p>
                     </div>
                 @endif
             </div>

             <!-- Aba: Ocorrências -->
             <div id="tab-hist-ocorrencias" class="tab-content-hist"
                 style="display: {{ $abaAtiva === 'tab-hist-ocorrencias' ? 'block' : 'none' }};">
                 @if (count($ocorrencias) > 0)
                     <div style="display: flex; flex-direction: column; gap: var(--space-md);">
                         @foreach ($ocorrencias as $ocorrencia)
                             <div
                                 style="display: flex; gap: var(--space-md); padding: var(--space-md); background: var(--neutral); border-radius: var(--radius-md); border-left: 3px solid var(--{{ $ocorrencia['cor'] }});">
                                 <div
                                     style="width: 32px; height: 32px; border-radius: 50%; background: var(--{{ $ocorrencia['cor'] }}-light); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                     @if ($ocorrencia['icone'] === 'check')
                                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="var(--{{ $ocorrencia['cor'] }})" stroke-width="2">
                                             <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                             <polyline points="22 4 12 14.01 9 11.01" />
                                         </svg>
                                     @elseif($ocorrencia['icone'] === 'clock')
                                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="var(--{{ $ocorrencia['cor'] }})" stroke-width="2">
                                             <circle cx="12" cy="12" r="10" />
                                             <path d="M12 6v6l4 2" />
                                         </svg>
                                     @else
                                         <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="var(--{{ $ocorrencia['cor'] }})" stroke-width="2">
                                             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                             <polyline points="14 2 14 8 20 8" />
                                         </svg>
                                     @endif
                                 </div>
                                 <div>
                                     <div style="font-weight: 600; font-size: var(--label-size);">
                                         {{ $ocorrencia['titulo'] }}</div>
                                     <div
                                         style="font-size: var(--small-size); color: var(--text-secondary); margin-top: 2px;">
                                         {{ $ocorrencia['descricao'] }}</div>
                                     <div
                                         style="font-size: var(--small-size); color: var(--text-muted); margin-top: 4px;">
                                         {{ $ocorrencia['data'] }} — {{ $ocorrencia['autor']['name'] }}</div>
                                 </div>
                             </div>
                         @endforeach
                     </div>
                 @else
                     <div style="text-align: center; padding: var(--space-xl); color: var(--text-muted);">
                         <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5"
                             style="margin-bottom: var(--space-md); opacity: 0.5;">
                             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                             <polyline points="14 2 14 8 20 8" />
                         </svg>
                         <p>Nenhuma ocorrência registrada para este cliente.</p>
                     </div>
                 @endif
             </div>
         </div>

         <!-- Footer -->
         <div class="modal-footer">
             <button class="btn btn-outline" onclick="closeModal('modal-historico-cliente')"
                 type="button">Fechar</button>
             <button class="btn btn-primary" wire:click="exportarPDF" wire:loading.attr="disabled" type="button">
                 <span wire:loading.remove wire:target="exportarPDF">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" style="margin-right: 6px;">
                         <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                         <polyline points="7 10 12 15 17 10" />
                         <line x1="12" x2="12" y1="15" y2="3" />
                     </svg>
                     Exportar PDF
                 </span>
                 <span wire:loading wire:target="exportarPDF">
                     <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" style="margin-right: 6px;">
                         <circle cx="12" cy="12" r="10" stroke-dasharray="60"
                             stroke-dashoffset="10" />
                     </svg>
                     Gerando...
                 </span>
             </button>
         </div>
     </div>
 </div>
