{{-- Editable list of image rows submitted as {{ $name }}[i][url|alt|featured]. --}}
<div class="card border-0 shadow-sm mb-4 js-image-list" data-name="{{ $name }}" data-max="{{ $max ?? '' }}">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi {{ $icon }}"></i> {{ $title }}
            <span class="badge bg-wedding ms-2 js-count">{{ count($images) }}</span>
        </h5>
        <button type="button" class="btn btn-wedding btn-sm js-add-row">
            <i class="bi bi-plus-lg"></i> Thêm ảnh
        </button>
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">{{ $hint }}</p>
        <div class="js-rows">
            @foreach($images as $i => $image)
                <div class="gallery-row row g-2 align-items-center py-2">
                    <div class="col-auto">
                        <img class="media-preview" src="{{ $image['url'] ?? '' }}" alt="">
                    </div>
                    <div class="col-md-5">
                        <input type="url" class="form-control js-preview-src" data-field="url" name="{{ $name }}[{{ $i }}][url]" value="{{ $image['url'] ?? '' }}" placeholder="https://..." required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" data-field="alt" name="{{ $name }}[{{ $i }}][alt]" value="{{ $image['alt'] ?? '' }}" placeholder="Mô tả ảnh (alt)">
                    </div>
                    <div class="col-auto">
                        <div class="form-check">
                            <input type="hidden" data-field="featured" name="{{ $name }}[{{ $i }}][featured]" value="0">
                            <input class="form-check-input" type="checkbox" data-field="featured" name="{{ $name }}[{{ $i }}][featured]" value="1" @checked(!empty($image['featured']))>
                            <label class="form-check-label">Nổi bật</label>
                        </div>
                    </div>
                    <div class="col-auto ms-auto">
                        <button type="button" class="btn btn-outline-secondary btn-sm js-move-up" title="Lên"><i class="bi bi-arrow-up"></i></button>
                        <button type="button" class="btn btn-outline-danger btn-sm js-remove-row" title="Xoá"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
