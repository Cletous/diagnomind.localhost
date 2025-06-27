<div>
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="submitFeedback">
                        <div class="modal-header">
                            <h5 class="modal-title">Diagnosis Feedback</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <select wire:model="rating" class="form-select">
                                    <option value="none">No Rating</option>
                                    <option value="like">👍 Like</option>
                                    <option value="dislike">👎 Dislike</option>
                                </select>
                                @error('rating')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">Feedback Comment</label>
                                <textarea wire:model="comment" class="form-control" rows="3"></textarea>
                                @error('comment')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
