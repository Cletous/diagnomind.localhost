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
                                <select class="form-select" wire:model.defer="doctor_rating">
                                    <option value="">-- Select Rating --</option>
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Review</label>
                                <textarea class="form-control" wire:model.defer="doctor_review"></textarea>
                            </div>

                            <h6>Hospital Feedback</h6>
                            <div class="mb-2">
                                <label>Rating (1–5)</label>
                                <select class="form-select" wire:model.defer="hospital_rating">
                                    <option value="">-- Select Rating --</option>
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Review</label>
                                <textarea class="form-control" wire:model.defer="hospital_review"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('showModal', false)">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
