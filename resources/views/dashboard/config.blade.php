<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cấu hình hình ảnh & video - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/dashboard.css">
    <style>
        .media-preview {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 8px;
            background: #f1f1f1;
            border: 1px solid #eee;
        }
        .media-preview-wide {
            width: 100%;
            max-height: 160px;
            object-fit: cover;
            border-radius: 8px;
            background: #f1f1f1;
            border: 1px solid #eee;
        }
        .gallery-row + .gallery-row {
            border-top: 1px dashed #e5e5e5;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1 text-wedding fw-bold">
            <i class="bi bi-images"></i> Cấu hình hình ảnh & video
        </span>
        <div>
            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                <i class="bi bi-arrow-left"></i> Về Dashboard
            </a>
            <form method="POST" action="{{ route('dashboard.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-4">
    @if(session('config_saved'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('config_saved') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle"></i> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('dashboard.config.update') }}" id="mediaConfigForm">
        @csrf

        @include("dashboard.partials.image-list", [
            "name" => "gallery",
            "title" => "Ảnh khung collage (phía trên)",
            "icon" => "bi-grid-1x2",
            "hint" => "Hiển thị trong khung collage đầu thiệp — tối đa 5 ảnh.",
            "max" => 5,
            "images" => old("gallery", $galleryImages),
        ])

        @include("dashboard.partials.image-list", [
            "name" => "moments",
            "title" => "Khoảnh khắc của chúng tôi",
            "icon" => "bi-images",
            "hint" => "Bộ ảnh riêng cho carousel \"Khoảnh khắc của chúng tôi\". Để trống thì ẩn mục này trên thiệp.",
            "images" => old("moments", $momentsImages),
        ])

        <!-- Video -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-camera-video"></i> Video cưới</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-500">Tiêu đề</label>
                            <input type="text" class="form-control" name="video[title]" value="{{ old('video.title', $video['title'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-500">Mô tả ngắn</label>
                            <input type="text" class="form-control" name="video[subtitle]" value="{{ old('video.subtitle', $video['subtitle'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-500">Link YouTube</label>
                            <input type="url" class="form-control" name="video[youtube_url]" value="{{ old('video.youtube_url', $video['youtube_url'] ?? '') }}" placeholder="https://youtube.com/shorts/... hoặc https://www.youtube.com/watch?v=...">
                        </div>
                        <div>
                            <label class="form-label fw-500">Ảnh thumbnail</label>
                            <input type="url" class="form-control js-preview-src" data-preview="#videoThumbPreview" name="video[thumbnail]" value="{{ old('video.thumbnail', $video['thumbnail'] ?? '') }}" placeholder="https://...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-500 text-muted">Xem trước thumbnail</label>
                        <img id="videoThumbPreview" class="media-preview-wide" src="{{ old('video.thumbnail', $video['thumbnail'] ?? '') }}" alt="">
                    </div>
                </div>
            </div>
        </div>

        <!-- Memorize -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-badge"></i> Trang kỷ niệm (/memorize)</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Ảnh bìa</label>
                        <input type="url" class="form-control js-preview-src mb-2" data-preview="#coverPreview" name="memorize[cover_photo]" value="{{ old('memorize.cover_photo', $memorize['cover_photo'] ?? '') }}" placeholder="https://...">
                        <img id="coverPreview" class="media-preview-wide" src="{{ old('memorize.cover_photo', $memorize['cover_photo'] ?? '') }}" alt="">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-500">Ảnh đại diện</label>
                        <input type="url" class="form-control js-preview-src mb-2" data-preview="#avatarPreview" name="memorize[avatar]" value="{{ old('memorize.avatar', $memorize['avatar'] ?? '') }}" placeholder="https://...">
                        <img id="avatarPreview" class="media-preview" style="width:120px;height:120px;border-radius:50%;" src="{{ old('memorize.avatar', $memorize['avatar'] ?? '') }}" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('dashboard.config') }}" class="btn btn-outline-secondary">Huỷ thay đổi</a>
            <button type="submit" class="btn btn-wedding px-4">
                <i class="bi bi-save"></i> Lưu cấu hình
            </button>
        </div>
    </form>
</div>

<template id="imageRowTemplate">
    <div class="gallery-row row g-2 align-items-center py-2">
        <div class="col-auto">
            <img class="media-preview" src="" alt="">
        </div>
        <div class="col-md-5">
            <input type="url" class="form-control js-preview-src" data-field="url" placeholder="https://..." required>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" data-field="alt" placeholder="Mô tả ảnh (alt)">
        </div>
        <div class="col-auto">
            <div class="form-check">
                <input type="hidden" data-field="featured" value="0">
                <input class="form-check-input" type="checkbox" data-field="featured" value="1">
                <label class="form-check-label">Nổi bật</label>
            </div>
        </div>
        <div class="col-auto ms-auto">
            <button type="button" class="btn btn-outline-secondary btn-sm js-move-up" title="Lên"><i class="bi bi-arrow-up"></i></button>
            <button type="button" class="btn btn-outline-danger btn-sm js-remove-row" title="Xoá"><i class="bi bi-trash"></i></button>
        </div>
    </div>
</template>

<script>
(function () {
    const template = document.getElementById('imageRowTemplate');

    document.querySelectorAll('.js-image-list').forEach(function (list) {
        const name = list.dataset.name;
        const max = parseInt(list.dataset.max, 10) || 0;
        const rows = list.querySelector('.js-rows');
        const addBtn = list.querySelector('.js-add-row');

        // Rewrite name[i][field] so indexes stay 0..n-1 in display order.
        function reindex() {
            const all = rows.querySelectorAll('.gallery-row');
            all.forEach(function (row, i) {
                row.querySelectorAll('input[data-field]').forEach(function (input) {
                    input.name = name + '[' + i + '][' + input.dataset.field + ']';
                });
                const id = name + 'Featured' + i;
                row.querySelector('.form-check-input').id = id;
                row.querySelector('.form-check-label').htmlFor = id;
            });
            list.querySelector('.js-count').textContent = all.length;
            addBtn.disabled = max > 0 && all.length >= max;
        }

        addBtn.addEventListener('click', function () {
            rows.appendChild(template.content.cloneNode(true));
            reindex();
            rows.lastElementChild.querySelector('input[type=url]').focus();
        });

        rows.addEventListener('click', function (e) {
            const row = e.target.closest('.gallery-row');
            if (!row) return;
            if (e.target.closest('.js-remove-row')) {
                row.remove();
                reindex();
            } else if (e.target.closest('.js-move-up') && row.previousElementSibling) {
                rows.insertBefore(row, row.previousElementSibling);
                reindex();
            }
        });

        reindex();
    });

    document.addEventListener('input', function (e) {
        const input = e.target;
        if (!input.classList.contains('js-preview-src')) return;
        const target = input.dataset.preview
            ? document.querySelector(input.dataset.preview)
            : input.closest('.gallery-row').querySelector('.media-preview');
        if (target) target.src = input.value.trim();
    });
})();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
