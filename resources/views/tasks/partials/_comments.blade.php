{{-- resources/views/tasks/partials/_comments.blade.php --}}
@foreach ($comments as $comment)
    <div class="comment mb-5">
        <div class="d-flex align-items-center mb-2">
            <div class="symbol symbol-35px me-3">
                <div class="symbol-label bg-light-primary">
                    {{ substr($comment->user->name, 0, 1) }}
                </div>
            </div>
            <div class="d-flex flex-column flex-grow-1">
                <span class="text-gray-800 fs-4 fw-bold">{{ $comment->user->name }}</span>
                <span class="text-gray-600 fs-6">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <div class="comment-content ms-8 ps-5">
            <div class="text-gray-800 mb-4">{!! $comment->content !!}</div>
            @if ($comment->attachments->count() > 0)
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach ($comment->attachments as $attachment)
                        <a href="{{ asset($attachment->file_path) }}"
                            class="d-flex align-items-center bg-light rounded p-2 text-primary" target="_blank">
                            <i class="ki-duotone ki-file fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <span class="fs-7 fw-bold">{{ $attachment->file_name }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endforeach
