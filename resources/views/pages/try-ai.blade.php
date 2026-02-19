@extends('layouts.app')

@section('title', 'Try AI Tools - ' . ($siteTitle ?? 'FasalSarthi'))
@section('meta_description', 'Chat with our agriculture AI expert or identify plant diseases from a photo. Free to try on the website.')

@section('content')
    <section class="page-hero blog-hero">
        <div class="container">
            <h1 data-aos="fade-up">Try Our AI Tools</h1>
            <p data-aos="fade-up" data-aos-delay="100">Get 3 free AI chats and 3 free disease identifications on the website. Download our app for unlimited access.</p>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- AI Chat -->
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-success mb-3"><i class="fas fa-comments me-2"></i> Ask Agriculture Expert (AI)</h3>
                            <p class="text-muted small">Ask anything about farming, crops, soil, pests, or weather. Our AI answers only agriculture-related questions.</p>
                            <div id="chatRemaining" class="badge bg-success mb-3">Free chats left: <span id="chatRemainingCount">3</span></div>
                            <div id="chatMessages" class="border rounded p-3 bg-white mb-3" style="min-height: 200px; max-height: 320px; overflow-y: auto;"></div>
                            <div id="chatLimitMsg" class="alert alert-info d-none mb-3">You have used your 3 free chats. <a href="{{ route('home') }}#contact">Download our app</a> for unlimited AI assistance.</div>
                            <div class="d-flex gap-2">
                                <input type="text" id="chatInput" class="form-control" placeholder="Ask about crops, pests, soil..." maxlength="2000">
                                <button type="button" id="chatSend" class="btn btn-success">Send</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disease ID -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-success mb-3"><i class="fas fa-camera me-2"></i> Identify Plant Disease</h3>
                            <p class="text-muted small">Upload a clear photo of the affected leaf or plant. Our AI suggests possible diseases and treatments.</p>
                            <div id="imageRemaining" class="badge bg-success mb-3">Free identifications left: <span id="imageRemainingCount">3</span></div>
                            <div id="diseaseResult" class="border rounded p-3 bg-white mb-3 d-none" style="min-height: 120px;"></div>
                            <div id="imageLimitMsg" class="alert alert-info d-none mb-3">You have used your 3 free identifications. <a href="{{ route('home') }}#contact">Download our app</a> for more.</div>
                            <div class="mb-2">
                                <input type="file" id="diseaseImage" class="form-control" accept="image/*" capture="environment">
                            </div>
                            <button type="button" id="identifyBtn" class="btn btn-success" disabled>Identify Disease</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 bg-white border-top">
        <div class="container text-center">
            <p class="text-muted mb-0">Need more? <a href="{{ route('home') }}#contact">Download our mobile app</a> for unlimited AI chat and disease identification.</p>
        </div>
    </section>

    @push('scripts')
    <script>
    (function() {
        var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function setCounts(chatLeft, imageLeft) {
            chatLeft = Math.max(0, parseInt(chatLeft, 10) || 3);
            imageLeft = Math.max(0, parseInt(imageLeft, 10) || 3);
            var chatEl = document.getElementById('chatRemainingCount');
            var imageEl = document.getElementById('imageRemainingCount');
            if (chatEl) chatEl.textContent = chatLeft;
            if (imageEl) imageEl.textContent = imageLeft;
            if (chatLeft <= 0) {
                var rb = document.getElementById('chatRemaining');
                if (rb) { rb.classList.remove('bg-success'); rb.classList.add('bg-secondary'); }
                var cm = document.getElementById('chatLimitMsg');
                if (cm) cm.classList.remove('d-none');
                var ci = document.getElementById('chatInput');
                if (ci) ci.disabled = true;
                var cs = document.getElementById('chatSend');
                if (cs) cs.disabled = true;
            }
            if (imageLeft <= 0) {
                var ib = document.getElementById('imageRemaining');
                if (ib) { ib.classList.remove('bg-success'); ib.classList.add('bg-secondary'); }
                var im = document.getElementById('imageLimitMsg');
                if (im) im.classList.remove('d-none');
                var di = document.getElementById('diseaseImage');
                if (di) di.disabled = true;
                var idb = document.getElementById('identifyBtn');
                if (idb) idb.disabled = true;
            }
        }
        function updateLimits() {
            fetch('{{ route("ai.limits") }}', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(r) {
                    if (!r.ok) throw new Error('Limits request failed');
                    return r.json();
                })
                .then(function(d) {
                    var chatLimit = parseInt(d.chat_limit, 10) || 3;
                    var chatUsed = parseInt(d.chat_used, 10) || 0;
                    var imageLimit = parseInt(d.image_limit, 10) || 3;
                    var imageUsed = parseInt(d.image_used, 10) || 0;
                    setCounts(chatLimit - chatUsed, imageLimit - imageUsed);
                })
                .catch(function() {
                    setCounts(3, 3);
                });
        }
        updateLimits();

        // Chat
        var chatMessages = document.getElementById('chatMessages');
        function appendChat(msg, isUser) {
            var div = document.createElement('div');
            div.className = 'mb-2 ' + (isUser ? 'text-end' : '');
            var bubble = document.createElement('div');
            bubble.className = 'd-inline-block p-2 rounded text-start ' + (isUser ? 'bg-success text-white' : 'bg-light');
            bubble.style.maxWidth = '90%';
            bubble.textContent = msg;
            div.appendChild(bubble);
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        document.getElementById('chatSend').addEventListener('click', function() {
            var input = document.getElementById('chatInput');
            var msg = input.value.trim();
            if (!msg) return;
            if (document.getElementById('chatSend').disabled) return;
            appendChat(msg, true);
            input.value = '';
            document.getElementById('chatSend').disabled = true;

            fetch('{{ route("ai.chat") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ message: msg })
            })
            .then(function(r) { return r.json().then(function(d) { return { ok: r.ok, status: r.status, data: d }; }); })
            .then(function(result) {
                document.getElementById('chatSend').disabled = false;
                if (result.status === 429 && result.data.limit_reached) {
                    appendChat(result.data.message, false);
                    updateLimits();
                    return;
                }
                if (result.ok && result.data.success) {
                    appendChat(result.data.reply, false);
                    updateLimits();
                } else {
                    appendChat(result.data.message || 'Sorry, something went wrong.', false);
                }
            })
            .catch(function() {
                document.getElementById('chatSend').disabled = false;
                appendChat('Network error. Please try again.', false);
            });
        });
        document.getElementById('chatInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') document.getElementById('chatSend').click();
        });

        // Disease
        document.getElementById('diseaseImage').addEventListener('change', function() {
            document.getElementById('identifyBtn').disabled = !this.files.length;
        });

        document.getElementById('identifyBtn').addEventListener('click', function() {
            var fileInput = document.getElementById('diseaseImage');
            if (!fileInput.files.length) return;
            var fd = new FormData();
            fd.append('image', fileInput.files[0]);
            fd.append('_token', csrf);
            this.disabled = true;
            var resultEl = document.getElementById('diseaseResult');
            resultEl.classList.remove('d-none');
            resultEl.innerHTML = '<span class="text-muted">Analyzing...</span>';

            fetch('{{ route("ai.identify-disease") }}', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: fd
            })
            .then(function(r) { return r.json().then(function(d) { return { ok: r.ok, status: r.status, data: d }; }); })
            .then(function(result) {
                document.getElementById('identifyBtn').disabled = false;
                if (result.status === 429 && result.data.limit_reached) {
                    resultEl.innerHTML = '<p class="text-warning mb-0">' + result.data.message + '</p>';
                    updateLimits();
                    return;
                }
                if (result.ok && result.data.success) {
                    resultEl.innerHTML = '<p class="mb-0">' + (result.data.summary || 'Analysis complete.') + '</p>';
                    if (result.data.remaining !== undefined) updateLimits();
                } else {
                    resultEl.innerHTML = '<p class="text-danger mb-0">' + (result.data.message || 'Upload failed.') + '</p>';
                }
            })
            .catch(function() {
                document.getElementById('identifyBtn').disabled = false;
                resultEl.innerHTML = '<p class="text-danger mb-0">Network error. Please try again.</p>';
            });
        });
    })();
    </script>
    @endpush
@endsection
