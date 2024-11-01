<div>
    @if($showModal)
        <div class="modal">
            <div class="modal-content">
                <h2>Confirmação</h2>
                <p>Deseja alterar o nome de "{{ $oldValue }}" para "{{ $newValue }}"?</p>
                <button wire:click="confirmChange">Sim</button>
                <button wire:click="$set('showModal', false)">Não</button>
            </div>
        </div>
    @endif
</div>
