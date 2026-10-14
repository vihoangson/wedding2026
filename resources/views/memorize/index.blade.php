<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dòng thời gian kỷ niệm — {{ $profile['page_name'] }}">
    <meta name="theme-color" content="#f0f2f5">
    <title>Kỷ niệm — {{ $profile['page_name'] }}</title>
    <link rel="stylesheet" href="/memorize.css?x=1">
</head>
<body class="memorize-body">

<div class="mz-topbar">
    <div class="mz-topbar-inner">
        <div class="mz-logo">{{ config('wedding.groom_initial') }}{{ config('wedding.bride_initial') }}</div>
        <div class="mz-topbar-title">Kỷ niệm</div>
        <nav class="mz-topbar-nav">
            <a href="/" class="mz-nav-link">Thiệp cưới</a>
            <a href="/about-us" class="mz-nav-link active">Về chúng tôi</a>
        </nav>
    </div>
</div>

<div class="mz-wrapper">
    <div class="mz-cover">
        <img src="{{ $profile['cover_photo'] }}" alt="Ảnh bìa {{ $profile['page_name'] }}" loading="lazy">
    </div>

    <div class="mz-profile-header">
        <div class="mz-avatar-wrap">
            <img class="mz-avatar" src="{{ $profile['avatar'] }}" alt="Ảnh đại diện {{ $profile['page_name'] }}">
            <div class="mz-profile-meta">
                <div class="mz-page-name">{{ $profile['page_name'] }}</div>
                <div class="mz-page-bio">{{ $profile['page_bio'] }}</div>
            </div>
        </div>
        <div class="mz-tabs">
            <div class="mz-tab active">Bài viết</div>
            <div class="mz-tab">Ảnh</div>
            <div class="mz-tab">Giới thiệu</div>
        </div>
    </div>

    <div class="mz-feed">
        @forelse($posts as $post)
            <div class="mz-post" data-post-id="{{ $post['id'] }}">
                <div class="mz-post-header">
                    <img class="mz-post-avatar" src="{{ $profile['avatar'] }}" alt="{{ $profile['page_name'] }}">
                    <div class="mz-post-authorline">
                        <div class="mz-post-author">{{ $profile['page_name'] }}</div>
                        <div class="mz-post-date">
                            {{ $post['formatted_date'] }}
                            <svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <path d="M8 0a8 8 0 100 16A8 8 0 008 0zM1.5 8a6.5 6.5 0 1113 0 6.5 6.5 0 01-13 0zm7.53-3.61a.5.5 0 00-1.06 0v3.61c0 .17.08.33.22.43l2.5 1.8a.5.5 0 10.6-.8L8.03 7.8V4.39z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                @if(!empty($post['content']))
                    <div class="mz-post-content">{{ $post['content'] }}</div>
                @endif

                @php $imgCount = count($post['images']); @endphp
                @if($imgCount > 0)
                    <div class="mz-post-images {{ $imgCount === 1 ? 'count-1' : ($imgCount === 2 ? 'count-2' : ($imgCount === 3 ? 'count-3' : 'count-4plus')) }}">
                        @foreach(array_slice($post['images'], 0, 4) as $imgIndex => $imageUrl)
                            <figure class="mz-img-{{ $imgIndex }}">
                                <img src="{{ $imageUrl }}" alt="Kỷ niệm {{ $imgIndex + 1 }}" loading="lazy">
                                @if($imgIndex === 3 && $imgCount > 4)
                                    <div class="mz-img-more-overlay">+{{ $imgCount - 4 }}</div>
                                @endif
                            </figure>
                        @endforeach
                    </div>
                @endif

                <div class="mz-post-stats">
                    <div class="mz-stat-likes">
                        <span class="mz-like-icon">👍</span>
                        <span class="mz-like-count" data-base-likes="{{ $post['likes'] ?? 0 }}">{{ $post['likes'] ?? 0 }}</span>
                    </div>
                    <div class="mz-stat-comments mz-comments-toggle" role="button" tabindex="0">{{ count($post['comments']) }} bình luận</div>
                </div>

                <div class="mz-post-actions">
                    <button type="button" class="mz-action-btn mz-like-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3H14z"/><path d="M7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"/></svg>
                        Thích
                    </button>
                    <button type="button" class="mz-action-btn mz-comment-toggle-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                        Bình luận
                    </button>
                </div>

                <div class="mz-comments-section" hidden>
                    <div class="mz-comment-list">
                        @forelse($post['comments'] as $comment)
                            <div class="mz-comment-item">
                                <div class="mz-comment-avatar">{{ mb_substr($comment['name'], 0, 1) }}</div>
                                <div class="mz-comment-bubble">
                                    <div class="mz-comment-name">{{ $comment['name'] }}</div>
                                    <div class="mz-comment-message">{{ $comment['message'] }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="mz-comment-empty">Hãy là người đầu tiên bình luận về kỷ niệm này.</div>
                        @endforelse
                    </div>

                    <form class="mz-comment-form" novalidate>
                        <div class="mz-comment-avatar mz-comment-avatar-guest">?</div>
                        <div class="mz-comment-form-fields">
                            <input type="text" class="mz-comment-name-input" placeholder="Tên của bạn" maxlength="100" required>
                            <input type="text" class="mz-comment-message-input" placeholder="Viết bình luận..." maxlength="1000" required>
                        </div>
                        <button type="submit" class="mz-comment-submit" aria-label="Gửi bình luận">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                        </button>
                    </form>
                    <div class="mz-comment-error" hidden></div>
                </div>
            </div>
        @empty
            <div class="mz-empty">Chưa có kỷ niệm nào được lưu lại.</div>
        @endforelse
    </div>
</div>

<script>
    document.querySelectorAll('.mz-like-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const post = btn.closest('.mz-post');
            const countEl = post.querySelector('.mz-like-count');
            const base = parseInt(countEl.getAttribute('data-base-likes'), 10) || 0;
            const isLiked = btn.classList.toggle('liked');
            countEl.textContent = isLiked ? base + 1 : base;
        });
    });

    function toggleComments(post) {
        const section = post.querySelector('.mz-comments-section');
        if (!section) return;
        const isHidden = section.hasAttribute('hidden');
        if (isHidden) {
            section.removeAttribute('hidden');
            const nameInput = section.querySelector('.mz-comment-name-input');
            if (nameInput) nameInput.focus();
        } else {
            section.setAttribute('hidden', '');
        }
    }

    document.querySelectorAll('.mz-comment-toggle-btn, .mz-comments-toggle').forEach(function (el) {
        el.addEventListener('click', function () {
            toggleComments(el.closest('.mz-post'));
        });
    });

    function renderComment(comment) {
        const item = document.createElement('div');
        item.className = 'mz-comment-item';
        const initial = (comment.name || '?').trim().charAt(0).toUpperCase();
        item.innerHTML = `
            <div class="mz-comment-avatar">${initial}</div>
            <div class="mz-comment-bubble">
                <div class="mz-comment-name"></div>
                <div class="mz-comment-message"></div>
            </div>
        `;
        item.querySelector('.mz-comment-name').textContent = comment.name;
        item.querySelector('.mz-comment-message').textContent = comment.message;
        return item;
    }

    document.querySelectorAll('.mz-comment-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const post = form.closest('.mz-post');
            const postId = post.getAttribute('data-post-id');
            const nameInput = form.querySelector('.mz-comment-name-input');
            const messageInput = form.querySelector('.mz-comment-message-input');
            const errorEl = post.querySelector('.mz-comment-error');
            const submitBtn = form.querySelector('.mz-comment-submit');

            const name = nameInput.value.trim();
            const message = messageInput.value.trim();

            if (errorEl) errorEl.setAttribute('hidden', '');

            if (!name || !message) {
                if (errorEl) {
                    errorEl.textContent = 'Vui lòng nhập tên và nội dung bình luận.';
                    errorEl.removeAttribute('hidden');
                }
                return;
            }

            submitBtn.disabled = true;

            fetch('/api/memory-comments', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ post_id: postId, name: name, message: message }),
            })
                .then(function (res) { return res.json(); })
                .then(function (result) {
                    submitBtn.disabled = false;

                    if (!result.success) {
                        if (errorEl) {
                            errorEl.textContent = result.message || 'Có lỗi xảy ra, vui lòng thử lại.';
                            errorEl.removeAttribute('hidden');
                        }
                        return;
                    }

                    const list = post.querySelector('.mz-comment-list');
                    const emptyEl = list.querySelector('.mz-comment-empty');
                    if (emptyEl) emptyEl.remove();
                    list.appendChild(renderComment(result.data));

                    const countEl = post.querySelector('.mz-comments-toggle');
                    if (countEl) {
                        const current = list.querySelectorAll('.mz-comment-item').length;
                        countEl.textContent = current + ' bình luận';
                    }

                    messageInput.value = '';
                })
                .catch(function () {
                    submitBtn.disabled = false;
                    if (errorEl) {
                        errorEl.textContent = 'Không thể kết nối, vui lòng thử lại.';
                        errorEl.removeAttribute('hidden');
                    }
                });
        });
    });
</script>

</body>
</html>
