<div>
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.6)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="submit">
                        <div class="modal-header">
                            <h5 class="modal-title">Rate Doctor and Hospital</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>

                        <div class="modal-body">
                            <h6>Doctor Feedback</h6>
                            <div class="mb-2">
                                <label>Rating (1–5)</label>
                                <input type="number" class="form-control" wire:model.defer="doctor_rating"
                                    min="1" max="5">
                            </div>
                            <div class="mb-3">
                                <label>Review</label>
                                <textarea class="form-control" wire:model.defer="doctor_review"></textarea>
                            </div>

                            <h6>Hospital Feedback</h6>
                            <div class="mb-2">
                                <label>Rating (1–5)</label>
                                <input type="number" class="form-control" wire:model.defer="hospital_rating"
                                    min="1" max="5">
                            </div>
                            <div class="mb-3">
                                <label>Review</label>
                                <textarea class="form-control" wire:model.defer="hospital_review"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" wire:click="$set('showModal', false)">Cancel</button>
                            <button class="btn btn-primary">Submit Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
