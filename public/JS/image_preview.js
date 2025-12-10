
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.new-image-url-input');

        inputs.forEach(input => {
            const previewId = input.dataset.previewId;
            const previewImg = document.getElementById(previewId);

            // 初期ロード時のプレビュー設定 (old()値がある場合)
            if (input.value && previewImg) {
                previewImg.src = input.value;
                previewImg.style.display = 'block';
            }

            // 入力変更時のイベント
            input.addEventListener('input', function() {
                const url = this.value;

                if (previewImg) {
                    if (url) {
                        previewImg.src = url;
                        previewImg.style.display = 'block';
                    } else {
                        previewImg.src = '';
                        previewImg.style.display = 'none';
                    }
                }
            });
        });
    });