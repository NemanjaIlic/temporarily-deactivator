<div class="modal fade" id="deactivateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('deactivator.store') }}" class="modal-content">
            @csrf
            <input type="hidden" name="model_id" id="modalModelId">
            <input type="hidden" name="model_type" id="modalModelType">
            <div class="modal-header">
                <h5 class="modal-title">Deactivate Model Temporarily</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="minutesInput" class="form-label">Deactivate for (minutes)</label>
                    <input type="number" min="1" class="form-control" id="minutesInput" name="minutes" value="60" required>
                </div>
                <p class="small text-muted">This will set <code>active</code> to <strong>false</strong> and schedule automatic reactivation.</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Deactivate</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modalEl = document.getElementById('deactivateModal');
    modalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;
        document.getElementById('modalModelId').value = button.getAttribute('data-model-id') || '';
        document.getElementById('modalModelType').value = button.getAttribute('data-model-type') || '';
    });
});
</script>